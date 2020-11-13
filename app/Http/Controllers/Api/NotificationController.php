<?php

namespace App\Http\Controllers\Api;

use App\Constants\ApiStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Pusher\Pusher;

class NotificationController extends Controller {

    public function send(Request $request) {

        $pusher = new Pusher(
            '53cbf8c7c95b4a051597',
            '0d1255b35a7a85d4f33e',
            '1106532',
            ['cluster' => 'mt1', 'useTLS' => true]
        );

        $id = Str::random(16);
        $data = ['_id' => $id, 'text' => $request->message];
        $pusher->trigger('stup', 'notification', $data);
        return response()->json(['message' => $request->message, '_id' => $id], ApiStatus::success);
    }
}
