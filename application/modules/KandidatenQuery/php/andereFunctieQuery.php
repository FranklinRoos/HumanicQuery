<?php
session_start();
include "includeFunctions.php";
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

$result = $conn->query("SELECT user_functie_id, functie_id, nwFunctie FROM user_functie WHERE functie_id='99'");
//$result = $conn->query("SELECT *  FROM user");

//maak JSON data aan, eerst [
$outp = "[";
//tussen {} de betreffende data zetten, datavelden scheiden met ,
while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
    if ($outp != "[") {$outp .= ",";}
    $outp .= '{"userFunctieId":"'  . $rs["user_functie_id"] . '",';
    $outp .= '"functieId":"'   . $rs["functie_id"]        . '",';
    $outp .= '"nwFunctie":"'   . $rs["nwFunctie"]        . '"}';
}
//sluit af met ]
$outp .="]";

$conn->close();
//dmv echo wordt de JSON data teruggegeven
echo($outp);
?>

