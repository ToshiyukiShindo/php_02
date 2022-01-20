<?php
include(dirname(__FILE__).'/userLayout.php');
?>
<?php
function connect(){
  $pdo = new PDO('mysql:dbname=gs-project;port=3306;host=localhost;charset=utf8','root','root');
  return $pdo;
} 
?>

<!-- ログイン情報の取得 -->
<?php
session_start();
if (!isset($_SESSION["login"])) {
    $message = "";}
else {
    $message = $_SESSION['login']."さん、ようこそ！";
    }
$message = htmlspecialchars($message);
?>

<!-- itemsの一覧データの取得（検索結果出なければ全て表示） -->
<?php
try{
    $pdo = connect();
    $itemlist = $_GET['itemslist'];
    $itemkey = $_GET['itemskey'];

    // 購入履歴を取得
    if(isset($_SESSION['login'])){
        $mail = $_SESSION['login'];
        $sqljoin = "SELECT * FROM `salesrecords` LEFT JOIN `items` ON salesrecords.itemcode = items.itemcode WHERE `customer_email` LIKE :email ORDER BY id DESC";
        $statement = $pdo->prepare("$sqljoin");
        $statement->bindValue(':email',$mail,PDO::PARAM_STR);
        $statement->execute();
        $resultjoin = $statement->fetchAll(PDO::FETCH_ASSOC);    
    }

    if(isset($itemlist) && isset($itemkey)){
        $sql = "SELECT * FROM `items` WHERE `$itemlist` LIKE :itemlist";
        $statement = $pdo->prepare("$sql");
        $statement->bindValue(':itemlist','%'.$itemkey.'%',PDO::PARAM_STR);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);    
    } else {
        $statement = $pdo->prepare('SELECT * FROM `items`'); //WHERE delete_flag ==0 で削除フラグを有効にできる
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);    
    }
} catch (PDOException $e){
    // echo "Itemsデータの取得に失敗しました。";
}
$message = htmlspecialchars($message);
?>


<!-- postsデータを取得（検索結果出なければ最新の３件を表示） -->
<?php
try{
    $pdo = connect();
    $postlist = $_GET['postslist'];
    $postkey = $_GET['postskey'];
    if(isset($postlist) && isset($postkey)){
        $sql = "SELECT * FROM `posts` WHERE `$postlist` LIKE :postlist";
        $statement = $pdo->prepare("$sql");
        $statement->bindValue(':postlist','%'.$postkey.'%',PDO::PARAM_STR);
        $statement->execute();
        $result2 = $statement->fetchAll(PDO::FETCH_ASSOC);    
    } else {
    $statement = $pdo->prepare('SELECT * FROM posts ORDER BY postid DESC LIMIT 3');
    $statement->execute();
    $result2 = $statement->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e){
    // $message="Postsデータ取得に失敗しました。";
}
$message = htmlspecialchars($message);
?>

<!-- お問い合わせをデータベース登録して管理側に共有 -->
<?php
try{
    $pdo = connect();
    $statement = $pdo->exec("DELETE FROM `Inqueries` WHERE `title`='' ");
    $cname = $_POST['name'];
    $cemail = $_POST['mail'];
    $ctitle = $_POST['title'];
    $ccategory = $_POST['category'];
    $cdes = $_POST['description'];
    $cdate = date('y-m-d');
    $statement = $pdo->exec("INSERT INTO `Inqueries`(`customer_name`, `email`, `title`, `category`, `description`, `created_at`, `in_charge`, `status`, `close_date`) VALUES ('$cname','$cemail','$ctitle','$ccategory','$cdes','$cdate','','','')");
} catch (PDOException $e){
//   $message="お問い合わせを再度ご登録ください。";
}
$message = htmlspecialchars($message);
?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
            
    <!-- 右のプロダクト一覧 -->
    <section class="right">
        <p style="font-size: 20px;font-weight: bold;margin: 5px 0 0 5px"><?= $message ?></p>
        <section class="sectionright container">
            <div class="title">
                <p class="titletext">Items</p>
            </div>
            <hr style="width: 76vw;">
            
            <ul class="itemlist">
                <?php foreach($result as $record){ ?>
                <li class=" list-group-item-action">
                    <div class="card"  style="width: 210px; height: 380px;">
                            <img src="<?= $record['imgurl']?>" class="card-img-top" alt="..." style="width: 200px; height:200px;">
                            <div class="card-body">
                                <h6 class="card-title">Name: <?php echo $record['itemname'];?></h6>
                                <p class="card-text">Category: <?php echo $record['category'];?></p>
                                <p class="card-text">Price: <?php echo $record['price'];?></p>
                                <form action="/php_01/buyConfirm.php" method="post">
                                    <input type="text" value="<?php echo $record['itemcode'];?>" style="display: none;" name="bicode">
                                    <input type="text" value="<?php echo $record['itemname'];?>" style="display: none;" name="biname">
                                    <input type="number" value="<?php echo $record['price'];?>" style="display: none;" name="biprice">
                                    <input type="text" value="<?php echo $record['description'];?>" style="display: none;" name="bides">
                                    <input type="text" value="<?php echo $record['imgurl'];?>" style="display: none;" name="biurl">
                                    <input type="submit" class="btn btn-primary" value="BuyNow"></input>
                                </form>
                            </div>
                    </div>    
                </li>
                    <?php }?>
                </ul>
                <hr style="width: 76vw;">
        </section>
        
        <!-- 購入履歴 -->
        <section class="sectionright container">
        <p style="font-size: 20px;">購入履歴</p>
        <hr style="width: 76vw;">
        <p><?php if(!isset($_SESSION['login'])){echo "ログインしてください。";} ?></p>
        <ul class="itemlist">
                <?php foreach($resultjoin as $record){ ?>
                <li class=" list-group-item-action">
                    <div class="card2"  style="width: 150px; height: 200px;">
                            <img src="<?= $record['imgurl']?>" class="card-img-top" alt="..." style="width: 130px; height:130px;">
                            <form action="/php_01/buyConfirm.php" method="post">
                                    <input type="text" value="<?php echo $record['itemcode'];?>" style="display: none;" name="bicode">
                                    <input type="text" value="<?php echo $record['itemname'];?>" style="display: none;" name="biname">
                                    <input type="number" value="<?php echo $record['price'];?>" style="display: none;" name="biprice">
                                    <input type="text" value="<?php echo $record['description'];?>" style="display: none;" name="bides">
                                    <input type="text" value="<?php echo $record['imgurl'];?>" style="display: none;" name="biurl">
                                    <input type="submit" class="btn btn-primary" value="BuyNow"></input>
                                </form>
                            </div>
                    </div>    
                </li>
                    <?php }?>
                </ul>
                <hr style="width: 76vw;">
        </section>




        <!-- Posts -->
        <section class="sectionright container">
            <div class="title">
                <p class="titletext">Posts</p>
            </div>
            <hr style="width: 76vw;">
            <ul class="itemlist2">
                <?php foreach($result2 as $record){ ?>
                    <li class=" list-group-item-action">
                        <div class="card" style="width: 60%; height: 150px">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $record['title'];?></h5>
                                <h6 class="card-subtitle mb-2 text-muted"><?php echo $record['category'];?></h6>
                                <p class="card-text text-truncate"><?php echo $record['description'];?></p>
                                <a href="#" class="card-link">link</a>
                            </div>
                        </div>
                    </li>
                    <?php }?>
                </ul>
                <hr style="width: 76vw;">
        </section>
        
        <!-- お問い合わせ -->
        <section class="sectionright container">
            <div class="title">
                <p class="titletext">お問い合わせ</p>
            </div>
            <hr style="width: 76vw;">
            <form class="userentry" action="/php_01/portal.php" method="post">
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">お名前</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" name="name" placeholder="Enter your name" style="width: 50vw;">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">e-mail</label>
                    <input type="email" class="form-control" id="exampleFormControlInput0" name="mail" placeholder="example@xx.com" style="width: 50vw;"  value="<?= $_SESSION["login"]?>">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">タイトル</label>
                    <input type="text" class="form-control" id="exampleFormControlInput2" name="title" placeholder="Enter the title" style="width: 50vw;">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Category</label>
                    <input type="text" class="form-control" id="exampleFormControlInput3" name="category" placeholder="Any keyword" style="width: 50vw;">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">お問い合わせ内容</label>
                    <textarea class="form-control" id="exampleFormControlTextarea4" name="description" rows="4" style="width: 50vw;"></textarea>
                </div>
                <input type="submit" class="btn btn-dark btn-sm h-50" role="button" style="margin-top: 20px;" value="post"></input>
            </form>
            <hr style="width: 76vw;">
        </section>
    
</body>
</html>