<?php


namespace App\Repositories;

use App\Constants\ApiMessages;
use App\Constants\ApiStatus;
use App\Exports\UserExport;
use App\Mail\NewUser;
use App\Models\Notification;
use App\Models\Permission;
use App\Models\User;
use App\Models\Role;
use App\Traits\NotificationTrait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Image;
use Maatwebsite\Excel\Facades\Excel;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserRepository implements UserContract {

    use NotificationTrait;

    protected $user, $notification;

    public function __construct(User $user, Notification $notification) {
        $this->user = $user;
        $this->notification = $notification;
    }

    /**
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticate(Array $data) {
        try {
            if (!$token = auth()->attempt($data)) {
                return response()->json(['message' => ApiMessages::credential], ApiStatus::unprocessableEntity);
            } else {
                $user = auth()->user();
                return response()->json(
                    [
                        'message' => 'Usuário autenticado',
                        'token' => $token,
                        'name' => $user->first_name,
                        'avatar' => $user->avatar
                    ], ApiStatus::success);
            }
        } catch (JWTException $e) {
            Log::debug($e->getMessage());
            return response()->json(['message' => ApiMessages::token], ApiStatus::internalServerError);
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function me() {
        $id = auth()->user()->id;
        return $this->user->with(['role', 'permission'])
            ->findOrFail($id);
    }

    /**
     * @return mixed
     */
    public function findAll() {
        return $this->user->withTrashed()
            ->with(['role','permission'])
            ->orderBy('first_name', 'asc')
            ->get();
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function findById($id) {
        return $this->user->findOrFail($id);
    }

    /**
     * @param String $name
     * @return mixed
     */
    public function findByName(String $name) {
        return $this->user->where('first_name', 'like', '%'.$name.'%')
            ->withTrashed()
            ->with(['role','permission'])
            ->get();
    }

    /**
     * @param String $name
     * @return mixed
     */
    public function filterByOrder(String $name) {
        $query = $this->user->withTrashed()
            ->with(['role','permission']);
        switch ($name) {
            case 1:
                return $query->orderBy('first_name', 'asc')
                    ->get();
            case 2:
                return $query->orderBy('email', 'asc')
                    ->get();
        }
    }

    /**
     * @param String $name
     * @return mixed
     */
    public function filterByStatus(String $name) {
        switch ($name) {
            case 1:
                return $this->user->orderBy('first_name', 'asc')
                    ->where('active', true)
                    ->with(['role','permission'])
                    ->get();
            case 2:
                return $this->user->orderBy('first_name', 'asc')
                    ->where('active', false)
                    ->with(['role','permission'])
                    ->get();
        }
    }

    /**
     * @param String $name
     * @return mixed
     */
    public function filterByRole(String $name) {
        return $this->user->where('permission_id', $name)
            ->withTrashed()
            ->with(['role','permission'])
            ->orderBy('first_name', 'asc')
            ->get();
    }

    /**
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Array $data) {
        try {

            $arr = [
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => strtolower($data['email']),
                'password' => $data['password'],
                'avatar' => null,
                'role_id' => Role::where('name', 'User')->first()->id,
                'permission_id' => $data['permission_id'],
                'active' => true,
                'pass' => $data['password']
            ];

            $save = $this->user->create($arr);
            if($save) {
                Mail::to(strtolower($data['email']))->send(new NewUser($arr));
                $users = $this->user->where('active', true)->get();
                foreach ($users as $user) {
                    if($user->notification) {
                        $aux = $user->notification['counter'];
                        $notification = [
                            'notification' => [
                                'counter' => ++$aux,
                                'read' => false
                            ]
                        ];
                        $this->user->find($user->_id)->update($notification);
                    } else {
                        $aux = 0;
                        $notification = [
                            'notification' => [
                                'counter' => ++$aux,
                                'read' => false
                            ]
                        ];
                        $this->user->find($user->_id)->update($notification);
                    }
                }

                $this->send(['title' => "${data['first_name']} foi adicionado", 'description' => "Your bones don't break, mine do", 'icon' => 'mdi mdi-account-multiple has-text-info']);
                return response()->json(['message' => ApiMessages::success], ApiStatus::created);
            } else {
                return response()->json(['message' => ApiMessages::error], ApiStatus::unprocessableEntity);
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json(['message' => $e->getMessage()], ApiStatus::internalServerError);
        }
    }

    /**
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Array $data) {
        try {

            $arr = [
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'avatar' => null,
                'active' => true,
                'role_id' => Role::where('name', 'User')->first()->id,
                'permission_id' => Permission::where('name', 'User')->first()->id
            ];

            $save = $this->user->create($arr);
            if($save) {
                $auth = ['email' => $arr['email'], 'password' => $arr['password']];
                $token = auth()->attempt($auth);
                return response()->json(['message' => ApiMessages::success, 'token' => $token], ApiStatus::created);
            } else {
                return response()->json(['message' => ApiMessages::error], ApiStatus::unprocessableEntity);
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json(['message' => $e->getMessage()], ApiStatus::internalServerError);
        }
    }

    /**
     * @param array $data
     * @param Int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Array $data, String $id) {
        try {

            $arr = [
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => strtolower($data['email']),
                'permission_id' => $data['permission_id'],
                'slug' => Str::slug($data['first_name'] . ' ' . $data['last_name'])
            ];

            $save = $this->user->find($id)->update($arr);
            if($save) {
                return response()->json(['message' => ApiMessages::success], ApiStatus::success);
            } else {
                return response()->json(['message' => ApiMessages::error], ApiStatus::unprocessableEntity);
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json(['message' => $e->getMessage()], ApiStatus::internalServerError);
        }
    }

    /**
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function personal(Array $data) {
        try {

            $id = auth()->user()->id;
            $arr = [
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'phone' => $data['phone'],
                'email' => strtolower($data['email']),
                'site' => $data['site'],
            ];

            $save = $this->user->find($id)->update($arr);
            if($save) {
                return response()->json(['message' => ApiMessages::success], ApiStatus::success);
            } else {
                return response()->json(['message' => ApiMessages::error], ApiStatus::unprocessableEntity);
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json(['message' => $e->getMessage()], ApiStatus::internalServerError);
        }
    }

    /**
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function address(Array $data) {
        try {

            $id = auth()->user()->id;
            $arr = [
                'address' => [
                    'zipcode' => $data['address']['zipcode'],
                    'street' => $data['address']['street'],
                    'number' => $data['address']['number'],
                    'neighborhood' => $data['address']['neighborhood'],
                    'state' => $data['address']['state'],
                    'city' => $data['address']['city'],
                ]
            ];

            $save = $this->user->find($id)->update($arr);
            if($save) {
                return response()->json(['message' => ApiMessages::success], ApiStatus::success);
            } else {
                return response()->json(['message' => ApiMessages::error], ApiStatus::unprocessableEntity);
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json(['message' => $e->getMessage()], ApiStatus::internalServerError);
        }
    }

    /**
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile(Array $data) {
        try {

            $id = auth()->user()->id;
            $arr = [
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'site' => $data['site'],
            ];

            $save = $this->user->find($id)->update($arr);
            if($save) {
                return response()->json(['message' => ApiMessages::success], ApiStatus::success);
            } else {
                return response()->json(['message' => ApiMessages::error], ApiStatus::unprocessableEntity);
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json(['message' => $e->getMessage()], ApiStatus::internalServerError);
        }
    }

    /**
     * @param array $data
     * @param $avatar
     * @return \Illuminate\Http\JsonResponse
     */
    public function avatar($data=[], $avatar) {
        try {
            $id = auth()->user()->id;
            $path = $avatar->store('avatar/' . $id);
            $img = Image::make(storage_path('app/public') . '/' . $path);
            $img->crop($data['width'], $data['height'], $data['x'], $data['y']);
            $img->save(storage_path('app/public') . '/' . $path);
            $source = storage_path('app/public') . '/' . $path;

            $save = $this->user->find($id)->update(['avatar' => $path]);
            if($save) {
                $source = $this->user->find($id)->avatar;
                return response()->json(['message' => ApiMessages::success, 'src' => $source], ApiStatus::success);
            } else {
                return response()->json(['message' => ApiMessages::error], ApiStatus::unprocessableEntity);
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json(['message' => $e->getMessage()], ApiStatus::internalServerError);
        }
    }

    /**
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function password($data=[]) {
        try {

            $id = auth()->user()->id;
            $user = $this->user->find($id);
            $password = $data['old_password'];
            $newPassword = $data['password'];

            if(!Hash::check($password, $user->password)) {
                return response()->json(['message' => ApiMessages::password], ApiStatus::unprocessableEntity);
            }

            $arr = ['password' => $newPassword,];
            $user = $this->user->find($id)->update($arr);
            if($user) {
                return response()->json(['message' => ApiMessages::success], ApiStatus::success);
            } else {
                return response()->json(['message' => ApiMessages::error], ApiStatus::unprocessableEntity);
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json(['message' => $e->getMessage()], ApiStatus::internalServerError);
        }
    }

    /**
     * @param String $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(String $id) {
        try {
            $delete = $this->user->find($id)->delete();
            if($delete) {
                return response()->json(['message' => ApiMessages::delete], ApiStatus::success);
            } else {
                return response()->json(['message' => ApiMessages::deleteError], ApiStatus::unprocessableEntity);
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json(['message' => $e->getMessage()], ApiStatus::internalServerError);
        }
    }

    /**
     * @param String $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore(String $id) {
        try {
            $restore = $this->user->withTrashed()->find($id)->restore();
            if($restore) {
                $this->user->find($id)->update(['active' => true]);
                return response()->json(['message' => ApiMessages::success], ApiStatus::success);
            } else {
                return response()->json(['message' => ApiMessages::error], ApiStatus::unprocessableEntity);
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json(['message' => $e->getMessage()], ApiStatus::internalServerError);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function export() {
        try {
            $query = $this->user->where('active', true)->get();
            if(count($query) > 0) {
                Storage::deleteDirectory('export');
                Excel::store(new UserExport(), 'export/user.xls');
                $download = 'export/user.xls';
                return response()->json(['message' => Storage::url($download)], ApiStatus::success);
            } else {
                return response()->json(['message' => ApiMessages::zeroData], ApiStatus::unprocessableEntity);
            }

        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json(['message' => $e->getMessage()], ApiStatus::internalServerError);
        }
    }

}
