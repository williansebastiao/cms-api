<?php

namespace App\Http\Controllers\Api;

use App\Constants\ApiStatus;
use App\Http\Controllers\Controller;
use App\Repositories\NotificationContract as Notification;
use Illuminate\Http\Request;


class NotificationController extends Controller {

    /**
     * @var Notification
     */
    protected $notification;

    /**
     * NotificationController constructor.
     * @param Notification $notification
     */
    public function __construct(Notification $notification) {
        $this->notification = $notification;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function send(Request $request) {
        try {
            return $this->notification->send($request->all());
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()], ApiStatus::internalServerError);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function findAll() {
        try {
            return $this->notification->findAll();
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()], ApiStatus::internalServerError);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function clearNotifications() {
        try {
            return $this->notification->clearNotifications();
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()], ApiStatus::internalServerError);
        }
    }
}
