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
  <h1>検索画面</h1>
<form action="3_search.php" method="post" enctype="multipart/form-data">
  <select name="mall">
    <option value="default">モール</option>
    <option value="Rakuten">楽天</option>
    <option value="Yahoo">ヤフー</option>
    <option value="Amazon">アマゾン</option>
    <option value="ポンパレモール">ポンパレモール</option>
    <option value="Qoo10">Qoo10</option>
  </select><br>

  注文番号: <input type="text" name="orderId"><br>
  名前(カタカナ相似比較): <input type="text" name="katakanaName"><br>

  注文期間: <input type="text" name="startYear">年
  <input type="text" name="startMonth">月
  <input type="text" name="startDay">日　〜  <br>
  <input type="text" name="endYear">年
  <input type="text" name="endMonth">月
  <input type="text" name="endDay">日
  <br>


  注文者電話番号: <input type="text" name="orderPhone"><br>
  送付先電話番号: <input type="text" name="shipPhone"><br>
  追跡番号: <input type="text" name="trackNum"><br>
  出荷日(YYYY-MM-DD): <input type="text" name="shipDate"><br>
  <input type="submit" value="search" name="search">
  </form>
</html>
