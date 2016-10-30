<html>
<head>
  <title>Upload</title>
  <style>
   .upload {
      float:left;
      width:100%;
      height:25%;
    }
    .upload_large {
      float:left;
      width:100%;
      height:35%;
    }
  </style>
</head>
<meta charset="UTF-8">
<body>
	<h1>モール出荷処理</h1>
	<div class="upload">
  		<form action="1_file_upload.php" method="post" enctype="multipart/form-data">
    		楽天csvファイル
    	<input type="file" name="rakuten"><br>
       <input type="checkbox" name="deleteRakuten" value="1"> 前回アップ資料削除<br>
       <input type="checkbox" name="isRakutenCustUpDay" value="0">
       <label for="rakutenUpDate">カスタマイズアップロード日期：</label>
       <input type="date" id="rakutenUpDate" name="rakutenUpDate" placeholder="2016-10-28"><br>
   	 	<input type="submit" value="Upload" name="rakutenUpload">
		</form>
  	</div>
  	<div class="upload_large">
  		<form action="1_file_upload.php" method="post" enctype="multipart/form-data">
    		ヤフーcsvファイル<br>
    	yahoo_items_info<input type="file" name="yahoo_items_info">
    	<br>yahoo_order_info<input type="file" name="yahoo_order_info"><br>
       <input type="checkbox" name="deleteYahoo" value="1"> 前回アップ資料削除<br>
       <input type="checkbox" name="isYahooCustUpDay" value="0">
       <label for="yahooUpDate">カスタマイズアップロード日期：</label>
       <input type="date" id="yahooUpDate" name="yahoo  UpDate" placeholder="2016-10-28"><br>
   	 	<input type="submit" value="Upload" name="yahooUpload">
		</form>
  	</div>
  	<div class="upload_large">
  		<form action="1_file_upload.php" method="post" enctype="multipart/form-data">
    		アマゾン<br>未出荷注文レポート
    	<input type="file" name="amazon_to_ship"><br>
    	注文レポート
    	<input type="file" name="amazon_order"><br>
       <input type="checkbox" name="deleteAmazon" value="1"> 前回アップ資料削除<br>
       <input type="checkbox" name="isAmazonCustUpDay" value="0">
       <label for="amazonUpDate">カスタマイズアップロード日期：</label>
       <input type="date" id="amazonUpDate" name="amazonUpDate" placeholder="2016-10-28"><br>
   	 	<input type="submit" value="Upload" name="amazonUpload">
		</form>
  	</div>
  	<div class="upload">
  		<form action="1_file_upload.php" method="post" enctype="multipart/form-data">
    		ポンパレモールcsvファイル
    	<input type="file" name="ponpare"><br>
       <input type="checkbox" name="deletePonpare" value="1"> 前回アップ資料削除<br>
       <input type="checkbox" name="isPonpareCustUpDay" value="0">
       <label for="ponpareUpDate">カスタマイズアップロード日期：</label>
       <input type="date" id="ponpareUpDate" name="ponpareUpDate" placeholder="2016-10-28"><br>
   	 	<input type="submit" value="Upload" name="ponpareUpload">
		</form>
  	</div>
  	<div class="upload">
  		<form action="1_file_upload.php" method="post" enctype="multipart/form-data">
    		Qoo10 csvファイル
    	<input type="file" name="q10"><br>
       <input type="checkbox" name="deleteQ10" value="1"> 前回アップ資料削除<br>
       <input type="checkbox" name="isQ10CustUpDay" value="0">
       <label for="q10UpDate">カスタマイズアップロード日期：</label>
       <input type="date" id="q10UpDate" name="q10UpDate" placeholder="2016-10-28"><br>
   	 	<input type="submit" value="Upload" name="q10Upload">
		</form>
  	</div>
  	<div class="upload">
  		<form action="1_generate_csv.php" method="post" enctype="multipart/form-data">
    		本日出荷資料まとめ
        <input type="submit" value="生成" name="generateCsv">
		</form>
  	</div>
</body>
</html>
