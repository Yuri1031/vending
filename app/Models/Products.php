<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    public function getList() {
        // Eloquent を使ってデータを取得
        return $this->all();
    }

    public function company()
{
    return $this->belongsTo(Company::class);
}

}
