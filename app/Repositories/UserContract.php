<?php


namespace App\Repositories;


interface UserContract {

    public function authenticate(Array $data);
    public function me();
    public function findAll();
    public function findById($id);
    public function store(Array $data);
    public function register(Array $data);
    public function update(Array $data, String $id);
    public function password(Array $data);
    public function destroy(String $id);

}
