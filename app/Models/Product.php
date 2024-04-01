<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'discounted_price',
        'reference',
        'image',
        'qte',
        'qte_order',
        'in_stock',
        'id_sub_catg',
    ];
    public function sub_category(){
        return $this->belongsTo(Sub_Category::class,'id_sub_catg','id');
    }
    

}
