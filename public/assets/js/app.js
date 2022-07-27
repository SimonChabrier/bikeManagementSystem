const app = {
    
    // Method init is called on DOMContentLoaded -> line 64.
    init: function() {
        console.log("init");
        app.getAllBikes();
    },

    //TODO dynamiser le end point avec des boutons pour changer de page 
    
    //set the api endpoint
    apiRootUrl: 'http://127.0.0.1:8000/api/bikes?page=2', 



    // Api fecth on NewYorkTimes public endPoint
    getAllBikes: function (){

        const output = document.getElementById('jsDiv');

            let config = {
                method: 'GET',
                mode: 'cors',
                cache: 'no-cache',
            };
            
            fetch(this.apiRootUrl, config)

            .then(function (response) {
            return response.json();
            })

            .then(function (data) {

                for (var i = 0; i < data['hydra:member'].length; i++){
              
                    try{
                       
                        output.innerHTML +=  `
                
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


