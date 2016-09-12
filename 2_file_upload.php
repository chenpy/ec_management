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
    $grouponXlsPath="/Library/WebServer/Documents/uploads/".$_FILES[groupon][name];
    $grouponUtf8CSVPath="/Library/WebServer/Documents/uploads/".$_FILES[groupon][name]."utf8.csv";
    $grouponSjisCSVPath="/Library/WebServer/Documents/uploads/".$_FILES[groupon][name]."sjis.csv";
    require "Classes/PHPExcel/IOFactory.php";
    $objPHPExcel = PHPExcel_IOFactory::load($grouponXlsPath);
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'CSV');
    $objWriter->save($grouponUtf8CSVPath);

    // Convert the encoding from UTF8 to Shift-jis
    $utf8CSV = file_get_contents($grouponUtf8CSVPath);
    $sjisCSV = mb_convert_encoding($utf8CSV,"sjis-win","UTF-8");
    file_put_contents($grouponSjisCSVPath, $sjisCSV);

    // load csv to database
    delete_old_data('groupon_orig',$conn);
    // NOTICE: If it is windows, please change \n to \r\n
    $sql = "LOAD DATA LOCAL INFILE "."'$grouponSjisCSVPath'
    INTO TABLE groupon_orig
    FIELDS TERMINATED BY ',' 
    ENCLOSED BY '\"'
    LINES TERMINATED BY '\n'
    IGNORE 1 ROWS";
    echo $sql;
    if ($conn->query($sql) === TRUE) {
        echo "Insert groupon data successfully<br>";
    } else {
        echo "Error Insert table: " . $conn->error;
    }
    // Delete
    unlink($grouponXlsPath);
    unlink($grouponUtf8CSVPath);
    unlink($grouponSjisCSVPath);
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

  // Insert into summary table
    //SQL BEGIN
    delete_summary_old_data("ポンパレチケット",$conn);
    $sql = "INSERT
INTO
  summary(
  SELECT
    '',
    'ポンパレチケット',
    `購入ID`,
    '',
    '',
    CURDATE(), CONCAT(`姓`, `名`),
    CONCAT(`姓カナ`, `名カナ`),
  INSERT
    (`郵便番号`, 4, 0, '-'),
    CONCAT(`都道府県`, `市区町村・住所・マンション・アパート名`),
  INSERT
    (`電話番号`, 4, 0, '-'),
    '',
    items_info.name,
    items_info.id,
    `購入枚数`,
    `購入枚数` * items_info.unit,
    items_info.couponSitePrice,
    IF(
      `送付先変更` = '',
      CONCAT(`姓`, `名`),
      CONCAT(`プレゼント送付先姓`, `プレゼント送付先名`)
    ),
    IF(
      `送付先変更` = '',
      CONCAT(`姓カナ`, `名カナ`),
      CONCAT(`プレゼント送付先姓`, `プレゼント送付先名`)
    ),
    IF(
      `送付先変更` = '',
    INSERT
      (`郵便番号`, 4, 0, '-'),
    INSERT
      (`プレゼント送付先郵便番号`, 4, 0, '-')
    ),
    IF(
      `送付先変更` = '',
      CONCAT(`都道府県`, `市区町村・住所・マンション・アパート名`),
      CONCAT(
        `プレゼント送付先都道府県`,
        `プレゼント送付先市区町村・住所・マンション・アパート名`
      )
    ),
    IF(
      `送付先変更` = '',
    INSERT
      (`電話番号`, 4, 0, '-'),
    INSERT
      (`プレゼント送付先電話番号`, 4, 0, '-')
    ),
    '',
    '',
    '',
    '',
    '',
    '',
    ''
  FROM
    `ponparetic_orig`
  LEFT JOIN
    `items_info`
  ON
    items_info.id = '100' AND mall = 'ポンパレチケット')";
    //SQL END
    if ($conn->query($sql) === TRUE) {
        echo "Insert ponpare data successfully<br>";
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

      // Insert into summary table
    //SQL BEGIN
    delete_summary_old_data("サンプル百貨店",$conn);
    $sql = "INSERT
  INTO
  summary(
  SELECT
    '',
    'サンプル百貨店',
    `受注ＩＤ`,
    `注文日`,
    '',
    CURDATE(), CONCAT(`姓`, `名`),
    CONCAT(`姓カナ`, `名カナ`),
    `郵便番号`,
    CONCAT(`都道府県`, `住所`),
    `電話番号`,
    `掲載名`,
    '1',
    items_info.id,
    items_info.unit,
    items_info.unit,
    items_info.couponSitePrice,
    CONCAT(`姓`, `名`),
    CONCAT(`姓カナ`, `名カナ`),
    `郵便番号`,
    CONCAT(`都道府県`, `住所`),
    `電話番号`,
    '',
    '',
    '',
    '',
    '',
    '',
    ''
  FROM
    `3ple_orig`
  LEFT JOIN
    `items_info`
  ON
    items_info.id = `掲載ＩＤ` AND mall = 'サンプル百貨店')";
    //SQL END
    if ($conn->query($sql) === TRUE) {
        echo "Insert 3ple data successfully<br>";
    } else {
        echo "Error Insert table: " . $conn->error;
    }
  }
//3ple end
?>