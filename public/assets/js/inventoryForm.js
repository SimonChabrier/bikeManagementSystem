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

    fetchSelectedDataApiPost:function(bikesArray, stationString) 
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
                app.postSuccessMessage();
                app.resetCountSelectedBikesOnPost();
                list.fetchInventories();
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

    addAllEventListeners:function(){
        //display each bike option selected
        document.getElementById('bikes').addEventListener('change', (event => {
            app.handleDisplayChoice(event);
            app.handleResetBikeOptionIndex();
        }));
   
        //Submit Api Post 
        document.getElementById('formSubmitButton').addEventListener('click', (event => {
            event.preventDefault()

            app.handleAlertUserIfPostEmptyValues();
            app.handlePostSubmitChoices();
            app.handleResetStationOptionIndexAfterPost();
            
            //reset div qui retourne les card inventaires du jour.
            list.handleResetDisplayedInventories();
        }));
    }, 

    handleDisplayChoice:function(event){

        const bikeIri = event.target.options[event.target.selectedIndex].id
        
        const div = document.createElement('div');
        div.setAttribute("id", bikeIri);

        setTimeout(() => {
          div.style.opacity = 1;
        }, 100 ); 
        
        div.className = "bikeDiv";

        const bikeNumber = document.createElement('text');
        bikeNumber.className = "form-control bikeElement mt-2 mb-2";
        bikeNumber.setAttribute('disabled', true)
        bikeNumber.innerText = event.target.value;
        bikeNumber.setAttribute("id", bikeIri);

        div.appendChild(bikeNumber);

        const button = document.createElement('button');
        button.className = "btn btn-danger btn-sm bikeButton";
        button.innerText = `Supprimer: ${bikeNumber.innerText}`;
        button.setAttribute("id", bikeIri);

        const divDisplaydSelectedBikes = document.getElementById('selectedBikes'); 
        div.appendChild(button);
        divDisplaydSelectedBikes.appendChild(div);

        app.deleteDisplayedBikeChoice();
        app.countSelectedBikes();

        app.alertUserIfDuplicateChoice();
        
    },

    handleResetBikeOptionIndex:function(){
        const bikesOptions = document.getElementById('bikes')
        const currentSelectedIndex = bikesOptions.options.selectedIndex;
        if(currentSelectedIndex !== 0){
            bikesOptions.options.selectedIndex = 0
        }
    },

    handleResetStationOptionIndexAfterPost:function(){
        const stationOptions = document.getElementById('stations')
        const currentSelectedIndex = stationOptions.options.selectedIndex;
        if(currentSelectedIndex !== 0){
            stationOptions.options.selectedIndex = 0
        }
    },

    handleAlertUserIfPostEmptyValues:function(){
        const currentBikeOptionValue = document.getElementsByClassName('bikeDiv');
        const currentStationOptionValue = document.getElementById('stations');
        
        if(currentBikeOptionValue.length == 0){
            alert('Vous devez selectionner au minimum un vélo !')
        }

        if(currentStationOptionValue.options.selectedIndex == 0){
            alert('Vous devez selectionner au minimum une station !')
        }
        
    },

    handlePostSubmitChoices:function(){
        //gestion des vélos
        const bikes = [];
    
        const values = document.getElementsByClassName('bikeElement');
        const bikesToPost = Array.from(values);
        
        bikesToPost.forEach(value => {
            bikes.push(value.getAttribute("id"));
        })

        //gestion de la station
        const selectedStation = document.getElementById('stations');
        const station = selectedStation.options[selectedStation.selectedIndex].id

        //post sur l'API
        app.fetchSelectedDataApiPost(bikes, station);
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

            app.diplayTotalAvailableBikes(choiceValue);

            }
        });

        
    
    },

    diplayTotalAvailableBikes: function(option){

        const availableBikes = document.getElementsByTagName('option');
        const displayAvailableBikesCount = document.getElementById('availableBikesCount');
        
        const totalBikesCount = option.length        
        const countValue = availableBikes.length;

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
            h5.innerText = "Commencez par sélectionner un vélo !";
            h5.style.color = "red";
            button.style.display = 'none';
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

    deleteDisplayedBikeChoice:function(){ 
        let div = document.getElementsByClassName('bikeDiv');
        const buttons = document.getElementsByClassName('btn btn-danger btn-sm');

        for(let button of buttons){
                button.addEventListener('click', function(event){
                event.preventDefault();
                div = event.target.closest('div');
                div.style.background = "red";
                div.style.padding = '1rem';
                div.style.borderRadius = '.5rem';
                div.style.opacity = 0;

                setTimeout(() => {
                    div.remove();
                    app.countSelectedBikes()
                  }, 500)
                ;
            });
        } 
    },

    postSuccessMessage:function(){
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

    alertUserIfDuplicateChoice: function(){
        console.log('alertUserIfDuplicateChoice')
        
        const divs = document.getElementsByClassName('form-control bikeElement mt-2 mb-2'); 
        const divsArray = []
        // j'indexe chaque div dans le tableau'
        for(let div of divs){
            divsArray.push(div.textContent)
        }
        //je filtre pour chercher les valeurs dupliquées
        const duplicateArray = divsArray.filter(
            (value, index) => index !== divsArray.indexOf(value)
        );
        //si une valeur dupliquée existe elle est indexée dans duplicateArray alors son length passe de 0 à 1...
        if(duplicateArray.length > 0){

            alert(`Le vélo ${duplicateArray} est déjà sélectionné !`);

            //je récupère l'ensemble des divs affichés avec des choix dé vélo
            let divs = document.getElementsByClassName('bikeDiv');
            //je récupère le nombre
            let length = divs.length;
            
            for(let div of divs){
            //comme le dernière div vient d'être annulée par le filtrage
                if (!--length){
                    div.style.background = "red";
                    div.style.padding = '1rem';
                    div.style.borderRadius = '.5rem';
                    // je la supprime en gérant son opacité pour fluidifier sa disparition
                    setTimeout(() => {
                        div.style.opacity = 0;
                    }, 500)

                    setTimeout(() => {
                    div.remove();
                    //je resete le conteur de vélos sélectionnés.
                    app.countSelectedBikes()
                    }, 1000)
                }
            }
        }
        
    }

 };

// Call init() on DOMContentLoaded
document.addEventListener('DOMContentLoaded', app.init);


