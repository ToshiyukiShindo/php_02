<?php
include(dirname(__FILE__).'/corplayout.php');
?>
<?php
function connect(){
  $pdo = new PDO('mysql:dbname=gs-project;port=3306;host=localhost;charset=utf8','root','root');
  return $pdo;
} 
?>

<!-- 集計情報を取得 -->
<?php
try{
    $pdo = connect();
    $sqlSales = 'SELECT itemname,sum(total_price) FROM salesrecords GROUP BY itemname ORDER BY sum(total_price) DESC LIMIT 10'; 
    $statement = $pdo->prepare("$sqlSales");
    $statement->execute();
    $resultSales = $statement->fetchAll(PDO::FETCH_ASSOC);
    $name1 = $resultSales[0]['itemname'];
    $name2 = $resultSales[1]['itemname'];
    $name3 = $resultSales[2]['itemname'];
    $name4 = $resultSales[3]['itemname'];
    $name5 = $resultSales[4]['itemname'];
    $name6 = $resultSales[5]['itemname'];
    $name7 = $resultSales[6]['itemname'];
    $name8 = $resultSales[7]['itemname'];
    $name9 = $resultSales[8]['itemname'];
    $name10 = $resultSales[9]['itemname'];
    $sales1 = $resultSales[0]['sum(total_price)'];
    $sales2 = $resultSales[1]['sum(total_price)'];
    $sales3 = $resultSales[2]['sum(total_price)'];
    $sales4 = $resultSales[3]['sum(total_price)'];
    $sales5 = $resultSales[4]['sum(total_price)'];
    $sales6 = $resultSales[5]['sum(total_price)'];
    $sales7 = $resultSales[6]['sum(total_price)'];
    $sales8 = $resultSales[7]['sum(total_price)'];
    $sales9 = $resultSales[8]['sum(total_price)'];
    $sales10 = $resultSales[9]['sum(total_price)'];
} catch (PDOException $e){
    $message="登録に失敗しました。";
}
$message = htmlspecialchars($message);
?>

<!-- ログインユーザー担当のお問い合わせを表示 -->
<?php
try{
    $pdo = connect();
    $selectname = $_GET['selectname'];
    // 商品在庫数を取得
    if(!isset($selectname)){
      $sqlIt = "SELECT `itemcode`,`itemname`,`stock_quantity` FROM `items` LIMIT 5";
      $statement = $pdo->prepare("$sqlIt");
      $statement->execute();
      $resultIt = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
      $sqlIt2 = "SELECT `itemcode`,`itemname`,`stock_quantity` FROM `items` WHERE `itemname` LIKE :selectname";
      $statement = $pdo->prepare("$sqlIt2");
      $statement->bindValue(':selectname','%'.$selectname.'%',PDO::PARAM_STR);
      $statement->execute();
      $resultIt = $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // ログインユーザーの名前を取得
    $sqlCu = "SELECT * FROM `corpusers` WHERE `email` LIKE :email";
    $statement = $pdo->prepare("$sqlCu");
    $statement->bindValue(':email',$_SESSION["corplogin"],PDO::PARAM_STR);
    $statement->execute();
    $resultCu = $statement->fetchAll(PDO::FETCH_ASSOC);
    // 担当のタスクを取得
    $nameIq = $resultCu[0]['name'];
    $sqlIq = "SELECT * FROM `Inqueries` WHERE `in_charge` LIKE :incharge";
    $statement = $pdo->prepare("$sqlIq");
    $statement->bindValue(':incharge',$nameIq,PDO::PARAM_STR);
    $statement->execute();
    $resultIq = $statement->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e){
    $message="失敗しました。";
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
</head>
<body>
    
  <section class="sectionright container">
    <p style="font-size: 20px;font-weight: bold;margin: 0 0 20px 5px"><?= $message ?></p>
    
    <div class="title">
      <div><h4>Sales Sammary</h4></div>
    </div>
    <hr>
    
    <div class="graphcontainer">
      <!-- 販売集計結果を表示 -->
      <div style="width: 85%;">
      <canvas id="myChart" width="80%" height="40%"></canvas>
      </div>
      <script>
const ctx = document.getElementById('myChart').getContext('2d');
const myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [
          `<?=$name1?>`,
          `<?=$name2?>`,
          `<?=$name3?>`,
          `<?=$name4?>`,
          `<?=$name5?>`,
          `<?=$name6?>`,
          `<?=$name7?>`,
          `<?=$name8?>`,
          `<?=$name9?>`,
          `<?=$name10?>`
          ],
        datasets: [{
            label: 'Sales of the items',
            data: [
              <?=$sales1?>,
              <?=$sales2?>,
              <?=$sales3?>,
              <?=$sales4?>,
              <?=$sales5?>,
              <?=$sales6?>,
              <?=$sales7?>,
              <?=$sales8?>,
              <?=$sales9?>,
              <?=$sales10?>,
            ],
            backgroundColor: [
                'rgba(54, 162, 235, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(54, 162, 235, 0.2)'
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});      
</script>


</div>

<!-- 在庫数を表示 -->
<div class="title">
  <div><h4>Stock of the items</h4></div>
</div>
<hr>
<form action="/php_01/corpPortal.php" method="get">
<input name="selectname" class="form-control form-control-sm" type="text" aria-label=".form-control-sm example" style="width: 20vw;" placeholder="any keyword on itemnames">
<input class="btn btn-dark btn-sm" type="submit" style="height: 2rem; width: 70px; margin: 10px 0 0 0;" value="select"></input>
</form>

<table class="table" style="width: 40vw;">
  <thead>
  <?php foreach($resultIt as $record){ ?>
    <tr>
      <th scope="col"><?php echo $record['itemname'];?></th>
      <td><?php echo $record['stock_quantity'];?></td>
    </tr>
    <?php } ?>
  </thead>
  </table>
  <p style="font-size: 14px; color: grey;">※お探しの商品が表示されていなかった場合、商品名を入れて検索してください。</p>


<!-- 担当の問い合わせを表示 -->
<div class="title" style="margin-top: 40px;">
  <div><h4>Inquiries In_charge</h4></div>
</div>
<hr>

    <table class="table table-hover" id="mainlist">
  <thead>
    <tr>
      <th class="small"  scope="col" style="width: 100px;">id</th>
      <th class="small"  scope="col" style="width: 100px;">Date</th>
      <th class="small"  scope="col" style="width: 100px;">CustomerName</th>
      <th class="small"  scope="col" style="width: 100px;">email</th>
      <th class="small"  scope="col" style="width: 150px;">Title</th>
      <th class="small"  scope="col" style="width: 100px;">Category</th>
      <th class="small"  scope="col" style="width: 300px;">お問い合せ内容</th>
      <th class="small"  scope="col" style="width: 100px;">担当者</th>
      <th class="small"  scope="col" style="width: 120px;">対応ステータス</th>
      <th class="small"  scope="col" style="width: 100px;">完了日</th>
      <th class="small"  scope="col">btn</th>
    </tr>
  </thead>
  <tbody class="table2">
  <?php foreach($resultIq as $record){ ?>
    <tr>
      <th scope="row" style="font-size: 12px;"><?php echo $record['id'];?></th>
      <td style="font-size: 12px;"><?php echo $record['created_at'];?></td>
      <td style="font-size: 12px;"><?php echo $record['customer_name'];?></td>
      <td style="font-size: 12px;"><?php echo $record['email'];?></td>
      <td style="font-size: 12px;"><?php echo $record['title'];?></td>
      <td style="font-size: 12px;"><?php echo $record['category'];?></td>
      <td style="font-size: 12px;"><?php echo $record['description'];?></td>
        <td style="font-size: 12px;"><p><?php echo $record['in_charge'];?></p></td>
        <td style="font-size: 12px;"><p><?php echo $record['status'];?></p></td>
        <td style="font-size: 12px;"><p><?php echo $record['close_date'];?></p></td>
        <form action="/php_01/InquieryEdit.php" method="get">
          <input type="text" name="iqid" value="<?php echo $record['id'];?>" style="display: none;">
          <td><input type="submit" class="btn btn-dark btn-sm h-50" style="margin-top: 20px;" value="edit"></input></td>
        </form>
      <td></td>
    </tr>
    <?php }?>
  </tbody>
</table>


</section>

</body>
</html>