<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Company;
use Illuminate\Support\Facades\Validator;



class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $companies = Company::all();
        $model = new Products();
        $products = $model->getList();
        return view('list', ['products' => $products, 'companies' => $companies]);
    } 

    public function getList()
{
    // Eager load the company relationship
    $products = Products::with('company')->get();
    return $products;
}

public function searchIndex(Request $request)
{
    $keyword = $request->input('keyword');
    $companies = Company::all();
    $maker = $request->input('maker');

    $query = Products::query();

    if (!empty($keyword)) {
        $query->where('product_name', 'LIKE', "%{$keyword}%");
    }

    if (!empty($maker)) {
        $query->where('company_id', $maker);
    }

    $products = $query->get();

    return view('list', compact('keyword', 'products','companies'));
}




    //public function indexDetail()
    //{
    //    return view('detail');
    //}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $companies = Company::all();
        return view('Register')
           -> with('companies',$companies);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    $request->validate([
        'product_name' => 'required',
        'company_id' => 'required',
        'price' => 'required|integer',
        'stock' => 'required|integer',
    ]);

    $product = new Products;
    $product->img_path = $request->img;
    $product->product_name = $request->product_name;
    $product->company_id = $request->company_id;
    $product->price = $request->price;
    $product->stock = $request->stock;
    $product->comment = $request->comment;
    $product->save();
    return redirect()->route('list'); // データ保存後に一覧画面にリダイレクト
}
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
{
    $productId = $request->route('id'); // ルートパラメータ 'id' を取得
    // モデルを取得
    $product = Products::findOrFail($productId);
    $companies = Company::all();

    return view('edit', compact('product','companies'));
    
}



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
{   
    // バリデーションルール
    $rules = [
        'product_name' => 'required',
        'company_id' => 'required',
        'price' => 'required|integer',
        'stock' => 'required|integer',
    ];

    
    $product=Products::find ($id);
    // バリデーションが成功した場合の処理
    $product->img_path = $request->img;
    $product->product_name = $request->product_name;
    $product->company_id = $request->company_id;
    $product->price = $request->price;
    $product->stock = $request->stock;
    $product->comment = $request->comment;
    $product->save();

    return redirect()->route('list');
}



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
{
    $product = Products::findOrFail($id);
    $product->delete();
    return redirect()->route('list');
}

}
