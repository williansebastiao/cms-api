<?php


namespace App\Repositories;


interface NotificationContract {

    public function send(Array $data);
    public function findAll();
    public function clearNotifications();

}
