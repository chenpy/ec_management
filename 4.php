<?php
// Connect to database
include 'mysql_connect.php';
if(isset($_POST["search"])){
  $sql= "SELECT * from summary where";
  $appendSQL = "";
  //  Make mall search string
  switch ($_POST["mall"]) {
    case 'Yahoo':
      $appendSql .= " `モール` = 'Yahoo' AND";
      break;
  
    case 'ポンパレモール':
      $appendSql .= " `モール` = 'ポンパレモール' AND";
      break;
  
    case 'Qoo10':
      $appendSql .= " `モール` = 'Qoo10' AND";
      break;
  
    case 'Amazon':
      $appendSql .= " `モール` = 'Amazon' AND";
      break;
  
    case 'Rakuten':
      $appendSql .= " `モール` = 'Rakuten' AND";
      break;

    default:
      break;
  }
  if($_POST["orderId"]!= ""){
    $appendSql .= " `注文番号` = '$_POST[orderId]' AND";
  }
  if($_POST["trackId"]!= ""){
    $appendSql .= " `注文番号` = '$_POST[trackId]' AND";
  }

  $appendSql.=" 1";

 
  $result = $conn->query($sql.$appendSql);
  if ($result->num_rows > 0) {
          echo "<table border='1'>
          <tr>
          <th>モール</th>
          <th>注文番号</th>
          <th>宅配商品</th>
          <th>お問い合わせ番号</th>
          <th>注文者名前</th>
          <th>注文日 </th>
          <th>注文者電話番号</th>
          <th>送付先電話番号</th>
          <th>送付先郵便番号</th>
          <th>送付先住所</th>
          <th>処理コメント</th>
          </tr>";
  // output data of each row
    while($row = $result->fetch_assoc()) {
      echo "<tr>";
      echo "<td>" . $row['モール'] . "</td>";
      echo "<td>" . $row['注文番号'] . "</td>";
      $GLOBALS['orderId'] = $row['注文番号'];
      echo "<td>" . $row['宅配商品'] . "</td>";
      echo "<td>" . $row['お問い合わせ番号'] . "</td>";
      echo "<td>" . $row['注文者名前'] . "</td>";
      echo "<td>" . $row['注文日'] . "</td>";
      echo "<td>" . $row['注文者電話番号'] . "</td>";
      echo "<td>" . $row['送付先電話番号'] . "</td>";
      echo "<td>" . $row['送付先郵便番号'] . "</td>";
      echo "<td>" . $row['送付先住所'] . "</td>";
      echo "<td>" . $row['処理コメント'] . "</td>";
      echo "</tr>";
      //echo "id: " . $row["id"]. " - Name: " . $row["name"]. "*" . $row["unit"]. "<br>";
    }
  } else {
    echo "0 results";
  }
}

?>
<?php
if(isset($_POST["update"])){
  if($_POST["orderIdConfirmed"] != null){  
    $sql = "UPDATE summary
      SET `お問い合わせ番号`='$_POST[resendTrackId]', `処理コメント`='$_POST[workComment]'
      WHERE `注文番号`= '$_POST[orderIdConfirmed]'";
        echo "<br>".$sql."<br>";
  }
  echo "<br>".$sql."<br>";
  if ($conn->query($sql) === TRUE) {
        echo "Update data successfully";
    } else {
        echo "Error update table: " . $conn->error;
    }
}
?>

<html>
<head>
  <title>Upload</title>
  <style>
   .upload {
      float:left;
      width:50%;
      height:25%;
    }
  </style>
</head>
<meta charset="UTF-8">
<body>
<form method="post">
<h1>再発送、処理コメント入力</h1>
    <select name="mall">
    <option value="Rakuten">楽天</option>
    <option value="Yahoo">ヤフー</option>
    <option value="Amazon">アマゾン</option>
    <option value="ポンパレモール">ポンパレモール</option>
    <option value="Qoo10">Qoo10</option>
  </select><br>
    注文番号: <input type="text" name="orderId"><br>
    お問い合わせ番号: <input type="text" name="trackId"><br>
    <input type="submit" value="検索" name="search"><br>
    選択された注文番号: <?php echo $orderId; ?>
    <input type="hidden" name="orderIdConfirmed" value="<?php echo $orderId; ?>">
    再発送お問い合わせ番号: <input type="text" name="resendTrackId"><br>
    処理コメント: <input type="text" name="workComment"><br>
    <input type="submit" value="変更" name="update">
    </form>
</body>
</html>
