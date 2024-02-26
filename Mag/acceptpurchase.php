
<?php
include("ConnData.php");
$connData = ConnData::shared();
$conn = new mysqli($connData->host(), $connData->user(), $connData->password(), $connData->database());
$query = "UPDATE Purchases SET AdminID = ".$_POST["admin"]." WHERE ID =".$_POST["id"];
$query2 = "UPDATE Purchases SET Status = 1 WHERE ID =".$_POST["id"];
$price = "";
$room = "";
if($result = $conn->query($query)){
    if($result = $conn->query($query2)){
    }
    else{
        echo json_encode(array('success' => 0));
    }
}
else{
    echo json_encode(array('success' => 0));
}
$query7 = "SELECT Price,Room FROM Purchases WHERE ID =".$_POST["id"];
if($result = $conn->query($query7)){
  foreach ($result as $row){
      $price = $row["Price"];
      $room = $row["Room"];
  }
}
$query3 = "SELECT ItemID,Count FROM PurchaseItems WHERE PurchaseID = ".$_POST["id"];

if($result = $conn->query($query3)){
  foreach ($result as $row){
      $query4 = "UPDATE Items SET NowCount = NowCount - ".$row["Count"]." WHERE ID =".$row["ItemID"];
      if($result = $conn->query($query4)){
      }
      else{
          echo json_encode(array('success' => 0));
      }
  }
}
else{
    echo json_encode(array('success' => 0));
}
$query5 = "SELECT ID,NowCount FROM Items";


if($result = $conn->query($query5)){
    foreach ($result as $row){
        $query4 = "UPDATE CartItem SET Count = ".$row["NowCount"]." WHERE ItemID =".$row["ID"]." AND Count > ".$row["NowCount"];
        if($result = $conn->query($query4)){
        }
        else{
            echo json_encode(array('success' => 0));
        }
    }
}

else{
    echo json_encode(array('success' => 0));
}
$tg_user = $_POST["user"]; // id пользователя, которому отправиться сообщения
$bot_token = '1480500018:AAGyEekow7WFuNqtNrx4VyEShwpu_Fjjmx8'; // токен бота

if($_POST["admin"] == "1171820656"){
    $text = "Заказ подтвержден! Ожидайте доставку) \nТелефон для перевода +79300765610 ТИНЬКОФФ \nСумма = ".$price."₽ \nКомната: ".$room." \nПо вопросам обращаться @rainboowbee";
}
else if($_POST["admin"] == "942713736"){
    $text = "Заказ подтвержден! Ожидайте доставку) \nТелефон для перевода +79300765610 ТИНЬКОФФ \nСумма = ".$price."₽ \nКомната: ".$room." \nПо вопросам обращаться @klopkate";
}
else if($_POST["admin"] == "599402112"){
    $text = "Заказ подтвержден! Ожидайте доставку) \nТелефон для перевода +79300765610 ТИНЬКОФФ \nСумма = ".$price."₽ \nКомната: ".$room." \nПо вопросам обращаться @viromadina";
}

// параметры, которые отправятся в api телеграмм
$params = array(
    'chat_id' => $tg_user, // id получателя сообщения
    'text' => $text, // текст сообщения
    'parse_mode' => 'HTML', // режим отображения сообщения, не обязательный параметр
);

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'https://api.telegram.org/bot' . $bot_token . '/sendMessage'); // адрес api телеграмм
curl_setopt($curl, CURLOPT_POST, true); // отправка данных методом POST
curl_setopt($curl, CURLOPT_TIMEOUT, 10); // максимальное время выполнения запроса
curl_setopt($curl, CURLOPT_POSTFIELDS, $params); // параметры запроса
$result = curl_exec($curl); // запрос к api
curl_close($curl);
?>
