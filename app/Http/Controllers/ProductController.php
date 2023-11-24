<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;

use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProductCreateRequest;

//トランザクション
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    //一覧ページ
    public function index(Request $request){
        $companies = Company::all();

        $query = Product::query();
        $product_name = $request->input('product_name');
        $company_id = $request->input ('company_id');
        $price_upper = $request->input('price-upper');
        $price_lower = $request->input('price-lower');
        $stock_upper = $request->input('stock-upper');
        $stock_lower = $request->input('stock-lower');

        if(!empty($product_name)){
            $query->where('product_name', 'like', "%$product_name%");
        }

        if(!empty($company_id)){
            $query->where('company_id', 'like', "%$company_id%");
        }

        if(!empty($price_upper)){
            $query->where('price', '<=', "$price_upper");
        }

        if(!empty($price_lower)){
            $query->where('price', '>=', "$price_lower");
        }

        if(!empty($stock_upper)){
            $query->where('stock', '<=', "$stock_upper");
        }

        if(!empty($stock_lower)){
            $query->where('stock', '>=', "$stock_lower");
        }

        $products = $query->paginate(4);


        return view('product.index',[
            "products"=>$products,
            'companies' => $companies,
        ]);
    }

    //新規作成ページ
    public function new(Request $request){
        $companies = Company::all();

        return view('product.new',[
            'companies' => $companies,
        ]);
    }

    //新規追加処理
    //ファイル保存
    public function create(ProductCreateRequest $request)
    {
    \Log::debug('[ProductController][create]');

    // トランザクション開始
    DB::beginTransaction();

    try {
        // フォームからデータ取得
        $productData = $request->only(['product_name', 'price', 'stock', 'comment', 'company_id']);
        $uploadedfile = $request->file('file');

        // ファイルをアップロード
        $filename = $uploadedfile->getClientOriginalName();

        // データのバリデーション
        $validatedData = $request->validated();

        // モデルを使用して商品を作成
        $product = Product::createProduct(array_merge($productData, ['filename' => $filename]));

        if($uploadedfile){
            $filename = $uploadedfile->getClientOriginalName();
            $uploadedfile->storeAs('',$product->id);
        }else{
            $filename = "";
        }

        // トランザクションをコミット
        DB::commit();
    } catch (\Exception $e) {
        // エラーが発生した場合、トランザクションをロールバック
        DB::rollback();

        // エラーハンドリングを行う
        return redirect()->back()->with('error', '商品の作成中にエラーが発生しました。');
    }

    return redirect()->route("product.new");
    }

    //詳細ページ
    public function show(Request $request,$id){
        \Log::debug('[ProductController][show]');
        \Log::debug('[ProductController][show]path=>',[$id]);
        $product = Product::find($id);
        return view("product.show",[
            "product"=>$product,
        ]);
    }

    //編集ページ
    public function edit(Request $request,$id){
        $companies = Company::all();

        \Log::debug('[ProductController][edit]');
        \Log::debug('[ProductController][edit]path=>',[$id]);
        $product = Product::find($id);
        return view("product.edit",[
            "product"=>$product,
            'companies' => $companies,
        ]);
    }

    //既存データ編集処理
    public function update(ProductCreateRequest $request)
    {
    \Log::debug('[ProductController][update]');
    $id = $request->input('id');
    $data = [
        'product_name' => $request->input('product_name'),
        'price' => $request->input('price'),
        'stock' => $request->input('stock'),
        'comment' => $request->input('comment'),
        'company_id' => $request->input('company_id'),
    ];
    $uploadedFile = $request->file('file');

    DB::beginTransaction();
    try {
        $validated = $request->validated();

        $product = Product::find($id);
        $product->updateProduct($data);

        if ($uploadedFile) {
            $filename = $uploadedFile->getClientOriginalName();
            $product->update(['filename' => $filename]);
            $uploadedFile->storeAs('', $id);
        }

        DB::commit();
    } catch (\Exception $e) {
        DB::rollback();
        return redirect()->back()->with('error', '商品の更新中にエラーが発生しました。');
    }

    return redirect()->route('product.edit', ['id' => $id]);
    }

    //削除処理
    public function delete(Request $request){
        \Log::debug('[ProductController][delete]');
        $id = $request->input('id');
        \Log::debug('[ProductController][delete] input=>',[$id]);

        DB::beginTransaction();

        try{
            $result = Product::deleteProduct($id);
            /* $product = Product::find($id);
            $product->delete(); */
            DB::commit();
        } catch (\Exception $e){
            DB::rollback();
            return redirect()->back()->with('error', '商品の削除中にエラーが発生しました。');
        }
        return redirect()->route('product.index');
    }

    //ファイル取得
    public function getfile(Request $request , $id){
        $product = Product::find($id);
        $storedfilename = $product->id;
        $filename = $product->filename;
        $mimeType = Storage::mimeType($storedfilename);
        $headers = [['Content-Type' => $mimeType]];
        return storage::response($storedfilename,$filename,$headers);
    }

    //練習
    public function apiproduct(Request $request){
        $products = Product::all();
        $result = [];
        foreach($products as $product){
            $result[] = [
                'id'=>$product->id,
                'product_name'=>$product->product_name,
                'price'=>$product->price,
            ];
        }
        return response()->json($result);
    }

    //削除非同期
    public function destroy(Request $request){
        $id = Product::find($id);
        $id->delete();
    }
}
