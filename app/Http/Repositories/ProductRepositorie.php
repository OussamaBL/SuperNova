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
    public function getInfoProduct($id){
        return Product::where('id',$id)->with('sub_category.category')->firstOrFail();
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
    
    public function getProducts_SubCategory($subCategory){
        return Product::where('id_sub_catg',$subCategory)->with('sub_category.category')->paginate(10);
    }
    public function getRelated_Products($subCategory,$product){
        return Product::where('id_sub_catg',$subCategory)->where('id','<>',$product)->with('sub_category.category')->take(6)->get();
    }
    public function getProducts_filter($subCategory,$option){
        // if($option=='filterByVente')
        if($option=='order_name_asc') return Product::where('id_sub_catg',$subCategory)->with('sub_category.category')->orderBy('title','asc')->paginate(10);
        if($option=='order_name_desc') return Product::where('id_sub_catg',$subCategory)->with('sub_category.category')->orderBy('title','desc')->paginate(10);
        if($option=='price_asc') return Product::where('id_sub_catg',$subCategory)->with('sub_category.category')->orderBy('price','asc')->paginate(10);
        if($option=='price_desc') return Product::where('id_sub_catg',$subCategory)->with('sub_category.category')->orderBy('price','desc')->paginate(10);
    }
}