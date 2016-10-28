var functies;
//wijzigen functies
var xmlhttp4 = new XMLHttpRequest();

//url waarin de php file staat die data ophaalt
var url = "http://localhost:7777/KandidatenQuery/php/QueryFuncties.php";

//check of XMLHttpRequest klaar is en goed gegaan is, zoja functie dropdown aanroepen
xmlhttp4.onreadystatechange=function() {
    if (this.readyState == 4 && this.status == 200) {
//functie voor de dropdown wordt aangeroepen
        toonFuncties(this.responseText);     
    }
};
    
xmlhttp4.open("GET", url, true);
xmlhttp4.send();
    
//opslaan andere functies
var xmlhttp5 = new XMLHttpRequest();

//url waarin de php file staat die data ophaalt
var url = "http://localhost:7777/KandidatenQuery/php/andereFunctieQuery.php";

//check of XMLHttpRequest klaar is en goed gegaan is, zoja functie dropdown aanroepen
xmlhttp5.onreadystatechange=function() {
    if (this.readyState == 4 && this.status == 200) {
        
//functie voor de dropdown wordt aangeroepen
        andereFuncties(this.responseText);     
    }
};
    
xmlhttp5.open("GET", url, true);
xmlhttp5.send();

 function toonFuncties(response) {
//array aanmaken van de ontvangen JSON data

        var arr = JSON.parse(response);
        var i;
        
//arrau doorlopen en verschillende option aanmaken 
        for(i = 0; i < arr.length; i++) {
            if (arr[i].FunctieId != 99){
                functies = '<div id="functieForm">';
                functies += '<div class="col-sm-1" >';
                functies += '<label><input id="checkboxFunctie' + i +'" type="checkbox"></label>';
                functies += '</div>';
                functies += '<p id="functieId' + i + '" style="display:none">' + arr[i].FunctieId + '</p>';
                functies += '<div class="col-sm-4" >';
                functies += '<input id="functieNaam'+ i + '" type="text" value="' + arr[i].FunctieNaam + '" ></div>';
                functies += '<div class="functieOmschrijving col-sm-7" >';   
                functies += '<textarea id="omschrijving' + i + '"  rows="1" cols="35" >'  + arr[i].Omschrijving + '</textarea></div>';                
                functies += "</div>";
                functies += "<div></div>";
                $("#wijzigFunctie").append(functies);
            }    
        }
        sessionStorage.wijzigFunctie = i;
        $("#wijzigFunctie").append("</div>");
    }
    
function andereFuncties(response) {
//array aanmaken van de ontvangen JSON data

        var arr = JSON.parse(response);
        if (arr.length > 0){
            var i;

    //arrau doorlopen en verschillende option aanmaken 
            for(i = 0; i < arr.length; i++) {
                if (arr[i].FunctieId != 99){
                    functies = '<div id="andereFunctieForm">';
                    functies += '<div class="col-sm-1"></div>';
                    functies += '<div class="col-sm-1">';
                    functies += '<input id="checkboxAndereFunctie' + i +'" type="checkbox">';
                    functies += '</div>';
                    functies += '<p id="userFunctieId' + i + '" style="display:none">' + arr[i].userFunctieId + '</p>';
                    functies += '<div class="col-sm-10" >';
                    functies += '<input id="andereFunctieNaam' + i + '" class="form-control" type="text" value="' + arr[i].nwFunctie + '" ></div>';
                    functies += '<div></div>';
                    functies += "</div>";
                    $("#andereFuncties").append(functies);
                }    
            }
            sessionStorage.andereFunctieId = i;
            //alert(sessionStorage.andereFunctieId);
            $("#andereFuncties").append("</div>");
            $(".wijzigFunctie").css("background-color", "#e5a7a7");
        }
        else {
           // $("#andereFuncties").append("Er zijn geen nieuwe functies opgegeven");
           $(".andereFunctie").css("display", "none");
           $(".wijzigFunctie").css("background-color", "#f2d5d5");
        }
    }
    
    $("#andereFunctieOpslaan").click(function(evt){   
        evt.preventDefault();
        var aantalAndereFunctie = sessionStorage.andereFunctieId;

        for (i=0; i < aantalAndereFunctie; i++){
            var elem = '#checkboxAndereFunctie' +  i ;
              
            if ($(elem).prop('checked')){
                var e1 = '#userFunctieId' +  i;
                var e2 = '#andereFunctieNaam' +  i;
                
                var functieId = $(e1).text();
                var functieNaam = $(e2).val();

                $.ajax({
                    type: "POST",
                    contentType: "application/json",
                    url:"http://localhost:7777/KandidatenQuery/php/toevoegenAndersFunctie.php",
                    data : '[{"userFunctieId":"' + functieId + '", "andereFunctieNaam":"' + functieNaam + '" } ]',
                    dataType: "text",
        //de call is goed gegaan, myFunction wordt aangeroepen met de ontvangen data
                    success: function(data){
                        console.log(data);
                        location.reload();
                    }
                });
            }
        }
    })
    
    $("#wijzigFunctieOpslaan").click(function(evt){   
        evt.preventDefault();
        var aantalWijzigFunctie = sessionStorage.wijzigFunctie;

        for (i=0; i < aantalWijzigFunctie; i++){
            var elem = '#checkboxFunctie' +  i ;
              
            if ($(elem).prop('checked')){
                var e1 = '#functieId' +  i;
                var e2 = '#functieNaam' +  i;
                var e3 = '#omschrijving' + i;
                
                var functieId = $(e1).text();
                var functieNaam = $(e2).val();
                var omschrijving = $(e3).val();

                $.ajax({
                    type: "POST",
                    contentType: "application/json",
                    url:"http://localhost:7777/KandidatenQuery/php/updateFunctie.php",
                    data : '[{"functieId":"' + functieId + '", "functieNaam":"' + functieNaam + '", "omschrijving":"' + omschrijving + '" } ]',
                    dataType: "text",
        //de call is goed gegaan, myFunction wordt aangeroepen met de ontvangen data
                    success: function(data){
                        location.reload();
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        if (textStatus == 'Unauthorized') {
                            alert('custom message. Error: ' + errorThrown);
                        } else {
                            alert('custom message. Error: ' + errorThrown);
                        }
                    }
                    
                });
            }
        }
    })
    
    