<?php
try {
    $database = new PDO('mysql:host=localhost;dbname=conforthouse;charset=utf8', 'root', '');
    $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>
