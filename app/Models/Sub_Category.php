<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sub_Category extends Model
{
    use HasFactory;

    protected $table ='sub_categories';
    protected $fillable = [
        'name',
        'image',
        'id_catg',
    ];
    public function category(){
        return $this->belongsTo(Category::class,'id_catg','id');
    }
}
