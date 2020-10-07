<?php

namespace App\Http\Controllers\Api;

use App\Constants\ApiStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdministratorRequest;
use Illuminate\Http\Request;
use App\Repositories\AdministratorContract as Administrator;

class AdministratorController extends Controller {

    /**
     * @var Administrator
     */
    protected $administrator;

    /**
     * AdministratorController constructor.
     * @param Administrator $administrator
     */
    public function __construct (Administrator $administrator){
        $this->administrator = $administrator;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticate(Request $request){
        try {
            return $this->administrator->authenticate($request->all());
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()], ApiStatus::internalServerError);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function me() {
        try {
            return $this->administrator->me();
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()], ApiStatus::internalServerError);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function findAll() {
        try {
            return $this->administrator->findAll();
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
            return $this->administrator->findById($id);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()], ApiStatus::internalServerError);
        }
    }

    public function store(Request $request) {
        try {
            return $this->administrator->store($request->all());
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()], ApiStatus::internalServerError);
        }
    }

    /**
     * @param AdministratorRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function stores(AdministratorRequest $request) {

    }

    /**
     * @param AdministratorRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(AdministratorRequest $request, $id) {
        try {
            return $this->administrator->update($request->all(), $id);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()], ApiStatus::internalServerError);
        }
    }

    /**
     * @param AdministratorRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile(AdministratorRequest $request) {
        try {
            return $this->administrator->profile($request->all());
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
            return $this->administrator->avatar($request->all(), $request->avatar);
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
            return $this->administrator->password($request->all());
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
            return $this->administrator->destroy($id);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()], ApiStatus::internalServerError);
        }
    }
}
