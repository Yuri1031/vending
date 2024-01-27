<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sales;
use App\Models\Products; 
use Illuminate\Support\Facades\DB; 
use Illuminate\Database\QueryException;

class SalesController extends Controller
{
    public function purchase(Request $request)
    {
        // バリデーション
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // 購入処理をモデルに委譲
        $result = Sales::purchaseProduct($request->input('product_id'), $request->input('quantity'));

        if (isset($result['error'])) {
            // エラーレスポンス
            return response()->json($result, 400);
        }

        // 正常レスポンス
        return response()->json($result);
    }
}
