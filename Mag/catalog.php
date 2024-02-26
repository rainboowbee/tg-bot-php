<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <title>5LET</title>
    <script src="https://telegram.org/js/telegram-web-app.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="style1.css">
    <link rel="preconnect" href="https://fonts.googleapis.com"> 
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> 
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;500;600;700&display=swap" rel="stylesheet">
    <style>
    body{
    -webkit-touch-callout: none;
	-webkit-user-select: none;
	-khtml-user-select: none;
	-moz-user-select: none;
	-ms-user-select: none;
    }
    </style>

</head>
<body style="">
<div id="Cart" class="cart nvis">
    <strong id="cartTextLogo" style="font-family: 'Jost', sans-serif;font-weight:600;">Заказ</strong>
    <button id='closeCart' onclick='hideCart()'><a><p>X</p></a></button>
    <div id="cartBlock">

    </div>

</div>
<strong id="textLogo" style="font-family: 'Jost', sans-serif;font-weight:600;">5LET</strong>
<button id='cartLogo' onclick='showCart()'><a style = 'text-decoration: none'><p>0</p></a></button>
<?php
$admins = array("1171820656","942713736","599402112");
include("ConnData.php");
$id = $_GET["id"];

$connData = ConnData::shared();
$conn = new mysqli($connData->host(), $connData->user(), $connData->password(), $connData->database());
mysqli_set_charset($conn, "utf8");
//$connSingletone = ConnSingletone::shared();
//Подключение к бд


if($conn->connect_error){
    echo("Ошибка 1: " . $conn->connect_error);
}

$sql0 = "SELECT * FROM Settings WHERE ID = 1";
if ($result = $conn->query($sql0)) {
    foreach ($result as $row) {
        $appOn = $row["Status"];
    }
}
$off = false;
if (($appOn == "0")&&(!in_array($_GET["id"],$admins))){
    $off = true;
}
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

try {

    if ($_GET["login"] != null){
        $login = $_GET["login"];
        $sql1 = "SELECT * FROM Clients WHERE VkID = " . $id . " AND " . "Login = '" . $login . "'";
        if ($result = $conn->query($sql1)) {
            $rowsCount = $result->num_rows; // количество полученных строк
        }

        if ($rowsCount == 0) {
            $query = "INSERT INTO Clients(VkID,CountCart,PriceCart,Login) VALUES(" . $id . ",0,0,'" . $login . "')";

            if ($result = $conn->query($query)) {
            } else {
                echo "Ошибка 222: " . $conn->error;
            }
        }

    }
}

//catch exception
catch(Exception $e) {
    echo 'Message: ' .$e->getMessage();
}


//включение админ панели
if (in_array($_GET["id"],$admins)){
    echo "<a href='admin.php?id=".$_GET["id"]."'><button class='adminpanelbtn'>admin panel</button></a>";
}

?>

<br>
<br>
<br>
<br>
<br>
<br>
<div class="itemBox">

<?php



//Товары
$items = array();
$ids = array();
$cart = array();
$prices = array();
$names = array();
$sql = "SELECT * FROM Items WHERE NowCount > 0 ORDER BY Category";
if($result = $conn->query($sql)){
    $rowsCount = $result->num_rows; // количество полученных строк

    foreach($result as $row){
        $items[] = $row["NowCount"];
        $ids[] = $row["ID"];
        $cart[] = 0;
        $names[] = $row["Name"];
        $prices[] = $row["NowPrice"];
        echo "<div class='itemCard'>";
        echo "<img src='img/".$row["Photo"]."'>";
        echo "<p class='itemName name'>".$row["Name"]."</p>";
        echo "<b class='itemSize'>".$row["Volume"]."</b>";
        echo "<b class='itemPrice'>".$row["NowPrice"]."₽</b>";
        echo "<div id='".$row["ID"]."'class='actionBox'>";
            // echo "<button onclick='minustestCart(".$row["ID"].",".$_GET["id"].",".$row["NowPrice"].",".$countInCart[$row["ID"]].")' class='changeCount'>-</button>";
            //echo "<a class='countInCart'>".$countInCart[$row["ID"]]."</a>";
            //echo "<button onclick='plustestCart(".$row["ID"].",".$_GET["id"].",".$row["NowPrice"].",".$countInCart[$row["ID"]].")' class='changeCount'>+</button>";
        echo "<button onclick='testCart(".$row["ID"].",".$_GET["id"].",".$row["NowPrice"].")'  class='addToCardBtn'><b>В Корзину<b></button>";

        echo "</div>";
        echo "</div>";
    }
    echo "</table>";

    $result->free();
} else{
    echo "Ошибка 2: " . $conn->error;
}
$conn->close();

?>

</div>


<script>
    <?php
        if ($off){
            echo "window.location.href = 'AppOff.html'; ";
        }
        echo "let userid = ".$_GET["id"].";" ;
    ?>
    var a = 0;
    var pricecartone= 0;
    let fruits = ["Яблоко", "Апельсин", "Слива"];
    items = [];
    ids = []
    cart = [];
    names = [];
    prices = [];
    
   let tg = window.Telegram.WebApp;
    
    <?php
        for ($i = 0;$i < count($ids);$i++) {
            echo "items.push(".$items[$i].");";
            echo "ids.push(".$ids[$i].");";
            echo "cart.push(".$cart[$i].");";
            echo "names.push('".$names[$i]."');";
            echo "prices.push(".$prices[$i].");";
        }


    ?>

    async function buy(userId){
        var room1 = document.getElementById("room").value;
        if (room1 != ""){
        document.getElementById("buy").onclick = "";
        await $.ajax({
            type:'POST',
            url:'buy.php',
            data:{user : userId, price : pricecartone, room : room1, items1: cart, items2: ids},
            success:function(msg){
                console.log("b");

            }
        });
        //let response = fetch("https://api.telegram.org/bot1480500018:AAGyEekow7WFuNqtNrx4VyEShwpu_Fjjmx8/sendMessage?chat_id=228212490&text=Новый+заказ!");
        //let response1 = fetch("https://api.telegram.org/bot1480500018:AAGyEekow7WFuNqtNrx4VyEShwpu_Fjjmx8/sendMessage?chat_id=417081307&text=Новый+заказ!");
        pricecartone = 0;
        tg.isClosingConfirmationEnabled = false;
        document.getElementById("cartLogo").innerHTML = "<p>"+0+"</p>";
        location.reload();
        }
        else{
            document.getElementById("room").style.border = "2px solid red";
        }
    }
    function showCart(userId){
    
        document.getElementById("Cart").style.top = '-3px';
        document.getElementsByClassName("itemBox")[0].hidden = true;
        if(pricecartone === 0){
            document.getElementById("cartBlock").innerHTML = "<img style='width: 80%;margin-left: 10%;margin-top: 40px;' src='img/emptycart.jpg' >"
        }
        else{
            document.getElementById("cartBlock").innerHTML = "<div id='cartitems'><div>"
            for (let i = 0; i < ids.length;i++){
                if (cart[i] > 0) {
                    document.getElementById("cartBlock").innerHTML += "<b style='margin-left:10%'>" + names[i] + "*" + cart[i] + "(" + prices[i] + "P)</b><br>";
                }
            }
            document.getElementById("cartBlock").innerHTML += "<h1 id='sum'> Сумма = "+ pricecartone+"</h1>"
            document.getElementById("cartBlock").innerHTML += "<input placeholder='Комната' id='room'  type='number'>"
            document.getElementById("cartBlock").innerHTML += "<button id='buy' onclick='buy("+userid+")' > Купить</button>"
                }
            }

    function hideCart(){
        document.getElementById("Cart").style.top = '-2000px';
        document.getElementsByClassName("itemBox")[0].hidden = false;
    }
      function testCart(itemId,userId,price){
                   if(items[ids.findIndex(i => i === itemId)] > cart[ids.findIndex(i => i === itemId)]){
                       let count =  1;
                       pricecartone += Number(price);
                       document.getElementById(itemId).innerHTML="<button onclick='minustestCart("+itemId+","+userId+","+price+","+1+")' class='changeCount'>-</button>";
                       document.getElementById(itemId).innerHTML+="<a class='countInCart' style='max-width:10%'>"+1+"</a>";
                       document.getElementById(itemId).innerHTML+="<button onclick='plustestCart("+itemId+","+userId+","+price+","+1+")' class='changeCount'>+</button>";
                       document.getElementById("cartLogo").innerHTML = "<p>"+pricecartone+"</p>";
                       cart[ids.findIndex(i => i === itemId)] = count;
                       tg.isClosingConfirmationEnabled = true;
                   }else{
                       console.log("no");
                   }
          console.log(cart);
       }


    function plustestCart(itemId,userId,price,count){
        if(items[ids.findIndex(i => i === itemId)] > cart[ids.findIndex(i => i === itemId)]){
                    var newCount = cart[ids.findIndex(i => i === itemId)] + 1;
                    let count = newCount;
                    pricecartone += price;
                    cart[ids.findIndex(i => i === itemId)] = count;
                    document.getElementById(itemId).innerHTML="<button onclick='minustestCart("+itemId+","+userId+","+price+","+newCount+")' class='changeCount'>-</button>";
                    document.getElementById(itemId).innerHTML+="<a class='countInCart'>"+newCount+"</a>";
                    document.getElementById(itemId).innerHTML+="<button onclick='plustestCart("+itemId+","+userId+","+price+","+newCount+")' class='changeCount'>+</button>";
                    document.getElementById("cartLogo").innerHTML = "<p>"+pricecartone+"</p>";
                }else{
                    console.log("no");
                }
        console.log(cart);
    }
    function minustestCart(itemId,userId,price,count){

                var newCount = count -1;
                if(cart[ids.findIndex(i => i === itemId)] > 1){
                    console.log("2");
                    cart[ids.findIndex(i => i === itemId)] = newCount;
                    pricecartone -= Number(price);
                    document.getElementById(itemId).innerHTML="<button onclick='minustestCart("+itemId+","+userId+","+price+","+newCount+")' class='changeCount'>-</button>";
                    document.getElementById(itemId).innerHTML+="<a class='countInCart'>"+newCount+"</a>";
                    document.getElementById(itemId).innerHTML+="<button onclick='plustestCart("+itemId+","+userId+","+price+","+newCount+")' class='changeCount'>+</button>";
                    document.getElementById("cartLogo").innerHTML = "<p>"+pricecartone+"</p>";
                }
                else if(cart[ids.findIndex(i => i === itemId)] === 1){
                    console.log("1");
                    cart[ids.findIndex(i => i === itemId)] = newCount;
                    pricecartone -= Number(price);
                    document.getElementById(itemId).innerHTML="<button onclick='testCart("+itemId+","+userId+","+price+")'  class='addToCardBtn'><b>В Корзину<b></button>";
                    document.getElementById("cartLogo").innerHTML = "<p>"+pricecartone+"</p>";
                
                }
                else {
                    console.log("no1");
                }
                if (pricecartone == 0){
                   tg.isClosingConfirmationEnabled = false;
                }
        console.log(cart);
    }
    <?php
    echo "window.scrollTo(0,".$_GET["scroll"].");";
    ?>

</script>
</body>



</html>