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

    public function getInfoProduct($id,$userId){
        return Product::select('products.*')
        ->selectSub(function ($query) use ($userId) {
            $query->select('id')
                ->from('wishlists')
                ->whereColumn('wishlists.prod_id', 'products.id')
                ->where('wishlists.user_id', $userId)
                ->limit(1);
                
        }, 'wishlist_id')
        ->selectSub(function ($query) use ($userId) {
            $query->select('id')
                ->from('carts')
                ->whereColumn('carts.product_id', 'products.id')
                ->where('carts.user_id', $userId)
                ->limit(1);
        }, 'cart_id')
        ->where('id',$id)
        ->with('sub_category.category')
        ->firstOrFail();
    }
    public function create(array $data)
    {
        return Product::create($data);
    }
    public function getAll()
    {
        return Product::with('sub_category.category')->paginate(2);
    }
    public function popular($userId){
        return Product::select('products.*')
        ->selectSub(function ($query) use ($userId) {
            $query->select('id')
                ->from('wishlists')
                ->whereColumn('wishlists.prod_id', 'products.id')
                ->where('wishlists.user_id', $userId)
                ->limit(1);
        }, 'wishlist_id')
        ->selectSub(function ($query) use ($userId) {
            $query->select('id')
                ->from('carts')
                ->whereColumn('carts.product_id', 'products.id')
                ->where('carts.user_id', $userId)
                ->limit(1);
        }, 'cart_id')
        ->with('sub_category')
        ->take(6)->get();
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
    
    public function getProducts_SubCategory($subCategory,$userId){
        return Product::select('products.*')
        ->selectSub(function ($query) use ($userId) {
            $query->select('id')
                ->from('wishlists')
                ->whereColumn('wishlists.prod_id', 'products.id')
                ->where('wishlists.user_id', $userId)
                ->limit(1);
        }, 'wishlist_id')
        ->selectSub(function ($query) use ($userId) {
            $query->select('id')
                ->from('carts')
                ->whereColumn('carts.product_id', 'products.id')
                ->where('carts.user_id', $userId)
                ->limit(1);
        }, 'cart_id')
        ->where('id_sub_catg', $subCategory)
        ->with('sub_category.category')
        ->paginate(10);
    }

    public function getRelated_Products($subCategory,$product,$userId){
        return Product::select('products.*')
        ->selectSub(function ($query) use ($userId) {
            $query->select('id')
                ->from('wishlists')
                ->whereColumn('wishlists.prod_id', 'products.id')
                ->where('wishlists.user_id', $userId)
                ->limit(1);
        }, 'wishlist_id')
        ->selectSub(function ($query) use ($userId) {
            $query->select('id')
                ->from('carts')
                ->whereColumn('carts.product_id', 'products.id')
                ->where('carts.user_id', $userId)
                ->limit(1);
        }, 'cart_id')
        ->where('id_sub_catg', $subCategory)
        ->where('id','<>',$product)
        ->with('sub_category.category')
        ->take(6)->get();
    }

    public function getProducts_filter($subCategory,$option){
        // if($option=='filterByVente')
        if($option=='order_name_asc') return Product::where('id_sub_catg',$subCategory)->with('sub_category.category')->orderBy('title','asc')->paginate(10);
        if($option=='order_name_desc') return Product::where('id_sub_catg',$subCategory)->with('sub_category.category')->orderBy('title','desc')->paginate(10);
        if($option=='price_asc') return Product::where('id_sub_catg',$subCategory)->with('sub_category.category')->orderBy('price','asc')->paginate(10);
        if($option=='price_desc') return Product::where('id_sub_catg',$subCategory)->with('sub_category.category')->orderBy('price','desc')->paginate(10);
    }
}