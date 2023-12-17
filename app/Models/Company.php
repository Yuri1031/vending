<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Company extends Model
{
   // public function getList()
    //{
        // companiesテーブルからデータを取得
        //$companies = DB::table('companies')->get();
        //return $companies;
    //}

    // Companies.php モデル内に追加
public static function getList()
{
    return self::all();
}


    
}
