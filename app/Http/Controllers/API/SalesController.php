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

        // トランザクションの開始
        DB::beginTransaction();

        try {
            // 商品情報取得
            $product = Products::findOrFail($request->input('product_id'));

            // 在庫確認
            if ($product->stock < $request->input('quantity')) {
                // 在庫が不足している場合はエラー
                return response()->json(['error' => '在庫が不足しています。'], 400);
            }

            // 購入処理
            $sales = new Sales();
            $sales->product_id = $product->id;
            $sales->quantity = $request->input('quantity');
            $sales->total_price = $product->price * $request->input('quantity');
            $sales->save();

            // 在庫更新
            $product->stock -= $request->input('quantity');
            $product->save();

            // トランザクションのコミット
            DB::commit();

            return response()->json(['message' => '購入が完了しました。']);
        } catch (QueryException $e) {
            // 例外発生時はロールバック
            DB::rollBack();

            return response()->json(['error' => '購入処理中にエラーが発生しました。'], 500);
        }
    }
}
