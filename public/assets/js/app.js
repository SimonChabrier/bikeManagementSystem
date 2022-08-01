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

    resetLengthInfo: function(){
        document.getElementById('lengthInfo').innerHTML = "";
    },

    dynamicEndPoint: function(){

        couterVal = 1,

        document.getElementById('next').addEventListener('click', function() { 
           
            couterVal++

            app.resetDiv();
            app.resetLengthInfo();

            //dynamise endpoint ++
            app.loading(couterVal);
        });

        document.getElementById('previous').addEventListener('click', function() { 
           
            couterVal--

            app.resetDiv();
            app.resetLengthInfo();

            //dynamise endpoint --
            app.loading(couterVal);

            if(couterVal == 0){
                app.resetDiv();
                // reset counter value
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
               
                //items length for one page
                let length =  data['hydra:member'].length
                //items length for all results
                let totalLength = data['hydra:totalItems']

                app.displayResultsLength(length, totalLength);
                
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
      
    displayResultsLength: function(item, items) {

        let itemLength = item;
        console.log('ici ' + itemLength)
        let itemsLength = items;
        
        document.getElementById('lengthInfo').innerHTML += items + ' résultats '
    }


 };

// Call init() on DOMContentLoaded
document.addEventListener('DOMContentLoaded', app.init);


