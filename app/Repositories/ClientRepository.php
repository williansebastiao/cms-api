<?php


namespace App\Repositories;
use App\Constants\ApiMessages;
use App\Constants\ApiStatus;
use App\Mail\NewClient;
use App\Models\Client;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Intervention\Image\Image;
use Tymon\JWTAuth\Exceptions\JWTException;


class ClientRepository implements ClientContract {

    protected $client;

    public function __construct(Client $client) {
        $this->client = $client;
    }

    /**
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticate(Array $data) {
        try {
            if (!$token = auth('client')->attempt($data)) {
                return response()->json(['message' => ApiMessages::credential], ApiStatus::unprocessableEntity);
            } else {
                $user = auth('client')->user();
                return response()->json(
                    [
                        'message' => 'Usuário autenticado',
                        'token' => $token,
                        'name' => $user->name,
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
        $id = auth('client')->user()->id;
        return $this->client->with('role')->findOrFail($id);
    }

    /**
     * @return mixed
     */
    public function findAll() {
        return $this->client->where('active', true)
            ->with('role')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function findById($id) {
        return $this->client->with('role')
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
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $password,
                'active' => true,
                'role_id' => Role::where('name', 'User')->first()->id,
                'pass' => $password
            ];

            $save = $this->client->create($arr);
            if($save) {
                Mail::to($data['email'])->send(new NewClient($arr));
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
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'active' => true,
                'role_id' => Role::where('name', 'User')->first()->id
            ];

            $save = $this->client->create($arr);
            if($save) {
                $auth = ['email' => $arr['email'], 'password' => $arr['password']];
                $token = auth('client')->attempt($auth);
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
                'name' => $data['name'],
                'email' => $data['email'],
                'slug' => Str::slug($data['name'])
            ];

            $save = $this->client->find($id)->update($arr);
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

            $save = $this->client->find($id)->update($arr);
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

            $save = $this->client->find($id)->update(['avatar' => $path]);
            if($save) {
                $source = $this->client->find($id)->avatar;
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

            $id = auth('client')->user()->id;
            $user = $this->client->find($id);
            $password = $data['old_password'];
            $newPassword = $data['password'];

            if(!Hash::check($password, $user->password)) {
                return response()->json(['message' => ApiMessages::password], ApiStatus::internalServerError);
            }

            $arr = ['password' => $newPassword,];
            $user = $this->client->find($id)->update($arr);
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
            $delete = $this->client->find($id)->delete();
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
