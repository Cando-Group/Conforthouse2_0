<?php

    require("database/database.php");

    $email = $_GET['email'];

    $deleteAccount = $database->prepare("");