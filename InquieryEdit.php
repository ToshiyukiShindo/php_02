<?php
include(dirname(__FILE__).'/corplayout.php');
?>
<?php
function connect(){
  $pdo = new PDO('mysql:dbname=gs-project;port=3306;host=localhost;charset=utf8','root','root');
  return $pdo;
} 
?>

<!-- お問い合わせ情報を検索 -->
<?php
try{
    $pdo = connect();
    $iqid = $_GET['iqid'];
    $sql5 = "SELECT * FROM Inqueries WHERE id LIKE :id";
    $statement = $pdo->prepare("$sql5");
    $statement->bindValue(':id',$iqid,PDO::PARAM_INT);
    $statement->execute();
    $resultIq = $statement->fetch(PDO::FETCH_ASSOC);    
} catch (PDOException $e){
  $message="登録に失敗しました。";
}
$message = htmlspecialchars($message);
?>

<!-- お問い合わせレコードを更新 -->
<?php
try{
    $pdo = connect();
    $id6 = $_GET['iqid'];
    $id6_2 = $_POST['iqid2'];
    $name6 = $_POST['iqname'];
    $email6 = $_POST['iqemail'];
    $title6 = $_POST['iqtitle'];
    $category6 = $_POST['iqcategory'];
    $description6 = $_POST['iqdescription'];
    $date6 = $_POST['iqcreated_at'];
    $charge6 = $_POST['iqin_charge'];
    $status6 = $_POST['iqstatus'];
    $closedate6 = $_POST['iqclose_date'];
    $sql6 = "UPDATE `Inqueries` SET `id`='$id6_2',`customer_name`='$name6',`email`='$email6',`title`='$title6',`category`='$category6',`description`='$description6',`created_at`='$date6',`in_charge`='$charge6',`status`='$status6',`close_date`='$closedate' WHERE `id` LIKE :id";
    $statement = $pdo->prepare("$sql6");
    $statement->bindValue(':id',$id6_2,PDO::PARAM_INT);
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
    <h4 class="titletext">InquieryEdit</h4>
    </div>
    <hr>
    <form class="userentry" action="/php_01/InquieryEdit.php" method="post">
                <div class="mb-3">
                    <label for="exampleFormControlInput0" class="form-label">Id</label>
                    <input type="number" class="form-control" id="exampleFormControlInput0" name="iqid2" style="width: 50vw;" value="<?= $_GET['iqid'] ?>">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">お名前</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" name="iqname" placeholder="Enter your name" style="width: 50vw;" value="<?php echo $resultIq['customer_name'];?>">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">e-mail</label>
                    <input type="email" class="form-control" id="exampleFormControlInput0" name="iqemail" placeholder="example@xx.com" style="width: 50vw;" value="<?php echo $resultIq['email'];?>">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">タイトル</label>
                    <input type="text" class="form-control" id="exampleFormControlInput2" name="iqtitle" placeholder="Enter the title" style="width: 50vw;" value="<?php echo $resultIq['title'];?>">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Category</label>
                    <input type="text" class="form-control" id="exampleFormControlInput3" name="iqcategory" placeholder="Any keyword" style="width: 50vw;" value="<?php echo $resultIq['category'];?>">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">お問い合わせ内容</label>
                    <input class="form-control" id="exampleFormControlTextarea4" name="iqdescription" style="width: 50vw;" type="textarea" value="<?php echo $resultIq['description'];?>">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput5" class="form-label">created_at</label>
                    <input type="text" class="form-control" id="exampleFormControlInput5" name="iqcreated_at" style="width: 50vw;" value="<?php echo $resultIq['created_at'];?>">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput6" class="form-label">InCharge</label>
                    <input type="text" class="form-control" id="exampleFormControlInput6" name="iqin_charge" placeholder="Any person" style="width: 50vw;" value="<?php echo $resultIq['in_charge'];?>">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput7" class="form-label">Status</label>
                    <select class="form-control" id="exampleFormControlInput7" name="iqstatus" style="width: 50vw;" value="<?php echo $resultIq['status'];?>">
                        <option value="Not started">Not started</option>
                        <option value="In progress">In progress</option>
                        <option value="Finished">Finished</option>
                        <option value="Pending">Pending</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput8" class="form-label">CloseDate</label>
                    <input type="text" class="form-control" id="exampleFormControlInput8" name="iqclose_date" placeholder="Enter task-finished date" style="width: 50vw;" value="<?php echo $resultIq['close_date'];?>">
                </div>
                <input type="submit" class="btn btn-dark btn-sm h-50" role="button" style="margin-top: 20px;" value="edit"></input>
            </form>

</div>

</section>



</body>
</html>