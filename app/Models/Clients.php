<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    protected $fillable = [
        'name','surname', 'phone','promo',
        'used_date', 'product_id', 'is_used',
    ];

    public function product(){
        return $this->hasOne(Products::class, 'id', 'product_id');
    }
}
