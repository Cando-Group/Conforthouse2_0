<?php

    require("includes/header_connect.php");

    $reqMesAnnonces = $database->prepare("SELECT * FROM annonces WHERE email=:email AND louer=:louer ORDER BY id DESC");
    $reqMesAnnonces->bindvalue(":email", $_SESSION['email']);
    $reqMesAnnonces->bindvalue(":louer", "non");
    $reqMesAnnonces->execute();

    if (isset($_POST['suppr'])){

        $insertLouer = $database->prepare("INSERT INTO annonces_louer SELECT * FROM annonces WHERE id=:id");
        $insertLouer->bindvalue(":id", $_POST['id_annonces']);
        $insertLouer->execute();

        $deleteAnnonces = $database->prepare("DELETE FROM annonces WHERE id =:id");
        $deleteAnnonces->bindvalue(":id", $_POST['id_annonces']);
        $deleteAnnonces->execute();

        if ($insertLouer && $deleteAnnonces){
            $successLouer = "Annonce supprimer avec succès";
        }

    }

    

?>

<main class="main">

<div class="site-breadcrumb" style="background: url(assets/img/breadcrumb/01.jpg)">
<div class="container">
<h2 class="breadcrumb-title">Mes annonces</h2>
<ul class="breadcrumb-menu">
<li><a href="index.php">Accueil</a></li>
<li class="active">Mes annonces</li>
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

<?php
    if (isset($successLouer)) {
        ?>
        <script>
            swal("Succès", "<?=$successLouer?>", "success").then(() => {
                window.location.href = "profile-property.php";
            });
        </script>
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
<li><a href="dashboard.php"><i class="far fa-gauge-high"></i> Tableau de bord</a></li>
<li><a href="profile.php"><i class="far fa-user"></i> Mon profile</a></li>
<li><a class="active" href="profile-property.php"><i class="far fa-home"></i> Mes annonces</a></li>
<li><a href="add-property.php"><i class="far fa-plus-circle"></i> Publier une annonce</a></li>
<!-- <li><a href="profile-favorite.php"><i class="far fa-heart"></i> My Favorite</a></li>
<li><a href="profile-message.php"><i class="far fa-envelope"></i> Messages <span class="badge bg-danger">02</span></a></li> 
<li><a href="profile-save-search.php"><i class="far fa-bookmark"></i> Save Search</a></li>-->
<li><a href="profile-setting.php"><i class="far fa-cog"></i> Paramètre de profile</a></li>
<li><a href="logout.php"><i class="far fa-sign-out"></i> Déconnexion</a></li>
</ul>
</div>
</div>
<div class="col-lg-9">
<div class="user-profile-wrapper">
<div class="user-profile-card user-profile-property">
<div class="user-profile-card-header">
<h4 class="user-profile-card-title">Mes annonces</h4>
<div class="user-profile-card-header-right">

<a href="add-property.php" class="theme-btn"><span class="far fa-plus-circle"></span>Ajouter une annonce</a>
</div>
</div>
<div class="col-lg-12">
<div class="table-responsive">
<table class="table text-nowrap">
<thead>
<tr>
<th>Annonce</th>
<th>Vues</th>
<th>Publié le</th>
<th>Catégorie</th>
<th>Action</th>
</tr>
</thead>
<tbody>

<?php

    while ($dataMesAnnonces = $reqMesAnnonces->fetch()){
        $photoAnnonces = $dataMesAnnonces['photo'];
        $id_annonces = $dataMesAnnonces['id_annonces'];
        $datePublication = $dataMesAnnonces['dates'];

        // Convertir la date de publication en objet DateTime
        $datePublication = new DateTime($datePublication);

        // Obtenir la date actuelle
        $dateActuelle = new DateTime();

        // Calculer la différence entre les deux dates
        $intervalle = $datePublication->diff($dateActuelle);

        // Obtenir le nombre de jours
        $jours = $intervalle->days;

        $reqVue = $database->prepare("SELECT * FROM vue WHERE id_annonces=:id_annonces");
        $reqVue->bindvalue(":id_annonces", $id_annonces);
        $reqVue->execute();

        $countVue = $reqVue->rowCount();

        ?>
        <tr>
            <td>
                <div class="table-property-info">
                <a href="#">
                <img src="upload/location/<?=$photoAnnonces?>" alt="Photo de l'annonce">
                    <div class="table-property-content">
                    <h6><?=$dataMesAnnonces['titre']?></h6>
                    <p><?=$dataMesAnnonces['localisation']?></p>
                    <span><?=$dataMesAnnonces['prix']?> FCFA</span>
                    </div>
                </a>
                </div>
            </td>
            <td>
            <h6 class="fw-bold"><?=$countVue?></h6>
            <span>Vues</span>
            </td>
            <td>
            <h6 class="fw-bold"><?=$dataMesAnnonces['dates']?></h6>
            <span>Il y a <?=$jours?> jours</span>
            </td>
            <td>
                
                <h6 class="fw_bold"><?=$dataMesAnnonces['categorie']?></h6>
            
            </td>
            <td>
            <form method="post">
                <input type="hidden" name="id_annonces" value="<?= $dataMesAnnonces['id']?>">
                <a href="property-single.php?id_annonces=<?=$dataMesAnnonces['id_annonces']?>" class="btn btn-outline-secondary btn-sm"><i class="far fa-eye"></i></a>
                <a class="btn btn-outline-secondary btn-sm"><i class="far fa-pen"></i></a>
            
                <button type="submit" class="btn btn-outline-secondary btn-sm" name="suppr"><i class="far fa-trash-can"></i></button>

                <!-- <a href="deleteLouer.php?id=" class="btn btn-outline-secondary btn-sm"><i class="far fa-trash-can"></i></a> -->

                
            </form>
            </td>
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

</main>

<?php
    require("includes/footer.php");
?>