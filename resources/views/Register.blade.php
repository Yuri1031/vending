<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>register</title>
    <link rel="stylesheet" href="{{asset('/css/register&edit.css')}}">
  </head>


  <body>
    <div class="base">
      <div class="row"><h2>商品新規登録画面</h2></div>
      <div class="row">
        <form method="POST" action="{{route('register.store')}}" enctype="multipart/form-data" >
          @csrf
          <div class="form-group">
            商品名　
            <input type="text" name="product_name" placeholder="商品名" required>
          </div>

          <div class="form-group">
              メーカー
              <select class="choices" name="company_id" required>
                <option value="" disabled selected>メーカー名</option>
                  @foreach ($companies as $company)
                  <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                  @endforeach 
              </select>
          </div>


          <div class="form-group">
            価格　　
            <input placeholder="価格" type="number" name="price">
          </div>

          <div class="form-group">
            在庫数　
            <input placeholder="在庫数" type="number" name="stock">
          </div>

          <div class="form-group">
            コメント
            <textarea placeholder="コメント" name="comment" rows="3"></textarea>
          </div>
          
          <div class="form-group">
            商品画像
            <input placeholder="商品画像" type="file" name="img">
          </div>

          <div class="form-group">
            <input class="go" type="submit" value="登録">
            <a href="{{route('list')}}"><input class="back" type="button" value="戻る"></a>
          </div>

        @if ($errors->any())
          <div class="alert alert-danger">
            <ul>
              @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
            </ul>
         </div>
        @endif

                
        </form>
      </div>
      
     
    </div>


    
  </body>
</html>