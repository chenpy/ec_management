<?php
// Connect to database
include 'mysql_connect.php';
include 'path.php';
$fileName = date("md")."クーポンーー NGWジャパン";
if($isWin == 1){
    $fileNameSjis = mb_convert_encoding($fileName,"sjis-win","UTF-8");
    $csvFilePath=$uploadPath.$fileNameSjis.".csv";
    $xlsFilePath = $uploadPath.$fileNameSjis.".xls";
} else {
    $csvFilePath=$uploadPath.$fileName.".csv";
    $xlsFilePath = $uploadPath.$fileName.".xls";
}

//Generate CSV start 
if(isset($_POST["generateCsv"])){
    unlink($csvFilePath);
    $sql = "SELECT
'モール','注文番号','送付先氏名','送付先郵便番号','送付先住所','送付先電話番号','宅配商品','出荷個数','配達日指定','配達時間指定','ネットコメント','注文者と送付先は異なる'
UNION ALL
SELECT
  `モール`,`注文番号`,`送付先氏名`,`送付先郵便番号`,`送付先住所`,`送付先電話番号`,`宅配商品`,`出荷個数`,`配達日指定`,`配達時間指定`,`ネットコメント`,`注文者と送付先は異なる`
FROM
  summary
WHERE
    (`モール`='ラクーポン' OR `モール`='グルーポン' OR `モール`='ポンパレチケット' OR `モール`='サンプル百貨店' ) AND `出荷日` = CURDATE()
ORDER BY `モール` desc
INTO OUTFILE
  '$csvFilePath' FIELDS ENCLOSED BY '\"' TERMINATED BY ',' ESCAPED BY '\"' LINES TERMINATED BY '\r\n' ";

    if ($conn->query($sql) === TRUE) {
        echo "Generate csv successfully";
        echo "<br>The csv file is store in $csvFilePath";
    } else {
        echo "Error when generating csv: " . $conn->error;
    }
     $conn->set_charset('sjis');
    //Output xls file 
    require "Classes/PHPExcel/IOFactory.php";
    $objCSVReader = PHPExcel_IOFactory::createReader('CSV');
    $objCSVReader->setInputEncoding('sjis');
    $objPHPExcel = $objCSVReader->load($csvFilePath);
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
    $objWriter->save($xlsFilePath);
    header("Location: uploads/".$fileName.".xls");
}
//Generate CSV end
?>