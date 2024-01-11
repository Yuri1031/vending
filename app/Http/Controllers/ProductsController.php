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
        $products = Products::sortable()->get();
        return view('list', ['products' => $products, 'companies' => $companies]);
    } 

    public function getList()
{
    $products = Products::getList();
}


public function searchIndex(Request $request)
{
    // リクエストからの検索条件取得
    $keyword = $request->input('keyword');
    $maker = $request->input('maker');
    $minPrice = $request->input('min_price');
    $maxPrice = $request->input('max_price');
    $minStock = $request->input('min_stock');
    $maxStock = $request->input('max_stock');

    // ページネーションを考慮した検索クエリ
    $query = Product::query();
        if ($keyword) { $query->where('product_name', 'LIKE', '%' . $keyword . '%'); }
        if ($maker) { $query->where('company_id', $maker); }
        if ($minPrice !== null && $maxPrice !== null) { $query->whereBetween('price', [$minPrice, $maxPrice]); }
        if ($minStock !== null && $maxStock !== null) { $query->whereBetween('stock', [$minStock, $maxStock]); }

    // ページネーションを適用して結果取得
    $products = $query->with('company')->paginate(10);
    return view('list', compact('keyword', 'products'));
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
    try {
        $request->validate([
            'product_name' => 'required',
            'company_id' => 'required',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'img' => 'image|mimes:jpeg,png,jpg,gif',
        ]);

        // 画像が選択されている場合にのみバリデーションルールを追加
        $rules = [
            'product_name' => 'required',
            'company_id' => 'required',
            'price' => 'required|integer',
            'stock' => 'required|integer',
        ];
        if ($request->hasFile('img')) {
            $rules['img'] = 'image|mimes:jpeg,png,jpg,gif';
        }

        // バリデーションが成功した場合の処理
        $request->validate($rules);

        // 商品情報を新規作成
        $product = new Products;
        $product->product_name = $request->product_name;
        $product->company_id = $request->company_id;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->comment = $request->comment;

        // 画像が選択されている場合にのみ新しい画像を保存
        if ($request->hasFile('img')) {
            $image = $request->file('img');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/images', $imageName);
            $product->img_path = 'storage/images/' . $imageName;
        }

        $product->save();

        return redirect()->route('list');
    } catch (ValidationException $e) {
        // バリデーションエラーが発生した場合の処理
        return redirect()->back()->withErrors($e->errors())->withInput();
    }
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
    public function update(Request $request, $id)
{
    try {
        // バリデーションルール
        $rules = [
            'product_name' => 'required',
            'company_id' => 'required',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'img' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        $request->validate($rules);

        $product = Products::find($id);

        // 商品画像がアップロードされた場合の処理
        if ($request->hasFile('img')) {
            // 画像を保存
            $image = $request->file('img');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/images'), $imageName);
            $product->img_path = 'storage/images/' . $imageName;
        }

        // 商品情報の更新
        $product->product_name = $request->product_name;
        $product->company_id = $request->company_id;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->comment = $request->comment;
        $product->save();

        return redirect()->route('list');
    } catch (ValidationException $e) {
        // バリデーションエラーが発生した場合の処理
        return redirect()->back()->withErrors($e->errors())->withInput();
    }
}




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $product = Products::findOrFail($id);
            $product->delete();
    
            return response()->json(['success' => true]);
        } catch (ModelNotFoundException $e) {
            // モデルが見つからなかった場合の処理
            return response()->json(['error' => '指定された商品が見つかりません。']);
        } catch (\Exception $e) {
            // その他の例外が発生した場合の処理
            return response()->json(['error' => '予期せぬエラーが発生しました。']);
        }
    }
}
