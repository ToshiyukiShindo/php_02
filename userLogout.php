<?php
include(dirname(__FILE__).'/userlayout.php');
?>

<?php
//セッションを使うことを宣言
session_start();

//ログインされていない場合は強制的にログインページにリダイレクト
if (!isset($_SESSION["login"])) {
  header("Location: portal.php");
  exit();
}

//セッション変数をクリア
$_SESSION = array();

//クッキーに登録されているセッションidの情報を削除
if (ini_get("session.use_cookies")) {
  setcookie(session_name(), '', time() - 42000, '/');
}

//セッションを破棄
session_destroy();
$message = htmlspecialchars($message);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <section class="sectionright container">
        <div><p class="undertext">ログアウトしました。</p></div>
        <div><a class="btn btn-dark btn-sm" href="/php_01/portal.php" role="button" style="height: 2rem; width: auto; margin-left: 20px;">Homeへ戻る</a></div>
    </section>

</body>
</html>