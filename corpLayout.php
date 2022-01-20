<!-- ログイン情報の取得 -->
<?php
session_start();

//ログインされていない場合は強制的にログインページにリダイレクト
if (!isset($_SESSION["corplogin"])) {
  header("Location: corpLogin.php");
  exit();
}

if (!isset($_SESSION["corplogin"])) {
    $message = "";}
else {
    $message = $_SESSION['corplogin']."さん、ようこそ！";
    }
$message = htmlspecialchars($message);
?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="/php_01/portal.css">
    <title>portal</title>
</head>
<body>
    <header class="header">
        <div class="headerleft">
            <p>G's platform</p>
        </div>
        <div class="headerright">
            <a class="btn btn-dark btn-sm h-50" href="/php_01/portal.php" role="button">Portal</a>
            <a class="btn btn-dark btn-sm h-50" href="/php_01/corpPortal.php" role="button">Home</a>
            <a class="btn btn-dark btn-sm h-50" href="/php_01/corpLogin.php" role="button">Login</a>
            <a class="btn btn-dark btn-sm h-50" href="/php_01/corpLogout.php" role="button">Logout</a>
            <a class="btn btn-dark btn-sm h-50" href="/php_01/corpRegister.php" role="button">Register</a>
            </div>
    </header>
    
    <!-- 左の検索画面 -->
    <section class="main">        
        <section class="sectionleft">
            <nav class="nav">
                <ul>
                  <li class="nav__item"><a href="/php_01/ItemEntry.php">商品管理</a></li>
                  <li class="nav__item"><a href="/php_01/Post.php">記事管理</a></li>
                  <li class="nav__item"><a href="/php_01/InquieryList.php">お問い合せ管理</a></li>
                </ul>
            </nav>

        </section>
        <section class="sectionright"></section>
            
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>