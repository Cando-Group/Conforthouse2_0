<?php

    require_once('../database/database.php');

    //Activation de la visibilité de l'annonce
    $activeAnnoncesDemarcheur = $database->prepare('UPDATE annonces SET statut=:statut WHERE email=:email AND tel=:tel');
    $activeAnnoncesDemarcheur->bindvalue(':statut', 1);
    $activeAnnoncesDemarcheur->bindvalue(':email', $_GET['email']);
    $activeAnnoncesDemarcheur->bindvalue(':tel', $_GET['tel']);
    $activeAnnoncesDemarcheur->execute();

    //Activation du compte du démarcheur
    $activeDemarcheur = $database->prepare('UPDATE demarcheurs SET validation=:validation, token=:token WHERE id=:id');
    $activeDemarcheur->bindvalue(':id', $_GET['id']);
    $activeDemarcheur->bindvalue(':validation', '1');
    $activeDemarcheur->bindvalue(':token', 'Valider');
    $activeDemarcheur->execute();

    header('Location:index.php');
