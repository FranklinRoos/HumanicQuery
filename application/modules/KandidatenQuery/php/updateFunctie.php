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

//haal de JSON data op
$json = file_get_contents('php://input');
//decode JSON, gevuld in array
$data = json_decode($json);
//bepaal de afzonderlijke velden
$functieId  = $data[0]->{"functieId"};
$functieNaam  = $data[0]->{"functieNaam"};
$omschrijving  = $data[0]->{"omschrijving"};
//$omschrijving = "goede functie 5";
//$functieNaam = "C# developer";
//$functieId = 1;
echo "UPDATE functie SET functie_naam = '$functieNaam', functie_omschrijving = '$omschrijving' WHERE functie_id = $functieId";
$sql = $conn->query("UPDATE functie SET functie_naam = '$functieNaam', functie_omschrijving = '$omschrijving' WHERE functie_id = $functieId");

/*if ($conn->query($sql) === FALSE){
    echo $conn->error;
}
else {
    echo "bah";
}*/



$conn->close();
//dmv echo wordt de JSON data teruggegeven

?>

