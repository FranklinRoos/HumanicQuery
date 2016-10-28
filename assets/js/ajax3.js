//haal de user_id op       
       var id = sessionStorage.user;
//ajax call naar php file om het profiel op te halen        
        $.ajax({
                type: "POST",
                contentType: "application/json",
                //url:"http://".$_SERVER['HTTP_HOST']."/query/application/modules/KandidatenQuery/php/profielQuery.php",
                url:"http://localhost:7777/query/application/modules/KandidatenQuery/php/profielQuery.php",
                data : '[{"userId":"' + id + '" } ]',
                dataType: "text",
                
                success: function(data){
                    profiel(data);
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    if (textStatus == 'Unauthorized') {
                        alert('custom message. Error: ' + errorThrown);
                    } else {
                        alert('custom message. Error: ' + errorThrown);
                    }
                }
         }); 

    function profiel(response) {
        var arr = JSON.parse(response);
        $("#header").html(arr[0].voorNaam + " " + arr[0].tussenVoegsel + " " + arr[0].achterNaam);
    };
        


 