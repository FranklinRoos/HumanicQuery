<?php
session_start();
include ("../../config/config.php");
include ("../../config/connect.php");
include("../../config/default_functions.php");
include ("../FCKeditor/fckeditor.php");
include("queryFunction.php");

$pageNavId=50;
fHeader($pageNavId);



echo"<div class=\"container\">";

if(!isset($_SESSION['loginnaam']))
{
    echo "<script type=\"text/javascript\">
           window.location = \"".$GLOBALS['path']."/application/modules/admin/indexAdmin.php\"
      </script>";
    //redirect($GLOBALS['path']."/application/modules/admin/indexAdmin.php");
}
else
{
    navigatieAdmin($pageNavId);
    If(!isset($_POST['submit_query'])) 
      {
    //    // showQueryForm (); // deze functie moet ik nog maken, zondag 21 aug
        echo "<div class=\"container\" style=\"margin-top:40px;\">";
       // functieQuery ();
        showQueryForm ();
        echo "</div>"; 
    }
  else
       { 
                 //echo "<div class=\"container\" style=\"margin-top:40px;\">";
                handleQueryForm();// deze functie moet ik nog maken , zondag 21 aug 
                // echo "</div>"; 
        }
/* }
    else 
        {
        echo "<div class=\"container\" style=\"margin-top:40px;\">";
        userBewerktOpslaan();
        echo "</div>"; 
    }*/
    echo "</div>";
    //controleer de wijziging
}  
footer();
