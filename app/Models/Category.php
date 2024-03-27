<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];
    public function sub_categories(){
        return $this->hasMany(Sub_Category::class,'id','id_catg');
    }
}
