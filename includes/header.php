<?php

session_start();

    require("database/database.php");

    $current_page = basename($_SERVER['PHP_SELF']);

    // Souscription de la newsletter
    if (isset($_POST['newsletter'])){

        if (!empty($_POST['newsletter_email'])){

            $reqNewsletterEmail = $database->prepare("SELECT * FROM newsletter WHERE email=:email AND statut=:statut");
            $reqNewsletterEmail->bindvalue(":email", $_POST['newsletter_email']);
            $reqNewsletterEmail->bindvalue(":statut", 1);
            $reqNewsletterEmail->execute();

            $countNewsletterEmail = $reqNewsletterEmail->rowCount();

            if ($countNewsletterEmail){
                $error = "Vous êtes déjà enregistrer à la newsletter";
            }else{
                $insertNewsletterEmail = $database->prepare("INSERT INTO newsletter(email) VALUES (:email)");
                $insertNewsletterEmail->bindvalue(":email", $_POST['newsletter_email']);
                $insertNewsletterEmail->execute();

                $success = "Abonnement à la newsletter réussi";
            }

            
        }else{
            $error = "Veuillez remplir le champs";
        }

    }

?>

<!DOCTYPE html>
<html lang="fr">

<head>

<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Trouvez votre location idéale avec ConfortHouse. Parcourez une large sélection d'appartements, de chambres, de boutiques et plus encore dans les meilleures localisations. Nous vous aidons à trouver la maison parfaite pour répondre à vos besoins, que vous recherchiez un logement en solo ou avec des colocataires. Découvrez nos sélections de location dès aujourd'hui.">
<meta name="keywords" content="">

<title>Conforthouse - <?php
    if ($current_page == "index.php"){
        echo "Accueil";
    }elseif($current_page == "about.php"){
        echo "A propos";
    }elseif($current_page == "add-property.php"){
        echo "Ajouter une annonce";
    }elseif($current_page == "agent-single.php"){
        echo "Agent immobilier";
    }elseif($current_page == "appartements.php"){
        echo "Appartements";
    }elseif($current_page == "autres.php"){
        echo "Autres";
    }elseif ($current_page == "boutique.php"){
        echo "Boutiques";
    }elseif ($current_page == "conference.php"){
        echo "Bureaux";
    }elseif ($current_page == "contact.php"){
        echo "Contact";
    }elseif ($current_page == "dashboard"){
        echo "Tableau de bord";
    }elseif($current_page == "etudiantes.php"){
        echo "Chambres étudiantes / personnelles";
    }elseif($current_page == "familiales.php"){
        echo "Chambres familiales";
    }elseif ($current_page == "faq.php"){
        echo "FAQ";
    }elseif ($current_page == "forgot-password.php"){
        echo "Mot de passe oublié ?";
    }elseif ($current_page == "login.php"){
        echo "Connexion";
    }elseif ($current_page == "privacy.php"){
        echo "Politique de confidentialité";
    }elseif($current_page == "profile-property.php"){
        echo "Mes annonces";
    }elseif ($current_page == "profile-settings.php"){
        echo "Paramètre";
    }elseif ($current_page == "profile.php"){
        echo "Mon profile";
    }elseif($current_page == "property-single.php"){
        echo "Détail de location";
    }elseif ($current_page == "register.php"){
        echo "Inscription.php";
    }elseif ($current_page == "terms.php"){
        echo "Conditions générales d'utilisations";
    }elseif ($current_page == "listing-search.php"){
        echo "Recherche";
    }elseif ($current_page == "mention-legale.php"){
        echo "Mentions légales";
    }

?>
</title>

<link rel="icon" type="image/x-icon" href="assets/img/logo/favicon.png">

<link rel="stylesheet" href="assets/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/css/all-fontawesome.min.css">
<link rel="stylesheet" href="assets/css/flaticon.css">
<link rel="stylesheet" href="assets/css/animate.min.css">
<link rel="stylesheet" href="assets/css/magnific-popup.min.css">
<link rel="stylesheet" href="assets/css/owl.carousel.min.css">
<link rel="stylesheet" href="assets/css/nice-select.min.css">
<link rel="stylesheet" href="assets/css/jquery-ui.min.css">
<link rel="stylesheet" href="assets/css/style.css">

<!-- Inclure SweetAlert via un lien CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- Google Analytics Conforthouse -->
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-WWWL4R4JLB"></script>
<!-- <script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-WWWL4R4JLB');
</script> -->

</head>
<body class="home-3">


<?php

    if (isset($success)){
        ?>
        <script>
            swal("Réussi", "<?=$success?>", "success");
        </script>
        <?php
    }elseif (isset($error)){
        ?>
        <script>
            swal("Oups", "<?=$error?>", "error");
        </script>
        <?php
    }

?>

<!--<div class="preloader">
<div class="loader">
<div class="loader-shadow"></div>
<div class="loader-box"></div>
</div>
</div>-->


<header class="header">


<div class="main-navigation">

<nav class="navbar d-md-none barnav" style="height:50px!important;">
    <!-- Bouton de recherche à gauche -->
    <a href="search/index.php"><i class="fa-solid fa-magnifying-glass" style="color: #ab1240;margin-left:15px;"></i></a>
    <!-- Bouton "plus" au milieu -->
    <a href="add-property.php" style="color: #ab1240;font-size:25px;" >+</a>
    <!-- Bouton de profil à droite -->
    <a href="login.php"><i class="fa-regular fa-user" style="color: #ab1240;margin-right:15px;"></i></a>
</nav>

<nav class="navbar navbar-expand-lg">
<div class="container">
<a class="navbar-brand" href="index.php">
<!-- <img src="assets/img/logo/logo.png" alt="logo"> -->ConfortHouse
</a>
<div class="mobile-menu-right">
<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main_nav" aria-expanded="false" aria-label="Toggle navigation">
<span class="navbar-toggler-btn-icon"><i class="far fa-bars"></i></span>
</button>
</div>
<div class="collapse navbar-collapse" id="main_nav">
<ul class="navbar-nav">
<li class="nav-item dropdown">
<a class="nav-link active" href="index.php">Accueil</a>

</li>
<li class="nav-item"><a class="nav-link" href="about.php">A propos</a></li>
<li class="nav-item dropdown">
<a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Catégories</a>
<ul class="dropdown-menu fade-down">
<li class="">
<a class="dropdown-item " href="familiales.php">Chambres familiales</a>

</li>
<li class="">
    <a class="dropdown-item" href="etudiantes.php">Chambres étudiantes / <br> personnelles</a>
    
</li>
<li class="">
    <a class="dropdown-item" href="appartements.php">Appartements</a>
    
</li>
<li class="">
    <a class="dropdown-item" href="boutique.php">Boutiques</a>
    
</li>
<li class="">
    <a class="dropdown-item" href="conference.php">Bureaux</a>
    
</li>
<li class="">
    <a class="dropdown-item" href="autres.php">Autres</a>
    
</li>
</ul>
</li>
<li class="nav-item">
<a class="nav-link" href="colocation/coloc.php">Colocation</a>

</li>
<li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
<li class="nav-item"><a href="search/index.php" class="nav-link" id="searchButton"><img src="assets/img/search.png" alt="Search" width="30"></a></li>
</ul>
<div class="header-nav-right">
<div class="header-btn">
<a href="add-property.php" class="theme-btn mt-2"><span class="far fa-plus-circle"></span>Publier une annonce</a>


</div>
</div>
</div>
</div>
</nav>
</div>
</header>