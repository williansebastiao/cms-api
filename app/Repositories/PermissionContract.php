<?php


namespace App\Repositories;


interface PermissionContract {

    public function findAll();
    public function findById(String $id);
    public function findAllOrderByDate();
    public function findByName(String $name);
    public function store(Array $data);
    public function update(Array $data, String $id);
    public function destroy(String $id);
    public function export();

}
