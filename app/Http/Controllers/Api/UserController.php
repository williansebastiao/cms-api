<?php

namespace App\Http\Controllers\Api;

use App\Constants\ApiMessages;
use App\Constants\ApiStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Repositories\UserContract as User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller {

    /**
     * @var User
     */
    protected $user;

    /**
     * UserController constructor.
     * @param User $user
     */
    public function __construct (User $user){
        $this->user = $user;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticate(Request $request){
        try {
            return $this->user->authenticate($request->all());
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()], ApiStatus::internalServerError);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function me() {
        try {
            return $this->user->me();
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()], ApiStatus::internalServerError);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function findAll() {
        try {
            return $this->user->findAll();
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()], ApiStatus::internalServerError);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function findById($id) {
        try {
            return $this->user->findById($id);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()], ApiStatus::internalServerError);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserRequest $request) {
        try {
            return $this->user->store($request->all());
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()], ApiStatus::internalServerError);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(UserRequest $request) {
        try {
            return $this->user->register($request->all());
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()], ApiStatus::internalServerError);
        }
    }

    /**
     * @param UserRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserRequest $request, $id) {
        try {
            return $this->user->update($request->all(), $id);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()], ApiStatus::internalServerError);
        }
    }

    /**
     * @param UserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile(UserRequest $request) {
        try {
            return $this->user->profile($request->all());
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()], ApiStatus::internalServerError);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function avatar(Request $request) {
        try {
            return $this->user->avatar($request->all(), $request->avatar);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()], ApiStatus::internalServerError);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function password(Request $request) {
        try {
            return $this->user->password($request->all());
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()], ApiStatus::internalServerError);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id) {
        try {
            return $this->user->destroy($id);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()], ApiStatus::internalServerError);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        try {
            Auth::logout();
            return response()->json(['message' => ApiMessages::seeYa], ApiStatus::success);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()], ApiStatus::internalServerError);
        }
    }

}
