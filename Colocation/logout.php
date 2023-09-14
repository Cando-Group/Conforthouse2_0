<?php

session_start();

    require_once("database/database.php");

    if (isset($_SESSION['coloc'])){

        session_unset();
        session_destroy();
        header("Location:login.php");

    }