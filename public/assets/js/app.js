const app = 
{
    init: function() {
        console.log("app init");
        app.listeners();
    },

    
    state : {
        id:"test",
        selected:[],
        count:'',
    },

   
    listeners:function(){

        app.getBikesList();
        app.getStationsList();
        
        const selectedValue = document.getElementById('bikes');
        selectedValue.addEventListener('change', function (event){
            //récupérer la valeur de l'attribut "id" du select changé
            let iri = event.target.options[event.target.selectedIndex].id
            app.handleDisplayChoice(event, iri);
        });

        document.getElementById('submit').addEventListener('click', function (event){
            event.preventDefault()
            app.handleGetSubmitChoice();
        });
    }, 
    
    //fetch api bikes
    getBikesList: function () {
 
        let apiRootUrl = 'http://127.0.0.1:8000/api/bikes'

        let config = {
            method: 'GET',
            mode: 'cors',
            cache: 'no-cache'
        };
      
        fetch(apiRootUrl, config)
          .then(response => {
              return response.json();
          })
          .then(data => {
            app.extractBikesItems(data['hydra:member']);
            //pousser les data dans l'objet state
            //app.state.bikesData.push(data['hydra:member']);
          });
    },

    //fetch api station
    getStationsList: function () {
            
        let apiRootUrl = 'http://127.0.0.1:8000/api/stations'
    
        let config = {
            method: 'GET',
            mode: 'cors',
            cache: 'no-cache'
        };
          
        fetch(apiRootUrl, config)
            .then(response => {
                return response.json();
            })
            .then(data => {
            app.extractStationsItems(data['hydra:member']);
            });
    },
    
    extractBikesItems: function (bikesArray){

        const bikes = bikesArray.map(bike => (
                [
                    bike.number, 
                    bike['@id'],
                    bike.id
                ]
            ));
        
        app.createBikesOptionList(bikes);
    },

    createBikesOptionList: function(bikesArray){
        //console.log(bikesArray)
        const select = document.getElementById('bikes')

        bikesArray.forEach(bike => {
            const option = new Option(bike[0], bike[0]);
            option.setAttribute("id", bike[1])
            select.appendChild(option);
        });
    },

    extractStationsItems: function (stations){
        const stationsName = stations.map(element => (element.name));
        app.createStationList(stationsName);
    },

    createStationList: function(choiceValue){
        const select = document.getElementById('stations')
        choiceValue.forEach(name => {
            const option = document.createElement('option');
            select.appendChild(option);
            option.innerText = name; 
        });        
    },
    
    handleDisplayChoice:function(event, iri){
        const divDisplaydSelectedBikes = document.getElementById('selectedBikes');
        const textElement = document.createElement('text');

        textElement.className = "form-control bikeElement mt-2 mb-2";
        textElement.setAttribute('disabled', true)
        textElement.innerText = event.target.value;
        textElement.setAttribute("id", iri);

        divDisplaydSelectedBikes.appendChild(textElement);
    },

    //Ici je récupère les valeurs slectionnées et insérées dans la page pour remplir le tableau
    // qui sera envoyé en post
    handleGetSubmitChoice:function(){
        const arrayToFeed = [];
        
        const values = document.getElementsByClassName('bikeElement');
        const bikesToPost = Array.from(values);
        
        bikesToPost.forEach(value => {
            arrayToFeed.push(value.getAttribute("id"));
        })

        app.postSelectedBikesData(arrayToFeed);
    },

    postSelectedBikesData:function(arrayValue) 
    {
        console.log(arrayValue);
        //prepare the content of the data to post.
        // arrayValue est déjà un array donc chacune de ses valeurs sera traitée dans les propriétés de fetchOptions sur body: JSON.stringify(data)
        const data = {
            "station": "/api/stations/3",
            "bikes": arrayValue,
          }

        //* format des datas attendus par l'API 
        //*  "/api/bikes/2" est un IRI ! 

        // const data = {
        //     "station": "/api/stations/3",
        //     "bikes": [
        //       "/api/bikes/2",
        //       "/api/bikes/3"
        //     ]
        //   }  

        //* prepare Headers
        const httpHeaders = new Headers();
        httpHeaders.append('Content-Type', 'application/json');
        
        const apiRootUrl = 'http://127.0.0.1:8000/api/inventories';
      
        const fetchOptions = {
        method: 'POST',
        mode : 'cors',
        cache : 'no-cache',
        headers: httpHeaders,
        body: JSON.stringify(data),
        }
       
        fetch(apiRootUrl , fetchOptions)
      
        .then(response => {
      
            if (response.status !== 201) 
            {
                throw 'Erreur avec la requête'; 
            }
            
            return response.json();
            }
        )
        .then(function(){
            console.log('Api POST Validé')
            //app.resetpictureDiv();

        })
        .catch(function(errorMsg){
            console.log(errorMsg)
        });

  

    },

 };

// Call init() on DOMContentLoaded
document.addEventListener('DOMContentLoaded', app.init);


