<?php

function bepaalFunctieid() {
$host ="localhost";
$database = "kandidaten";
$user= "admin";
$pass= "123";
$conn = new mysqli($host, $user, $pass, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT functie_id FROM functie WHERE functie_id <> 99 ORDER BY functie_id DESC LIMIT 1";

$result = $conn->query($sql);

$row =  mysqli_fetch_assoc($result);

return $row["functie_id"];

}

