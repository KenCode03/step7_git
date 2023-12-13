<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;
use App\Models\Sale;

use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function purchase (Request $request) {

        DB::beginTransaction();
        try{
            $productId = $request->input('product_id');
            $quantity = $request->input('quantity', 1);

            $product = Product::find($productId);

            if (!$product) {
                return response()->json(['message' => '商品が存在しません']);
            }
            if ($product->stock < $quantity) {
                return response()->json(['message' => '商品が在庫不足です']);
            }

            $product->stock -= $quantity;
            $product->save();

            $sale = new Sale([
                'product_id' => $productId,
            ]);

            $sale->save();
            DB::commit();
        } catch(\Exception $e){
            DB::rollback();
            return redirect()->back()->with('error','商品の作成中にエラーが発生しました。');
        }
        return response()->json(['message' => '購入成功']);

    }
}
