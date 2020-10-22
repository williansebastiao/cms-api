<?php


namespace App\Repositories;


interface PermissionContract {

    public function findAll();
    public function store(Array $data);
    public function update(Array $data, String $id);
    public function destroy(String $id);

}
