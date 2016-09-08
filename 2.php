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
    	<input type="file" name="racoupon">
   	 	<input type="submit" value="Upload" name="racouponUpload">
		</form>
  	</div>
  	<div class="upload">
  		<form action="2_file_upload.php" method="post" enctype="multipart/form-data">
    		グルーポン
    	<input type="file" name="groupon">
   	 	<input type="submit" value="Upload" name="grouponUpload">
		</form>
  	</div>
  	<div class="upload">
  		<form action="2_file_upload.php" method="post" enctype="multipart/form-data">
    		ポンパレ
    	<input type="file" name="ponpare">
   	 	<input type="submit" value="Upload" name="ponpareUpload">
		</form>
  	</div>
  	<div class="upload">
  		<form action="2_file_upload.php" method="post" enctype="multipart/form-data">
    		サンプル百貨店
    	<input type="file" name="3ple">
   	 	<input type="submit" value="Upload" name="3pleUpload">
		</form>
  	</div>
  	<div class="upload">
  		<form action="upload.php" method="post" enctype="multipart/form-data">
    		本日出荷資料まとめ
		</form>
  	</div>
</body>
</html>
