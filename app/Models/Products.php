<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use Kyslik\ColumnSortable\Sortable;

class Products extends Model
{
    use HasFactory;
    use Sortable;

    // メソッドを追加
    public static function getList()
    {
        // Eager load the company relationship
        return self::with('company')->get();
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}