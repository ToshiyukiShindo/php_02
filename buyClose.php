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
?>

<!-- 購入内容のDB登録 -->
<?php
function connect(){
  $pdo = new PDO('mysql:dbname=gs-project;port=3306;host=localhost;charset=utf8','root','root');
  return $pdo;
} 
?>
<?php
try{
    $pdo = connect();
    $customerEmail = $_SESSION['login'];
    $code = $_POST['concode'];
    $name = $_POST['conname'];
    $price = $_POST['conprice'];
    $camount = $_POST['conamount'];
    $buysql = "INSERT INTO `salesrecords`(`id`, `customer_email`, `itemcode`, `itemname`, `price`, `amount`, `total_price`, `sales_date`, `cancel_flag`) VALUES (NULL,'$customerEmail','$code','$name','$price','$camount',price*amount,sysdate(),'0')";
    $statement = $pdo->exec("$buysql");
    $searchsql = "SELECT `itemcode`,`stock_quantity` FROM `items` WHERE `itemcode` LIKE :code1";
    $statement = $pdo->prepare("$searchsql");
    $statement->bindValue(':code1',$code,PDO::PARAM_STR);
    $statement->execute();
    $searchresult = $statement->fetch(PDO::FETCH_ASSOC);
    $stock = $searchresult['stock_quantity']; 
    $stocksql = "UPDATE `items` SET `stock_quantity` = $stock-$camount,`updated_at`= sysdate() WHERE `itemcode` LIKE :code2";
    $statement = $pdo->prepare("$stocksql");
    $statement->bindValue(':code2',$code,PDO::PARAM_STR);
    $statement->execute();
    $stockresult = $statement->fetch(PDO::FETCH_ASSOC);
    $message = "Yes";
    }
catch (PDOException $e){
  $message = "No";
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
        <div><p class="undertext">お買い上げありがとうございます！</p></div>
        <div><a class="btn btn-dark btn-sm" href="/php_01/portal.php" role="button" style="height: 2rem; width: auto; margin-left: 20px;">Homeへ戻る</a></div>
    </section>
</body>
</html>