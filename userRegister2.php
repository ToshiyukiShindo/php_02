<?php
include(dirname(__FILE__).'/userlayout.php');
function connect(){
  $pdo = new PDO('mysql:dbname=gs-project;port=3306;host=localhost;charset=utf8','root','root');
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  return $pdo;
} 
?>

<?php
try{
    $pdo = connect();
    $statement = $pdo->exec("DELETE FROM `users` WHERE `username`='' ");
    $uid = $_POST['userid'];
    $uname = $_POST['username'];
    $uemail = $_POST['email'];
    $upass = $_POST['password'];
    $uhashedpass = password_hash($upass, PASSWORD_DEFAULT);
    $statement = $pdo->exec("INSERT INTO `users`(`user id`, `username`, `email`, `password`) VALUES ('$uid','$uname','$uemail','$uhashedpass')");
    $message="登録に成功しました。";
} catch (PDOException $e){
  $message="登録に失敗しました。";
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
        <div><p class="undertext"><?= $message ?></p></div>
        <div><a class="btn btn-dark btn-sm" href="/php_01/portal.php" role="button" style="height: 2rem; width: auto; margin-left: 20px;">Homeへ戻る</a></div>
    </section>

</body>
</html>