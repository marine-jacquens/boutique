//APPEL FONCTION JQUERY
$(document).ready(function () {

    let searchNav = $('#searchNav');

    $(window ).resize(function() {
        if (window.matchMedia("(min-height: 700px)").matches) {}else{$('#autocompletion').empty();}
    });

    //LORSQU'ON TAPE UN CARACTERE DANS LA BARRE DE RECHERCHE
    searchNav.on('keyup', function () {

        if (window.matchMedia("(min-height: 700px)").matches) {

            //VIDE LES RECHERCHES A CHAQUE NOUVELLE ENTREE
            $('#autocompletion').empty();

            //SI L'INPUT SEARCH EST DIFFERENT DE VIDE EFFECTUE UNE RECHERCHE DANS LA BDD
            if (searchNav.val() != "") {

                $.ajax({
                    //ENVOI CONTENU INPUT VERS UN SCRIPT
                    url: "../script/autocompletionScript.php",
                    type: "POST",
                    data: "search=" + searchNav.val(),
                    success: function (html) {
                        //AJOUT DES RESULTATS EN LISTE DANS UNE DIV SOUS LA BARRE DE RECHERCHE
                        $('#autocompletion').prepend(html);
                    },
                    error: function (resultat, statut, erreur) {

                        console.log(resultat, statut, erreur);

                    }

                });

                //SI L'INPUT SEARCH EST VIDE, VIDER LA DIV PROPOSANT DES REQUETES
            } else {

                $('#autocompletion').empty();

            }

        }

    });


    $('#formSearch').submit(function(e) {

        e.preventDefault();

        if (searchNav.val() != "") {

            $.ajax({
                url: "search.php?search=" + searchNav.val(),
                type: "GET",
                success: function (html) {
                    $(location).attr('href', 'search.php?search=' + searchNav.val());
                },
                error: function (resultat, statut, erreur) {
                    console.log(resultat, statut, erreur);
                }
            });
        } else {
            console.log("mensonge");
        }

    });


});