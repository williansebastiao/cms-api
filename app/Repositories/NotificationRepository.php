<?php


namespace App\Repositories;
use App\Constants\ApiMessages;
use App\Constants\ApiStatus;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Pusher\Pusher;


class NotificationRepository implements NotificationContract {

    protected $notification, $user;

    public function __construct(Notification $notification, User $user) {
        $this->notification = $notification;
        $this->user = $user;
    }

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
                'read' => false,
                'active' => true
            ];
            $save = $this->notification->create($arr);
            if($save) {
                $id = $save->_id;
                $obj = ['_id' => $id, 'message' => $arr];
                $pusher->trigger('notification', 'notification', $obj);
            } else {
                return response()->json(['message' => ApiMessages::errorPusher], ApiStatus::unprocessableEntity);
            }

        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json(['message' => ApiMessages::token], ApiStatus::internalServerError);
        }
    }

    /**
     * @return mixed
     */
    public function findAll() {
        return $this->notification->where('active', true)
            ->where('read', false)
            ->orderBy('created_at', 'desc')
            ->take(15)
            ->get();
    }

    public function clearNotifications() {
        try {
            $id = auth()->user()->id;
            $notification = [
                'notification' => [
                    'counter' => 0,
                    'read' => true
                ]
            ];
            $this->user->find($id)->update($notification);
            return response()->json(['message' => ApiMessages::clearNotification], ApiStatus::success);
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json(['message' => ApiMessages::clearNotificationError], ApiStatus::internalServerError);
        }
    }
}
