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

$json = file_get_contents('php://input');
$data = json_decode($json);
//echo $data;
$userId = $data[0]->{"userId"};
//echo $userId;
//$userId = 2;

$result = $conn->query("SELECT * FROM user WHERE user_id = $userId");
//$result = $conn->query("SELECT *  FROM user");

$outp = "[";
while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
    if ($outp != "[") {$outp .= ",";}
    $outp .= '{"userId":"'   . $rs["user_id"]        . '",';
    $outp .= '"emailAdres":"'   . $rs["user_email"]        . '",';
    $outp .= '"achterNaam":"'   . $rs["achternaam"]        . '",';
    $outp .= '"tussenVoegsel":"'   . $rs["tussenvoegsel"]        . '",';
    $outp .= '"voorNaam":"'   . $rs["voornaam"]        . '",';
    $outp .= '"straat":"'   . $rs["straat"]        . '",';
    $outp .= '" huisNummer":"'   . $rs["huisnummer"]        . '",';
    $outp .= '"toevoeging":"'   . $rs["postcode"]        . '",';
    $outp .= '"postcode":"'   . $rs["postcode"]        . '",';
    $outp .= '"plaats":"'   . $rs["plaats"]        . '",';
    $outp .= '"telefoon":"'   . $rs["telefoon"]        . '",';
    $outp .= '"foto":"'   . $rs["foto"]        . '",';
    $outp .= '"cv":"'   . $rs["cv"]        . '",';
    $outp .= '"geboorteDatum":"'   . $rs["geboortedatum"]        . '",';
    $outp .= '"salaris":"'   . $rs["salaris"]        . '",';
    $outp .= '"uitkering":"'   . $rs["uitkering"]        . '",';
    $outp .= '"uitkeringGeldigTotplaats":"'   . $rs["uitkering_geldig_tot"]        . '",';
    $outp .= '"rijbewijs":"'   . $rs["rijbewijs"]        . '",';
    $outp .= '"auto":"'   . $rs["auto"]        . '",';
    $outp .= '"reisafstand":"'   . $rs["reisafstand"]        . '",';
    //$outp .= '"opmerking":"'   . $rs["opmerking"]        . '",';
    $outp .= '"linkedIn":"'   . $rs["linkedin"]        . '",';
    $outp .= '"facebook":"'   . $rs["facebook"]        . '",';
    $outp .= '"twitter":"'   . $rs["twitter"]        . '"}';
    
}
$outp .="]";

$conn->close();

echo($outp);
?>


