
<?php
include("ConnData.php");

$connData = ConnData::shared();
$conn = new mysqli($connData->host(), $connData->user(), $connData->password(), $connData->database());
$query = "UPDATE Purchases SET AdminID = ".$_POST["admin"]." WHERE ID =".$_POST["id"];
$query2 = "UPDATE Purchases SET Status = 2 WHERE ID =".$_POST["id"];

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
$tg_user = $_POST["user"]; // id пользователя, которому отправиться сообщения
$bot_token = '1480500018:AAGyEekow7WFuNqtNrx4VyEShwpu_Fjjmx8'; // токен бота

$text = "Сейчас мы не можем принести Ваш заказ :( \nВозможно один из товаров закончился";

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
