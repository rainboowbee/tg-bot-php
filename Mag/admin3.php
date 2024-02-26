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
<div id="goga" style="width:100px;hight:100px;background-color:red;">
    
</div>
<?php
include("ConnData.php");
echo "<a class='menu_link' href='catalog.php?id=".$_GET["id"]."&scroll=0'>Магазин</a><br>";
echo "<a class='menu_link' href='admin.php?id=".$_GET["id"]."'>Активные заказы</a><br>";
echo "<a class='menu_link' href='admin2.php?id=".$_GET["id"]."'>Выполненные заказы</a><br>";
echo "<a class='menu_link' href='admin3.php?id=".$_GET["id"]."'>Статистика</a><br>";
$connData = ConnData::shared();
$conn = new mysqli($connData->host(), $connData->user(), $connData->password(), $connData->database());
$query1 = "SELECT SUM((BuyCount-NowCount)* NowPrice) FROM Items ";
$query2 = "SELECT SUM((BuyCount-NowCount)*(NowPrice - BuyPrice)) FROM Items ";
$query3 = "SELECT SUM((BuyCount-NowCount)* BuyPrice) FROM Items ";
$query4 = "SELECT adminID, SUM(price) AS total_price FROM Purchases WHERE DATE(time) = CURDATE() and adminID = 1171820656 AND Status = 1;";
$query5 = "SELECT adminID, SUM(price) AS total_price FROM Purchases WHERE DATE(time) = CURDATE() and adminID = 942713736 AND Status = 1;";
$query6 = "SELECT adminID, SUM(price) AS total_price FROM Purchases WHERE DATE(time) = CURDATE() and adminID = 599402112 AND Status = 1;";
if($result = $conn->query($query1)){
    foreach ($result as $row){
        echo "<p id='stats'>На счете: ".$row["SUM((BuyCount-NowCount)* NowPrice)"]."</p>";
    }
}
echo "<br>";
if($result = $conn->query($query2)){
    foreach ($result as $row){
        $bonus = $row["SUM((BuyCount-NowCount)*(NowPrice - BuyPrice))"];
        $bonus = round(intval($bonus)*0.05);
        echo "<p id='stats'>Чистая прибыль: ".(intval($row["SUM((BuyCount-NowCount)*(NowPrice - BuyPrice))"])-$bonus)."(".$row["SUM((BuyCount-NowCount)*(NowPrice - BuyPrice))"].")"."</p>";
        
    }
}
echo "<br>";
if($result = $conn->query($query3)){
    foreach ($result as $row){
        echo "<p id='stats'>На закупки: ".(intval($row["SUM((BuyCount-NowCount)* BuyPrice)"])+$bonus)."</p>";
    }
}

echo "<br>";
if($result = $conn->query($query4)){
    foreach ($result as $row){
        echo "<p id='stats'>rainboowbee: ".($row["total_price"])."</p>";
    }
}

echo "<br>";
if($result = $conn->query($query5)){
    foreach ($result as $row){
        echo "<p id='stats'>klopkate: ".($row["total_price"])."</p>";
    }
}

echo "<br>";
if($result = $conn->query($query5)){
    foreach ($result as $row){
        echo "<p id='stats'>viromadina: ".($row["total_price"])."</p>";
    }
}

?>

<script>


  
</script>
</body>
</html>
