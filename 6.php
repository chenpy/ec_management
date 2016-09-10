<?php
include 'mysql_connect.php';
function delete_old_data($tableName,$conn){
  $delete_old_sql="DELETE FROM $tableName WHERE DATE(`upload`) = CURDATE();";
  if ($conn->query($delete_old_sql) === TRUE) {
      echo "Delete old data of $tableName successfully<br>";
  } else {
      echo "Error delete old data: " . $conn->error."<br>";
  }
}
if(isset($_POST["submit"]) && $_FILES["uploadedCsv"]["error"] == UPLOAD_ERR_OK){
  // Yahoo items information handling
  $tmp_name = $_FILES["uploadedCsv"]["tmp_name"];
  // basename() may prevent filesystem traversal attacks;
  // further validation/sanitation of the filename may be appropriate
  $name = basename($_FILES["uploadedCsv"]["name"]);
  move_uploaded_file($tmp_name, "uploads/$name");
  delete_old_data('summary_temp',$conn);
  $sql = "LOAD DATA LOCAL INFILE '/Library/WebServer/Documents/uploads/".$_FILES[uploadedCsv][name]."'
            INTO TABLE summary_temp 
            FIELDS TERMINATED BY ',' 
            ENCLOSED BY '\"'
            LINES TERMINATED BY '\r\n'
            IGNORE 1 ROWS";
  echo $sql;
  if ($conn->query($sql) === TRUE) {
        echo "Insert data successfully";
  } else {
        echo "Error Insert table: " . $conn->error;
  }
  //UPDATE COLUMN
  $sql = "UPDATE summary left join summary_temp on summary.`モール` = summary_temp.`モール` AND summary.`注文番号`= summary_temp.`注文番号` AND summary.`商品id`= summary_temp.`商品id`  SET    summary.`お問い合わせ番号` = summary_temp.`お問い合わせ番号`;";
  echo $sql;
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
<h1>追跡番号アップロード</h1>
  <form method="post" enctype="multipart/form-data">
      <input type="file" name="uploadedCsv">
      <input type="submit" value="Upload" name="submit">
  </form>
</body>
</html>
