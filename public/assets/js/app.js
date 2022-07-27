const app = 
{
    
    init: function() {
        console.log("init");
        app.dynamicEndPoint();
        app.loading();
    },


    resetDiv: function(){
        document.getElementById('jsDiv').innerHTML = "";
    },


    dynamicEndPoint: function(){

        couterVal = 1,

        document.getElementById('next').addEventListener('click', function() { 
           
            couterVal++

            app.resetDiv();
            app.loading(couterVal);
        });

        document.getElementById('previous').addEventListener('click', function() { 
           
            couterVal--

            app.resetDiv();
            app.loading(couterVal);

            if(couterVal == 0){
                app.resetDiv();
                couterVal = 1;
            }
        });
         
    },

    loading: function (couterVal){


        if (couterVal === undefined) {
            apiRootUrl =  'http://127.0.0.1:8000/api/bikes';
        } else {
            apiRootUrl =  'http://127.0.0.1:8000/api/bikes?page=' + couterVal;
        }

        console.log(apiRootUrl);
        
        output = document.getElementById('jsDiv');

            let config = {
                method: 'GET',
                mode: 'cors',
                cache: 'no-cache',
            };
            
            fetch(apiRootUrl, config)

            .then(function (response) {
            return response.json();
            })

            .then(function (data) {

                for (var i = 0; i < data['hydra:member'].length; i++){
              
                    try{
                       
                        output.innerHTML +=  
                        
                        `
                            <ol>
                                <li>N° ${data['hydra:member'][i]['number']}</li>
                                <li>Statut ${data['hydra:member'][i]['availablity']}</li>
                            </ol>
                            <hr>
                   
                        `
                    }
                    catch(err){
                        console.log(err);
                    }  
                }//endfor
            })// end then
    },
      



 };

// Call init() on DOMContentLoaded
document.addEventListener('DOMContentLoaded', app.init);


