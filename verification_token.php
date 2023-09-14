<?php

    if ((isset($_GET['email']) && isset($_GET['token']) && isset($_GET["t"])) && (!empty($_GET["email"]) && !empty($_GET['token']) && !empty($_GET["t"]))){

        $type = $_GET["t"];
        $email = $_GET['email'];
        $token = $_GET['token'];

        require_once('database/database.php');

        // Exemple : localhost/Home/verification_token.php?email=$email&token=$token=ai

        if ($type == "ai"){
            // REQUETE POUR AGENT IMMOBILIER

            $reqValidation = $database->prepare("SELECT * FROM demarcheurs WHERE email=:email AND token=:token");
            $reqValidation->bindvalue(":email", $email);
            $reqValidation->bindvalue(":token", $token);
            $reqValidation->execute();

            $countReqValidation = $reqValidation->rowCount();

            if ($countReqValidation == 1){

                // Update du token

                $updateToken = $database->prepare("UPDATE demarcheurs SET token=:token AND validation=:validation WHERE email=:email");
                $updateToken->bindvalue(":token", "Valider");
                $updateToken->bindvalue(":validation", 1);
                $updateToken->bindvalue(":email", $email);
                $updateToken->execute();

                // session_start();

                // $_SESSION['email'] = $email;

                header("Location:login.php");

            }

        }
        // elseif ($type == "u"){

        //     $reqValidation = $database->prepare("SELECT * FROM collocusers WHERE email=:email AND token=:token");
        //     $reqValidation->bindvalue(":email", $email);
        //     $reqValidation->bindvalue(":token", $token);
        //     $reqValidation->execute();

        //     $countReqValidation = $reqValidation->rowCount();

        //     if ($countReqValidation == 1){

        //         // Update du token

        //         $updateToken = $database->prepare("UPDATE collocusers SET token=:token WHERE email=:email");
        //         $updateToken->bindvalue(":token", "Valider");
        //         $updateToken->bindvalue(":email", $email);
        //         $updateToken->execute();

        //         session_start();

        //         $_SESSION['email'] = $email;

        //         header("Location:connexion.php?t=u");

        //     }

        // }
        else{
            header('Location:404.php');
        }

    }