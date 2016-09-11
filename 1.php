<html>
<head>
  <title>Upload</title>
  <style>
   .upload {
      float:left;
      width:100%;
      height:10%;
    }
    .upload_large {
      float:left;
      width:100%;
      height:20%;
    }
  </style>
</head>
<meta charset="UTF-8">
<body>
	<h1>モール出荷処理</h1>
	<div class="upload">
  		<form action="1_file_upload.php" method="post" enctype="multipart/form-data">
    		楽天csvファイル
    	<input type="file" name="rakuten">
   	 	<input type="submit" value="Upload" name="rakutenUpload">
		</form>
  	</div>
  	<div class="upload_large">
  		<form action="1_file_upload.php" method="post" enctype="multipart/form-data">
    		ヤフーcsvファイル<br>
    	yahoo_items_info<input type="file" name="yahoo_items_info">
    	<br>yahoo_order_info<input type="file" name="yahoo_order_info">
   	 	<input type="submit" value="Upload" name="yahooUpload">
		</form>
  	</div>
  	<div class="upload_large">
  		<form action="1_file_upload.php" method="post" enctype="multipart/form-data">
    		アマゾン<br>未出荷注文レポート
    	<input type="file" name="amazon_to_ship"><br>
    	注文レポート
    	<input type="file" name="amazon_order">
   	 	<input type="submit" value="Upload" name="amazonUpload">
		</form>
  	</div>
  	<div class="upload">
  		<form action="1_file_upload.php" method="post" enctype="multipart/form-data">
    		ポンパレモールcsvファイル
    	<input type="file" name="ponpare">
   	 	<input type="submit" value="Upload" name="ponpareUpload">
		</form>
  	</div>
  	<div class="upload">
  		<form action="1_file_upload.php" method="post" enctype="multipart/form-data">
    		Qoo10 csvファイル
    	<input type="file" name="q10">
   	 	<input type="submit" value="Upload" name="q10Upload">
		</form>
  	</div>
  	<div class="upload">
  		<form action="1_generate_csv.php" method="post" enctype="multipart/form-data">
    		本日出荷資料まとめ
        <input type="submit" value="Generate" name="generateCsv">
		</form>
  	</div>
</body>
</html>
