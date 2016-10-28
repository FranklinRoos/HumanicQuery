<?php
include "includeFunctions.php";
//include "bepaalFunctieId.php";
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
$userFunctieId  = $data[0]->{"userFunctieId"};
$andereFunctieNaam  = $data[0]->{"andereFunctieNaam"};
//$andereFunctieNaam = "goede functie";
//$userFunctieId = 117;

$functieId = bepaalFunctieid() + 1;

echo $functieId;

$sql = "INSERT INTO functie (functie_id, functie_naam) VALUES ($functieId,'$andereFunctieNaam')";

if ($conn->query($sql) === FALSE){
    echo $conn->error;
}
else {
    $last_id = $conn->insert_id;
    
    $sql = "UPDATE user_functie SET functie_id = $last_id WHERE user_functie_id = $userFunctieId";
    if ($conn->query($sql) === TRUE){
        echo "updated!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
//dmv echo wordt de JSON data teruggegeven

?>

