<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $fillable = [
        'name', 'description', 'quantity', 'probability', 'is_active', 'bgColor', 'color', 'image'
    ];
    public function clients()
    {
        return $this->hasMany(Clients::class, 'product_id');
    }
}
