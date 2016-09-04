<?php
// Connect to database
include 'mysql_connect.php';
//Generate CSV start 
if(isset($_POST["generateCsv"])){
    unlink('/Library/WebServer/Documents/uploads/uploadTest.csv');
    $sql = "SELECT
'モール','注文番号','送付先氏名','送付先郵便番号','送付先住所','送付先電話番号','宅配商品','出荷個数','配達日指定','配達時間指定','ネットコメント','注文者と送付先は異なる'
UNION ALL
SELECT
  `モール`,`注文番号`,`送付先氏名`,`送付先郵便番号`,`送付先住所`,`送付先電話番号`,`宅配商品`,`出荷個数`,`配達日指定`,`配達時間指定`,`ネットコメント`,`注文者と送付先は異なる`
FROM
  summary
INTO OUTFILE
  '/Library/WebServer/Documents/uploads/uploadTest.csv' FIELDS ENCLOSED BY '\"' TERMINATED BY ',' ESCAPED BY '\"' LINES TERMINATED BY '\r\n' ";

    if ($conn->query($sql) === TRUE) {
        echo "Generate csv successfully";
        echo "<br>The csv file is store in  /Library/WebServer/Documents/uploads/uploadTest.csv";
    } else {
        echo "Error when generating csv: " . $conn->error;
    }
}
//Generate CSV end
?>