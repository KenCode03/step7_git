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

        $product_name = $request->input('product_name');

        $company_id = $request->input ('company_id');

        $products = Product::where('product_name', 'like', "%$product_name%")->where('company_id', 'like', "%$company_id%")->paginate(2);

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
    public function create(ProductCreateRequest $request){

        \Log::debug('[ProductController][create]');

        //トランザクション開始
        DB::beginTransaction();

        try{
            //フォームからデータ取得
            $product_name = $request->input("product_name");
            $price = $request->input("price");
            $stock = $request->input("stock");
            $comment = $request->input("comment");
            $company_id = $request->input ('company_id');

            $uploadedfile = $request->file('file');

            if($uploadedfile){
                $filename = $uploadedfile->getClientOriginalName();
            } else{
                $filename = "";
            }

            //データのバリデーション
            $validated = $request->validated();
            $product_name = $validated['product_name'];
            $price = $validated['price'];
            $stock = $validated['stock'];
            $comment = $validated['comment'];

            \Log::debug('[ProductController][create] input =>',[$product_name,$price,$stock,$comment,$company_id,$filename]);

            //商品をデータベースに作成
            /* $product = Product::create([
                "product_name"=>$product_name,
                "price"=>$price,
                "stock"=>$stock,
                "comment"=>$comment,
                "company_id"=>$company_id,
                'filename'=>$filename,
            ]); */
            $product = Product::create($data);

            //ファイルをアップロード
            if($uploadedfile){
                $filename = $uploadedfile->getClientOriginalName();
                $uploadedfile->storeAs('',$product->id);
            }else{
                $filename = "";
            }

            //トランザクションをコミット
            DB::commit();
        } catch(\Exception $e) {
            //エラーが発生した場合、トランザクションをロールバック
            DB::rollback();


            //エラーハンドリングを行う
            return redirect()->back()->with('error','商品の作成中にエラーが発生しました。');
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
    public function update(ProductCreateRequest $request){
        \Log::debug('[ProductController][update]');
        $id = $request->input('id');
        $product_name = $request->input('product_name');
        $price = $request->input('price');
        $stock = $request->input('stock');
        $comment = $request->input("comment");
        $company_id = $request->input('company_id');

        $uploadedfile = $request->file('file');

        DB::beginTransaction();
        try{
            $validated = $request->validated();
            $product_name = $validated['product_name'];
            $price = $validated['price'];
            $stock = $validated['stock'];

            \Log::debug('[ProductController][update] inputs => ',[$id,$product_name,$price,$stock,$comment/* ,$company_name */]);
            $product = Product::find($id);
            $product->product_name = $product_name;
            $product->price = $price;
            $product->stock = $stock;
            $product->comment = $comment;
            $product->company_id = $company_id;


            if ($uploadedfile){
                $filename = $uploadedfile->getClientOriginalName();

                $product->filename = $filename;

                $uploadedfile->storeAs('',$product->id);
            };

            $product->save();

            DB::commit();
        } catch (\Exception $e) {

            DB::rollback();

            return redirect()->back()->with('error', '商品の更新中にエラーが発生しました。');
        }

        return redirect()->route('product.edit',['id'=>$id]);
    }

    //削除処理
    public function delete(Request $request){
        \Log::debug('[ProductController][delete]');
        $id = $request->input('id');
        \Log::debug('[ProductController][delete] input=>',[$id]);

        DB::beginTransaction();

        try{
            $product = Product::find($id);
            $product->delete();

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
}
