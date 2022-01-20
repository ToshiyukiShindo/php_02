<?php
include(dirname(__FILE__).'/userlayout.php');
?>
<?php 
function connect(){
  $pdo = new PDO('mysql:dbname=gs-project;port=3306;host=localhost;charset=utf8','root','root');
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  return $pdo;
}
?>

<?php
session_start();

// DBに接続
try {
  $pdo = connect();
}
catch (PDOException $e) {
  exit ('データベースエラー');
}

// ログイン状態の場合、メインページに遷移
if (isset($_SESSION["login"])) {
  session_regenerate_id(TRUE);
  header("Location: portal.php");
  exit();
}

// しばらくログイン入力エラーチェック
if ($_POST["useremail"] === "" && $_POST["userpass"] ==="") {
  $message = "入力がありません";
}
else {
  if(empty($_POST["useremail"]) || empty($_POST["userpass"])) {
    $message = "ユーザー名とパスワードを入力してください";
  }
  else {
    //post送信されてきたユーザー名がデータベースにあるか検索
    try {
      $sql = "SELECT * FROM `users` WHERE `email` LIKE :email";
      $stmt = $pdo -> prepare("$sql");
      $stmt -> bindParam(':email', $_POST['useremail'], PDO::PARAM_STR);
      $stmt -> execute();
      $resultLogin = $stmt -> fetch(PDO::FETCH_ASSOC);
    }
    catch (PDOException $e) {
      exit('データベースエラー');
    }

    if (!password_verify($_POST['userpass'], $resultLogin['password'])) {
      $message="ユーザー名かパスワードが違います";
    }
    else {
      session_regenerate_id(TRUE); //セッションidを再発行
      $_SESSION["login"] = $_POST['useremail']; //セッションにログイン情報を登録
      header("Location: portal.php"); //ログイン後のページにリダイレクト
      exit();
    }
  }
}
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
  <section class="main"> 

<section class="sectionright container">

<div class="title">
        <h4 class="titletext">User Login</h4>
    </div>
    <hr>

    <form class="userentry" action="/php_01/userLogin.php" method="post">
<div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label">Email address</label>
  <input type="email" class="form-control" id="exampleFormControlInput1" name="useremail" placeholder="name@example.com">
</div>
<div class="mb-3">
  <label for="exampleFormControlInput2" class="form-label">Password</label>
  <input type="password" class="form-control" id="exampleFormControlInput2" name="userpass">
</div>
<input type="submit" class="btn btn-dark btn-sm h-50" role="button" style="margin-top: 20px;" value="login"></input>
</form>
<p><?= $message ?></p>
</section>
</section>

</body>
</html>