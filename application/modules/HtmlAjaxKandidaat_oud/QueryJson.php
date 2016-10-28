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
//decode JSON, gevuld in array
$data = json_decode($json);
//bepaal de afzonderlijke velden
$functie  = $data[0]->{"functieNaam"};
$regio  = $data[0]->{"regioNaam"};
$useriD = $data[0]->{"userId"};

//echo $json;
//var_dump(json_decode($json));
//echo $data[0]["functieNaam"];
//if (isset($_GET['functieNaam'])){
//als er een user is meegeven, data ophalen met WHERE clausule user_id
if ($useriD > 0) {
    $qry = "SELECT DISTINCT user_id, voornaam, tussenvoegsel, achternaam, telefoon, cv  FROM kandiaten_vw WHERE user_id = $useriD";
}
else{
//anders, functie en regio tussen ""    
    $functieFilter = "'".$functie."'";
    $regioFilter = "'".$regio."'";
//eersteFilter geeft aan of al een WHERE clausle is aangemaakt
    $eersteFilter = false;
//queru zonder WHERE
    $qry = "SELECT DISTINCT user_id, voornaam, tussenvoegsel, achternaam, telefoon, cv  FROM kandiaten_vw";
    if ($functieFilter != "'Alle functies'"){
//er is een functie geselecteerd
//er wordt een WHERE clausile aangemaakt, dus eersteFilter is true
        $eersteFilter = true;
//in de meegegeven data mag geen # staanm dus als Csharp meegegen, daarna teruggezet naar C#
        if ($functieFilter == "'Csharp developer'"){
                $functieFilter = "'C# developer'";
        }
//maak WHERE clausule aan vor functie criterium
        $selectie = "WHERE functie_naam = $functieFilter";
};

if ($regioFilter != "'Geen voorkeur'"){
//er is een regio geselcteerd en er is al een WHERE clausule
    if ($eersteFilter){
        $selectie .= " AND regio_naam = $regioFilter";
    }
    else {
//er is een regio geselcteerd en er is nog geen WHERE clausule
//WHERE clausule aanmaken en eersteFilter true
        $eersteFilter = true;
        $selectie = "WHERE regio_naam = $regioFilter";
    }
    
};

//als er een WHERE clausule is aangemaakt, dan qru uitbreiden met WHERE clausule
if ($eersteFilter){
    $qry .= " ".$selectie;
}
    
}


$result = $conn->query($qry);
//maak JSON data aan, beginnen met [, dan tussen {} de velden gescheiden door , en eindigen met ]
$outp = "[";
while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
    if ($outp != "[") {$outp .= ",";}
    $outp .= '{"UserId":"'  . $rs["user_id"] . '",';
    $outp .= '"Voornaam":"'  . $rs["voornaam"] . '",';
    $outp .= '"Tussenvoegsel":"'   . $rs["tussenvoegsel"]        . '",';
    $outp .= '"Achternaam":"'. $rs["achternaam"]     . '",';
    $outp .= '"Telefoon":"'. $rs["telefoon"]     . '",';
    $outp .= '"Cv":"'. $rs["cv"]     . '"}';
}
$outp .="]";

$conn->close();
//JSON data wordt teruggegeven mbv echo
echo  $outp; 


/*$json = file_get_contents('php://input');
$data = json_decode($json);
$functie  = $data[0]->{"functieNaam"};
$regio  = $data[0]->{"regioNaam"};

//echo $json;
//var_dump(json_decode($json));
//echo $data[0]["functieNaam"];
//if (isset($_GET['functieNaam'])){
$functieFilter = "'".$functie."'";
$regioFilter = "'".$regio."'";


$eersteFilter = false;
$qry = "SELECT DISTINCT voornaam, tussenvoegsel, achternaam, telefoon, cv  FROM kandiaten_vw";
if ($functieFilter != "'Alle functies'"){
    $eersteFilter = true;
    if ($functieFilter == "'Csharp developer'"){
            $functieFilter = "'C# developer'";
    }
    $selectie = "WHERE functie_naam = $functieFilter";
};

if ($regioFilter != "'Geen voorkeur'"){
    if ($eersteFilter){
        $selectie .= " AND regio_naam = $regioFilter";
    }
    else {
        $eersteFilter = true;
        $selectie = "WHERE regio_naam = $regioFilter";
    }
    
};

if ($eersteFilter){
    $qry .= " ".$selectie;
}


$result = $conn->query($qry);

$outp = "[";
while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
    if ($outp != "[") {$outp .= ",";}
    $outp .= '{"Voornaam":"'  . $rs["voornaam"] . '",';
    $outp .= '"Tussenvoegsel":"'   . $rs["tussenvoegsel"]        . '",';
    $outp .= '"Achternaam":"'. $rs["achternaam"]     . '",';
    $outp .= '"Telefoon":"'. $rs["telefoon"]     . '",';
    $outp .= '"Cv":"'. $rs["cv"]     . '"}';
}
$outp .="]";

$conn->close();

echo  $outp; */
?>


