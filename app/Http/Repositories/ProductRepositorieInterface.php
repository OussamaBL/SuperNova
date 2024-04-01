<?php

namespace App\Http\Repositories;


interface ProductRepositorieInterface
{
    public function getById($id);

    public function getAll();
    public function popular();
    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);
}