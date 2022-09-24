const app = 
{
    
    init: function() {
        console.log("app init");
        app.listeners();
    },

    listeners:function(){

        app.getBikesList();
        app.getStationsList();
        
        document.getElementById('bikes').addEventListener('change', function (event){
            app.handleDisplayChoice(event);
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

        //const bikeNumber = bikesArray.map(bike => (bike.number));
        //app.createBikesList(bikeNumber);

        const bikesData = bikesArray.map(element => ([
                element.number, 
                element['@id']]
            ));

        app.createBikesList(bikesData);
        //console.log(bikesData);
    },

    createBikesList: function(bikesArray){
        const label = document.getElementById('bikes');
        label.innerText = "Vélos ";

        const select = document.createElement('select');
        label.appendChild(select);

        bikesArray.forEach(bike => {
            const option = new Option(bike[0], bike[1]);
            //option.setAttribute("attribute", bike[1])
            option.dataset.id = (bike[0])
            select.appendChild(option);
        });
    },

    extractStationsItems: function (stations){
        const stationsName = stations.map(element => (element.name));
        app.createStationList(stationsName);
    },

    createStationList: function(choiceValue){
        const label = document.getElementById('stations');
        label.innerText = "Station ";

        const select = document.createElement('select');
        label.appendChild(select);

        choiceValue.forEach(name => {
            const option = document.createElement('option');
            select.appendChild(option);
            option.innerText = name; 
        });        
    },
    
    handleDisplayChoice:function(event){
        const olElement = document.getElementById('selected');

        let liElement = document.createElement('li');

        liElement.className = "bikeElement";
        liElement.innerText = event.target.value;
        olElement.appendChild(liElement);
    },

    handleGetSubmitChoice:function(){
        const arrayValue = [];
        
        const values = document.getElementsByClassName('bikeElement');
        const list = Array.from(values);
        
        //je récupère chaque numéro de vélo au submit je concatène avec le format API platform
        list.forEach(value => {
            //arrayValue.push('/api/bikes/' + element.innerHTML);
            arrayValue.push(value.innerHTML);
        })
        //console.log(arrayValue);
        app.postSelectedBikesData(arrayValue);
    },

    postSelectedBikesData:function(arrayValue) 
    {
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


