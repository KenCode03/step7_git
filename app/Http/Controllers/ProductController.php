<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProductCreateRequest;

class ProductController extends Controller
{
    //一覧ページ
    public function index(Request $request){
        /* $products = Product::all(); */
        /* $products = Product::paginate(2); */ //ページネーション カラム2つで次ページへ

        $company_name = $request->input('company_name');
        $products = Product::where('company_name', 'like', "%$company_name%")->paginate(2);

        return view('product.index',[
            'products' => $products,
        ]);
    }

    //新規作成ページ
    public function new(Request $request){
        return view('product.new',[
        ]);
    }

    //新規追加処理
    //ファイル保存
    public function create(ProductCreateRequest $request){
        \Log::debug('[ProductController][create]');
        $product_name = $request->input("product_name");
        $price = $request->input("price");
        $stock = $request->input("stock");
        $comment = $request->input("comment");
        $company_name = $request->input("company_name");

        $uploadedfile = $request->file('file');

        $validated = $request->validated();
        $product_name = $validated['product_name'];
        $price = $validated['price'];
        $stock = $validated['stock'];
        $comment = $validated['comment'];
        $company_name = $validated['company_name'];

        if($uploadedfile){
            $filename = $uploadedfile->getClientOriginalName();
            /* $filename = $validated['file']; */
            $uploadedfile->storeAs('',$product->id);
        }else{
            $filename = "";
        }

        \Log::debug('[ProductController][create] input =>',[$product_name,$price,$stock,$comment,$company_name,$filename]);

        $product = Product::create([
            "product_name"=>$product_name,
            "price"=>$price,
            "stock"=>$stock,
            "comment"=>$comment,
            "company_name"=>$company_name,
            'filename'=>$filename,
        ]);

        return redirect()->route("product.index");
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
        \Log::debug('[ProductController][edit]');
        \Log::debug('[ProductController][edit]path=>',[$id]);
        $product = Product::find($id);
        return view("product.edit",[
            "product"=>$product,
        ]);
    }

    //既存データ編集処理
    public function update(ProductCreateRequest $request){
        \Log::debug('[ProductController][update]');
        $id = $request->input('id');
        $product_name = $request->input('product_name');
        $price = $request->input('price');
        $stock = $request->input('stock');
        $comment = $request->input("comment");
        $company_name = $request->input("company_name");

        $uploadedfile = $request->file('file');


        $validated = $request->validated();
        $product_name = $validated['product_name'];
        $price = $validated['price'];
        $stock = $validated['stock'];
        $company_name = $validated['company_name'];

        \Log::debug('[ProductController][update] inputs => ',[$id,$product_name,$price,$stock,$comment,$company_name]);
        $product = Product::find($id);
        $product->product_name = $product_name;
        $product->price = $price;
        $product->stock = $stock;
        $product->comment = $comment;
        $product->company_name = $company_name;
        if ($uploadedfile){
            $filename = $uploadedfile->getClientOriginalName();
            $file = $validated['file'];

            $product->filename = $filename;

            $uploadedfile->storeAs('',$product->id);
        };

        $product->save();

        return redirect()->route('product.index');
    }

    //削除処理
    public function delete(Request $request){
        \Log::debug('[ProductController][delete]');
        $id = $request->input('id');
        \Log::debug('[ProductController][delete] input=>',[$id]);
        $product = Product::find($id);
        $product->delete();

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
}
