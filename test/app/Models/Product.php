<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['name', 'status', 'o_price', 's_price', 'image_path', 'brand_id'];

    public function category(){
        return $this->hasMany('App\Models\Category');
    }

    public function brand(){
        return $this->belongsTo('App\Models\Brand');
    }
}
