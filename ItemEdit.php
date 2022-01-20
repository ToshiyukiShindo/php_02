<?php
include(dirname(__FILE__).'/corplayout.php');
?>
<?php
function connect(){
  $pdo = new PDO('mysql:dbname=gs-project;port=3306;host=localhost;charset=utf8','root','root');
  return $pdo;
} 
?>
<?php
try{
    $pdo = connect();
    $itemcode2 = $_GET['itemcode2'];
    $sql3 = "SELECT * FROM items WHERE itemcode LIKE :itemcode";
    $statement = $pdo->prepare("$sql3");
    $statement->bindValue(':itemcode','%'.$itemcode2.'%',PDO::PARAM_STR);
    $statement->execute();
    $resultEdit = $statement->fetch(PDO::FETCH_ASSOC);    
} catch (PDOException $e){
  $message="登録に失敗しました。";
}
$message = htmlspecialchars($message);
?>

<!-- items情報を更新 -->
<?php
try{
    $pdo = connect();
    $itemcode2 = $_GET['itemcode2'];
    $itemcode = $_POST['itemcode3'];
    $cate = $_POST['category3'];
    $itemname = $_POST['itemname3'];
    $price = $_POST['price3'];
    $des = $_POST['description3'];
    $url = $_POST['imgurl3'];
    $date = date('y-m-d');
    $sql4 = "UPDATE `items` SET `itemcode`='$itemcode', `category`='$cate', `itemname`='$itemname',`price`='$price',`description`= '$des',`imgurl`= '$url',`created_at`='$date',`updated_at`= '$date',`delete_flag`='0' WHERE `itemcode` LIKE :itemcode";
    $statement = $pdo->prepare("$sql4");
    $statement->bindValue(':itemcode','%'.$itemcode.'%',PDO::PARAM_STR);
    $statement->execute();
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

<!-- 商品登録欄 -->
<div class="ItemEntry">

    <div class="title">
    <h4 class="titletext">ItemEdit / <a href="/php_01/ItemList.php">ItemList</a></h4>
    </div>
    <hr>
    
    <form class="userentry" action="/php_01/ItemEdit.php" method="post">
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Itemcode</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" name="itemcode3" placeholder="Item_number" value="<?= $_GET['itemcode2'] ?>">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Category</label>
            <input type="number" class="form-control" id="exampleFormControlInput2" name="category3" placeholder="1/2/3" value="<?= $resultEdit['category'] ?>">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Itemname</label>
            <input type="text" class="form-control" id="exampleFormControlInput3" name="itemname3" placeholder="Enter the name" value="<?= $resultEdit['itemname'] ?>">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Price</label>
            <input type="number" class="form-control" id="exampleFormControlInput4" name="price3" placeholder="10000" value="<?= $resultEdit['price'] ?>">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Description</label>
            <textarea class="form-control" id="exampleFormControlTextarea6" name="description3" rows="3" value="<?= $resultEdit['description'] ?>"></textarea>
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Image url</label>
            <input type="text" class="form-control" id="exampleFormControlInput7" name="imgurl3" placeholder="/php_01/asset/xxx.png" value="<?= $resultEdit['imgurl'] ?>">
        </div>
        <input type="submit" class="btn btn-dark btn-sm h-50" role="button" style="margin-top: 20px;" value="register"></input>
    </form>

</div>

</section>



</body>
</html>