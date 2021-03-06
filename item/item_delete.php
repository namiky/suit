<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<title>てすと</title>
</head>
<body>
<?php
try{
  $item_id=$_GET['item_id'];
  #共通関数の読み取り
	require_once('../common/common.php');

  #DB接続
	$dbh=DBconnect();

  #SQL文定義
  $sql='SELECT item.id AS item_id, item.name AS item_name, img_id, img.name AS img_name FROM item JOIN img ON item.img_id=img.id WHERE item.id=?';
  $question[]=$item_id;

  #SQL実行
	$stmt=DBexecute($dbh,$sql,$question);

	#dbh破棄（$stmtを使用するので）
	$dbh=null;

  #sql結果取得
  $rec = $stmt->fetch(PDO::FETCH_ASSOC);
  $item_id=$rec['item_id'];
  $item_name=$rec['item_name'];
  $img_id=$rec['img_id'];
  $img_name=$rec['img_name'];

}catch (Exception $e){
  print'DB障害';
  exit();

}
 ?>
アイテム削除</br>
</br>
<!--アイテムID：<?php print $item_id; ?><br>-->
アイテム名：<?php print $item_name;?><br>
<!--イメージID：<?php print $img_id;?><br>-->
イメージ：
<style type="text/css">img.pic {width: 100px;}</style>
<img class="image img-circle" src="../picture/<?php print $img_name;?>"><br>

このアイテムを削除してよいですか？<br>
紐づいているヒストリ情報も併せてすべて削除します。<br>
<form method="post" action="item_delete_done.php">
  <input type="hidden" name="item_id" value="<?php print $item_id?>"></br>
  <input type="button" onclick="history.back()" value="戻る">
  <input type="submit" value="OK">
</form>


</body>
</html>
