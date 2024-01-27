<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'product_id', 'quantity', 'total_price'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public static function purchaseProduct($productId, $quantity)
    {
        $product = Product::findOrFail($productId);

        // 在庫確認
        if ($product->stock < $quantity) {
            return ['error' => '在庫が不足しています。'];
        }

        // 購入処理
        $totalPrice = $product->price * $quantity;

        try {
            self::create([
                'product_id' => $productId,
                'quantity' => $quantity,
                'total_price' => $totalPrice,
            ]);

            // 在庫更新
            $product->stock -= $quantity;
            $product->save();

            return ['message' => '購入が完了しました。'];
        } catch (\Exception $e) {
            return ['error' => '購入処理中にエラーが発生しました。'];
        }
    }
}
