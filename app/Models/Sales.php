<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Products;

class Sales extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'product_id', 'quantity', 'total_price'];

    public function product()
    {
        return $this->belongsTo(Products::class);
    }

    
}
