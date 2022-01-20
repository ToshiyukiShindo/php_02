<?php
include(dirname(__FILE__).'/userlayout.php');
?>

<!-- ログイン情報の取得 -->
<?php
session_start();

if (!isset($_SESSION["login"])) {
  header("Location: portal.php");
  exit();
}

if (!isset($_SESSION["login"])) {
  $message = "";}
else {
  $message = $_SESSION['login']."さん";
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
    <section class="sectionright container">
    <div><p style="font-size: 20px;font-weight: bold;margin: 5px 0 0 5px"><?= $message ?></p></div>

    <!-- ここから確認欄 -->
    <div>
    <img src="<?= $_POST['biurl'] ?>" alt="">
    <table class="table table-hover" style="width: 60vw;">
      <thead>
        <tr>
          <th>項目</th>
          <th>内容</th>
        </tr>
      </thead>
      <form action="/php_01/buyClose.php" method="post">
        <tbody>
          <tr>
            <td><p>ItemCode</p></td>
            <td><input name="concode" type="text" value="<?= $_POST['bicode'] ?>" style="border:none;"></input></td>
          </tr>
          <tr>
            <td><p>ItemName</p></td>
            <td><input name="conname" type="text" value="<?= $_POST['biname'] ?>" style="border:none;"></input></td>
          </tr>
          <tr>
            <td><p>Price</p></td>
            <td><input name="conprice" type="text" value="<?= $_POST['biprice'] ?>" style="border:none;"></input></td>
          </tr>
          <tr>
            <td><p>Amount</p></td>
            <td><input name="conamount" type="number" value="1"></input></td>
          </tr>
          <tr>
            <td><p>Description</p></td>
            <td><input name="condes" type="text" value="<?= $_POST['bides'] ?>" style="border:none;"></input></td>
          </tr>
        </tbody>
      </table>
      <input class="btn btn-dark btn-sm" type="submit" style="height: 2rem; width: 70px; margin: 10px 0 0 10px;" value="Buy"></input>
    </form>
    </div>
    <div ><a class="btn btn-dark btn-sm" href="/php_01/portal.php" role="button" style="height: 2rem; width: auto; margin: 20px 0 0 10px;">Homeへ戻る</a></div>
      
  </section>

</body>
</html>