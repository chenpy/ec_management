<?php
// Connect to database
include 'mysql_connect.php';
include 'path.php';
function delete_old_data($tableName,$conn){
  $delete_old_sql="TRUNCATE TABLE $tableName;";
  if ($conn->query($delete_old_sql) === TRUE) {
      echo "Delete old data of $tableName successfully<br>";
  } else {
      echo "Error delete old data: " . $conn->error."<br>";
  }
}
function delete_summary_old_data($mall,$conn,$date){
  $delete_old_sql="DELETE FROM summary WHERE `出荷日` = $date AND `モール`='$mall';";
  if ($conn->query($delete_old_sql) === TRUE) {
      echo "Delete old data of summary successfully<br>";
  } else {
      echo "Error delete old data: " . $conn->error."<br>";
  }
}
// YAHOO START
if(isset($_POST["yahooUpload"]) && $_FILES["yahoo_items_info"]["error"] == UPLOAD_ERR_OK && $_FILES["yahoo_order_info"]["error"] == UPLOAD_ERR_OK){
    // Yahoo items information handling
    $tmp_name = $_FILES["yahoo_items_info"]["tmp_name"];
        // basename() may prevent filesystem traversal attacks;
        // further validation/sanitation of the filename may be appropriate
    $name = basename($_FILES["yahoo_items_info"]["name"]);
    move_uploaded_file($tmp_name, "uploads/$name");
    delete_old_data('yahoo_items_info',$conn);
    $sql = "LOAD DATA LOCAL INFILE '".$uploadPath.$_FILES[yahoo_items_info][name]."'
	INTO TABLE yahoo_items_info 
	FIELDS TERMINATED BY ',' 
	ENCLOSED BY '\"'
	LINES TERMINATED BY '\r\n'
	IGNORE 1 ROWS";
	if ($conn->query($sql) === TRUE) {
        echo "Insert data successfully<br>";
    } else {
       	echo "Error Insert table: " . $conn->error;
    }
    // Yahoo order information handling
    $tmp_name = $_FILES["yahoo_order_info"]["tmp_name"];
    $name = basename($_FILES["yahoo_order_info"]["name"]);
    move_uploaded_file($tmp_name, "uploads/$name");
    delete_old_data('yahoo_order_info',$conn);
    $sql = "LOAD DATA LOCAL INFILE '".$uploadPath.$_FILES[yahoo_order_info][name]."'
    INTO TABLE yahoo_order_info 
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
    $isCustUpDayEnabled = isset($_POST[isYahooCustUpDay])? "'".$_POST[yahooUpDate]."'":"CURDATE()";

    if(isset($_POST["deleteYahoo"])){
      delete_summary_old_data("Yahoo",$conn,$isCustUpDayEnabled);
    }

    $sql = "Insert into summary (SELECT
  '',
  'Yahoo',
  yahoo_order_info.OrderID,
REPLACE
  (
    SUBSTR(
      yahoo_order_info.OrderDate,
      1,
      10
    ),
    '-',
    '/'
  ),
  SUBSTR(yahoo_order_info.OrderDate, 11),
  $isCustUpDayEnabled, yahoo_order_info.BillName, yahoo_order_info.BillNameKana, INSERT(yahoo_order_info.BillZip,4,0,'-'), CONCAT(
    yahoo_order_info.BillState,
    yahoo_order_info.BillCity,
    yahoo_order_info.BillAddress1,
    yahoo_order_info.BillAddress2
  ),
  INSERT(yahoo_order_info.BillPhone,4,0,'-'),
  yahoo_items_info.Description,
  items_info.name,items_info.id,
  yahoo_items_info.Quantity,
  items_info.unit * yahoo_items_info.Quantity,
  yahoo_items_info.UnitPrice,
  yahoo_order_info.ShipName,
  yahoo_order_info.ShipNameKana,
  INSERT(yahoo_order_info.ShipZip,4,0,'-'),
  CONCAT(
    yahoo_order_info.ShipState,
    yahoo_order_info.ShipCity,
    yahoo_order_info.ShipAddress1,
    yahoo_order_info.ShipAddress2
  ),
  INSERT(yahoo_order_info.ShipPhone,4,0,'-'),
  yahoo_order_info.ShippingReqDateConv,
    CASE SUBSTR(ShippingReqTime,1,2) WHEN '08' THEN '01'
    ELSE SUBSTR(ShippingReqTime,1,2) END,
  IF(STRCMP(yahoo_order_info.ShipName,yahoo_order_info.BillName),CONCAT('注文者:',yahoo_order_info.BillName),''),
  yahoo_order_info.Comments,'','',yahoo_items_info.LineId
FROM
  yahoo_order_info right join
  yahoo_items_info on yahoo_items_info.OrderId = yahoo_order_info.OrderId ,
  items_info
WHERE
  items_info.id = yahoo_items_info.ProductCode and items_info.mall='Yahoo')
";
    //SQL END
    if ($conn->query($sql) === TRUE) {
        echo "Insert data successfully<br>";
    } else {
        echo "Error Insert table: " . $conn->error;
    }
}
// YAHOO END
// Rakuten start
if(isset($_POST["rakutenUpload"]) && $_FILES["rakuten"]["error"] == UPLOAD_ERR_OK ){  
    // Yahoo items information handling
    $tmp_name = $_FILES["rakuten"]["tmp_name"];
        // basename() may prevent filesystem traversal attacks;
        // further validation/sanitation of the filename may be appropriate
    $name = basename($_FILES["rakuten"]["name"]);
    move_uploaded_file($tmp_name, "uploads/$name");
    delete_old_data('rakuten_original',$conn);
    $sql = "LOAD DATA LOCAL INFILE '".$uploadPath.$_FILES[rakuten][name]."'
    INTO TABLE rakuten_original
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
    $isCustUpDayEnabled = isset($_POST[isRakutenCustUpDay])? "'".$_POST[rakutenUpDate]."'":"CURDATE()";
    if(isset($_POST["deleteRakuten"])){
      delete_summary_old_data("Rakuten",$conn,$isCustUpDayEnabled);
    }
        $sql = "insert into summary (SELECT '','Rakuten',`受注番号`,`注文日`,`注文時間`,$isCustUpDayEnabled,CONCAT(`注文者名字`,`注文者名前`) ,CONCAT(`注文者名字フリガナ`,`注文者名前フリガナ`) ,CONCAT(`注文者郵便番号１`,'-',`注文者郵便番号２`), CONCAT(`注文者住所：都道府県`,`注文者住所：都市区`,`注文者住所：町以降`),CONCAT(`注文者電話番号１`,'-',`注文者電話番号２`,`注文者電話番号３`),`商品名` ,items_info.name ,items_info.id,rakuten_original.`個数`,rakuten_original.`個数`*items_info.unit,rakuten_original.単価,CONCAT(`送付先名字`,`送付先名前`) ,CONCAT(`送付先名字フリガナ`,`送付先名前フリガナ`),CONCAT(`送付先郵便番号１`,'-',`送付先郵便番号２`),CONCAT(`送付先住所：都道府県`,`送付先住所：都市区`,`送付先住所：町以降`),CONCAT(`送付先電話番号１`,'-',`送付先電話番号２`,`送付先電話番号３`),`お届け日指定`, IF( LOCATE('〜', `コメント`) != 0, CASE SUBSTR(`コメント`, LOCATE('〜', `コメント`) -3, 2) WHEN '08' THEN '01' ELSE SUBSTR(`コメント`, LOCATE('〜', `コメント`) -3, 2) END, '' ) ,TRIM(IF(STRCMP(CONCAT(`注文者名字`,`注文者名前`),CONCAT(`送付先名字`,`送付先名前`)),CONCAT('注文者:',CONCAT(`注文者名字`,`注文者名前`)),'')),REPLACE(REPLACE(`コメント`,'\n',''),'　',''),'','','' FROM `rakuten_original`,`items_info` WHERE
        items_info.id = rakuten_original.`商品ID`)";
      echo $sql;
//SQL END
    if ($conn->query($sql) === TRUE) {
        echo "Insert rakuten data successfully<br>";
    } else {
        echo "Error Insert table: " . $conn->error;
    }
    
}
// Rakuten END

// Ponpare start 

if(isset($_POST["ponpareUpload"]) && $_FILES["ponpare"]["error"] == UPLOAD_ERR_OK ){
    // Yahoo items information handling
    $tmp_name = $_FILES["ponpare"]["tmp_name"];
        // basename() may prevent filesystem traversal attacks;
        // further validation/sanitation of the filename may be appropriate
    $name = basename($_FILES["ponpare"]["name"]);
    move_uploaded_file($tmp_name, "uploads/$name");
    delete_old_data('ponpare_original',$conn);
    $sql = "LOAD DATA LOCAL INFILE '".$uploadPath.$_FILES[ponpare][name]."'
    INTO TABLE ponpare_original
    FIELDS TERMINATED BY ',' 
    ENCLOSED BY '\"'
    LINES TERMINATED BY '\r\n'
    IGNORE 1 ROWS";

    if ($conn->query($sql) === TRUE) {
        echo "Insert ponpare data successfully<br>";
    } else {
        echo "Error Insert table: " . $conn->error;
    }

    // Insert into summary table
    //SQL BEGIN
    $isCustUpDayEnabled = isset($_POST[isPonpareCustUpDay])? "'".$_POST[ponpareUpDate]."'":"CURDATE()";
    if(isset($_POST["deletePonpare"])){
      delete_summary_old_data("ポンパレモール",$conn,$isCustUpDayEnabled);
    }
    $sql = "INSERT INTO summary SELECT '','ポンパレモール' ,`注文番号`,REPLACE ( SUBSTR( `注文日時`, 1, 10 ), '-', '/' ), SUBSTR(`注文日時`, 11),$isCustUpDayEnabled,CONCAT(`注文者名字`,`注文者名前`) ,CONCAT(`注文者名字フリガナ`,`注文者名前フリガナ`) ,CONCAT(`注文者郵便番号1`,'-',`注文者郵便番号2`), CONCAT(`注文者住所：都道府県`,`注文者住所：市区町村以降`),INSERT(`注文者電話番号`,4,0,'-'),`商品名` ,name ,id,`個数`,unit * `個数`,単価, CONCAT(`送付先名字`,`送付先名前`) ,CONCAT(`送付先名字フリガナ`,`送付先名前フリガナ`),CONCAT(`送付先郵便番号1`, '-',`送付先郵便番号2`),CONCAT(`送付先住所：都道府県`,`送付先住所：市区町村以降`),INSERT(`送付先電話番号`,4,0,'-'),IF( `コメント` REGEXP '^.*-.*-.*\(.*).*$', SUBSTR(`コメント`, 11, 10), '' ) , IF( LOCATE('〜', `コメント`) != 0, CASE SUBSTR(`コメント`, LOCATE('〜', `コメント`) -3, 2) WHEN '08' THEN '01' ELSE SUBSTR(`コメント`, LOCATE('〜', `コメント`) -3, 2) END, '' ) ,IF(`送付先一致フラグ`=0,CONCAT('注文者:',CONCAT(`注文者名字`,`注文者名前`)),''),REPLACE(`コメント`,'\r\n',''),'','','' from `ponpare_original` left join`items_info` on  ponpare_original.`商品管理ID`=items_info.id  and items_info.mall='ポンパレモール'";
    //SQL END
    if ($conn->query($sql) === TRUE) {
        echo "Insert ponpare data successfully<br>";
    } else {
        echo "Error Insert table: " . $conn->error;
    }
}

// Ponpare END
//Amazon start

if(isset($_POST["amazonUpload"]) && $_FILES["amazon_to_ship"]["error"] == UPLOAD_ERR_OK && $_FILES["amazon_order"]["error"] == UPLOAD_ERR_OK){
    // Yahoo items information handling
    $tmp_name = $_FILES["amazon_to_ship"]["tmp_name"];
        // basename() may prevent filesystem traversal attacks;
        // further validation/sanitation of the filename may be appropriate
    $name = basename($_FILES["amazon_to_ship"]["name"]);
    move_uploaded_file($tmp_name, "uploads/$name");
    delete_old_data('amazon_to_ship',$conn);
    $sql = "LOAD DATA LOCAL INFILE '".$uploadPath.$_FILES[amazon_to_ship][name]."'
  INTO TABLE amazon_to_ship 
  FIELDS TERMINATED BY '\t' 
  LINES TERMINATED BY '\r\n'
  IGNORE 1 ROWS";

  if ($conn->query($sql) === TRUE) {
        echo "Insert data successfully<br>";
    } else {
        echo "Error Insert table: " . $conn->error;
    }
    // Yahoo order information handling
    $tmp_name = $_FILES["amazon_order"]["tmp_name"];
    $name = basename($_FILES["amazon_order"]["name"]);
    move_uploaded_file($tmp_name, "uploads/$name");
    delete_old_data('amazon_order',$conn);
    $sql = "LOAD DATA LOCAL INFILE '".$uploadPath.$_FILES[amazon_order][name]."'
    INTO TABLE amazon_order 
    FIELDS TERMINATED BY '\t' 
    LINES TERMINATED BY '\r\n'
    IGNORE 1 ROWS";

    if ($conn->query($sql) === TRUE) {
        echo "Insert data successfully<br>";
    } else {
        echo "Error Insert table: " . $conn->error;
    }
    $isCustUpDayEnabled = isset($_POST[isAmazonCustUpDay])? "'".$_POST[amazonUpDate]."'":"CURDATE()";
    // Insert into summary table
    //SQL BEGIN
    if(isset($_POST["deleteAmazon"])){
      delete_summary_old_data("Amazon",$conn,$isCustUpDayEnabled);
    }
        $sql = "insert into summary SELECT
  '',
  'Amazon',
  `amazon_to_ship`.`order-id`,
  SUBSTR(
    amazon_order.`purchase-date`,
    1,
    10
  ),
  SUBSTR(
    amazon_order.`purchase-date`,
    12,
    8
  ),
  $isCustUpDayEnabled, amazon_order.`buyer-name`, '', '', '',IF(LOCATE(amazon_order.`buyer-phone-number`,'-')=0, INSERT(amazon_order.`buyer-phone-number`,4,0,'-'),amazon_order.`buyer-phone-number`), `amazon_order`.`product-name`, items_info.name, items_info.id, amazon_to_ship.`quantity-purchased`, items_info.unit * `amazon_to_ship`.`quantity-purchased`, `amazon_order`.`item-price` / amazon_order.`quantity-purchased`, `amazon_order`.`recipient-name`, '', `amazon_order`.`ship-postal-code`, CONCAT(
    amazon_to_ship.`ship-state`,
    amazon_to_ship.`ship-address-1`,
    amazon_to_ship.`ship-address-2`,
    amazon_to_ship.`ship-address-3`
  ),
  Insert(`amazon_order`.`ship-phone-number`,4,0,'-'),
  substr(`amazon_to_ship`.`scheduled-delivery-start-date`,1,10),
  substr(`amazon_to_ship`.`scheduled-delivery-start-date`,12,8),
  IF(
    STRCMP(
     REPLACE( REPLACE(`amazon_order`.`buyer-name`,' ',''),'　',''),
       REPLACE( REPLACE(`amazon_order`.`recipient-name`,' ',''),'　','')
    ),
    CONCAT('注文者:', `amazon_order`.`buyer-name`),''
  ),
  '',
  '',
  '',
  ''
FROM
  `amazon_to_ship`
LEFT JOIN
  `amazon_order`
ON
  `amazon_to_ship`.`order-id` = `amazon_order`.`order-id` AND `amazon_to_ship`.`sku` = `amazon_order`.`sku` 
LEFT JOIN
  items_info
ON
  amazon_order.sku = items_info.id
";
    //SQL END
    if ($conn->query($sql) === TRUE) {
        echo "Insert data successfully<br>";
    } else {
        echo "Error Insert table: " . $conn->error;
    }

}


//Amazon end

//Q10 start 
if(isset($_POST["q10Upload"]) && $_FILES["q10"]["error"] == UPLOAD_ERR_OK ){  

    // Yahoo items information handling
    $tmp_name = $_FILES["q10"]["tmp_name"];
        // basename() may prevent filesystem traversal attacks;
        // further validation/sanitation of the filename may be appropriate
    $name = basename($_FILES["q10"]["name"]);
    move_uploaded_file($tmp_name, "uploads/$name");
    delete_old_data('q10_original',$conn);
    $sql = "LOAD DATA LOCAL INFILE '".$uploadPath.$_FILES[q10][name]."'
    INTO TABLE q10_original
    FIELDS TERMINATED BY ',' 
    ENCLOSED BY '\"'
    LINES TERMINATED BY '\r\n'
    IGNORE 1 ROWS";

    if ($conn->query($sql) === TRUE) {
        echo "Insert q10 data successfully<br>";
    } else {
        echo "Error Insert table: " . $conn->error;
    }

    // Insert into summary table
    //SQL BEGIN
    $isCustUpDayEnabled = isset($_POST[isQ10CustUpDay])? "'".$_POST[q10UpDate]."'":"CURDATE()";
    if(isset($_POST["deleteQ10"])){
      delete_summary_old_data("Qoo10",$conn,$isCustUpDayEnabled);
    }
    $sql = "insert into summary SELECT '', 'Qoo10', `注文番号`, SUBSTR(`注文日`, 1, LOCATE(' ', `注文日`) -1), SUBSTR(`注文日`, LOCATE(' ', `注文日`), 7), $isCustUpDayEnabled, `購入者名`, `購入者名(フリガナ)`, '', '',IF(`購入者電話番号` != '', `購入者電話番号`, `購入者携帯電話番号`), `商品名`, items_info.name, items_info.id, `数量`, items_info.unit * `数量`, `販売価格`, `受取人名`, `受取人名(フリガナ)`, `郵便番号`, `住所`, IF(`受取人電話番号` != '-', `受取人電話番号`, `受取人携帯電話番号`), `お届け希望日`, '', IF( `購入者名` != `受取人名`, CONCAT('注文者: ', `購入者名`), '' ), `配送要請事項`, '', '', '' FROM q10_original LEFT JOIN items_info ON `商品番号` = items_info.id";
    //SQL END
    if ($conn->query($sql) === TRUE) {
        echo "Insert ponpare data successfully<br>";
    } else {
        echo "Error Insert table: " . $conn->error;
    }
}
//Q10 end
?>