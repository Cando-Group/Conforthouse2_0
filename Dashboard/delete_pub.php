<?php

    require_once('../database/database.php');

    $deletePub = $database->prepare('DELETE FROM annonces WHERE id=:id');
    $deletePub->bindvalue(':id', $_GET['id']);
    $deletePub->execute();

    header('Location:index.php');
