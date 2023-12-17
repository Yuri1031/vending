<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>signin</title>
    <link rel="stylesheet" href="{{asset('/css/login&signin.css')}}">
  </head>
  <body>
   <div class="base">
    <div class="row">
        <h2>ユーザー登録画面</h2>
    </div>
    <div class="row">
        <form action="login.html" method="POST">
            <div class="form-group">
                <div class="input-group">
                    <input type="text" name="username" placeholder="ユーザー名" required>
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <input type="text" name="mail" pattern="^[a-zA-Z0-9]+$" placeholder="アドレス" required>
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <input type="password" name="password" placeholder="パスワード" required>
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <input type="password" name="confirm" placeholder="パスワード(確認用)" oninput="checkPassword(this)" required>
                </div>
            </div>

            <div class="form-group">
                <input id="signin" type="submit" value="新規登録"></a>
                <a href="{{route('/')}}"><input id="login" type="button" value="戻る"></a>
            </div>
        </form>
    </div>
   </div>
    <script>
        function checkPassword(confirmInput) {
            // 入力値取得
            var passwordInput = document.querySelector('input[name="password"]');
            var input1 = passwordInput.value;
            var input2 = confirmInput.value;
            
            // パスワード一致確認
            if (input1 !== input2) {
                confirmInput.setCustomValidity('パスワードが一致しません');
            } else {
                confirmInput.setCustomValidity('');
            }
        }
    </script>

  </body>
</html>
