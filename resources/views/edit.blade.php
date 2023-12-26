<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>edit</title>
    <link rel="stylesheet" href="{{asset('/css/register&edit.css')}}">
  </head>

  <body>
    <div class="base">
      <div class="row"><h2>商品情報編集画面</h2></div>
      
      
      <div class="row">
        <form method="POST" action="{{ route('update.list', ['id' => $product->id]) }}" enctype="multipart/form-data">
         @csrf
         <div class="form-group">
            商品名　
            <input type="text" value="{{ old('product_name', $product->product_name) }}" name="product_name" required>
          </div>
                  
          <div class="form-group">
              メーカー
              <select class="choices" name="company_id" required>
                <option value="" disabled selected>メーカー名</option>
                  @foreach ($companies as $company)
                  <option value="{{ $company->id }}" {{($company->id == $product->company_id) ? 'selected' : ''}}>
                    {{ $company->company_name }}
                  </option>
                  @endforeach 
              </select>
          </div>
          
          <div class="form-group">
            価格　　
            <input value="{{ old('price',$product->price) }}" type="number" name="price">
          </div>

          <div class="form-group">
            在庫数　
            <input value="{{ old('stock',$product->stock) }}" type="number" name="stock">
          </div>

          <div class="form-group">
            コメント
            <textarea value="{{ $product->comment }}" name="comment" rows="3"></textarea>
          </div>
          
          <div class="form-group">
            商品画像
            <input type="file" name="img">
            @if ($product->img_path)
               <img src="{{ asset($product->img_path) }}" alt="商品画像" width="300" >
            @else
               <p>画像未登録</p>
            @endif
          </div>

          <input type="submit" class="go" value="編集完了">
          <a href="{{route('list')}}"><input class="back" type="button" value="戻る"></a>

        </form>
          <!-- バリデーションエラーの表示 -->
          @if ($errors->any())
          <div class="alert alert-danger">
            <ul>
              @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
            </ul>
         </div>
        @endif
       
      </div>
    </div>   
  </body>
</html>

