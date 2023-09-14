<?php

    require("includes/header_connect.php");

    $reqAnnonces = $database->prepare("SELECT * FROM annonces WHERE email=:email");
    $reqAnnonces->bindvalue(":email", $_SESSION["email"]);
    $reqAnnonces->execute();

    $countTotalAnnonces = $reqAnnonces->rowCount();

    // Location active
    $reqAnnoncesActive = $database->prepare("SELECT * FROM annonces WHERE email=:email AND louer=:louer");
    $reqAnnoncesActive->bindvalue(":email", $_SESSION["email"]);
    $reqAnnoncesActive->bindvalue(":louer", "non");
    $reqAnnoncesActive->execute();

    $countTotalAnnoncesActive = $reqAnnoncesActive->rowCount();

    // Location Louer
    $reqAnnoncesLouer = $database->prepare("SELECT * FROM annonces WHERE email=:email AND louer=:louer");
    $reqAnnoncesLouer->bindvalue(":email", $_SESSION["email"]);
    $reqAnnoncesLouer->bindvalue(":louer", "oui");
    $reqAnnoncesLouer->execute();

    $countTotalAnnoncesLouer = $reqAnnoncesLouer->rowCount();

?>

<main class="main">

<div class="site-breadcrumb" style="background: url(assets/img/breadcrumb/01.jpg)">
<div class="container">
<h2 class="breadcrumb-title">Profile</h2>
<ul class="breadcrumb-menu">
<li><a href="index.php">Accueil</a></li>
<li class="active">Profile</li>
</ul>
</div>
</div>

<?php
    if (empty($dataUser['whatsapp'])){
        ?>
        <div class="card">
        <div class="card-body">
            
            <div class="alert alert-info solid alert-right-icon alert-dismissible fade show">
                <span><i class="fa-solid fa-bell" style="color: #c64a15;"></i></span>
                <button type="button" class="close h-100 text-center" data-bs-dismiss="alert" aria-label="Close"><i class="fa-duotone fa-circle-xmark" style="--fa-primary-color: #a42219; --fa-secondary-color: #a42219;"></i>
                </button> 
                <p class="text-center">
                Veuillez ajouter votre numéro Whatsapp pour que les utilisateurs vous contact. Allez dans Paramètre. 
                </p>
            </div>
            </div>
        </div>
        <?php
    }
?>

<div class="user-profile py-120">
<div class="container">
<div class="row">
<div class="col-lg-3">
<div class="user-profile-sidebar">
<div class="user-profile-sidebar-top">
<div class="user-profile-img">
<img src="upload/profile/<?=$dataUser['photo']?>" alt="Photo de profil" style="width: 100px;height:100px;">

</div>
<h4><?=$dataUser['nom']?> <?=$dataUser['prenoms']?></h4>
<p><a href="mailto:candidesodokinpro@gmail.com" class="__cf_email__" ><?=$_SESSION['email']?></a></p>
</div>
<ul class="user-profile-sidebar-list">
<ul class="user-profile-sidebar-list">
<li><a href="dashboard.php"><i class="far fa-gauge-high"></i> Tableau de bord</a></li>
<li><a class="active" href="profile.php"><i class="far fa-user"></i> Mon profile</a></li>
<li><a href="profile-property.php"><i class="far fa-home"></i> Mes annonces</a></li>
<li><a href="add-property.php"><i class="far fa-plus-circle"></i> Publier une annonce</a></li>
<!-- <li><a href="profile-favorite.php"><i class="far fa-heart"></i> My Favorite</a></li>
<li><a href="profile-message.php"><i class="far fa-envelope"></i> Messages <span class="badge bg-danger">02</span></a></li> 
<li><a href="profile-save-search.php"><i class="far fa-bookmark"></i> Save Search</a></li>-->
<li><a href="profile-setting.php"><i class="far fa-cog"></i> Paramètre de profile</a></li>
<li><a href="logout.php"><i class="far fa-sign-out"></i> Déconnexion</a></li>
</ul>
</div>
</div>
<div class="col-lg-9" >
<div class="user-profile-wrapper">
<div class="user-profile-card user-profile-property">
<div class="user-profile-card-header">
<h4 class="user-profile-card-title">Profile</h4>
<div class="user-profile-card-header-right">

<a href="add-property.php" class="theme-btn"><span class="far fa-plus-circle"></span>Ajouter une annonce</a>
</div>
</div>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-lg-6" >
            <div class="profile-info-list">
            <ul>
            <li>Nom complet : <span><?=$dataUser['nom']?> <?=$dataUser['prenoms']?></span></li>
            <li>Email: <span><a href="mailto:<?=$dataUser['email']?>" class="__cf_email__"><?=$dataUser['email']?></a></span></li>
            <li>Téléphone: <span><?=$dataUser['telephone']?></span></li>
            <li>Whatsapp: <span><?=$dataUser['whatsapp']?></span></li>

            <li>Total de location : <span><?=$countTotalAnnonces?></span></li>
            <li>Location actif : <span><?=$countTotalAnnoncesActive?></span></li>
            <li>Location loués : <span><?=$countTotalAnnoncesLouer?></span></li>
            <li>Création du compte : <span><?=$dataUser['save_date']?></span></li>
            <li>Description: <span><?=$dataUser['description']?></span></li>
            </ul>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>
</div>
</div>
</div>
</div>
</div>

</main>

<?php
    require("includes/footer.php")
?>