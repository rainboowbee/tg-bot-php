<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>5LET</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="style1.css">
    <link rel="preconnect" href="https://fonts.googleapis.com"> 
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> 
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@600&display=swap" rel="stylesheet">
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
$sql0 = "SELECT * FROM Settings WHERE ID = 1";
if($result = $conn->query($sql0)){
    foreach ($result as $row){
        $appOn = $row["Status"];

    }
}
if (($appOn == "0" )){
    echo "<button onclick='onApp()' class='purchasebtn canselbtn' >Включить магазин</button>";
}
else{
    echo "<button onclick='offApp()' class='purchasebtn acceptbtn' >Выключить магазин</button>";
}
$query1 = "SELECT ID,Room,Price,ClientID,Time FROM Purchases WHERE Status = 0 ORDER BY ID DESC";
if($result = $conn->query($query1)){
    foreach ($result as $row){
        $id = $row["ID"];
        $client = $row["ClientID"];
        $query2 = "SELECT Login FROM Clients WHERE VkID = ".$client;
        if($result2 = $conn->query($query2)){
        foreach ($result2 as $row2){
            $login = $row2["Login"];
             }
        }
        echo "<div class = 'purchasecard'>";
        echo "<b>Заказ №".$row["ID"]."(".$login.")</b><br>";
        echo "<b>".$row["Time"]."</b><br>";
        echo "<b>Комната: ".$row["Room"]."</b><br>";
        echo "<b>".$row["Price"]."Р</b><br>";
        $query2 = "SELECT Items.Name,Items.NowPrice,PurchaseItems.Count FROM Items,PurchaseItems WHERE PurchaseItems.ItemID = Items.ID AND PurchaseItems.PurchaseID = ".$row["ID"];
        if($result = $conn->query($query2)){
            foreach ($result as $row){
                echo $row["Name"]."*".$row["Count"]."(".$row["NowPrice"]."P)<br>";
            }
        }
        else{
            echo "Error1";
        }
        echo "<button onclick='accept(".$id.",".$client.",".$_GET["id"].")' class='purchasebtn acceptbtn'>Подтвердить</button>";
        echo "<button onclick='cansel(".$id.",".$client.",".$_GET["id"].")'  class='purchasebtn canselbtn'>Отклонить</button>";
        echo "</div>";
    }
}
else{
    echo "Error2";
}
?>
<script>
    async function accept(id,client,admin){
        console.log("accept"+id);
        await $.ajax({
            type:'POST',
            url:'acceptpurchase.php',
            data:{id:id,user:client,admin:admin},
            success:function(msg){
                location.reload();
            }
        });
    }
    async function cansel(id,client,admin){
        console.log("cansel"+id);
        await $.ajax({
            type:'POST',
            url:'canselpurchase.php',
            data:{id:id,user:client,admin:admin},
            success:function(msg){
                location.reload();
            }
        });
    }

    async function offApp(){
        await $.ajax({
            type:'POST',
            url:'offApp.php',
            data:{id:12},
            success:function(msg){
                location.reload();
            }
        });
    }
    async function onApp(){
        await $.ajax({
            type:'POST',
            url:'onApp.php',
            data:{id:12},
            success:function(msg){
                location.reload();
            }
        });
    }
</script>
</body>
</html>

