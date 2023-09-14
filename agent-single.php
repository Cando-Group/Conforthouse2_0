<?php

    require("includes/header.php");

    $reqAgent = $database->prepare("SELECT * FROM demarcheurs WHERE email=:email");
    $reqAgent->bindvalue(":email", $_GET['agent']);
    $reqAgent->execute();

    $dataUserAgent = $reqAgent->fetch();

    $Agent = $_GET['agent'];

    $reqAnnoncesAgent = $database->prepare("SELECT * FROM annonces WHERE email=:email AND louer=:louer");
    $reqAnnoncesAgent->bindvalue(":email", $_GET['agent']);
    $reqAnnoncesAgent->bindvalue(":louer", "non");
    $reqAnnoncesAgent->execute();

    $countAnnoncesAgent = $reqAnnoncesAgent->rowCount();

    // Count dun nombre d'annonce par catégorie

    // ----- Chambres Familiale

    $reqFamiliale = $database->prepare("SELECT * FROM annonces WHERE categorie=:categorie AND statut=:statut  AND louer = :louer AND email=:email");
    $reqFamiliale->bindvalue(":categorie", "Chambres Familiale");
    $reqFamiliale->bindvalue(":louer", "non");
    $reqFamiliale->bindvalue(":email", $_GET['agent']);
    $reqFamiliale->bindvalue(":statut", 1);
    $reqFamiliale->execute();

    $countFamiliale = $reqFamiliale->rowcount();

    // ----- Chambres étudiantes

    $reqEtudiantes = $database->prepare("SELECT * FROM annonces WHERE categorie=:categorie AND statut=:statut AND louer=:louer AND email=:email");
    $reqEtudiantes->bindvalue(":categorie", "Chambres étudiants");
    $reqEtudiantes->bindvalue(":statut", 1);
    $reqEtudiantes->bindvalue(":louer", "non");
    $reqEtudiantes->bindvalue(":email", $_GET['agent']);
    $reqEtudiantes->execute();

    $countEtudiantes = $reqEtudiantes->rowcount();

    // ----- Boutique

    $reqBoutique = $database->prepare("SELECT * FROM annonces WHERE categorie=:categorie AND louer=:louer AND statut=:statut AND email=:email");
    $reqBoutique->bindvalue(":louer", "non");
    $reqBoutique->bindvalue(":categorie", "Boutique");
    $reqBoutique->bindvalue(":statut", 1);
    $reqBoutique->bindvalue(":email", $_GET['agent']);
    $reqBoutique->execute();

    $countBoutique = $reqBoutique->rowcount();

    // ----- Appartement

    $reqAppartement = $database->prepare("SELECT * FROM annonces WHERE categorie=:categorie AND statut=:statut AND louer=:louer AND email=:email");
    $reqAppartement->bindvalue(":categorie", "Appartement");
    $reqAppartement->bindvalue(":louer", "non");
    $reqAppartement->bindvalue(":statut", 1);
    $reqAppartement->bindvalue(":email", $_GET['agent']);
    $reqAppartement->execute();

    $countAppartement = $reqAppartement->rowcount();

    // ----- Bureau

    $reqConference = $database->prepare("SELECT * FROM annonces WHERE categorie=:categorie AND statut=:statut AND louer=:louer AND email=:email");
    $reqConference->bindvalue(":categorie", "Bureau");
    $reqConference->bindvalue(":louer", "non");
    $reqConference->bindvalue(":statut", 1);
    $reqConference->bindvalue(":email", $_GET['agent']);
    $reqConference->execute();

    $countConference = $reqConference->rowcount();

    // ----- Autres

    $reqAutres = $database->prepare("SELECT * FROM annonces WHERE categorie=:categorie AND statut=:statut AND louer=:louer AND email=:email");
    $reqAutres->bindvalue(":louer", "non");
    $reqAutres->bindvalue(":categorie", "Autres");
    $reqAutres->bindvalue(":statut", 1);
    $reqAutres->bindvalue(":email", $_GET['agent']);
    $reqAutres->execute();

    $countAutres = $reqAutres->rowcount();

?>

<main class="main">

<div class="site-breadcrumb" style="background: url(assets/img/breadcrumb/01.jpg)">
<div class="container">
<h2 class="breadcrumb-title">Agent Immobilier</h2>
<ul class="breadcrumb-menu">
<li><a href="index.php">Accueil</a></li>
<li class="active"><?=$dataUserAgent['nom']. " ". $dataUserAgent['prenoms']?></li>
</ul>
</div>
</div>

<div class="team-single agency-list py-120">
<div class="container">
<div class="agency-wrapper">
<div class="row">
<div class="col-md-12">
<div class="row">
<div class="col-md-12">
<div class="agency-item">
<div class="agency-img">
<img src="upload/profile/<?=$dataUserAgent['photo']?>" alt>
</div>
<div class="agency-content">
<div class="agency-name">
<h4><?=$dataUserAgent['nom']. " ". $dataUserAgent['prenoms']?> (Agent)</h4>
<span><?=$countAnnoncesAgent?> Annonces</span>
</div>
<div class="agency-rating">
<i class="fas fa-star"></i>
<i class="fas fa-star"></i>
<i class="fas fa-star"></i>
<i class="fas fa-star"></i>
<i class="fas fa-star"></i>
<!-- <span>5.0 (50 reviews)</span> -->
</div>
<div class="agency-info">
<ul>
<li><a href="#"><i class="far fa-location-dot"></i><?=$dataUserAgent['pays']?></a></li>
<li><a href="tel:<?=$dataUserAgent['telephone']?>"><i class="far fa-phone"></i><?=$dataUserAgent['telephone']?></a></li>
<li><a href="mail:<?=$dataUserAgent['email']?>"><i class="far fa-envelope"></i><span class="__cf_email__" ><?=$dataUserAgent['email']?></span></a></li>
</ul>
</div>
<div class="agency-bottom">
<!-- <div class="agency-social">
<a href="#"><i class="fab fa-facebook-f"></i></a>
<a href="#"><i class="fab fa-twitter"></i></a>
<a href="#"><i class="fab fa-linkedin-in"></i></a>
<a href="#"><i class="fab fa-whatsapp"></i></a>
</div> -->
</div>
</div>
</div>
</div>

<!-- Categorie voir -->


<div class="category-area py-120">
    <div class="container">
    <div class="row">
    <div class="col-lg-6 mx-auto wow fadeInDown" data-wow-duration="1s" data-wow-delay=".25s">
    <div class="site-heading text-center">
    <span class="site-title-tagline">Catégories</span>
    <h2 class="site-title">Choisissez votre catégorie</h2>
    </div>
    </div>
    </div>
    <div class="row">
    <div class="col-6 col-md-4 col-lg-2">
    <div class="category-item wow fadeInUp" data-wow-duration="1s" data-wow-delay=".25s">
    <a href="agentFamiliales.php?email=<?=$Agent?>">
    <div class="category-icon">
    <i class="flaticon-apartment"></i>
    </div>
    <div class="category-content">
    <h4 class="category-title">Chambres familiales</h4>
    <span class="category-property"><?=$countFamiliale?></span>
    </div>
    </a>
    </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
    <div class="category-item wow fadeInUp" data-wow-duration="1s" data-wow-delay=".50s">
    <a href="agentEtudiants.php?email=<?=$Agent?>">
    <div class="category-icon">
    <i class="flaticon-business-and-trade"></i>
    </div>
    <div class="category-content">
    <h4 class="category-title">Chambres étudiants / personnelles</h4>
    <span class="category-property"><?=$countEtudiantes?></span>
    </div>
    </a>
    </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
    <div class="category-item wow fadeInUp" data-wow-duration="1s" data-wow-delay=".75s">
    <a href="agentBoutique.php?email=<?=$Agent?>">
    <div class="category-icon">
    <i class="flaticon-home"></i>
    </div>
    <div class="category-content">
    <h4 class="category-title">Boutiques</h4>
    <span class="category-property"><?=$countBoutique?></span>
    </div>
    </a>
    </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
    <div class="category-item wow fadeInUp" data-wow-duration="1s" data-wow-delay="1s">
    <a href="agentAppartements.php?email=<?=$Agent?>">
    <div class="category-icon">
    <i class="flaticon-villa"></i>
    </div>
    <div class="category-content">
    <h4 class="category-title">Appartements</h4>
    <span class="category-property"><?=$countAppartement?></span>
    </div>
    </a>
    </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
    <div class="category-item wow fadeInUp" data-wow-duration="1s" data-wow-delay="1.25s">
    <a href="agentBureaux.php?email=<?=$Agent?>">
    <div class="category-icon">
    <i class="flaticon-living-room"></i>
    </div>
    <div class="category-content">
    <h4 class="category-title">Bureaux</h4>
    <span class="category-property"><?=$countConference?></span>
    </div>
    </a>
    </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
    <div class="category-item wow fadeInUp" data-wow-duration="1s" data-wow-delay="1.50s">
    <a href="agentAutres.php?email=<?=$Agent?>">
    <div class="category-icon">
    <i class="flaticon-houses"></i>
    </div>
    <div class="category-content">
    <h4 class="category-title">Autres</h4>
    <span class="category-property"><?=$countAutres?></span>
    </div>
    </a>
    </div>
    </div>
    </div>
    </div>
</div>


</main>

<?php
    require("includes/footer.php");
?>