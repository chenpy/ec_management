<?php
// Connect to database
include 'mysql_connect.php';

function delete_old_data($tableName,$conn){
  $delete_old_sql="DELETE FROM $tableName WHERE DATE(`upload`) = CURDATE();";
  if ($conn->query($delete_old_sql) === TRUE) {
      echo "Delete old data of $tableName successfully<br>";
  } else {
      echo "Error delete old data: " . $conn->error."<br>";
  }
}
function delete_summary_old_data($mall,$conn){
  $delete_old_sql="DELETE FROM summary WHERE `出荷日` = CURDATE() AND `モール`='$mall';";
  if ($conn->query($delete_old_sql) === TRUE) {
      echo "Delete old data of summary successfully<br>";
  } else {
      echo "Error delete old data: " . $conn->error."<br>";
  }
}

// Racoupon start
if(isset($_POST["racouponUpload"]) && $_FILES["racoupon"]["error"] == UPLOAD_ERR_OK ){  
    // Yahoo items information handling
    $tmp_name = $_FILES["racoupon"]["tmp_name"];
        // basename() may prevent filesystem traversal attacks;
        // further validation/sanitation of the filename may be appropriate
    $name = basename($_FILES["racoupon"]["name"]);
    move_uploaded_file($tmp_name, "uploads/$name");
    delete_old_data('racoupon_orig',$conn);
    $sql = "LOAD DATA LOCAL INFILE "."'/Library/WebServer/Documents/uploads/".$_FILES[racoupon][name]."'
    INTO TABLE racoupon_orig
    FIELDS TERMINATED BY ',' 
    ENCLOSED BY '\"'
    LINES TERMINATED BY '\r\n'
    IGNORE 1 ROWS";

    if ($conn->query($sql) === TRUE) {
        echo "Insert data successfully<br>";
    } else {
        echo "Error Insert table: " . $conn->error;
    }
}
// Racoupon END

// groupon start 

if(isset($_POST["grouponUpload"]) && $_FILES["groupon"]["error"] == UPLOAD_ERR_OK ){
    // groupon items information handling
    $tmp_name = $_FILES["groupon"]["tmp_name"];
    // basename() may prevent filesystem traversal attacks;
    // further validation/sanitation of the filename may be appropriate
    $name = basename($_FILES["groupon"]["name"]);
    move_uploaded_file($tmp_name, "uploads/$name");
    // convert xls to csv
    require "Classes/PHPExcel/IOFactory.php";
    $objPHPExcel = PHPExcel_IOFactory::load("/Library/WebServer/Documents/uploads/".$_FILES[groupon][name]);
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'CSV');
    $objWriter->save("/Library/WebServer/Documents/uploads/".$_FILES[groupon][name].".csv");

    //TODO load csv to database
    // delete_old_data('groupon_original',$conn);
    // $sql = "LOAD DATA LOCAL INFILE "."'/Library/WebServer/Documents/uploads/".$_FILES[ponpare][name]."'
    // INTO TABLE groupon_orig
    // FIELDS TERMINATED BY ',' 
    // ENCLOSED BY '\"'
    // LINES TERMINATED BY '\r\n'
    // IGNORE 1 ROWS";

    // if ($conn->query($sql) === TRUE) {
    //     echo "Insert groupon data successfully<br>";
    // } else {
    //     echo "Error Insert table: " . $conn->error;
    // }
}
// Groupon END

//Ponpare start

if(isset($_POST["ponpareUpload"]) && $_FILES["ponpare"]["error"] == UPLOAD_ERR_OK ){
    // Yahoo items information handling
    $tmp_name = $_FILES["ponpare"]["tmp_name"];
        // basename() may prevent filesystem traversal attacks;
        // further validation/sanitation of the filename may be appropriate
    $name = basename($_FILES["ponpare"]["name"]);
    move_uploaded_file($tmp_name, "uploads/$name");
    delete_old_data('ponparetic_orig',$conn);
    $sql = "LOAD DATA LOCAL INFILE '/Library/WebServer/Documents/uploads/".$_FILES[ponpare][name]."'
  INTO TABLE ponparetic_orig 
  FIELDS TERMINATED BY ',' 
  ENCLOSED BY '\"'
  LINES TERMINATED BY '\r\n'
  IGNORE 1 ROWS";

  if ($conn->query($sql) === TRUE) {
        echo "Insert data successfully<br>";
    } else {
        echo "Error Insert table: " . $conn->error;
    }
}

//ponpare end

//3ple start 
if(isset($_POST["3pleUpload"]) && $_FILES["3ple"]["error"] == UPLOAD_ERR_OK ){  

    // Yahoo items information handling
    $tmp_name = $_FILES["3ple"]["tmp_name"];
        // basename() may prevent filesystem traversal attacks;
        // further validation/sanitation of the filename may be appropriate
    $name = basename($_FILES["3ple"]["name"]);
    move_uploaded_file($tmp_name, "uploads/$name");
    delete_old_data('3ple_orig',$conn);
    $sql = "LOAD DATA LOCAL INFILE "."'/Library/WebServer/Documents/uploads/".$_FILES['3ple'][name]."'
    INTO TABLE 3ple_orig
    FIELDS TERMINATED BY ',' 
    ENCLOSED BY '\"'
    LINES TERMINATED BY '\r\n'
    IGNORE 1 ROWS";

    if ($conn->query($sql) === TRUE) {
        echo "Insert 3ple data successfully<br>";
    } else {
        echo "Error Insert table: " . $conn->error;
    }
  }
//3ple end
?>