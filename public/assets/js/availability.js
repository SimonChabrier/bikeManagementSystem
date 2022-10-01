const availability = {


    init: function ()
    {
        console.log("avalability.init()");
        availability.fetchBikesList();
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
        //console.log(data)
        availability.checkIfBikeIsAvailable(data['hydra:member']);
    },
    
    checkIfBikeIsAvailable:function(bikes){
        const unavailableBikes = bikes.filter(bike => bike.availablity != 'Disponible');
        availability.unavailableBikesTemplate(unavailableBikes);
 
    },

    unavailableBikesTemplate(unavailableBikes){

        ol = document.getElementById('bikesList');

        unavailableBikes.forEach(bike => {
            let li = document.createElement('li')

            if(bike.availablity == "Disparu"){
                li.style.color = 'red'; 
            }

            if(bike.availablity == "Dépôt - Stock"){
                li.style.color = 'orange'; 
            }

            if(bike.availablity == "Dépôt - Panne"){
                li.style.color = 'black'; 
            }

            if(bike.availablity == "Bloqué - Maintenance"){
                li.style.color = 'blue'; 
            }
            
            const updatedAt = new Date( bike.updatedAt).toLocaleDateString('fr-FR');
  
            li.innerHTML = ` N° <a href="/bike/${bike.id}"> ${ bike.number } </a> est ${bike.availablity} le ${updatedAt}`            
            ol.appendChild(li)
        });
    }
}

document.addEventListener("DOMContentLoaded", availability.init);