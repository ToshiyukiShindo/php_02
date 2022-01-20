<?php
include(dirname(__FILE__).'/corplayout_login.php');
?>
<?php
function connect(){
  $pdo = new PDO('mysql:dbname=gs-project;port=3306;host=localhost;charset=utf8','root','root');
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  return $pdo;
}
?>

<?php
session_start();
try {
  $pdo = connect();
}
catch (PDOException $e) {
  exit ('データベースエラー');
}

if (isset($_SESSION["corplogin"])) {
  session_regenerate_id(TRUE);
  header("Location: corpPortal.php");
  exit();
}

// ログイン処理
if ($_POST["corpemail"] === "" && $_POST["corppass"] ==="") {
  $message = "データを入力してください";
} else {
  if(empty($_POST["corpemail"]) || empty($_POST["corppass"])) {
    $message = "メールアドレスとパスワードを入力してください";
  } else {
    try {
      $stmt = $pdo -> prepare('SELECT * FROM `corpusers` WHERE `email` LIKE :email');
      $stmt -> bindParam(':email', $_POST['corpemail'], PDO::PARAM_STR);
      $stmt -> execute();
      $resultCorp = $stmt -> fetch(PDO::FETCH_ASSOC);
    } 
    catch (PDOException $e) {
      exit('データベースエラー');
    }

    if (!password_hash($_POST['corppass'], PASSWORD_DEFAULT) === $resultCorp['token']) {
      $message="ユーザー名かパスワードが違います";
    } else {
      // setcookie('corpLoginCode',password_hash($_POST['corppass'], PASSWORD_DEFAULT),time()+60*60*24*7);
      session_regenerate_id(TRUE); //セッションidを再発行
      $_SESSION["corplogin"] = $_POST['corpemail']; //セッションにログイン情報を登録
      header("Location: corpPortal.php"); //ログイン後のページにリダイレクト
      exit();
    }}}
$message = htmlspecialchars($message);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>portal</title>
</head>
<body>
    
    <section class="main"> 
    <section class="sectionright container"> 

    <div class="title">
        <h4 class="titletext">CorpUser Login</h4>
    </div>
    <hr>


<form class="userentry" method="post" action="/php_01/corpLogin.php">
<div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label">EmailAddress</label>
  <input type="email" class="form-control" id="exampleFormControlInput1" name="corpemail" placeholder="name@example.com">
</div>
<div class="mb-3">
  <label for="exampleFormControlInput2" class="form-label">Password</label>
  <input type="password" class="form-control" id="exampleFormControlInput2" name="corppass">
</div>
<input type="submit" class="btn btn-dark btn-sm h-50" role="button" style="margin-top: 20px;" value="login"></input>
</form>
</section>
</section>
 
</body>
</html>