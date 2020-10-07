<?php


namespace App\Repositories;
use App\Constants\ApiMessages;
use App\Constants\ApiStatus;
use App\Mail\NewAdministrator;
use App\Models\Administrator;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Exceptions\JWTException;
use Intervention\Image\Image;


class AdministratorRepository implements AdministratorContract {

    /**
     * @var Administrator
     */
    protected $administrator;

    /**
     * AdministratorRepository constructor.
     * @param Administrator $administrator
     */
    public function __construct(Administrator $administrator) {
        $this->administrator = $administrator;
    }

    /**
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticate(Array $data) {
        try {
            if (!$token = auth('administrator')->attempt($data)) {
                return response()->json(['message' => ApiMessages::credential], ApiStatus::unprocessableEntity);
            } else {
                $user = auth('administrator')->user();
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
        $id = auth('administrator')->user()->id;
        return $this->administrator->with('role')->findOrFail($id);
    }

    /**
     * @return mixed
     */
    public function findAll() {
        return $this->administrator->where('active', true)
            ->with('role')
            ->orderBy('id', 'desc')
            ->get();
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function findById($id) {
        return $this->administrator->with('role')
            ->findOrFail($id);
    }

    /**
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Array $data) {
        try {

            $password = Str::random(8);
            $arr = [
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'password' => $password,
                'role_id' => Role::where('name', $data['role'])->first()->id,
                'pass' => $password
            ];

            $save = $this->administrator->create($arr);
            if($save) {
                Mail::to($data['email'])->send(new NewAdministrator($arr));
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
     * @param Int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Array $data, Int $id) {
        try {

            $arr = [
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'role_id' => $data['role_id'],
            ];

            $save = $this->administrator->find($id)->update($arr);
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

            $id = auth('administrator')->user()->id;
            $arr = [
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
            ];

            $save = $this->administrator->find($id)->update($arr);
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
            $id = auth('administrator')->user()->id;
            $path = $avatar->store('avatar/' . $id);
            $img = Image::make(storage_path('app/public') . '/' . $path);
            $img->crop($data['width'], $data['height'], $data['x'], $data['y']);
            $img->save(storage_path('app/public') . '/' . $path);
            $source = storage_path('app/public') . '/' . $path;

            $save = $this->administrator->find($id)->update(['avatar' => $path]);
            if($save) {
                $source = $this->administrator->find($id)->avatar;
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

            $id = auth('administrator')->user()->id;
            $user = $this->administrator->find($id);
            $password = $data['old_password'];
            $newPassword = $data['password'];

            if(!Hash::check($password, $user->password)) {
                return response()->json(['message' => ApiMessages::password], ApiStatus::internalServerError);
            }

            $arr = ['password' => $newPassword,];
            $user = $this->administrator->find($id)->update($arr);
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
     * @param Int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Int $id) {
        try {
            $delete = $this->administrator->find($id)->delete();
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
