const app = {
    /**
     * Méthode d'initialisation de notre module
     */
    init: function() {
      
        console.log('init');
      

        let selectedTeam = document.getElementById('result_team');
        selectedTeam.addEventListener("change", app.handleChangeTeam);


    },

    handleChangeTeam: function (event) {

        let selectedTeam = document.getElementById('result_team');
        let teamId = selectedTeam.value;
        let xhr = new XMLHttpRequest();
        xhr.open('GET', '/ajax/' + teamId);

        xhr.responseType = "text";

        xhr.send();

   
        app.changeUserListFromApi(teamId);

        app.dnoneKiller();

    },

    changeUserListFromApi: function (teamId) {

        console.log('loadCategoriesFromAPI lancé');

        // On prépare la configuration de la requête HTTP
        let config = {
          method: 'GET',
          mode: 'cors',
          cache: 'no-cache'
          // Si on veut envoyer des données avec la requête => décommenter et remplacer data par le tableau de données
          //, body : JSON.stringify(data)
        };
        
        // On exécute la requête HTTP via fetch en lui envoyant les options créées au dessus
        fetch('/ajax/' + teamId , config)
          // Une fois la requête exécutée, j'exécute le callback du then
          // callback => la fonction passée entre parrenthèses
          .then(function(response) {
            // On convertit cette réponse en un objet JS et on le retourne
            return response.json();
          })
          // On récupère une variable js depuis le return du then précédent
          // On peut le nommer comme on veut, et l'utiliser dans le callback ici
          .then(function(data) {
            // On dispose désormais d'un tableau JS exploitable dans la variable data
            
            console.log(data);
        }); 

/*             let selectCategoriesFilter = categoriesList.createSelectElement(data, 'Toutes les catégories', 'filter__choice');

            const divSelectHeaderContent = document.getElementById('header_categories');
            divSelectHeaderContent.append(selectCategoriesFilter);


            let selectCategories = categoriesList.createSelectElement(data, 'Toutes les catégories');

            const divSelectTaskAddContent = document.getElementById('task_add_categories');

            divSelectTaskAddContent.append(selectCategories); */

    },

    dnoneKiller: function () {

        console.log('tu as changé l\'équipe');
        let none = document.querySelectorAll('.d-none');
        for (each of none) {
            each.classList.remove('d-none');
        }
        

    }


}

document.addEventListener('DOMContentLoaded', app.init);