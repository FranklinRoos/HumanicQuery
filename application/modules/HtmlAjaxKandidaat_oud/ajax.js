 //$Ajaxpath="http://localhost:7777/query_ajax/application/modules/HtmlAjaxKandidaat/";   
    $(document).ready(function(){    
        $("#opslaan").click(function(){
            var functieSel = $("#functie option:selected").text();
            var regioSel = $("#regio option:selected").text();
            
            $.ajax({
                type: "POST",
                contentType: "application/json",
                url:"http://localhost:7777/query_ajax/application/modules/HtmlAjaxKandidaat/QueryJson.php",
                //url:"".$Ajaxpath."QueryJson.php/",
                
                data : '[{"functieNaam":"' + functieSel + '", "regioNaam":"' + regioSel + '"} ]',
                dataType: "text",
                
                success: function(data){
                    myFunction(data);
                }
                
                
                
            });
            
            /*promise.done(function(){alert("ajax is goed gegaan");});
            
            promise.fail(function(){alert("fail");});
            promise.always(function(){alert("always");});*/
            
            return false; 
        });
 /*       $("#functie").change(function(){ 
            var str = $("#functie option:selected").text();
            
            var xmlhttp = new XMLHttpRequest();
           
    //str = '"product owner"';

            var url = "http://localhost/HtmlAjaxKandidaat/QueryJson.php";
            
            if (str == "C# developer"){
                str = str + "Csharp developer";
                
            };
            
            if (str != "Geen voorkeur"){
                url = url + "?q=" + "'" + str + "'";
               
                alert(url);
            }
            xmlhttp.onreadystatechange=function() {
                if (this.readyState == 4 && this.status == 200) {
                    myFunction(this.responseText);     
                }
            }
         
            xmlhttp.open("GET", url, true);
            //xhttp.setRequestHeader("Content-type", "application/json");
            xmlhttp.send(); 
        });*/

    

    var xmlhttp = new XMLHttpRequest();

    var url = "http://localhost:7777/query_ajax/application/modules/HtmlAjaxKandidaat/QueryFuncties.php";
    //var url = "".$Ajaxpath."QueryFuncties.php";

    xmlhttp.onreadystatechange=function() {
        if (this.readyState == 4 && this.status == 200) {
            functiesDropdown(this.responseText);     
        }
    }
    xmlhttp.open("GET", url, true);
    xmlhttp.send();

    var xmlhttp2 = new XMLHttpRequest();

    var url = "http://localhost:7777/query_ajax/application/modules/HtmlAjaxKandidaat/QueryRegio.php";
    //var url = "".$Ajaxpath."QueryRegio.php";
    
    xmlhttp2.onreadystatechange=function() {
        if (this.readyState == 4 && this.status == 200) {
            
            regioDropdown(this.responseText);     
        }
    }
    xmlhttp2.open("GET", url, true);
    xmlhttp2.send();

    function myFunction(response) {
        
        var arr = JSON.parse(response);
        
        var i;
        var out = "<table class=ajax>" +
                  "<tr>" +
                        "<th>Naam</th>" + 
                        "<th>Telefoon</th>" + 
                        "<th>CV</th>" +
                  "</tr>";

        for(i = 0; i < arr.length; i++) {
            out += "<tr><td>" +           
            arr[i].Voornaam + " " +
            arr[i].Tussenvoegsel + " " +
            arr[i].Achternaam +
            "</td><td>" +
            arr[i].Telefoon +
            "</td><td><a href = 'http://localhost:7777/HumanicIC/humanic/assets/cv/" +
            arr[i].Cv + "' target = '_blank' >cv</a>" +  
            "</td></tr>";
        }
        out += "</table>";
        document.getElementById("id01").innerHTML = out;
    }

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
            $("#regio").append(option);   
        }
    }
    
    }); 