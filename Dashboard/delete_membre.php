<?php

    require_once('../database/database.php');

    $deletePub = $database->prepare('DELETE FROM team WHERE id=:id');
    $deletePub->bindvalue(':id', $_GET['id']);
    $deletePub->execute();

    echo "<script type=\"text/javascript\">alert('Membre supprimé avec succès');document.location.href='profile-posts.php';</script>";
