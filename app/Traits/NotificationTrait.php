<?php


namespace App\Traits;

use App\Constants\ApiMessages;
use App\Constants\ApiStatus;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;
use Pusher\Pusher;

trait NotificationTrait {

    public function send(Array $data) {
        try {

            $pusher = new Pusher(
                '53cbf8c7c95b4a051597',
                '0d1255b35a7a85d4f33e',
                '1106532',
                ['cluster' => 'mt1', 'useTLS' => true]
            );

            $arr = [
                'title' => $data['title'],
                'description' => $data['description'],
                'icon' => $data['icon'],
                'read' => false,
                'active' => true
            ];
            $save = Notification::create($arr);
            if($save) {
                $id = $save->_id;
                $obj = [
                    'id' => $id,
                    'title' => $data['title'],
                    'description' => $data['description'],
                    'icon' => $data['icon'],
                ];
                $pusher->trigger('notification', 'notification', $obj);
            } else {
                return response()->json(['message' => ApiMessages::errorPusher], ApiStatus::unprocessableEntity);
            }

        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json(['message' => ApiMessages::token], ApiStatus::internalServerError);
        }
    }
    public function permission(String $id) {
        try {
            $pusher = new Pusher(
                '53cbf8c7c95b4a051597',
                '0d1255b35a7a85d4f33e',
                '1106532',
                ['cluster' => 'mt1', 'useTLS' => true]
            );

            $obj = [
                'id' => $id,
                'message' => 'Permissão alterada com sucesso',
            ];
            $pusher->trigger('permission', "user_${id}", $obj);

        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json(['message' => ApiMessages::token], ApiStatus::internalServerError);
        }
    }

}
