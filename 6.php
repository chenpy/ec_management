<?php
include 'mysql_connect.php';
include 'path.php';
function delete_old_data($tableName,$conn){
  $delete_old_sql="TRUNCATE TABLE $tableName;";
  if ($conn->query($delete_old_sql) === TRUE) {
      echo "OK<br>";
  } else {
      echo "NG: " . $conn->error."<br>";
  }
}
if(isset($_POST["submit"]) && $_FILES["uploadedCsv"]["error"] == UPLOAD_ERR_OK){
  $tmp_name = $_FILES["uploadedCsv"]["tmp_name"];
  // basename() may prevent filesystem traversal attacks;
  // further validation/sanitation of the filename may be appropriate
  $name = basename($_FILES["uploadedCsv"]["name"]);
  move_uploaded_file($tmp_name, "uploads/$name");
  include_once 'Classes/PHPExcel.php';
  // Read the file in *.xls format
  $objReader = PHPExcel_IOFactory::createReader('Excel5');
  echo $uploadPath.$_FILES["uploadedCsv"]["name"];
  $objPHPExcel = $objReader->load($uploadPath.$_FILES["uploadedCsv"]["name"]);
  //Output the file in *.csv 
  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
  $objWriter->save($uploadPath."tempTrackId.csv");

  // Convert the encoding from UTF8 to Shift-jis
  $utf8CSV = file_get_contents($uploadPath."tempTrackId.csv");
  $sjisCSV = mb_convert_encoding($utf8CSV,"sjis-win","UTF-8");
  file_put_contents($uploadPath."tempTrackId.csv",$sjisCSV);

  delete_old_data('summary_temp',$conn);
  $sql = "LOAD DATA LOCAL INFILE '".$uploadPath.'tempTrackId.csv'."'
            INTO TABLE summary_temp 
            FIELDS TERMINATED BY ',' 
            ENCLOSED BY '\"'
            LINES TERMINATED BY '\n'
            IGNORE 1 ROWS";
  echo $sql;
  if ($conn->query($sql) === TRUE) {
        echo "OK<br>";
  } else {
        echo "NG:" . $conn->error;
  }
  //UPDATE COLUMN
  $sql = "UPDATE summary inner join summary_temp on summary.`モール` = summary_temp.`モール` AND summary.`注文番号`= summary_temp.`注文番号` SET   summary.`お問い合わせ番号` = summary_temp.`お問い合わせ番号`;";
 // echo $sql;
  if ($conn->query($sql) === TRUE) {
        echo "テープル summary にアップデート成功<br>";
  } else {
        echo "テープル summary にアップデート失敗、原因は:" . $conn->error;
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
<h1>追跡番号アップロード</h1>
  <form method="post" enctype="multipart/form-data">
      <input type="file" name="uploadedCsv">
      <input type="submit" value="Upload" name="submit">
  </form>
</body>
</html>
