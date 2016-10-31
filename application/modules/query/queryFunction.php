<?php
function overzicht()
{
    global $connection;
    global $cvpath;
    global $path;
    global $imagepath;
    
    $_SESSION['kopText'] = "Overzicht van alle kandidaten uit de database";
    
    if(!isSet($_SESSION['blad']))
       {
           $_SESSION['blad']='user_blad';         
        }    
    if(isSet($_SESSION['blad'])&& $_SESSION['blad'] !='user_blad')    
        {
            $_SESSION['blad']='user_blad';
            $_SESSION['user_page']=0;// hierdoor kom ik in de eerste pagina van het kandidaat overzicht als ik uit de kandidaat.php kom na het bekijken van een profiel   
        }
   
    if(isset($_GET['user_page']))
       {
           $_SESSION['user_page']=$_GET['user_page'];     
       }
   elseif(!isset($_SESSION['user_page']))
      {
             $_SESSION['user_page']=0;
       }

    $qpp = 10; // hier geef ik aan hoeveel records ik op een pagina wil zien
    $start=$_SESSION['user_page']*$qpp;
    $prev = $_SESSION['user_page']-1;
    $next = $_SESSION['user_page']+1;
    $from = $_SESSION['user_page']*$qpp+1;
    $to = $_SESSION['user_page'] * $qpp + $qpp;

    $users = mysqli_query($connection, "SELECT * FROM user WHERE `user_authorisatie`= 'usr'") or die(mysqli_error());// ik doe hier een call(query) naar de databse op alle users in de 'user'tabel
    $count_users = mysqli_num_rows($users);// hier tel ik vervolgens hoeveel users de query heeft opgeleverd
    $objecten = mysqli_query($connection, "SELECT * FROM user  WHERE `user_authorisatie`= 'usr' LIMIT $start,10") or die(mysqli_error());
    $count_Limit_users = mysqli_num_rows($objecten);//tellen hoeveel users er (nog) in de ($objecten) presentatie  zitten
    
    if (mysqli_num_rows($objecten) == 0) 
    {
        die("<i>Nog geen users aanwezig !</i>");
    }

        //zaterdag 13 aug 2016 toegevoegd
        //echo "<h3 style=\"text-align:center; color:black;\">".$_SESSION['kopText']."</h3>";
        echo "<div id=\"overzichtTabel\" class=\"table-responsive\">";  
        echo "<h3 style=\"text-align:center; color:black;\">".$_SESSION['kopText']."</h3>";
             echo "<table class=\"table\" id=\"edit\" cellpadding=\"3\" cellspacing=\"3\" >";
                echo "<tbody>";
                        echo "<tr>";
                              echo "<th width=\"50\" align=\"left\">Profiel</th>";
                              echo "<th width=\"50\" align=\"left\">CV</th>";
                              echo "<th width=\"50\" align=\"left\">User-ID</th>";
                              echo "<th width=\"50\" align=\"left\">Pasfoto</th>";
                              echo "<th width=\"50\" align=\"left\">Geregistreerd sinds</th>";
                              echo "<th width=\"50\" align=\"left\">Voornaam</th>";
                              echo "<th width=\"50\" align=\"left\">Tussenvoegsel</th>"; 
                              echo "<th width=\"50\" align=\"left\">Achternaam</th>";              
                              echo "<th width=\"50\" align=\"left\">Plaats</th>";
                              echo "<th width=\"50\" align=\"left\">Telefoon</th>";
                              echo "<th width=\"50\" align=\"left\">Geb.Datum</th>";
                        echo "</tr>";

   while ($bericht = mysqli_fetch_object($objecten)) 
        {
                        if(isSet($bericht->cv)){$_SESSION['cv'] = ($bericht->cv);}
                             else {$_SESSION['cv'] = "";}
                        echo "<tr>";
                              echo "<td width=\"50\" align=\"left\"><a href=\"".$GLOBALS['path']."application/modules/humanic-portal/kandidaat.php?user_id=".$bericht->user_id."\">Profiel";
                              echo "<td width=\"50\" align=\"left\"><a href=\"$cvpath".$_SESSION['cv']."\" TARGET=\"_blank\">CV";
                              echo "<td>".utf8_encode($bericht->user_id)."</td>";
                              echo "<td>".utf8_encode("<img width=\"70\" height=\"80\" style=\"margin: 5px;\" src=\"$imagepath").utf8_encode($bericht->foto)."\" /></a></td>";
                              echo "<td>".utf8_encode($bericht->user_sinds)."</td>";
                              echo "<td>".utf8_encode($bericht->voornaam)."</td>";
                              echo "<td>".utf8_encode($bericht->tussenvoegsel)."</td>"; 
                              echo "<td>".utf8_encode($bericht->achternaam)."</td>";                     
                              echo "<td>".utf8_encode($bericht->plaats)."</td>";
                              echo "<td>".utf8_encode($bericht->telefoon)."</td>";
                              echo "<td>".utf8_encode($bericht->geboortedatum)."</td>";         
                             echo "</tr>";
        }
                echo "</tbody>";
            echo "</table>";
        echo "</div>" ; 
        
        echo "<table>";
              echo "<tr><td colspan='3'></td>";
              echo "<br/>";
              echo "<tr><td class=\"prev\">".($prev>=0?"<a href=overzicht.php?user_page=".$prev. "> prev </a>":"")."</td>";
                     echo "<td>$from...$to</td>";
                     echo "<td class=\"prev\">".(($count_users - $to)> 0?"<a href=overzicht.php?user_page=" .$next. "> next </a>":"")."</td>"; 
              echo "</tr>";
        echo "</table>";    
       
}

function functieQuery ()
{
    global $connection;
    global $cvpath;
    //global $path;
    global $imagepath;
    
  /*  if(!isSet($_SESSION['kopText']))
        {
            $_SESSION['kopText'] = "Overzicht C# developers met voorkeur Regio Utrecht";
        }*/
    $functie = $_SESSION['functie'];
    $regio = $_SESSION['regio'];
    
     if(($functie === ""  &&  $regio === "") OR ($functie === " "  &&  $regio === " "))
        {
             echo "queryStatus=all";
             $_SESSION['kopText'] = "Overzicht van alle kandidaten";
             $queryStatus = 'all';
             
             echo "<script type=\"text/javascript\">
           window.location = \"".$GLOBALS['path']."/application/modules/query/overzicht.php\"
            </script>";
             
        }    
    
    if($functie != "" && $regio != "")
        {
                $_SESSION['kopText'] = "Overzicht ".$functie."s met voorkeur ".$regio. "";
                $queryStatus = 'F&R';
         }
    if($functie != "" && $regio === " ")
                //voer uit query met beide parameters
        {
                $_SESSION['kopText'] = "Overzicht ".$functie."s  ";
                $queryStatus = 'F';
                // voer uit query zonder parameter regio
         }   
     if($functie === " " && $regio != "")
        {
                $_SESSION['kopText'] = "Overzicht kandidaten met voorkeur ".$regio."  ";
                $queryStatus = 'R';
                // voer uit query zonder parameter functie
         }    
         
         
   if(!isSet($_SESSION['blad']))
        {
                $_SESSION['blad']='user_blad2';
        }    
if(isSet($_SESSION['blad'])&& $_SESSION['blad'] !='user_blad2')    
{
  $_SESSION['blad']='user_blad2';
  $_SESSION['user_page2']=0;// hierdoor kom ik in de eerste pagina van het kandidaat overzicht als ik uit de kandidaat.php kom na het bekijken van een profiel   
}
   
    
    
    
     if(isset($_GET['user_page']))
     {
      $_SESSION['user_page']=$_GET['user_page'];     
      }
   else
      {
        if (!isset($_SESSION['user_page']))
           {
             $_SESSION['user_page']=0;
            }
       }
             
 /*  if($queryStatus == 'all')
     {
         echo "<script type=\"text/javascript\">
           window.location = \"".$GLOBALS['path']."/application/modules/query/overzicht.php\"
            </script>";
      }   */ 
       
    $qpp = 10; // hier geef ik aan hoeveel records ik op een pagina wil zien
    $start=$_SESSION['user_page']*$qpp;
    $prev = $_SESSION['user_page']-1;
    $next = $_SESSION['user_page']+1;
    $from = $_SESSION['user_page']*$qpp+1;
    $to = $_SESSION['user_page'] * $qpp + $qpp;
    
    if($queryStatus == 'F&R')
         {
            $users = mysqli_query($connection, "SELECT DISTINCT `user_id`,`achternaam`, `tussenvoegsel`, `voornaam`, `foto`, `cv`, `ervaring` FROM `kandiaten_vw`  WHERE  `functie_naam` = '".$functie."' AND  `regio_naam`  = '".$regio. "'  ");
            $count_users = mysqli_num_rows($users);// hier tel ik vervolgens hoeveel users de query heeft opgeleverd ..geeft een foutmelding omdat in de query waarop deze telling gebaseerd is , een fout zit
            $objecten = mysqli_query($connection, "SELECT DISTINCT `user_id`,`achternaam`, `tussenvoegsel`, `voornaam`, `foto`, `cv`, `ervaring` FROM `kandiaten_vw`  WHERE  `functie_naam` = '".$functie."' AND  `regio_naam`  = '".$regio. "'   LIMIT $start,10") or die(mysqli_error());//weergave per 10
            $count_Limit_users = mysqli_num_rows($objecten);//tellen hoeveel users er (nog) in de ($objecten) presentatie  zitten
            //echo "count_Limit = ".$count_Limit_users."";
            
                    
   if (mysqli_num_rows($objecten) == 0) 
    {
        die("<marquee><h5 class=\"msg\">Er is nog geen kandidaat met een voorkeur voor ".$_SESSION['functie']." in ".$_SESSION['regio']."!</h5></marquee>");
    } 
     
     
        //zaterdag 13 aug 2016 toegevoegd
 echo"<div class=\"container\">";  
     echo "<div class=\"container\" style=\"margin-top:0.5%;\">";    
          echo "<div id=\"overzichtTabel\" class=\"table-responsive\">";
                  echo "<h3 style=\"text-align:center; color:brown;\">".$_SESSION['kopText']."</h3>"; 
                  echo "<table class=\"table\" id=\"edit\" cellpadding=\"3\" cellspacing=\"3\" >";
                        echo "<tbody>";
                                 echo "<tr>";
                                      echo "<th width=\"50\" align=\"left\">Profiel</th>";
                                      echo "<th width=\"50\" align=\"left\">CV</th>";
                                      echo "<th width=\"50\" align=\"left\">User-ID</th>";
                                      echo "<th width=\"50\" align=\"left\">Pasfoto</th>";
                                      //echo "<th width=\"50\" align=\"left\">Geregistreerd sinds</th>";
                                      echo "<th width=\"50\" align=\"left\">Voornaam</th>";
                                      echo "<th width=\"50\" align=\"left\">Tussenvoegsel</th>"; 
                                      echo "<th width=\"50\" align=\"left\">Achternaam</th>";              
                                      //echo "<th width=\"50\" align=\"left\">Plaats</th>";
                                      //echo "<th width=\"50\" align=\"left\">Telefoon</th>";
                                      //echo "<th width=\"50\" align=\"left\">Geb.Datum</th>";            
                                 echo "</tr>";

   while ($bericht = mysqli_fetch_object($users)) 
        {
                                 echo "<tr>";
                                      echo "<td width=\"50\" align=\"left\"><a href=\"".$GLOBALS['path']."application/modules/humanic-portal/kandidaat.php?user_id=".$bericht->user_id."\">Profiel";
                                      echo "<td width=\"50\" align=\"left\"><a href=\"$cvpath".$_SESSION['cv']."\" TARGET=\"_blank\">CV";
                                      echo "<td>".utf8_encode($bericht->user_id)."</td>";
                                      echo "<td>".utf8_encode("<img width=\"70\" height=\"80\" style=\"margin: 5px;\" src=\"$imagepath").utf8_encode($bericht->foto)."\" /></a></td>";
                                      //echo "<td>".utf8_encode($bericht->user_sinds)."</td>";
                                      echo "<td>".utf8_encode($bericht->voornaam)."</td>";
                                      echo "<td>".utf8_encode($bericht->tussenvoegsel)."</td>"; 
                                      echo "<td>".utf8_encode($bericht->achternaam)."</td>";                     
                                      //echo "<td>".utf8_encode($bericht->plaats)."</td>";
                                      //echo "<td>".utf8_encode($bericht->telefoon)."</td>";
                                      //echo "<td>".utf8_encode($bericht->geboortedatum)."</td>";                                 
                                 echo "</tr>";
        }
                        echo "</tbody>";
                  echo "</table>";
          echo "</div>" ;
      echo "</div>" ;
  echo "</div>" ;    
        
        echo "<table>";
             echo "<tr><td colspan='3'></td>";
             //echo "<tr><td>".($prev>=0?"<a href=user.php?user_page=".$prev. "> prev </a>":"prev")."</td>";
             //echo "<td>$from...$to</td>";
             //echo "<td>".(mysqli_num_rows($objecten)>9?"<a href=user.php?user_page=" .$next. "> next </a>":"next")."</td>";
            echo "<br/>";
            echo "<tr><td class=\"prev\">".($prev>=0?"<a href=queryMaken.php?user_page2=".$prev. "> prev </a>":"")."</td>";
                 echo "<td>$from...$to</td>";
                 echo "<td class=\"prev\">".(($count_users - $to)> 0?"<a href=queryMaken.php?user_page2=" .$next. "> next </a>":"")."</td>"; 
            echo "</tr>";
        echo "</table>"; 
    
            
            
            
        }
    
    if($queryStatus == 'F')
         {
            $users = mysqli_query($connection, "SELECT DISTINCT `user_id`,`achternaam`, `tussenvoegsel`, `voornaam`, `foto`, `cv`, `ervaring` FROM `kandiaten_vw`  WHERE  `functie_naam` = '".$functie."'   ");
            $count_users = mysqli_num_rows($users);// hier tel ik vervolgens hoeveel users de query heeft opgeleverd ..geeft een foutmelding omdat in de query waarop deze telling gebaseerd is , een fout zit
            $objecten = mysqli_query($connection, "SELECT DISTINCT `user_id`,`achternaam`, `tussenvoegsel`, `voornaam`, `foto`, `cv`, `ervaring` FROM `kandiaten_vw`  WHERE  `functie_naam` = '".$functie."'   LIMIT $start,10") or die(mysqli_error());//weergave per 10
            $count_Limit_users = mysqli_num_rows($objecten);//tellen hoeveel users er (nog) in de ($objecten) presentatie  zitten
            //echo "count_Limit = ".$count_Limit_users."<br>";
                 
   if (mysqli_num_rows($objecten) == 0) 
    {
        die("<marquee><h5 class=\"msg\">Er is nog geen kandidaat met de voorkeur voor ".$_SESSION['functie']." !</h5></marquee>");
    } 
     
     
        //zaterdag 13 aug 2016 toegevoegd
   
echo"<div class=\"container\">";  
     echo "<div class=\"container\" style=\"margin-top: 0.5%;\">";           
        echo "<div id=\"overzichtTabel\" class=\"table-responsive\">";
             echo "<h3 style=\"text-align:center; color:brown;\">".$_SESSION['kopText']."</h3>";
             echo "<table class=\"table\" id=\"edit\" cellpadding=\"3\" cellspacing=\"3\" >";
                  echo "<tbody>";
                     echo "<tr>";
                                      echo "<th width=\"50\" align=\"left\">Profiel</th>";
                                      echo "<th width=\"50\" align=\"left\">CV</th>";
                                      echo "<th width=\"50\" align=\"left\">User-ID</th>";
                                      echo "<th width=\"50\" align=\"left\">Pasfoto</th>";
                                      //echo "<th width=\"50\" align=\"left\">Geregistreerd sinds</th>";
                                      echo "<th width=\"50\" align=\"left\">Voornaam</th>";
                                      echo "<th width=\"50\" align=\"left\">Tussenvoegsel</th>"; 
                                      echo "<th width=\"50\" align=\"left\">Achternaam</th>";              
                                      //echo "<th width=\"50\" align=\"left\">Plaats</th>";
                                      //echo "<th width=\"50\" align=\"left\">Telefoon</th>";
                                      //echo "<th width=\"50\" align=\"left\">Geb.Datum</th>";            
                     echo "</tr>";

   while ($bericht = mysqli_fetch_object($users)) 
        {
                     echo "<tr>";
                                      echo "<td width=\"50\" align=\"left\"><a href=\"".$GLOBALS['path']."application/modules/humanic-portal/kandidaat.php?user_id=".$bericht->user_id."\">Profiel";
                                      echo "<td width=\"50\" align=\"left\"><a href=\"$cvpath".$_SESSION['cv']."\" TARGET=\"_blank\">CV";
                                      echo "<td>".utf8_encode($bericht->user_id)."</td>";
                                      echo "<td>".utf8_encode("<img width=\"70\" height=\"80\" style=\"margin: 5px;\" src=\"$imagepath").utf8_encode($bericht->foto)."\" /></a></td>";
                                      //echo "<td>".utf8_encode($bericht->user_sinds)."</td>";
                                      echo "<td>".utf8_encode($bericht->voornaam)."</td>";
                                      echo "<td>".utf8_encode($bericht->tussenvoegsel)."</td>"; 
                                      echo "<td>".utf8_encode($bericht->achternaam)."</td>";                     
                                      //echo "<td>".utf8_encode($bericht->plaats)."</td>";
                                      //echo "<td>".utf8_encode($bericht->telefoon)."</td>";
                                      //echo "<td>".utf8_encode($bericht->geboortedatum)."</td>";                                
                     echo "</tr>";
        }
                  echo "</tbody>";
              echo "</table>";
          echo "</div>" ; 
     echo "</div>" ;
 echo "</div>" ;         
        
        echo "<table>";
                 echo "<tr><td colspan='3'></td>";
                 //echo "<tr><td>".($prev>=0?"<a href=user.php?user_page=".$prev. "> prev </a>":"prev")."</td>";
                 //echo "<td>$from...$to</td>";
                 //echo "<td>".(mysqli_num_rows($objecten)>9?"<a href=user.php?user_page=" .$next. "> next </a>":"next")."</td>";
                 echo "<br/>";
                 //echo "<tr><td class=\"prev\">".($prev>=0?"<a href=queryMaken.php?user_page2=".$prev. "> prev </a>":"")."</td>";
                     echo "<td>$from...$to</td>";
                     //echo "<td class=\"prev\">".(($count_users - $to)> 0?"<a href=queryMaken.php?user_page2=" .$next. "> next </a>":"")."</td>"; 
                 echo "</tr>";
        echo "</table>";    
            
            
            
            
        }
        
    if($queryStatus == 'R')
         {
            $users = mysqli_query($connection, "SELECT DISTINCT `user_id`,`achternaam`, `tussenvoegsel`, `voornaam`, `foto`, `cv` FROM `kandiaten_vw`  WHERE `regio_naam`  = '".$regio. "'  ");
            $count_users = mysqli_num_rows($users);// hier tel ik vervolgens hoeveel users de query heeft opgeleverd ..geeft een foutmelding omdat in de query waarop deze telling gebaseerd is , een fout zit
            $objecten = mysqli_query($connection, "SELECT DISTINCT `user_id`,`achternaam`, `tussenvoegsel`, `voornaam`, `foto`, `cv` FROM `kandiaten_vw`  WHERE  `regio_naam`  = '".$regio. "'   LIMIT $start,10") or die(mysqli_error());//weergave per 10
            $count_Limit_users = mysqli_num_rows($objecten);//tellen hoeveel users er (nog) in de ($objecten) presentatie  zitten
            //echo "count_Limit = ".$count_Limit_users."<br>";
            
                 
                if (mysqli_num_rows($objecten) == 0) 
                    {
                        die("<marquee><h5 class=\"msg\">Er is nog geen kouro kandidaat met een voorkeur voor ".$_SESSION['regio']." !</h5></marquee>");
                    } 
     
     
             //zondag 21 aug 2016 toegevoegd
   
 echo"<div class=\"container\">";  
     echo "<div class=\"container\" style=\"margin-top: 0.5%;\">";               
             echo "<div id=\"overzichtTabel\" class=\"table-responsive\">";
                    echo "<h3 style=\"text-align:center; color:brown;\">".$_SESSION['kopText']."</h3>";
                    echo "<table class=\"table\" id=\"edit\" cellpadding=\"3\" cellspacing=\"3\" >";
                         echo "<tbody>";
                                echo "<tr>";
                                         echo "<th width=\"50\" align=\"left\">Profiel</th>";
                                         echo "<th width=\"50\" align=\"left\">CV</th>";
                                         echo "<th width=\"50\" align=\"left\">User-ID</th>";
                                         echo "<th width=\"50\" align=\"left\">Pasfoto</th>";
                                         //echo "<th width=\"50\" align=\"left\">Geregistreerd sinds</th>";
                                         echo "<th width=\"50\" align=\"left\">Voornaam</th>";
                                         echo "<th width=\"50\" align=\"left\">Tussenvoegsel</th>"; 
                                         echo "<th width=\"50\" align=\"left\">Achternaam</th>";              
                                         //echo "<th width=\"50\" align=\"left\">Plaats</th>";
                                         //echo "<th width=\"50\" align=\"left\">Telefoon</th>";
                                         //echo "<th width=\"50\" align=\"left\">Geb.Datum</th>";             
                               echo "</tr>";

         while ($bericht = mysqli_fetch_object($users)) 
             {
                                 echo "<tr>";
                                      echo "<td width=\"50\" align=\"left\"><a href=\"".$GLOBALS['path']."application/modules/humanic-portal/kandidaat.php?user_id=".$bericht->user_id."\">Profiel";
                                      echo "<td width=\"50\" align=\"left\"><a href=\"$cvpath".$_SESSION['cv']."\" TARGET=\"_blank\">CV";
                                      echo "<td>".utf8_encode($bericht->user_id)."</td>";
                                      echo "<td>".utf8_encode("<img width=\"70\" height=\"80\" style=\"margin: 5px;\" src=\"$imagepath").utf8_encode($bericht->foto)."\" /></a></td>";
                                      //echo "<td>".utf8_encode($bericht->user_sinds)."</td>";
                                      echo "<td>".utf8_encode($bericht->voornaam)."</td>";
                                      echo "<td>".utf8_encode($bericht->tussenvoegsel)."</td>"; 
                                      echo "<td>".utf8_encode($bericht->achternaam)."</td>";                     
                                      //echo "<td>".utf8_encode($bericht->plaats)."</td>";
                                      //echo "<td>".utf8_encode($bericht->telefoon)."</td>";
                                      //echo "<td>".utf8_encode($bericht->geboortedatum)."</td>";                                
                                 echo "</tr>";
            }
                         echo "</tbody>";
                   echo "</table>";
        echo "</div>" ; 
     echo "</div>" ;
echo "</div>" ;          
       echo "<table>";
        echo "<tr><td colspan='3'></td>";
        echo "<br/>";
       // echo "<tr><td class=\"prev\">".($prev>=0?"<a href=queryMaken.php?user_page2=".$prev. "> prev </a>":"")."</td>";
          echo "<td>$from...$to</td>";
        //echo "<td class=\"prev\">".(($count_users - $to)> 0?"<a href=queryMaken.php?user_page2=" .$next. "> next </a>":"")."</td>"; 
        echo "</tr>";
        echo "</table>"; 
            
            
            
            
        }    
        

    
    
  // vanaf hier naar beneden heb ik uitgeschakeld op zaterdag 20 aug , het limiteren in de presentatie per 10 kandidaten werkt niet, bovenste gedeelte werkt wel , 
 //  maar bij meer dan 10 resultaten is het een lange brij
        
 /*   $users = mysqli_query($connection, "SELECT DISTINCT `user_id`,`achternaam`, `tussenvoegsel`, `voornaam`, `foto`, `cv`, `ervaring` FROM `kandiaten_vw`  WHERE  `functie_naam` = 'Front-end developer' AND  `regio_naam`  = 'Amsterdam e.o.'  ");
    $count_users = mysqli_num_rows($users);// hier tel ik vervolgens hoeveel users de query heeft opgeleverd ..geeft een foutmelding omdat in de query waarop deze telling gebaseerd is , een fout zit
    $objecten = mysqli_query($connection, "SELECT DISTINCT `user_id`,`achternaam`, `tussenvoegsel`, `voornaam`, `foto`, `cv`, `ervaring` FROM `kandiaten_vw`  WHERE  `functie_naam` = 'Front-end developer' AND  `regio_naam`  = 'Amsterdam e.o.'   LIMIT $start,10") or die(mysqli_error());//weergave per 10
    $count_Limit_users = mysqli_num_rows($objecten);//tellen hoeveel users er (nog) in de ($objecten) presentatie  zitten
    echo "count_Limit = ".$count_Limit_users."";
   if (mysqli_num_rows($objecten) == 0) 
    {
        die("<i>Nog geen users aanwezig !</i>");
    } 
     
     
        //zaterdag 13 aug 2016 toegevoegd
   
         echo "<h3 style=\"text-align:center; color:brown;\">".$_SESSION['kopText']."</h3>";//echo "hoeveel records zitten in de presentatie: ".$count_Limit_users."";
        echo "<div id=\"overzichtTabel\" class=\"table-responsive\">";  
        echo "<table class=\"table\" id=\"edit\" cellpadding=\"3\" cellspacing=\"3\" >";
        echo "<tbody>";
        echo "<tr>";
        echo "<th width=\"50\" align=\"left\">View</th>";
        echo "<th width=\"50\" align=\"left\">Pasfoto</th>";
        //echo "<th width=\"50\" align=\"left\">Geregistreerd sinds</th>";
        echo "<th width=\"50\" align=\"left\">User_ID</th>";
        echo "<th width=\"50\" align=\"left\">Voornaam</th>";
        echo "<th width=\"50\" align=\"left\">Tussenvoegsel</th>"; 
        echo "<th width=\"50\" align=\"left\">Achternaam</th>";              
        echo "</tr>";

   while ($bericht = mysqli_fetch_object($objecten)) // zolang er nog users in $objecten zitten
        {
            echo "<tr>";
            echo "<td width=\"50\" align=\"left\"><a href=\"".$GLOBALS['path']."application/modules/humanic-portal/kandidaat.php?user_id=".$bericht->user_id."\">View";
            echo "<td>".utf8_encode("<img width=\"70\" height=\"80\" style=\"margin: 5px;\" src=\"$imagepath").utf8_encode($bericht->foto)."\" /></a></td>";
            //echo "<td>".utf8_encode($bericht->user_sinds)."</td>";
            echo "<td>".utf8_encode($bericht->user_id)."</td>";
            echo "<td>".utf8_encode($bericht->voornaam)."</td>";
            echo "<td>".utf8_encode($bericht->tussenvoegsel)."</td>"; 
            echo "<td>".utf8_encode($bericht->achternaam)."</td>";                                
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        echo "</div>" ; 
        
        echo "<table>";
        echo "<tr><td colspan='3'></td>";
        //echo "<tr><td>".($prev>=0?"<a href=user.php?user_page=".$prev. "> prev </a>":"prev")."</td>";
        //echo "<td>$from...$to</td>";
        //echo "<td>".(mysqli_num_rows($objecten)>9?"<a href=user.php?user_page=" .$next. "> next </a>":"next")."</td>";
        echo "<br/>";
        echo "<tr><td class=\"prev\">".($prev>=0?"<a href=user2.php?user_page2=".$prev. "> prev </a>":"prev")."</td>";
        echo "<td>$from...$to</td>";
        echo "<td class=\"prev\">".(($count_users - $to)> 0?"<a href=user2.php?user_page2=" .$next. "> next </a>":"next")."</td>"; 
        echo "</tr>";
        echo "</table>"; */
    
    // einde uitschakeling zaterdag 2o aug
        
}

function showQueryForm ($functie="", $regio="")
{
       
          echo "<form action='".htmlspecialchars($_SERVER["PHP_SELF"])."' method='post'>";
          echo "<h1 class=\"ajaxKandidaat\">Kandidaten</h1>";
 echo "<div class=\"container-fluid\">"; // bootstrap
     echo "<div class=\"row\">";   // bootstrap  
            echo "<div class=\"col-sm-4\">";
                 echo "<div class=\"table-responsive\">"; // bootstrap
                    echo "<table id=\"functies\">";
                          echo "<select class=\"form-control input-sm\" name=\"functie\" value=$functie>";
                                echo   "<option value=\" \">Geen selectie</option>
                               <option value=\"C# developer\" $selectCS>C# developer</option>
                               <option value=\".NET developer\" $selectDOT>.NET developer</option>
                               <option value=\"Front-end developer\" $selectFRONT>Front-end developer</option>
                               <option value=\"Back-end developer\" $selectBACK>Back-end developer</option>
                               <option value=\"Java developer\" $selectJAVA>Java developer</option>
                               <option value=\"Project manager\" $selectPROJ>Project manager</option>
                               <option value=\"Functioneel ontwerper\" $selectFUNCTO>Functioneel ontwerper</option>    
                               <option value=\"Test coordinator\" $selectTESTCO>Test coordinator</option>
                               <option value=\"Product owner\" $selectPRODOWN>Product owner</option>    
                               <option value=\"Business analist\" $selectBUSANA>Business analist</option>";                
                          echo "</select>";
                     echo "</table>";     
                 echo "</div>";   
            echo "</div>"; 
            echo "<div class=\"operator\">AND</div>";
            echo "<div class=\"col-sm-4\">";
                 echo "<div class=\"table-responsive\">"; // bootstrap
                    echo "<table id=\"regios\">";
                          echo "<select class=\"form-control input-sm\" name=\"regio\" value=$regio>";
                                echo   "<option value=\" \">Geen selectie</option>
                               <option value=\"Noord-Holland\" $selectNH>Noord-Holland</option>
                               <option value=\"Zuid-Holland\" $selectZH>Zuid-Holland</option>
                               <option value=\"Zeeland\" $selectZL>Zeeland</option>
                               <option value=\"Noord-Brabant\" $selectNB>Noord-Brabant</option>
                               <option value=\"Limburg\" $selectLB>Limburg</option>
                               <option value=\"Gelderland\" $selectGL>Gelderland</option>
                               <option value=\"Overijssel\" $selectOV>Overijssel</option>    
                               <option value=\"Utrecht\" $selectUT>Utrecht</option>
                               <option value=\"Flevoland\" $selectFL>Flevoland</option>
                               <option value=\"Drenthe\" $selectDT>Drenthe</option>
                               <option value=\"Groningen\" $selectGR>Groningen</option>
                               <option value=\"Friesland\" $selectFR>Friesland</option>
                               <option value=\"Amsterdam e.o.\" $selectAM>Amsterdam e.o.</option>    
                               <option value=\"Rotterdam\" $selectRT>Rotterdam</option>
                               <option value=\"Eindhoven\" $selectEH>Eindhoven\</option>";                   
                          echo "</select>";
                     echo "</table>";     
                 echo "</div>";   
            echo "</div>";              
                      
                      
                      
                      
                      //echo "</table>";
                      echo "<input type='submit' name='submit_query' value='voer query uit'>";
                      echo "</form><br/>";
                      
                      
     echo "</div>"; //afsluiting bootstrap div        
echo "</div>";  //afsluiting bootstrap div 
    
    
}

function handleQueryForm() 
{
    if(isSet($_POST['functie']) && ($_POST['functie'] !== "" OR $_POST['functie'] !== " "))
        {
             $_SESSION['functie'] = $_POST['functie'];
        }
    else
        {
             $_SESSION['functie'] = "";
        }
     if(isSet($_POST['regio']) && ($_POST['regio'] !== "" OR $_POST['regio'] !== " "))
        {
             $_SESSION['regio'] = $_POST['regio'];
        }
    else
        {
             $_SESSION['regio'] = "";
        }
         //if(($_SESSION['functie'] === "" &&  $_SESSION['regio'] === "") OR ($_SESSION['functie'] === " " &&  $_SESSION['regio'] === " "))
     if($_SESSION['functie'] === "" &&  $_SESSION['regio'] === "")
            {
                functieQuery ();
                //showQueryForm ();
            }
    else 
        {
            functieQuery ();
        }
    
}
