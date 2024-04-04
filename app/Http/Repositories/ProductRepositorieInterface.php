<?php

namespace App\Http\Repositories;


interface ProductRepositorieInterface
{
    public function getById($id);
    public function getInfoProduct($id);

    public function getAll();
    public function popular();
    public function getProducts_SubCategory($subCategory);
    public function getRelated_Products($subCategory,$product);
    public function getProducts_filter($subCategory,$option);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);
}