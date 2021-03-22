<?php

//FICHIER QUI INSTANCIE LES CLASS EN POO
require_once('../config.php');

if(!empty($_POST['search'])){

    // STOCKAGE DE LA RECHERCHE DANS UNE VARIABLE
    $recherche = isset($_POST['search']) ? $_POST['search'] : '';

    // APPEL DE LA FONCTION QUI RECHERCHE LES CORRESPONDANCES DANS LA CLASS SEARCH
    $data = $product->autocompletion($recherche);

    //AFFICHAGE DU RESULTAT DE LA REQUETE
    echo $data;

}
else{

    echo 'remplir le champs';

}

?>

