<?php
include("ConnData.php");
$connData = ConnData::shared();
$conn = new mysqli($connData->host(), $connData->user(), $connData->password(), $connData->database());
$query1 = "UPDATE Settings SET Status = 1 WHERE ID = 1";
if($result = $conn->query($query1)){


}
?>