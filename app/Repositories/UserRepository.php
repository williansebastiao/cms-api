<?php


namespace App\Repositories;

use App\Constants\ApiMessages;
use App\Constants\ApiStatus;
use App\Mail\NewUser;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Intervention\Image\Image;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserRepository implements UserContract {

    protected $user;

    public function __construct(User $user) {
        $this->user = $user;
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
        return $this->user->with('permission')
            ->findOrFail($id);
    }

    /**
     * @return mixed
     */
    public function findAll() {
        return $this->user->where('active', true)
            ->with('permission')
            ->orderBy('created_at', 'desc')
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
            ->where('active', true)
            ->get();
    }

    /**
     * @param String $name
     * @return mixed
     */
    public function filterByOrder(String $name) {
        $query = $this->user->where('active', true);
        switch ($name) {
            case 1:
                return $query->orderBy('name', 'asc')
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
                return $this->user->orderBy('name', 'asc')->where('active', true)->get();
            case 2:
                return $this->user->orderBy('name', 'asc')->where('active', false)->get();
        }
    }

    /**
     * @param String $name
     * @return mixed
     */
    public function filterByRole(String $name) {
        return $this->user->where('permission_id', $name)
            ->where('active', true)
            ->orderBy('name', 'asc')
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
                'permission_id' => $data['permission_id'],
                'active' => true,
                'pass' => $data['password']
            ];

            $save = $this->user->create($arr);
            if($save) {
                Mail::to(strtolower($data['email']))->send(new NewUser($arr));
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
                'role_id' => Role::where('name', 'User')->first()->id
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
                'slug' => Str::slug($data['name'])
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
                return response()->json(['message' => ApiMessages::password], ApiStatus::internalServerError);
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

}
