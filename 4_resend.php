<?php
// Connect to database
include 'mysql_connect.php';

$sql= "SELECT * from summary where";
$appendSql = " `モール` = '$_POST[mall]' AND";

//注文番号
if($_POST["orderId"]!= ""){
  $appendSql .= " `注文番号` = '$_POST[orderId]' AND";
}
//名前(カタカナ相似比較):
if($_POST["katakanaName"]!= ""){
  $appendSql .= " `注文者名前カタカナ` LIKE '%$_POST[katakanaName]%' AND";
}
//注文期間:
if($_POST["startYear"]!= "" && $_POST["startMonth"]!= "" && $_POST["startDay"]!= ""){
  $appendSql .= " date(`注文日`) >= date '$_POST[startYear]-$_POST[startMonth]-$_POST[startDay]' AND";
}

if($_POST["endYear"] != "" && $_POST["endMonth"]!= "" && $_POST["endDay"]!= ""){
  $appendSql .= " date(`注文日`) <= date '$_POST[endYear]-$_POST[endMonth]-$_POST[endDay]' AND";
}
//注文者電話番号:
if($_POST["orderPhone"]!= ""){
  $appendSql .= " `注文者電話番号` = '$_POST[orderPhone]' AND";
}
//送付先電話番号:
if($_POST["shipPhone"]!= ""){
  $appendSql .= " `送付先電話番号` = '$_POST[shipPhone]' AND";
}
//追跡番号:
if($_POST["trackNum"]!= ""){
  $appendSql .= " `お問い合わせ番号` = '$_POST[trackNum]' AND";
}
//TODO出荷日:
if($_POST["shipDate"] != ""){
  $appendSql .= " `出荷日` = '$_POST[shipDate]' AND";
}

$appendSql.=" 1";

echo "<br>".$sql.$appendSql."<br>";


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
</tr>";

$result = $conn->query($sql.$appendSql);
 if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['モール'] . "</td>";
    echo "<td>" . $row['注文番号'] . "</td>";
    echo "<td>" . $row['宅配商品'] . "</td>";
    echo "<td>" . $row['お問い合わせ番号'] . "</td>";
    echo "<td>" . $row['注文者名前'] . "</td>";
    echo "<td>" . $row['注文日'] . "</td>";
    echo "<td>" . $row['注文者電話番号'] . "</td>";
    echo "<td>" . $row['送付先電話番号'] . "</td>";
    echo "<td>" . $row['送付先郵便番号'] . "</td>";
    echo "<td>" . $row['送付先住所'] . "</td>";
    echo "</tr>";
    //echo "id: " . $row["id"]. " - Name: " . $row["name"]. "*" . $row["unit"]. "<br>";
  }
} else {
  echo "0 results";
}
echo "</table>";

$conn->close();
?>