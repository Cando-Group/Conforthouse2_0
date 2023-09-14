<?php

    require("includes/header_connect.php");

    $reqAnnonces = $database->prepare("SELECT * FROM annonces WHERE email=:email");
    $reqAnnonces->bindvalue(":email", $_SESSION["coloc"]);
    $reqAnnonces->execute();

    $countTotalAnnonces = $reqAnnonces->rowCount();

    // Location active
    $reqAnnoncesActive = $database->prepare("SELECT * FROM annonces WHERE email=:email AND louer=:louer");
    $reqAnnoncesActive->bindvalue(":email", $_SESSION["coloc"]);
    $reqAnnoncesActive->bindvalue(":louer", "non");
    $reqAnnoncesActive->execute();

    $countTotalAnnoncesActive = $reqAnnoncesActive->rowCount();

    // Location Louer
    $reqAnnoncesLouer = $database->prepare("SELECT * FROM annonces WHERE email=:email AND louer=:louer");
    $reqAnnoncesLouer->bindvalue(":email", $_SESSION["coloc"]);
    $reqAnnoncesLouer->bindvalue(":louer", "oui");
    $reqAnnoncesLouer->execute();

    $countTotalAnnoncesLouer = $reqAnnoncesLouer->rowCount();

?>

<main class="main">

<div class="site-breadcrumb" style="background: url(../assets/img/breadcrumb/01.jpg)">
<div class="container">
<h2 class="breadcrumb-title">Profile</h2>
<ul class="breadcrumb-menu">
<li><a href="index.php">Accueil</a></li>
<li class="active">Profile</li>
</ul>
</div>
</div>

<div class="user-profile py-120">
<div class="container">
<div class="row">
<div class="col-lg-3">
<div class="user-profile-sidebar">
<div class="user-profile-sidebar-top">
<div class="user-profile-img">
<img src="../assets/img/account/user-1.jpg" alt="Photo de profil" style="width: 100px;height:100px;">

</div>
<h4><?=$dataUser['username']?></h4>
<p><a href="mailto:<?=$dataUser['email']?>" class="__cf_email__" ><?=$dataUser['email']?></a></p>
</div>
<ul class="user-profile-sidebar-list">
<ul class="user-profile-sidebar-list">
<li><a class="active" href="profile.php"><i class="far fa-user"></i> Mon profile</a></li>
<li><a href="add-property.php"><i class="far fa-plus-circle"></i> Publier une colocation</a></li>
<!-- <li><a href="profile-favorite.php"><i class="far fa-heart"></i> My Favorite</a></li>
<li><a href="profile-message.php"><i class="far fa-envelope"></i> Messages <span class="badge bg-danger">02</span></a></li> 
<li><a href="profile-save-search.php"><i class="far fa-bookmark"></i> Save Search</a></li>-->
<!-- <li><a href="profile-setting.php"><i class="far fa-cog"></i> Paramètre de profile</a></li> -->
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

<a href="add-property.php" class="theme-btn"><span class="far fa-plus-circle"></span>Ajouter une colocation</a>
</div>
</div>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-lg-6" >
            <div class="profile-info-list">
            <ul>
            <li>Username : <span><?=$dataUser['username']?></span></li>
            <li>Email: <span><a href="mailto:<?=$dataUser['email']?>" class="__cf_email__"><?=$dataUser['email']?></a></span></li>
            <li>Whatsapp: <span><?=$dataUser['whatsapp']?></span></li>

            <li>Création du compte : <span><?=$dataUser['save_date']?></span></li>
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
    require("includes/footer.php");
?>