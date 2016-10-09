<?php include 'mysql_connect.php';?>
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
<h1>各モール商品ID管理</h1>
<form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
モール
  <select name="mall">
    <option value="Yahoo">ヤフー</option>
    <option value="Rakuten">楽天</option>
    <option value="Amazon">アマゾン</option>
    <option value="ポンパレモール">ポンパレモール</option>
    <option value="Qoo10">Qoo10</option>
    <option value="ラクーポン">ラクーポン</option>
    <option value="サンプル百貨店">サンプル百貨店</option>
    <option value="ポンパレチケット">ポンパレチケット</option>
    <option value="グルーポン">グルーポン</option>
  </select>
  <input type ="submit" name="search" value="検索"><br><br>
  
  <?php 
      if(isset($_POST["search"])){
            $sql = "select * from items_info where mall='".$_POST["mall"]."';";
            //echo $sql;
            echo "<br>";
            $result = $conn->query($sql);
            echo "<table border='1'>
                  <tr>
                  <th>id</th>
                  <th>name</th>
                  <th>unit</th>
                  </tr>";
            if ($result->num_rows > 0) {
              // output data of each row
              while($row = $result->fetch_assoc()) {    
                echo "<tr>";
                echo "<td>" . $row["id"]. "</td>";
                echo "<td>" . $row["name"]. "</td>";
                echo "<td>" . $row["unit"] . "</td>";
                echo "</tr>";
              }
            } else {
              echo "0 results";
            }
            echo "</table>";
            $conn->close();
          } 
      
  ?>
    <br>商品ID: <input type="text" name="productId"><br><br>
    宅配商品名: 
    <select name="name">
      <option value="５００ｍｌ">500ml</option>
      <option value="２Ｌ">2L</option>
      <option value="５００ｍｌ＋２Ｌ">500ml+2L</option>
    </select><br><br>
    計算単位: 
    <select name="unit">
      <option value="1">1</option>
      <option value="2">2</option>
      <option value="3">3</option>
      <option value="4">4</option>
      <option value="5">5</option>
      <option value="6">6</option>
    </select><br><br>
    クーポンサイト価格: 
    <input type="text" name="couponPrice" value="0"><br>
    <input type="submit" name="create" value="新規登録">
    <input type="submit" name="update" value="変更確定">
  </form>

  <?php 
      if(isset($_POST["create"])){
        $sql="insert into items_info values('$_POST[productId]','$_POST[name]','$_POST[unit]','$_POST[mall]','$_POST[couponPrice]')";
        echo "<br>".$sql."<br>";

        if ($conn->query($sql) === TRUE) {
          echo "Insert data successfully";
        } else {
          echo "Error creating table: " . $conn->error;
        }
      } else if(isset($_POST["update"])){
        $sql="Update items_info set name='$_POST[name]',unit='$_POST[unit]',mall='$_POST[mall]',couponSitePrice='$_POST[couponPrice]' where id='$_POST[productId]'";
        echo "<br>".$sql."<br>";

        if ($conn->query($sql) === TRUE) {
          echo "Update data successfully";
        } else {
          echo "Error creating table: " . $conn->error;
        }

      }
  ?>

</body>
</html>
