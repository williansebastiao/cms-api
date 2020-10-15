<?php


namespace App\Repositories;


interface ClientContract {

    public function authenticate(Array $data);
    public function me();
    public function findAll();
    public function findById($id);
    public function store(Array $data);
    public function register(Array $data);
    public function update(Array $data, String $id);
    public function avatar(Array $data, $avatar);
    public function profile(Array $data);
    public function password(Array $data);
    public function destroy(String $id);

}
