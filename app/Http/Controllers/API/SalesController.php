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
            // 商品情報を取得
            $product = Product::findOrFail($request->input('product_id')); // 正しい名前空間を指定

            // 在庫確認
            if ($product->stock < $request->input('quantity')) {
                return response()->json(['error' => '在庫が不足しています。'], 400);
            }

            // 購入処理
            $totalPrice = $product->price * $request->input('quantity');
            Sales::create([
                'product_id' => $product->id,
                'quantity' => $request->input('quantity'),
                'total_price' => $totalPrice,
            ]);

            // 在庫数の更新
            $product->stock -= $request->input('quantity');
            $product->save();

            // トランザクションをコミット
            DB::commit();

            // 正常レスポンス
            return response()->json(['message' => '購入が完了しました。']);
        } catch (\Exception $e) {
            // トランザクションをロールバック
            DB::rollBack();

            return response()->json(['error' => '購入処理中にエラーが発生しました。'], 500);
        }
    }
}
