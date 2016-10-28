<?php
session_start();
include("../../config/config.php");
include("../../config/connect.php");
include("../../config/default_functions.php");

$pageNavId=12;
navigatieAdmin($pageNavId);
fHeader($pageNavId);//actief=$pageNavId);
global $connection;

//<head>
//<link rel="stylesheet" href="ajax.css">
//<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
//</head>


echo "<h1 class=\"ajaxKandidaat\">Kandidaten</h1>";

echo "<form>";
    //echo "<div id=\"functieRegLabel\">";
    echo "<div>";
        echo "<label for=\"functie\" id=\"labelFunctie\">Functie</label>";
        echo "<label for=\"regio\" id=\"labelRegio\">Regio</label>";
    echo "</div>";
    echo "<div id=\"funcReg\">";
       echo "<select id=\"functie\" name=\"functieNaam\">";
          echo "<option>Alle functies</option>";
       echo "</select>";
       echo "<select id=\"regio\" name=\"regio\">";
          echo "<option>Geen voorkeur</option>";
      echo "</select>";
    echo "</div>";
    echo "<div id=\"subOpslaan\">";
      echo "<input type=\"submit\" value=\"selecteer kandidaten\" id=\"opslaan\" >";
    echo "</div>";
echo "</form>";

echo "<div id=\"id01\"></div>";

echo "<script src=\"ajax.js\"></script>";

//fFooter($pageNavId); 
?>