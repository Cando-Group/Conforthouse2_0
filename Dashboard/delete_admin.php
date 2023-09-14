<?php

    require_once('../database/database.php');

    $deletePub = $database->prepare('DELETE FROM admin WHERE username=:username');
    $deletePub->bindvalue(':username', $_GET['username']);
    $deletePub->execute();

    echo "<script type=\"text/javascript\">alert('Administrateur supprimé avec succès');document.location.href='profile-posts.php';</script>";
