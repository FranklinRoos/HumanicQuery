<?php
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

$result = $conn->query("SELECT user_id, achternaam, tussenvoegsel, voornaam  FROM user");
//$result = $conn->query("SELECT *  FROM user");

$outp = "[";
while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
    if ($outp != "[") {$outp .= ",";}
    $outp .= '{"userId":"'   . $rs["user_id"]        . '",';
    $outp .= '"achterNaam":"'   . $rs["achternaam"]        . '",';
    $outp .= '"tussenVoegsel":"'   . $rs["tussenvoegsel"]        . '",';
    $outp .= '"voorNaam":"'   . $rs["voornaam"]        . '"}';
}
$outp .="]";

$conn->close();

echo($outp);
?>


