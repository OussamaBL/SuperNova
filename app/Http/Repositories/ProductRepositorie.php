<?php

namespace App\Http\Repositories;

use App\Http\Repositories\ProductRepositorieInterface;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
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
        return Product::with('sub_category.category')->paginate(10);
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
        ->with('sub_category')->orderBy('qte_order','desc')->take(6)->get();  
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

    public function getProducts_filter($subCategory,$option,$userid){
        if($option=='filterByVente'){
            $column='qte_order';
            $order='desc';
        }
        if($option=='order_name_asc'){
            $column='title';
            $order='asc';
        }
        if($option=='order_name_desc'){
            $column='title';
            $order='desc';
        }
        if($option=='price_asc'){
            $column='price';
            $order='asc';
        }
        if($option=='price_desc'){
            $column='price';
            $order='desc';
        }
        return 
        Product::select('products.*')
            ->selectSub(function ($query) use ($userid) {
                $query->select('id')
                ->from('wishlists')
                ->whereColumn('wishlists.prod_id', 'products.id')
                ->where('wishlists.user_id', $userid)
                ->limit(1);
            }, 'wishlist_id')
            ->selectSub(function ($query) use ($userid) {
                $query->select('id')
                ->from('carts')
                ->whereColumn('carts.product_id', 'products.id')
                ->where('carts.user_id', $userid)
                ->limit(1);
            }, 'cart_id')
        ->where('id_sub_catg', $subCategory)
        ->with('sub_category.category')
        ->orderBy($column,$order)
        ->paginate(10);
    }

    public function getProfitMonth(){
        $firstDayOfMonth = date('Y-m-01 00:00:00');
        $currentDate = date('Y-m-d H:i:s');
        return Payment::whereBetween('created_at', [$firstDayOfMonth, $currentDate])->sum('amount');
    }
    public function getSales(){
        return Payment::count();
    }
    public function getCostumers(){
        return User::whereHas('role',function($query) {
            $query->where('name','client');
        })->count();
    }
    public function getProducts(){
        return Product::count();
    }
    public function getRevenue(){
        return Payment::sum('amount');
    }
    public function transactions(){
        return Payment::orderBy('created_at','desc')->take(8)->get();
    }
    
}