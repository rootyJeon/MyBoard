<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category_product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['category_id', 'product_id'];
}
