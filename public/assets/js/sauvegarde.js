const app = 
{
    init: function() {
        console.log("app init");
        app.listeners();
        console.log(app.state.count);       
    },
    
    state : {
        count : 0,
    },

    listeners:function(){

        app.getBikesList();
        app.getStationsList();

        //display each bike option selected
        const selectedBikes = document.getElementById('bikes');
        selectedBikes.addEventListener('change', function (event){
            let bikesIri = event.target.options[event.target.selectedIndex].id
            app.handleDisplayChoice(event, bikesIri);
            app.state.count += 1
            console.log(app.state.count)
        });
   
        //Submit Api Post 
        document.getElementById('submit').addEventListener('click', function (event){
            event.preventDefault()
            app.handleSubmitChoices();
        });
    }, 
    
    //fetch api bikes
    getBikesList: function () {

        const location = window.location.origin;
        const endPoint = '/api/bikes';
        const apiRootUrl = location + endPoint;

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
        
        const location = window.location.origin;
        const endPoint = '/api/stations';
        const apiRootUrl = location + endPoint;
    
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

    extractStationsItems: function (stationsArray){
        const stationsName = stationsArray.map(station => (
            [
            station.name,
            station['@id'],
            station.id
            ]

        ));

        app.createStationOptionList(stationsName);
    },

    createBikesOptionList: function(bikesArray){
        const select = document.getElementById('bikes')

        bikesArray.forEach(bike => {
            const option = new Option(bike[0], bike[0]);
            option.setAttribute("id", bike[1])
            select.appendChild(option);
        });
    },

    createStationOptionList: function(choiceValue){
        const select = document.getElementById('stations')
        
        choiceValue.forEach(station => {

            const option = new Option(station[0], station[0]);
            option.setAttribute("id", station[1])
            select.appendChild(option); 
        });        
    },
    
    handleDisplayChoice:function(event, bikesIri){

        const divDisplaydSelectedBikes = document.getElementById('selectedBikes'); 
        
        const div = document.createElement('div');
        div.setAttribute("id", bikesIri);
        div.className = "bikeDiv";

        const textElement = document.createElement('text');
        textElement.className = "form-control bikeElement mt-2 mb-2";
        textElement.setAttribute('disabled', true)
        textElement.innerText = event.target.value;
        textElement.setAttribute("id", bikesIri);

        div.appendChild(textElement);

        const button = document.createElement('submit');
        button.className = "btn btn-danger btn-sm";
        button.innerText = `Supprimer: ${textElement.innerText}`;
        button.setAttribute("id", bikesIri);

        div.appendChild(button);
        divDisplaydSelectedBikes.appendChild(div);

        app.handleDeleteChoice(); 
        //app.countSelectedBikes();
    },

    // countSelectedBikes:function(){
    //     const count = document.getElementsByClassName('bikeDiv');
    //     const h5 = document.getElementById('bikesSelecTitle');
    //     h5.innerText = `${count.length} vélos sélectionnés`
    // },

    //bouttons supprimer
    handleDeleteChoice:function(){ 
        let div = document.getElementsByClassName('bikeDiv');
        const buttons = document.getElementsByClassName('btn btn-danger btn-sm');

        for(let button of buttons){
                button.addEventListener('click', function(event){
                div = event.target.closest('div');
                div.remove();
                console.log(event.target.id)
            });
        } 
    },

    postSuccesMessage:function(){
        const div = document.getElementById('selectedBikes');

        div.innerHTML =
        ` <div class="alert alert-success" role="alert">
            Données postées ! 
         </div>
        `
        setTimeout(() => {
            div.innerHTML = '';
          }, 2000)
    },

    //Gestion des values d'options selectionnées pour API Post
    handleSubmitChoices:function(){
        const bikes = [];
    
        const values = document.getElementsByClassName('bikeElement');
        const bikesToPost = Array.from(values);
        
        bikesToPost.forEach(value => {
            bikes.push(value.getAttribute("id"));
        })

        const selectedStation = document.getElementById('stations');
        const station = selectedStation.options[ selectedStation.selectedIndex ].id

        app.apiPost(bikes, station);
    },

    apiPost:function(bikesArray, stationString) 
    {

        const data = {
            "station": stationString,
            "bikes": bikesArray,
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
        const location = window.location.origin;
        const endPoint = '/api/inventories';
        const apiRootUrl = location + endPoint;
      
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
            app.postSuccesMessage();
        })
        .catch(function(errorMsg){
            console.log(errorMsg)
        });

  

    },

 };

// Call init() on DOMContentLoaded
document.addEventListener('DOMContentLoaded', app.init);


