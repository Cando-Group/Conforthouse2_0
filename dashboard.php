<?php
require("includes/header_connect.php");

?>



<main class="main">

<div class="site-breadcrumb" style="background: url(assets/img/breadcrumb/01.jpg)">
<div class="container">
<h2 class="breadcrumb-title">Dashboard</h2>
<ul class="breadcrumb-menu">
<li><a href="index.php">Accueil</a></li>
<li class="active">Dashboard</li>
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

<!--  -->

<div class="user-profile py-120">
<div class="container">
<div class="row">
<div class="col-lg-3">
<div class="user-profile-sidebar">
<div class="user-profile-sidebar-top">
<div class="user-profile-img">
<img src="upload/profile/<?=$dataUser['photo']?>" alt="Photo de profil" style="width: 100px;height:100px;">

</div>
<h4><?=$dataUser['nom'] . " ". $dataUser['prenoms']?></h4>
<p><a href="mailto:<?=$_SESSION['email']?>" class="__cf_email__" data-cfemail="e98386879a8687a98c91888499858cc78a8684"><?=$_SESSION['email']?></a></p>
</div>
<ul class="user-profile-sidebar-list">
<li><a class="active" href="dashboard.php"><i class="far fa-gauge-high"></i> Tableau de bord</a></li>
<li><a href="profile.php"><i class="far fa-user"></i> Mon profile</a></li>
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
<?php

    $reqTotalAnnonces = $database->prepare("SELECT * FROM annonces WHERE email=:email");
    $reqTotalAnnonces->bindvalue(":email", $_SESSION['email']);
    $reqTotalAnnonces->execute();

    $countTotalAnnonces = $reqTotalAnnonces->rowCount();

    $reqLouerAnnonces = $database->prepare("SELECT * FROM annonces WHERE email=:email AND louer=:louer");
    $reqLouerAnnonces->bindvalue(":email", $_SESSION['email']);
    $reqLouerAnnonces->bindvalue(":louer", "oui");
    $reqLouerAnnonces->execute();

    $countLouerAnnonces = $reqLouerAnnonces->rowCount();

    $reqPriceAnnonces = $database->prepare("SELECT SUM(prix) AS somme_prix FROM annonces WHERE email=:email AND louer=:louer");
    $reqPriceAnnonces->bindvalue(":email", $_SESSION['email']);
    $reqPriceAnnonces->bindvalue(":louer", "oui");
    $reqPriceAnnonces->execute();

    $dataPrice = $reqPriceAnnonces->fetch();

    $SommePrix = $dataPrice['somme_prix'];

?>
<div class="col-lg-9">
<div class="user-profile-wrapper">
<div class="row">
<div class="col-md-6 col-lg-4">
<div class="dashboard-widget dashboard-widget-color-1">
<div class="dashboard-widget-info">
<h1><?=$countTotalAnnonces?></h1>
<span>Total Publication</span>
</div>
<div class="dashboard-widget-icon">
<i class="fal fa-home"></i>
</div>
</div>
</div>
<div class="col-md-6 col-lg-4">
<div class="dashboard-widget dashboard-widget-color-2">
<div class="dashboard-widget-info">
<h1><?=$countLouerAnnonces?></h1>
<span>Chambre Louer</span>
</div>
<div class="dashboard-widget-icon">
<i class="fal fa-box-check"></i>
</div>
</div>
</div>
<div class="col-md-6 col-lg-4">
<div class="dashboard-widget dashboard-widget-color-3">
<div class="dashboard-widget-info">
<h1>
    <?php
        if ($countLouerAnnonces > 0){
            ?>
            <?=$SommePrix?> FCFA
            <?php
        }else{
            ?>
            0 FCFA
            <?php
        }
    ?>
</h1>
<span>Prix Chambres louer</span>
</div>
<div class="dashboard-widget-icon">
<i class="fal fa-sack-dollar"></i>
</div>
</div>
</div>
</div>

<?php

    $reqRecemmentPublié = $database->prepare("SELECT * FROM annonces WHERE email=:email ORDER BY id DESC");
    $reqRecemmentPublié->bindvalue(":email", $_SESSION['email']);
    $reqRecemmentPublié->execute();



?>

<div class="col-lg-12">
    <div class="user-profile-card">
        <h4 class="user-profile-card-title">Récemment publié</h4>
        
            <div class="table-responsive">
            <table class="table table-hover text-nowrap">
            <thead>
            <tr>
                <th>Chambre</th>
                <th>Catégorie</th>
                <th>Date</th>
                <th>Status</th>
                <th>Prix</th>
                </tr>
                </thead>
                <tbody>
                    <?php

                        while($dataRecemmentPublie = $reqRecemmentPublié->fetch()){
                            ?>
                            <tr>
                                <td>
                                <div class="table-property-info">
                                    <a href="#">
                                    <img src="upload/location/<?=$dataRecemmentPublie['photo']?>" alt="Photo annonce" style="width:70px;height:46px;">
                                    <h6><?=$dataRecemmentPublie['localisation']?></h6>
                                    </a>
                                </div>
                                </td>
                                    <td><b><?=$dataRecemmentPublie['categorie']?></b></td>
                                    <td><?=$dataRecemmentPublie['dates']?></td>
                                    <?php
                                        if ($dataRecemmentPublie['louer'] == "non"){
                                            ?>
                                            <td><span class="bg-success" style="color:white;padding:3px;border-radius:20px;">Active</span></td>
                                            <?php
                                        }else{
                                            ?>
                                            <td><span class="bg-danger" style="color:white;padding:3px;border-radius:20px;">Désactiver</span></td>
                                            <?php
                                        }
                                    ?>
                                    
                                    <td><?=$dataRecemmentPublie['prix']?> FCFA</td>
                            </tr>
                            <?php
                        }

                    ?>
                    
                </tbody>
            </table>
            </div>
            </div>
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