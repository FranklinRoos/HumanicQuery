<?php
session_start();
include ("../../config/config.php");
include ("../../config/connect.php");
include("../../config/default_functions.php");
include ("../FCKeditor/fckeditor.php");
include("userFunction.php");

$pageNavId=50;
fHeaderB($pageNavId);
navigatieAdmin($pageNavId);


echo"<div class=\"container\">";

if(!isset($_SESSION['loginnaam']))
{
    echo "<script type=\"text/javascript\">
           window.location = \"".$GLOBALS['path']."/application/modules/admin/indexAdmin.php\"
      </script>";
}
else
{
        echo "<div class=\"container\" style=\"margin-top:40px;\">";
        overzicht();
        echo "</div>"; 
    echo "</div>";
    //controleer de wijziging
}  
footer();

?>
