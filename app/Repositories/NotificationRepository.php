<?php


namespace App\Repositories;
use App\Constants\ApiMessages;
use App\Constants\ApiStatus;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;
use Pusher\Pusher;


class NotificationRepository implements NotificationContract {

    protected $notification;

    public function __construct(Notification $notification) {
        $this->notification = $notification;
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
            ->orderBy('created_at', 'desc')
            ->take(15)
            ->get();
    }
}
