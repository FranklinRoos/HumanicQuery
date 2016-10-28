<?php
session_start(); 
include ("../../../config/config.php");
include ("../../../config/connect.php");
include("../../../config/default_functions.php");
global $connection;
global $querypath;

$pageNavId=31;
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

     echo "<section class=\"functiesPage\">";
           /*echo "<nav class=\"navbar navbar-default\">";
           //echo "<nav class=\"navbar navbar-inverse navbar-fixed-top\">";        
            echo "<div class=\"container-fluid\">";*/
              /*echo "<div class=\"navbar-header\">";
                echo "<a class=\"navbar-brand\" href=\"#\">WebSiteName</a>";
              echo "</div>";*/
             /* echo "<ul class=\"nav navbar-nav\">";
                echo "<li class=\"navbar-toggle\"><a href=\"$querypath"."pages/kandidatenSelectie.php\">kandidaten Filter</a></li>";
                echo "<li class=\"navbar-toggle\"><a href=\"$querypath"."pages/functies.php\">Functies</a></li>";
              echo "</ul>";
            echo "</div>";
        echo "</nav>";*/
        echo "<div class=\"overzicht container\">";
            echo "<div class=\"nieuweFuncties\">";
                echo "<div class=\"functie col-sm-2\">";
                    echo "<h4>Nieuwe functies opvoeren</h4>";
                    echo "<form>";
                        echo "<div class=\"form-group\">";
                            echo "<label>functienaam</label>";
                            echo "<input class=\"form-control\" type=\"text\" name=\"functieNaam\">";
                        echo "</div>";
                        echo "<div class=\"form-group\">";
                            echo "<label>omschrijving</label>";
                            echo "<textarea class=\"form-control\" rows=\"5\" id=\"omschrijving\" name=\"omschrijving\"></textarea>";
                        echo "</div>";
                        echo "<div class=\"form-group\">";
                            echo "<button id=\"nwFunctieOpslaan\" type=\"submit\" class=\"btn btn-primary\">functie opslaan</button>";
                        echo "</div>";
                    echo "</form>";
                echo "</div>";
                echo "<div class=\"andereFunctie col-sm-3\">";
                    echo "<h4>Nieuwe functies opgegeven door kandiaat</h4>";
                    echo "<form>";
                        echo "<div class=\"row\">";
                            echo "<div>";
                                echo "<label class=\"col-sm-2\"></label>";
                                echo "<label class=\"col-sm-2\">functienaam</label>";
                            echo "</div>";    
                            echo "<div id =\"andereFuncties\" class=\"checkbox\">";
                            echo "</div> ";
                        echo "</div>";
                        echo "<div class=\"form-group\">";
                            echo "<button id=\"andereFunctieOpslaan\" type=\"submit\" class=\"btn btn-primary\">functies opslaan</button>";
                        echo "</div>";
                        echo "<div></div>";
                    echo "</form>";
                echo "</div>";
                echo "<div class=\"wijzigFunctie col-sm-5\">";
                    echo "<h4>Functies wijzigen of verwijderen</h4>";
                    echo "<form>";
                        echo "<div class=\"form-group\">";
                            echo "<div>";
                                echo "<label class=\"col-sm-1 glyphicon glyphicon-pencil updateIcon\"></label>";
                                echo "<label class=\"col-sm-1 glyphicon glyphicon-trash deleteIcon\"></label>";
                                echo "<label class=\"col-sm-4\">functienaam</label>";
                                echo "<label class=\"col-sm-6\">omschrijving</label>";
                            echo "</div>";    
                            echo "<div id =\"wijzigFunctie\" class=\"checkbox\"></div>";
                            echo "<div class=\"form-group\">";
                                echo "<button id=\"wijzigFunctieOpslaan\" type=\"submit\" class=\"btn btn-primary\">wijzigen functie</button>";
                            echo "</div>";
                        echo "</div>";    
                    echo "</form>";
                echo "</div>";
            echo "</div>"; 
            
            
            
        echo "</div>";
        
        
        //<script src="/KandidatenQuery/js/ajax2.js"></script>
   echo "</section>";
?>