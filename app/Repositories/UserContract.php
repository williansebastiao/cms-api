<?php


namespace App\Repositories;


interface UserContract {

    public function authenticate(Array $data);
    public function me();
    public function findAll();
    public function findById($id);
    public function findByName(String $name);
    public function filterByOrder(String $name);
    public function filterByStatus(String $name);
    public function filterByRole(String $name);
    public function store(Array $data);
    public function register(Array $data);
    public function update(Array $data, String $id);
    public function profile(Array $data);
    public function avatar(Array $data);
    public function personal(Array $data);
    public function address(Array $data);
    public function password(Array $data);
    public function disable(String $id);
    public function destroy(String $id);
    public function restore(String $id);
    public function export();

}
