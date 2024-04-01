<?php

namespace App\Http\Repositories;

use App\Http\Repositories\ProductRepositorieInterface;
use App\Models\Product;
use Illuninate\Database\Eloquent\Collection;

class ProductRepositorie implements ProductRepositorieInterface
{
    public function getById($id)
    {
        return Product::findOrFail($id);
    }

    public function create(array $data)
    {
        return Product::create($data);
    }
    public function getAll()
    {
        return Product::with('sub_category.category')->paginate(2);
    }
    public function popular(){
        // change it to really 6 popular product
        return Product::with('sub_category')->take(6)->get();
    }

    public function update($id, array $data)
    {
        $product = $this->getById($id);
        $product->update($data);
        return $product;
    }

    public function delete($id)
    {
        $product = $this->getById($id);
        $product->delete();
    }
}