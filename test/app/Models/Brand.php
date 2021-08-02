<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['kor_name', 'eng_name', 'introduction', 'cnt'];

    public function product(){
        return $this->hasMany('App\Models\Product');
    }
}
