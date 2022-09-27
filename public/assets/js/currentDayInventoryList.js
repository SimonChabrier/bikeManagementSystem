const list = {


    init: function ()
    {
        console.log("todayInventory Init");
        list.fetchInventories();
    },

    fetchInventories: async function () {

        

        const location = window.location.origin;
        const endPoint = '/api/inventories';
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

        list.extractInventoriesItems(data['hydra:member']);
        
    },

    extractInventoriesItems:function(inventories){

        console.log('extractInventoriesItems')

        let currentDate = new Date();

        for (let inventory of inventories){

            let inventoryDate = inventory.createdAt;

           if(currentDate.toISOString().slice(0, 10) == inventoryDate.slice(0, 10)){

            const renderDiv = document.getElementById('todayInventories');

            //créer une div card
            const inventoryCard = document.createElement('div');
            inventoryCard.className ="inventoryCard";
            inventoryCard.setAttribute('id', inventory.id);
            //creer un span title
            const spanTitle = document.createElement('span');
            spanTitle.className = "spanStationName"
            //accrocher le span à la div card
            inventoryCard.appendChild(spanTitle)
            //accrocher le titre à la span
            spanTitle.innerText = inventory.station.name;
            //creer une div content
            const inventoryContentDiv = document.createElement('div');
            inventoryContentDiv.className = "stationList";
            //acrocher la liste des bikes à la card
            inventoryCard.appendChild(inventoryContentDiv)
            //crer les ol
            const olElement = document.createElement('ol');
            olElement.className ="inventoryOl";
            //ajouter le ol à au content
            inventoryContentDiv.appendChild(olElement);

                for(let bikes of inventory.bikes){
                
                const liElement = document.createElement('li');
                liElement.innerText = bikes.number;
                olElement.appendChild(liElement);
                }
            
            //accrocher le tout à la div de render
            renderDiv.appendChild(inventoryCard)
            }
        }

        list.dynamizeInventoriesListTitle();
    },

    handleResetDisplayedInventories:function(){
        console.log('handleResetDisplayedInventories')
        document.getElementById('todayInventories').innerHTML = '';
    },

    dynamizeInventoriesListTitle:function(){

        const h5 = document.getElementById('dayInventoriesTitle');
        const inventoriesList = document.querySelectorAll(".inventoryCard");
        const cardsCount = inventoriesList.length

        let sentance = "inventaire";
        if(cardsCount > 1) { sentance = "inventaires" }

        return inventoriesList.length > 0 ? h5.innerText = `${cardsCount} ${sentance}` : h5.innerText = "Aucun inventaire aujourd'hui !";
    }
}

document.addEventListener("DOMContentLoaded", list.init);