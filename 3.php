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
  <select name="startMonth">
  <?php
    for ($x = 1; $x <= 12; $x++) {
      echo "<option value=\"$x\">$x</option>";
    }
  ?> 
  </select>月
  <select name="startDay">
  <?php
    for ($x = 1; $x <= 31; $x++) {
      echo "<option value=\"$x\">$x</option>";
    }
  ?> 
  </select>日　〜  <br>
  <input type="text" name="endYear">年
  <select name="endMonth">
  <?php
    for ($x = 1; $x <= 12; $x++) {
      echo "<option value=\"$x\">$x</option>";
    }
  ?> 
  </select>月
  <select name="endDay">
  <?php
    for ($x = 1; $x <= 31; $x++) {
      echo "<option value=\"$x\">$x</option>";
    }
  ?> 
  </select>日
  <br>


  注文者電話番号: <input type="text" name="orderPhone"><br>
  送付先電話番号: <input type="text" name="shipPhone"><br>
  追跡番号: <input type="text" name="trackNum"><br>
  出荷日(YYYY-MM-DD): <input type="text" name="shipDate"><br>
  <input type="submit" value="search" name="search">
  </form>
</html>
