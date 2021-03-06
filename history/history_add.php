<?php session_start();?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>てすと</title>
    <link rel="stylesheet" href="../css/style.css">
    <!-- Bootstrap-select利用のためのライブラリ読み込み -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/bootstrap-select.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script src="../js/bootstrap-select.js"></script>
    <!-- Bootstrap-select利用のためのライブラリ読み込み ここまで-->
  </head>

<?php
try{

#共通関数の読み取り
require_once('../common/common.php');
$user_id=$_SESSION['user_id'];

#DB接続
$dbh=DBconnect();
$sql='SELECT item.id AS item_id, item.name AS item_name, item.img_id AS img_id, img.name AS img_name
      FROM item JOIN img ON item.img_id=img.id
      WHERE item.user_id=?
      ORDER BY item.id';

#
$question[]=$user_id;

#SQL実行
$stmt=DBexecute($dbh,$sql,$question);


#dbh破棄（$stmtを使用するので）
$dbh=null;

 ?>

  <body>
    ヒストリー追加</br></br>
    <form method="post" action="history_add_check.php">

      該当日付</br>
      <input type="date" name="history_date" value="<?php print(date("Y-m-d"));?>"><br>
      アイテム名を選択してください</br>
      <select title="Select your surfboard" class="selectpicker" name="item_id">

  <?php
        while(true){
          $rec=$stmt->fetch(PDO::FETCH_ASSOC);
          if($rec==false){
            break;
          }
          print '<option data-thumbnail="../picture/'.$rec['img_name'].'" value="'.$rec['item_id'].'">'.$rec['item_name'].'</option>';
        }
      }
      catch(Exception $e){
        print'DB障害';
        var_dump($e);
        exit();
      }
  ?>
      </select>

      </br>
      <input type="button" onclick="history.back()" value="戻る">
      <input type="submit" value="OK">

    </form>
  </body>
</html>
