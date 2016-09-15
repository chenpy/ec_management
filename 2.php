<?php include 'mysql_connect.php';?>
<html>
<head>
  <title>Upload</title>
  <style>
   .upload {
      float:left;
      width:100%;
      height:15%;
    }
  </style>
</head>
<meta charset="UTF-8">  
<body>
  <h1>クーポンサイト出荷処理</h1>
	<div class="upload">
  		<form action="2_file_upload.php" method="post" enctype="multipart/form-data">
    		ラクーポン
    	<input type="file" name="racoupon"><br>
       <input type="checkbox" name="deleteRacoupon" value="1">前回アップ資料削除
       <input type="submit" value="Upload" name="racouponUpload">
		</form>
  	</div>
  	<div class="upload">
  		<form action="2_file_upload.php" method="post" enctype="multipart/form-data">
    		グルーポン
    	<input type="file" name="groupon"><br>
       <input type="checkbox" name="deleteGroupon" value="1">前回アップ資料削除
   	 	<input type="submit" value="Upload" name="grouponUpload">
		</form>
  	</div>
  	<div class="upload">
  		<form action="2_file_upload.php" method="post" enctype="multipart/form-data">
    		ポンパレ
    	<input type="file" name="ponpare"><br>
       <input type="checkbox" name="deletePonpare" value="1">前回アップ資料削除
   	 	<input type="submit" value="Upload" name="ponpareUpload">
		</form>
  	</div>
  	<div class="upload">
  		<form action="2_file_upload.php" method="post" enctype="multipart/form-data">
    		サンプル百貨店
    	<input type="file" name="3ple"><br>
       <input type="checkbox" name="delete3ple" value="1">前回アップ資料削除
   	 	<input type="submit" value="Upload" name="3pleUpload">
		</form>
  	</div>
  	<div class="upload">
  	     <form action="2_generate_csv.php" method="post" enctype="multipart/form-data">
        本日出荷資料まとめ
        <input type="submit" value="Generate" name="generateCsv">
  	</div>
</body>
</html>
