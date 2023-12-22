<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>list</title>
    <link rel="stylesheet" href="{{asset('/css/list.css')}}">
  </head>

  <body>
      <div class="row">
        <h2>商品一覧画面</h2>
      </div>

    <div class="base">

      <form class="search" action="{{ route('search') }}" method="GET">
        <div class="search-group">
          <input type="text" name="keyword" placeholder="検索キーワード">
        </div>

        <div class="search-group">
          <select class="choices" name="maker">
             <option>メーカー名</option>
              @foreach ($companies as $company)
             <option value="{{ $company->id }}">{{ $company->company_name }}</option>
              @endforeach 
          </select>
        </div>
        
        <div class="search-group">
          <input class="go" type="submit" value="検索">
        </div>
        <div class="new">
        <a href="{{route('register.create')}}"><input class="register" type="button" value="新規登録"></a>
        </div>
</form>
        

      <div class="table">
        <table border="1">
          <tr>
            <th>ID</th>
            <th>商品画像</th>
            <th>商品名</th>
            <th>価格</th>
            <th>在庫数</th>
            <th>メーカー名</th>
            
          </tr>

          @foreach ($products as $product)
          <tr>
            <td>{{ $product->id }}</td>
            <td>
              @if ($product->img_path)
                <img src="{{ asset($product->img_path) }}" alt="商品画像" width="100" height="50">
              @else
                No Image
              @endif
            </td>
            <td>{{ $product->product_name }}</td>
            <td>￥{{ $product->price }}</td>
            <td>{{ $product->stock }}</td>
            <td>{{ $product->company->company_name }}</td>
            <td><a href="{{route('edit',$product->id)}}"><input class="detail" type="submit" name="submit" value="詳細&編集"></a></td>
            <td class="ml-2">
              <form method="POST" action="{{route('destroy',$product)}}">
                @csrf
                @method('delete')
                <input class="del" type="submit" name="delete" value="削除" onClick="return confirm('削除しますか？')">
              </form>
            </td>
          </tr>
          @endforeach 
        </table>
      </div>
     
    </div>
  </body>
</html>