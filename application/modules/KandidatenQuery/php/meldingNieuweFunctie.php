<?php
//moet meegeven worden voor de json data
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$host ="localhost";
$database = "kandidaten";
$user= "admin";
$pass= "123";
$conn = new mysqli($host, $user, $pass, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT functie_id FROM user_functie WHERE functie_id='99'";
$result = $conn->query($sql);
if ($result->num_rows > 0){
    echo "gevonden";
}
else {
    echo "leeg";
}


    


?>

