const app = 
{
    init: function() {
        console.log("app init");
        app.addAllEventListeners();  
        app.fetchBikesList();
        app.fecthStationsList();
        app.displayCountSelectedBikes();    
    },
    
    state : {
        count : 0,
    },

    addAllEventListeners:function(){
        //display each bike option selected
        document.getElementById('bikes').addEventListener('change', (event => {
            app.handleDisplayChoice(event);
        }));
   
        //Submit Api Post 
        document.getElementById('formSubmitButton').addEventListener('click', (event => {
            event.preventDefault()
            app.handleAlertUserIfPostEmptyValues();
            app.handleSubmitChoices();
        }));
    }, 
    
    fetchBikesList: async function () {

        const location = window.location.origin;
        const endPoint = '/api/bikes';
        const apiRootUrl = location + endPoint;

        let fetchOptions = {
            method: 'GET',
            mode: 'cors',
            cache: 'no-cache'
        };
        try
        {
            response = await fetch(apiRootUrl, fetchOptions);
            data = await response.json();
        }
        catch (error)
        {
            console.log(error);
        }

        app.extractBikesItems(data['hydra:member']);
    },

    fecthStationsList: async function () {
        
        const location = window.location.origin;
        const endPoint = '/api/stations';
        const apiRootUrl = location + endPoint;
    
        let fetchOptions = {
            method: 'GET',
            mode: 'cors',
            cache: 'no-cache'
        };
        try
        {
            response = await fetch(apiRootUrl, fetchOptions);
            data = await response.json();
        }
        catch (error)
        {
            console.log(error);
        }
        app.extractStationsItems(data['hydra:member']);
    },
    
    extractBikesItems: function (bikesArray){

        const bikes = bikesArray.map(bike => (
                [
                    bike.number, 
                    bike['@id'],
                    bike.id,
                    bike.availablity
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

    createBikesOptionList: function(choiceValue){
        const select = document.getElementById('bikes')

        choiceValue.forEach(bike => {
            if(bike[3] == 'Disponible'){
            const option = new Option(bike[0], bike[0]);
            option.setAttribute("id", bike[1])
            select.appendChild(option);
            }
        });

        app.diplayTotalAvailableBikes(choiceValue);
    
    },

    diplayTotalAvailableBikes: function(choiceValue){
          const totalBikesCount = choiceValue.length
          const availableBikes = document.getElementsByTagName('option');
          const countValue = availableBikes.length;
  
          const displayAvailableBikesCount = document.getElementById('availableBikesCount');
          displayAvailableBikesCount.innerHTML = `${countValue} vélos dispo sur ${totalBikesCount}`
    },

    createStationOptionList: function(choiceValue){
        const select = document.getElementById('stations')
        
        choiceValue.forEach(station => {
            const option = new Option(station[0], station[0]);
            option.setAttribute("id", station[1])
            select.appendChild(option); 
        });  

        app.diplayTotalAvailableStations(choiceValue);
   
    },

    diplayTotalAvailableStations: function(choiceValue){
        const countValue = choiceValue.length;
        const displayCount = document.getElementById('availableStationsCount');
        displayCount.innerHTML = `${countValue} stations actives sur ${countValue}`
    },
    
    handleDisplayChoice:function(event){

        const bikeIri = event.target.options[event.target.selectedIndex].id
        
        const div = document.createElement('div');
        div.setAttribute("id", bikeIri);
        div.className = "bikeDiv";

        const bikeNumber = document.createElement('text');
        bikeNumber.className = "form-control bikeElement mt-2 mb-2";
        bikeNumber.setAttribute('disabled', true)
        bikeNumber.innerText = event.target.value;
        bikeNumber.setAttribute("id", bikeIri);

        div.appendChild(bikeNumber);

        const button = document.createElement('button');
        button.className = "btn btn-danger btn-sm";
        button.innerText = `Supprimer: ${bikeNumber.innerText}`;
        button.setAttribute("id", bikeIri);

        const divDisplaydSelectedBikes = document.getElementById('selectedBikes'); 
        div.appendChild(button);
        divDisplaydSelectedBikes.appendChild(div);

        app.deleteDisplayedBikeChoice(); 
        app.countSelectedBikes();
        
    },

    countSelectedBikes:function(){
        let count = document.getElementById('selectedBikes');
        value = count.childElementCount;
        app.state.count = value;

        app.displayCountSelectedBikes()
    },

    displayCountSelectedBikes:function(){

        const h5 = document.getElementById('bikesSelecTitle');
        h5.style.color = "";

        const button = document.getElementById('formSubmitButton')
        
        if(app.state.count == 0){
            h5.innerText = "Aucun vélos sélectionné"  
            button.style.display = 'none'
        };

        if(app.state.count == 1){
            h5.innerText = `${app.state.count} vélos sélectionné`
            button.style.display = 'block'
        }

        if(app.state.count >= 2){
            h5.innerText = `${app.state.count} vélos sélectionnés`
            button.style.display = 'block'
        }
    },

    resetCountSelectedBikesOnPost:function(){
        const h5 = document.getElementById('bikesSelecTitle');
        h5.style.color = "green";

        const button = document.getElementById('formSubmitButton');
        button.style.display = 'none';

        if(app.state.count == 0){
            alert("Oupsss, aucun vélos ajouté !")  
        };

        if(app.state.count == 1){
            h5.innerText = `${app.state.count} vélo ajouté à cet inventaire !`
        }

        if(app.state.count >= 2){
            h5.innerText = `${app.state.count} vélos ajoutés à cet inventaire !`
        }

        setTimeout(() => {
            h5.innerText = 'Réaliser un autre inventaire';
            h5.style.color = "";
          }, 3000)
    },

    //bouttons supprimer
    deleteDisplayedBikeChoice:function(){ 
        let div = document.getElementsByClassName('bikeDiv');
        const buttons = document.getElementsByClassName('btn btn-danger btn-sm');

        for(let button of buttons){
                button.addEventListener('click', function(event){
                div = event.target.closest('div');
                div.remove();
                app.countSelectedBikes();
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

    handleAlertUserIfPostEmptyValues:function(){
        const currentBikeOptionValue = document.getElementById('bikes');
        const currentStationOptionValue = document.getElementById('stations');
        
        if(currentBikeOptionValue.options.selectedIndex == 0){
            alert('Vous devez selectionner au minimum un vélo !')
        }

        if(currentStationOptionValue.options.selectedIndex == 0){
            alert('Vous devez selectionner au minimum une station !')
        }
        
    },

    apiPost:function(bikesArray, stationString) 
    {   
        if(app.state.count >= 1){
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
                app.resetCountSelectedBikesOnPost();
            })
            .catch(function(errorMsg){
                console.log(errorMsg)
            });
        } else {
            const h5 = document.getElementById('bikesSelecTitle');
            h5.innerText = "Oupsss, aucun vélos ajouté !"
            h5.style.color = "red";  
        };   
    },

 };

// Call init() on DOMContentLoaded
document.addEventListener('DOMContentLoaded', app.init);


