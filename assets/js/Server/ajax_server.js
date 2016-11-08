$(document).ready(function(){
//globale vatiabelen aanmaken        
    var user = [];
    var userSel;
    var arr;

/***** Begin Ajax call voor functie dropdown *********/    
// eerste ajax call, met object XMLHttpRequest voor functie dropdown
//nieuw object XMLHttpRequest
var xmlhttp = new XMLHttpRequest();

    //var url = "http://".$_SERVER['HTTP_HOST']."/query/application/modules/KandidatenQuery/QueryFuncties.php";
    var url = "http://localhost:7777/query/application/modules/KandidatenQuery/php/QueryFuncties.php";

    xmlhttp.onreadystatechange=function() {
        if (this.readyState === 4 && this.status === 200) {
            functiesDropdown(this.responseText);     
        }
    };
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
/****** Einde Ajax call voor functie dropdown **********/



//tweede ajax call voor regio dropdown
    var xmlhttp2 = new XMLHttpRequest();

    var url = "http://localhost:7777/query/application/modules/KandidatenQuery/php/QueryRegio.php";
    //var url = "http://".$_SERVER['HTTP_HOST']."/query/application/modules/KandidatenQuery/php/QueryRegio.php";
    
    xmlhttp2.onreadystatechange=function() {
        if (this.readyState === 4 && this.status === 200) {
            
            regioDropdown(this.responseText);     
        }
    };
    xmlhttp2.open("GET", url, true);
    xmlhttp2.send();
//tweede ajax call voor user dropdown
    var xmlhttp3 = new XMLHttpRequest();

    var url = "http://localhost:7777/query/application/modules/KandidatenQuery/php/QueryUser.php";
    //var url = "http://".$_SERVER['HTTP_HOST']."/query/application/modules/KandidatenQuery/php/QueryUser.php";
    
    xmlhttp3.onreadystatechange=function() {
        if (this.readyState === 4 && this.status === 200) {
            
            userDropdown(this.responseText);     
        }
    };
    xmlhttp3.open("GET", url, true);
    xmlhttp3.send();
//functie waarin de ajax call om data van de kadiaat_vw te halen   
//eerste keer wordem alle kandidaten opgehaald
    selectKandidaat();   
 
//als er een kandidaat geselecteerd wordt, worden de andere dropdowns uitgezet
    $("#kandidaat").change(function(){
        userSel = $("#kandidaat option:selected").text();
        if (userSel === "Geen voorkeur"){
            $("#functie").prop('disabled', false);
            $("#regioB").prop('disabled', false);
        }
        else {
            $("#functie").prop('disabled', true);
            $("#regioB").prop('disabled', true);
        };
//ophalen van data als een andere kandidaat wordt geselecteerd
        selectKandidaat();
        
    });
//ophalen van data als een andere functie wordt geselecteerd    
    $("#functie").change(function(){
        selectKandidaat();
    });
//ophalen van data als een andere regio wordt geselecteerd    
    $("#regioB").change(function(){
        selectKandidaat();
    });
      
    
    
function functiesDropdown(response) {
        var arr = JSON.parse(response);
        var i;
        var option = "";

        for(i = 0; i < arr.length; i++) {
            if (arr[i].FunctieId != 99){
                option="<option>" + arr[i].FunctieNaam + "</option>";
                $("#functie").append(option);
            }    
        }
    }
    

    
    function regioDropdown(response) {
        var arr = JSON.parse(response);
        
        var i;
        var option = "";

        for(i = 0; i < arr.length; i++) {
            option="<option>" + arr[i].regioNaam + "</option>";
            $("#regioB").append(option);   
        }
    }
    
 
    
    
    function userDropdown(response) {
        var arr = JSON.parse(response);
        
        var i;
        var option = "";

        for(i = 0; i < arr.length; i++) {
            user[arr[i].voorNaam + " " + arr[i].tussenVoegsel + " " +  arr[i].achterNaam    ] = arr[i].userId;
            
            //user["Thijs van Hout"] = arr[i].userId;
            option="<option>" + arr[i].voorNaam + " " + arr[i].tussenVoegsel + " " +  arr[i].achterNaam + "</option>";
            $("#kandidaat").append(option);   
        }
    }
    
    function selectKandidaat() {
//bepalen welke functie en regio is geselcteerd
        var functieSel = $("#functie option:selected").text();
        var regioSel = $("#regioB option:selected").text();
//jquert ajax call voor ophalen data van kandiaat_vw. content_type geeft aan wat voor data verzonden wordt
//dataType wat ontvangen wordt. data geeft aan waarop geselcteerd moet worden
        $.ajax({
            type: "POST",
            contentType: "application/json",
            url:"http://localhost:7777/query/application/modules/KandidatenQuery/php/QueryJson.php",
            //url:"http://".$_SERVER['HTTP_HOST']."/query/application/modules/KandidatenQuery/php/QueryJson.php",
            data : '[{"functieNaam":"' + functieSel + '", "regioNaam":"' + regioSel + '", "userId":"' + user[userSel] + '" } ]',
            dataType: "text",
//de call is goed gegaan, myFunction wordt aangeroepen met de ontvangen data
            success: function(data){
                myFunction(data);
            }
        });
    };
    
       function myFunction(response) {
//arr wordt aangemaakt met de JSON data
        arr = JSON.parse(response);
        var i;
        var out = "<table>" +
                  "<tr>" +
                        "<th>Id</th>" + 
                        "<th>Naam</th>" + 
                        "<th>Telefoon</th>" + 
                        "<th>CV</th>" + 
                        "<th>Profiel</th>" +
                  "</tr>";
//doorloop de array en maak ht,l tabel aan
        for(i = 0; i < arr.length; i++) {
            out += "<tr><td> " +  
            arr[i].UserId + "</td><td>" + 
            arr[i].Voornaam + " " +
            arr[i].Tussenvoegsel + " " +
            arr[i].Achternaam + 
            "</td><td>" +
            arr[i].Telefoon +
            //"</td><td><a href = 'http://localhost:7777/KandidatenQuery/cv/" +
            //"</td><td><a href = 'http://".$_SERVER['HTTP_HOST']."/humanic/assets/cv/" +
            "</td><td><a href = 'http://localhost:7777/HumanicIC/humanic/assets/cv/" +        
            arr[i].Cv + "' target = '_blank' >cv</a>" +  
            "</td><td><button class='profiel'>Profiel</button>" +
            "</td></tr>";
        }
        out += "</table>";
        //sessionStorage.user = out;
        //window.open ("http://localhost/HtmlAjaxKandidaat/newPage.html", "_blank");
//voeg de html tabel toe aan de html pagina
        document.getElementById("id01").innerHTML = out;
//als er op profiel wordt geklikt, profiel aanroepen, met de gegevens van de rij waarin profiel is aangeklikt      
        $(".profiel").click(function(){
            profiel(this);
        });
    }
    
    function profiel(x){
//bepaal de user_id om het juiste profiel te tonen. Dit is de eerst column van de betreffende rij
        var id = $(x).closest("tr").find('td:eq(0)').text();
//bewaar de user_id om deze in de profiel pagina te gebruiken
        sessionStorage.user = id;
//ga naar de profelpagina
        //window.open ("http://localhost:7777/KandidatenQuery/pages/profiel.html", "_blank");
        //window.open ("http://".$_SERVER['HTTP_HOST']."/query/application/modules/KandidatenQuery/pages/profiel.html", "_blank");
        window.open ("http://localhost:7777/HumanicQuery/application/modules/humanic-portal/kandidaat.php?user_id=id ");
        
    }
    
    }); 