<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sales;
use App\Models\Products;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function purchase(Request $request)
    {
        // バリデーション
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1', // 数値であり、1以上であることを確認
        ]);

        // トランザクションを開始
        DB::beginTransaction();

        try {
            // 購入処理
            $result = Sales::purchaseProduct($request->input('product_id'), $request->input('quantity'));

            if (isset($result['error'])) {
                // エラーレスポンス
                return response()->json($result, 400);
            }

            // トランザクションをコミット
            DB::commit();

            // 正常レスポンス
            return response()->json($result);
        } catch (\Exception $e) {
            // トランザクションをロールバック
            DB::rollBack();

            return response()->json(['error' => '購入処理中にエラーが発生しました。'], 500);
        }
    }
}
