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
<h1>データアップロード</h1>
  <form action="upload.php" method="post" enctype="multipart/form-data">
      <input type="file" name="fileToUpload">
      <input type="submit" value="Upload" name="submit">
  </form>
  <p>Note: Key　受注番号＋送付先住所＋商品</p>
  <p>Note: </p>
</body>
</html>
