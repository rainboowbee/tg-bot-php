
<?php
include("ConnData.php");
$connData = ConnData::shared();
$conn = new mysqli($connData->host(), $connData->user(), $connData->password(), $connData->database());
$query1 = "INSERT INTO Purchases(AdminID,ClientID,Price,Room,Time,Status) VALUES(0,".$_POST["user"].",".$_POST["price"].",".$_POST["room"].",NOW(),0)";
$query2 = "SELECT * FROM Purchases";
$items = array();
$id = 0;

$cart = $_POST["items1"];
$ids = $_POST["items2"];

if($result = $conn->query($query1)){
    if($result = $conn->query($query2)){
        foreach ($result as $row){
            $id = $row["ID"];
        }
    }
    else{
        echo json_encode(array('success' => 0));
    }
}
else{
    echo json_encode(array('success' => 0));
}

for($i = 0; $i < count($ids);$i++){
    if($cart[$i] != 0) {
        $query4 = "INSERT INTO PurchaseItems(itemID,Count,PurchaseID) VALUES(" . $ids[$i]. "," . $cart[$i] . "," . $id . ")";
        if ($result = $conn->query($query4)) {
        } else {
            echo json_encode(array('success' => 0));
        }
    }
}


$tg_user = '599402112'; // id пользователя, которому отправиться сообщения
$bot_token = '1480500018:AAGyEekow7WFuNqtNrx4VyEShwpu_Fjjmx8'; // токен бота
$text = "Новый заказ";

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


$tg_user = '1171820656'; // id пользователя, которому отправиться сообщения
$bot_token = '1480500018:AAGyEekow7WFuNqtNrx4VyEShwpu_Fjjmx8'; // токен бота

$text = "Новый заказ";

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

$tg_user = '942713736'; // id пользователя, которому отправиться сообщения
$bot_token = '1480500018:AAGyEekow7WFuNqtNrx4VyEShwpu_Fjjmx8'; // токен бота
$text = "Новый заказ";

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


$tg_user = $_POST["user"]; // id пользователя, которому отправиться сообщения
$bot_token = '1480500018:AAGyEekow7WFuNqtNrx4VyEShwpu_Fjjmx8'; // токен бота

$text = "Заказ оформлен.\nОжидайте подтверждения";

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
echo json_encode(array('success' => 1));



?>
