<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>list</title>
    <link rel="stylesheet" href="{{asset('/css/list.css')}}">
   
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- tablesorter プラグイン -->
    <script src="{{ asset('/js/jquery.tablesorter.min.js') }}"></script>
    <!-- ※jQuery書き方 https://uxmilk.jp/11074 -->
    <!-- ※テーブルソート機能ヒント https://qiita.com/anomeme/items/5475c5e8ba9136e73b4e -->
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
  </head>

  <body>
      <div class="row">
        <h2>商品一覧画面</h2>
      </div>

    <div class="base">

      <form class="search" id="search-form" action="{{ route('search') }}" method="GET">
        @csrf
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
         <p>
           <label for="min_price">価格 下限:</label>
           <input type="number" name="min_price" id="min_price">
           <label for="max_price">     上限:</label>
           <input type="number" name="max_price" id="max_price">
         </p>
         <p>
           <label for="min_stock">在庫 下限:</label>
           <input type="number" name="min_stock" id="min_stock">
           <label for="max_stock">     上限:</label>
           <input type="number" name="max_stock" id="max_stock">
         </p>
        </div>

        <div class="search-group">
          <input class="go" id="search-button" type="submit" value="検索">
        </div>

        <div class="new">
          <a href="{{route('register.create')}}"><input class="register" type="button" value="新規登録"></a>
        </div>

     </form>
        
        
     
           

     <div class="table" id="product-tabl">
       <table border="1" id="sortable-table">
         <thead>
           <tr>
             <th class="sortable">@sortablelink('id', 'ID')</th>
             <th class="sortable">@sortablelink('img_path', '商品画像')</th>
             <th class="sortable">@sortablelink('product_name', '商品名')</th>
             <th class="sortable">@sortablelink('price', '価格')</th>
             <th class="sortable">@sortablelink('stock', '在庫数')</th>
             <th class="sortable">@sortablelink('company.company_name', 'メーカー名')</th>
           </tr>
         </thead>

         <tbody>
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
             <td><a href="{{ route('edit', $product->id) }}"><input class="detail" type="submit" name="submit"
                         value="詳細&編集"></a></td>
             <td class="ml-2">
                 <form method="POST" action="{{ route('destroy', $product) }}">
                     @csrf
                     @method('delete')
                     <input class="del" type="submit" name="delete" value="削除" onClick="return confirm('削除しますか？')">
                 </form>
             </td>
          </tr>
          @endforeach
         </tbody>
       </table>






       
 <script>
    //検索ボタン処理
    $('#search-button').click(function (event) {
        event.preventDefault(); // ボタンがクリックされたときデフォルトの動作をストップ
        console.log('ボタンがクリックされました');
        performSearch();
    });

    function performSearch() {
        // フォーム入力情報の取得
        var keyword = $('#keyword').val();
        let formData = $('#search-form').serialize();

        // Laravelのroute関数を使ってURLを取得
        var searchUrl = "{{ route('search') }}";

        // Ajaxリクエストを送信
        $.ajax({
            url: searchUrl,
            type: "GET",
            data: formData,
            dataType: "html",
        }).done(function (data) {
            // 検索結果を表示する処理など
            let newTable = $(data).find('#sortable-table');
            $('#sortable-table').replaceWith(newTable);// テーブルすり替え変更
            $('#sortable-table').tablesorter();// テーブル変更後再度 tablesorter を初期化
        }).fail(function (error) {
            console.error('Error:', error);
        });
    };



    //削除ボタン処理  
    $(document).ready(function () {
        // 商品削除の非同期処理
        $('.del').click(function (event) {
            event.preventDefault();

            console.log('ボタンがクリックされました');

            var form = $(this).closest('form');
            var url = form.attr('action');

            // Ajaxリクエストを送信
            $.ajax({
                url: url,
                type: "DELETE",
                dataType: "json",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                // 削除が成功した場合の処理
                success: function (data) {
                    console.log('Delete success');// 該当の行を非表示にする
                    form.closest('tr').fadeOut();},// または hide() を使用
                // エラーが発生した場合の処理
                error: function (error) {
                    console.error('Error:', error);
                }
            });
        });
    });



    
</script>


      </div>
     
    </div>
  </body>
</html>
