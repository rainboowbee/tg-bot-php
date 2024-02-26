
<?php
include("ConnData.php");

$connData = ConnData::shared();
$conn = new mysqli($connData->host(), $connData->user(), $connData->password(), $connData->database());
$query = "SELECT * FROM CartItem WHERE ClientID =".$_POST["user"];

$count = 0;
if($result = $conn->query($query)){
   foreach ($result as $row){
       $count +=1;

   }
}
else{}

echo json_encode(array('success' => $count));



?>
