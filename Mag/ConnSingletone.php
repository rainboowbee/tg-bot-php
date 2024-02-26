<?php

include("ConnData.php");

class ConnSingletone
{

    private static $connData;
    private static $instance = null;
    private $userID;
    private $userName;

    public static function shared()
    {
        if (null === self::$instance) {

            self::$instance = new self();
            self::$connData = ConnData::shared();
        }
        return self::$instance;
    }

    private function __clone()
    {
    }

    private function __construct()
    {
    }


    public function checkSettings()
    {
        $conn = new mysqli(self::$connData->host(), self::$connData->user(), self::$connData->password(), self::$connData->database());

        return $appOn == "0";
    }

    //-OLD
    public function checkUser($id, $login)
    {
        $conn = new mysqli(self::$connData->host(), self::$connData->user(), self::$connData->password(), self::$connData->database());
        mysqli_set_charset($conn, "utf8mb4");

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
?>


