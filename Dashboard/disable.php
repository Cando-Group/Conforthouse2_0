<?php

    require_once('../database/database.php');

    //Désactivation de la visibilité de l'annonce
    $disableAnnoncesDemarcheur = $database->prepare('UPDATE annonces SET statut=:statut WHERE email=:email AND tel=:tel');
    $disableAnnoncesDemarcheur->bindvalue(':statut', 0);
    $disableAnnoncesDemarcheur->bindvalue(':email', $_GET['email']);
    $disableAnnoncesDemarcheur->bindvalue(':tel', $_GET['tel']);
    $disableAnnoncesDemarcheur->execute();

    // Désactivation du compte du démarcheur
    $disableDemarcheur = $database->prepare('UPDATE demarcheurs SET validation=:validation WHERE id=:id');
    $disableDemarcheur->bindvalue(':id', $_GET['id']);
    $disableDemarcheur->bindvalue(':validation', '0');
    $disableDemarcheur->execute();

    header('Location:index.php');