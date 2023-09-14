<?php

    require("includes/header_connect.php");

    if (!isset($_SESSION['coloc'])){

        ?>
        <script>
            window.location.href = "login.php";
        </script>
        <?php
    }


    if (isset($_POST['submit'])){

        $categories = $_POST['categories'];
        $prix = strip_tags($_POST['prix']);
        $description = strip_tags($_POST['description']);

        if (!empty($categories) && !empty($prix) && !empty($description)){

            $reqExistAnnonce = $database->prepare("SELECT * FROM annoncescolocations WHERE description=:description AND username=:username");;
            $reqExistAnnonce->bindvalue(":description", $description);
            $reqExistAnnonce->bindvalue(":username", $dataUser['username']);
            $reqExistAnnonce->execute();

            $countAnnoncesExist = $reqExistAnnonce->rowCount();
            // echo $_SESSION['email'];
            // echo $countAnnoncesExist;

            if ($countAnnoncesExist != 0){

                ?>
                <script>
                    swal("Oups", "Cette annonce existe déjà", "error");
                </script>
                <?php

            }else{

                function token_random_string($leng=40){

                    $str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $token = '';
                    for ($i=0;$i<$leng;$i++){
                        $token.=$str[rand(0, strlen($str)-1)];
                    }
                    return $token;
                }

                $token = token_random_string(10);

                $insert = $database->prepare("INSERT INTO annoncescolocations (id_colocation,username, pays, prix, categorie, description) VALUES(:id_colocation, :username, :pays, :prix, :categorie, :description)");
                $insert->bindvalue(":id_colocation", $token );
                $insert->bindvalue(":username", $dataUser['username']);
                $insert->bindvalue(":prix", $prix);
                $insert->bindvalue(":categorie", $categories);
                $insert->bindvalue(":description", $description);
                $insert->bindvalue(":pays", $dataUser["pays"]);
                $insert->execute();

                ?>
                <script>
                    swal("Réussi", "Annonce de colocation publié", "success");
                </script>
                <?php

            }

        }else{
            ?>
            <script>
                swal("Oups", "Remplissez les champs", "info")
            </script>
            <?php
        }

    }

?>

<main class="main">

<div class="site-breadcrumb" style="background: url(../assets/img/breadcrumb/01.jpg)">
<div class="container">
<h2 class="breadcrumb-title">Ajouter une annonce (Colocation)</h2>
<ul class="breadcrumb-menu">
<li><a href="index.php">Accueil</a></li>
<li class="active">Ajouter une annonce (Colocation)</li>
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
<li><a href="profile.php"><i class="far fa-user"></i> Mon profile</a></li>
<li><a class="active" href="add-property.php"><i class="far fa-plus-circle"></i> Publier une colocation</a></li>
<!-- <li><a href="profile-favorite.php"><i class="far fa-heart"></i> My Favorite</a></li>
<li><a href="profile-message.php"><i class="far fa-envelope"></i> Messages <span class="badge bg-danger">02</span></a></li> 
<li><a href="profile-save-search.php"><i class="far fa-bookmark"></i> Save Search</a></li>-->
<!-- <li><a href="profile-setting.php"><i class="far fa-cog"></i> Paramètre de profile</a></li> -->
<li><a href="logout.php"><i class="far fa-sign-out"></i> Déconnexion</a></li>
</ul>
</div>
</div>
<div class="col-lg-9">
<div class="row">
    <div class="user-profile-wrapper">
        <div class="user-profile-card add-property">
        <h4 class="user-profile-card-title">Ajouter une annonce de colocation</h4>
        <div class="col-lg-12">
        <div class="add-property-form">
        <h5 class="fw-bold mb-4">Informations basiques</h5>
        <form method="post" enctype="multipart/form-data">
        <div class="row align-items-center">
        <div class="col-lg-6">
        <div class="form-group">
        <label>Catégrories</label>
        <select class="select" name="categories">
        <option value>Selectionner une catégorie</option>
        <option value="Chambres Familiale">Chambre familiales</option>
        <option value="Chambres étudiants">Chambre étudiantes / personnelles</option>
        <option value="Appartement">Appartements</option>
        <option value="Bureau">Bureaux</option>
        <option value="Boutique">Boutiques</option>
        <option value="Autres">Autres</option>
        </select>
        </div>
        </div>
        <div class="col-lg-6">
        <div class="form-group">
        <label>Prix</label>
        <input type="text" class="form-control" name="prix" placeholder="Entrer un prix">
        </div>
        </div>
        <h5 class="fw-bold my-4">Information détaillée</h5>
        <div class="col-lg-12">
        <div class="form-group">
        <label>Description</label>
        <textarea class="form-control" name="description" placeholder="Description" cols="30" rows="5"></textarea>
        </div>
        </div>
        <div class="col-lg-12 my-4">
        <button type="submit" name="submit" class="theme-btn">Publier l'annonce</button>
        </div>
        </div>
</div>
</form>
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
    require("includes/footer.php")
?>