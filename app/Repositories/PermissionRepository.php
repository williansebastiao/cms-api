<?php


namespace App\Repositories;

use App\Constants\ApiMessages;
use App\Constants\ApiStatus;
use App\Exports\RoleExport;
use App\Models\Permission;
use App\Models\User;
use App\Traits\NotificationTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class PermissionRepository implements PermissionContract {

    use NotificationTrait;

    /**
     * @var Permission
     * @var User
     */
    protected $permission, $user;

    /**
     * PermissionRepository constructor.
     * @param Permission $permission
     * @param User $user
     */
    public function __construct(Permission $permission, User $user) {
        $this->permission = $permission;
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function findAll() {
        return $this->permission->where('active', true)
            ->orderBy('name')
            ->get();
    }

    /**
     * @param String $id
     * @return mixed
     */
    public function findById(String $id) {
        return $this->permission->findOrFail($id);
    }

    /**
     * @return mixed
     */
    public function findAllOrderByDate() {
        return $this->permission->where('active', true)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * @param String $name
     * @return mixed
     */
    public function findByName(String $name) {
        return $this->permission->where('name', 'like', '%'.$name.'%')
            ->where('active', true)
            ->get();
    }

    /**
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Array $data) {
        try {
            $save = $this->permission->create($data);
            if($save) {
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
                $this->send(['title' => "${data['name']} foi adicionado a roles", 'description' => "Your bones don't break, mine do", 'icon' => 'mdi mdi-account-multiple has-text-info']);
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
     * @param String $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Array $data, String $id) {
        try {
            $data['slug'] = Str::slug($data['name']);
            $save = $this->permission->find($id)->update($data);
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
     * @param String $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(String $id) {
        try {
            $delete = $this->permission->find($id)->delete();
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function export() {
        try {
            $query = $this->permission->where('active', true)->get();
            if(count($query) > 0) {
                Storage::deleteDirectory('export');
                Excel::store(new RoleExport(), 'export/permission.xls');
                $download = 'export/permission.xls';
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
