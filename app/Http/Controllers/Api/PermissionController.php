<?php

namespace App\Http\Controllers\Api;

use App\Constants\ApiStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionRequest;
use Illuminate\Http\Request;
use App\Repositories\PermissionContract as Permission;

class PermissionController extends Controller {

    /**
     * @var Permission
     */
    protected $permission;

    /**
     * PermissionController constructor.
     * @param Permission $permission
     */
    public function __construct(Permission $permission) {
        $this->permission = $permission;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function findAll() {
        try {
            return $this->permission->findAll();
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()], ApiStatus::internalServerError);
        }
    }

    /**
     * @param PermissionRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PermissionRequest $request) {
        try {
            return $this->permission->store($request->all());
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()], ApiStatus::internalServerError);
        }
    }

    /**
     * @param PermissionRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(PermissionRequest $request, $id) {
        try {
            return $this->permission->update($request->all(), $id);
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
            return $this->permission->destroy($id);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()], ApiStatus::internalServerError);
        }
    }
}
