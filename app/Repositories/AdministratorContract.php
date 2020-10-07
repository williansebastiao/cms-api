<?php


namespace App\Repositories;


interface AdministratorContract {

    public function authenticate(Array $data);
    public function me();
    public function findAll();
    public function findById($id);
    public function store(Array $data);
    public function update(Array $data, Int $id);
    public function avatar(Array $data, $avatar);
    public function profile(Array $data);
    public function password(Array $data);
    public function destroy(Int $id);

}
