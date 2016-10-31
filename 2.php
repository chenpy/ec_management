<?php include 'mysql_connect.php';?>
<html>
<head>
  <title>Upload</title>
  <style>
   .upload {
      float:left;
      width:100%;
      height:20%;
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
       <input type="checkbox" name="deleteRacoupon" value="1">前回アップ資料削除<br>
       <input type="checkbox" name="isRacouponCustUpDay" value="0">
       <label for="racouponUpDate">カスタマイズアップロード日期：</label>
       <input type="date" id="racouponUpDate" name="racouponUpDate" placeholder="2016-10-28"><br>
       <input type="submit" value="Upload" name="racouponUpload">
		</form>
  	</div>
  	<div class="upload">
  		<form action="2_file_upload.php" method="post" enctype="multipart/form-data">
    		グルーポン
    	<input type="file" name="groupon"><br>
       <input type="checkbox" name="deleteGroupon" value="1">前回アップ資料削除
       <br>
       <input type="checkbox" name="isGrouponCustUpDay" value="0">
       <label for="grouponUpDate">カスタマイズアップロード日期：</label>
       <input type="date" id="grouponUpDate" name="grouponUpDate" placeholder="2016-10-28"><br>
   	 	<input type="submit" value="Upload" name="grouponUpload">
		</form>
  	</div>
  	<div class="upload">
  		<form action="2_file_upload.php" method="post" enctype="multipart/form-data">
    		ポンパレ
    	<input type="file" name="ponpare"><br>
       <input type="checkbox" name="deletePonpare" value="1">前回アップ資料削除<br>
       <input type="checkbox" name="isPonpareCustUpDay" value="0">
       <label for="ponpareUpDate">カスタマイズアップロード日期：</label>
       <input type="date" id="ponpareUpDate" name="ponpareUpDate" placeholder="2016-10-28"><br>
   	 	<input type="submit" value="Upload" name="ponpareUpload">
		</form>
  	</div>
  	<div class="upload">
  		<form action="2_file_upload.php" method="post" enctype="multipart/form-data">
    		サンプル百貨店
    	<input type="file" name="3ple"><br>
       <input type="checkbox" name="delete3ple" value="1">前回アップ資料削除<br>
       <input type="checkbox" name="is3pleCustUpDay" value="0">
       <label for="3pleUpDate">カスタマイズアップロード日期：</label>
       <input type="date" id="3pleUpDate" name="3pleUpDate" placeholder="2016-10-28"><br>
   	 	<input type="submit" value="Upload" name="3pleUpload">
		</form>
  	</div>
  	<div class="upload">
  	     <form action="2_generate_csv.php" method="post" enctype="multipart/form-data">
        本日出荷資料まとめ<br>
                <input type="checkbox" name="isCustCsvDownloadDay" value="0">
        <label for="csvDate">カスタマイズダウンロード日期：</label>
       <input type="date" id="csvDate" name="csvDate" placeholder="2016-10-28"><br>
        <input type="submit" value="生成" name="generateCsv">
  	</div>
</body>
</html>
