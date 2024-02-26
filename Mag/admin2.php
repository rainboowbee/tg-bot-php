<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>5LET</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="style1.css">
</head>

<body>

<?php
include("ConnData.php");
echo "<a class='menu_link' href='catalog.php?id=".$_GET["id"]."&scroll=0'>Магазин</a><br>";
echo "<a class='menu_link' href='admin.php?id=".$_GET["id"]."'>Активные заказы</a><br>";
echo "<a class='menu_link' href='admin2.php?id=".$_GET["id"]."'>Выполненные заказы</a><br>";
echo "<a class='menu_link' href='admin3.php?id=".$_GET["id"]."'>Статистика</a><br>";
$connData = ConnData::shared();
$conn = new mysqli($connData->host(), $connData->user(), $connData->password(), $connData->database());
mysqli_set_charset($conn, "utf8");
$query1 = "SELECT ID,Room,Price,ClientID,AdminID,Time,Status FROM Purchases WHERE Status != 0 ORDER BY ID DESC LIMIT 100;";
if($result = $conn->query($query1)){
    foreach ($result as $row){
        $client = $row["ClientID"];
        $query2 = "SELECT Login FROM Clients WHERE VkID = ".$client;
        if($result2 = $conn->query($query2)){
            foreach ($result2 as $row2){
                $login = $row2["Login"];
            }
        }

        echo "<div class = 'purchasecard'>";
        echo "<b>Заказ №".$row["ID"]."(".$login.")</b><br>";
        if ($row["AdminID"] == "1171820656"){
            echo "__Димасик__<br>";
        }
        else{
            echo "__Катенька__<br>";
        }
        echo "<b>".$row["Time"]."</b><br>";
        echo "<b>Комната: ".$row["Room"]."</b><br>";
        echo "<b>".$row["Price"]."Р</b><br>";
        if ($row["Status"] == 1){
            echo "<b style='color: #72cc41'>Подвержден</b><br>";
        }
        if ($row["Status"] == 2){
            echo "<b style='color: crimson'>Отменен</b><br>";
        }
        $query2 = "SELECT Items.Name,Items.NowPrice,PurchaseItems.Count FROM Items,PurchaseItems WHERE PurchaseItems.ItemID = Items.ID AND PurchaseItems.PurchaseID = ".$row["ID"]." LIMIT 200;";
        if($result = $conn->query($query2)){
            foreach ($result as $row){
                echo $row["Name"]."*".$row["Count"]."(".$row["NowPrice"]."P)<br>";
            }
        }
        else{
            echo "Error1";
        }

        echo "</div>";
    }
}
else{
    echo "Error2";
}
?>

</body>
</html>

