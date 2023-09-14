<?php
    require_once('../database/database.php');

    // Vérifier si les paramètres requis sont fournis
    if (isset($_GET['id'], $_GET['tel'], $_GET['email'])) {
        try {
            // Préparer la requête pour supprimer les annonces
            $deleteAgentsAnnonces = $database->prepare('DELETE FROM annonces WHERE tel=:tel AND email=:email');
            $deleteAgentsAnnonces->bindvalue(':tel', $_GET['tel']);
            $deleteAgentsAnnonces->bindvalue(':email', $_GET['email']);
            $deleteAgentsAnnonces->execute();

            // Préparer la requête pour supprimer les démarcheurs
            $deleteAgents = $database->prepare('DELETE FROM demarcheurs WHERE id=:id AND telephone=:tel AND email=:email');
            $deleteAgents->bindvalue(':id', $_GET['id']);
            $deleteAgents->bindvalue(':tel', $_GET['tel']);
            $deleteAgents->bindvalue(':email', $_GET['email']);
            $deleteAgents->execute();

            // Redirection avec un message de succès
            header('Location: demarcheurs.php?success=1');
            exit();
        } catch (PDOException $e) {
            // Gérer les erreurs de la base de données avec un message d'erreur
            header('Location: demarcheurs.php?error=1');
            exit();
        }
    } else {
        // Redirection avec un message d'erreur pour les paramètres manquants
        header('Location: demarcheurs.php?error=2');
        exit();
    }
?>
