<?php
session_start(); 
include ("../../../config/config.php");
include ("../../../config/connect.php");
include("../../../config/default_functions.php");
global $connection;
global $querypath;

$pageNavId=30;
fHeader($pageNavId);//actief=$pageNavId);

if(isSet($_SESSION['loginnaam']))
  {
   navigatieAdmin($pageNavId);
  }
  
else
  {
    echo "<script type=\"text/javascript\">
           window.location = \"".$GLOBALS['path']."/application/modules/admin/indexAdmin.php\"
            </script>";  
   }


$sql = mysqli_query($connection,"SELECT * FROM `pages` WHERE `page_nav_id`=$pageNavId  and `page_taal` = 'nl' and `page_show` ='y' ");
    if (mysqli_num_rows($sql)==0)   
      {
         die ("Je hebt geen gegevens tot je beschikking");
      }
while ($content = mysqli_fetch_assoc($sql)) 
   {   // show de inhoud     
        echo "<meta name=\"description\" content=\"".$content["page_description"]."\">";
        echo "<meta name=\"keywords\" content=\"".$content["page_keywords"]."\">";       
        echo utf8_encode($content["page_title"]);
   }

   echo "<div class=\"container\">";
        echo "<div id=\"kandFilter\">";
               echo "<section class=\"queryPage\">";  
                    
                           //echo "<div>";
                                 echo "<form>";
                                          echo "<div clas=\"kopRegel\">";
                                                    echo "<label for=\"kandidaat\" id=\"labelKandidaat\">Kandiaat</label>";
                                                    echo "<label for=\"functie\" id=\"labelFunctie\">Functie</label>";
                                                    echo "<label for=\"regio\" id=\"labelRegio\">Regio</label>";      
                                          echo "</div>";
                                          echo "<div clas=\"kopRegel\">";
                                                   echo "<select id=\"kandidaat\" name=\"user\">";
                                                          echo "<option>Geen voorkeur</option>";
                                                   echo "</select>";
                                                   echo "<select id=\"functie\" name=\"functieNaam\">"; // hier komt de in ajax.js omgezette json data uit QueryFuncties.php 
                                                          echo "<option>Alle functies</option>";
                                                   echo "</select>";
                                                   echo "<div clas=\"regio\">";
                                                        echo "<select id=\"regioB\" name=\"regio\">";
                                                               echo "<option>Geen voorkeur</option>";
                                                       echo "</select>";
                                                   echo "</div>";   
                                          echo "</div>";  
                                 echo "</form>";
                                 echo "<div id=\"id01\"></div>";
                     //echo "</div>";
                     echo "<div id=\"meldingNieuweFunctie\">";
                               echo "<p>Er zijn nieuwe functies opgevoerd door kandidaten</p>";
                     echo "</div>";
               echo "</section>";
    //echo "<script src=\"/KandidatenQuery/js/ajax.js\"></script>";
        echo "</div>";
  echo "</div>";
?>