<?php

    require('includes/header_connect.php');

    // Mettre à jour les informations

    if (isset($_POST['info'])){

        if (!empty($_POST['nom']) && !empty($_POST['prenoms']) && !empty($_POST['whatsapp'] && !empty($_POST['telephone'])) && !empty($_POST['description'])){

            $updateInfo = $database->prepare("UPDATE collocusers SET username=:nom, whatsapp=:whatsapp WHERE username=:username");
            $updateInfo->bindvalue(":nom", $_POST['nom']);
            $updateInfo->bindvalue(":whatsapp", $_POST['whatsapp']);
            $updateInfo->bindvalue(":username", $_SESSION['coloc']);
            $updateInfo->execute();

            // Mise a jour de toutes les annonces de la plateforme

            $updateAllAnnonces = $database->prepare("UPDATE annoncescolocations SET username=:username ");
            $updateAllAnnonces->bindvalue(":prenoms", $_POST['prenoms']);
            $updateAllAnnonces->bindvalue(":tel", $_POST['telephone']);
            $updateAllAnnonces->bindvalue(":email", $_SESSION['email']);
            $updateAllAnnonces->execute();

            ?>
            <script>
                swal("Réussi", "Vos informations ont été mis à jour", "success");
            </script>
            <?php

        }else{
            ?>
                <script>
                    swal("Oups", "Veuillez remplir tous les champs", "error")
                </script>
            <?php
        }

    }

    // Mettre à jour le mot de passe

    if (isset($_POST['password'])){

        if (!empty($_POST['new_password']) && !empty($_POST["confirm_password"])){

            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];

            if ($new_password == $confirm_password){

                // HAchage du nouveau mot de passe

                $hashedNewPassword = password_hash($new_password, PASSWORD_DEFAULT);

                // Mettre à jour le mot de passe dans la base de données
                $updatePassword = $database->prepare("UPDATE demarcheurs SET mdp = :new_password WHERE email = :email");
                $updatePassword->bindValue(":new_password", $hashedNewPassword);
                $updatePassword->bindValue(":email", $_SESSION['email']);
                $updatePassword->execute();

                ?>
                <script>
                    swal("Réussi", "Votre mot de passe a été modifié", "success")
                </script>
                <?php

            }else{
                ?>
                <script>
                    swal("Oups", "Les mots de passe ne sont pas identique", "error")
                </script>
                <?php
            }

        }

    }

    // Suppression du compte

    if (isset($_POST['deleteAccount'])){

        if (!empty($_POST['password_delete'])){

            if (password_verify($_POST['password_delete'], $dataUser['mdp'])){

                // Supprimer toutes les annonces de l'utilisateur
                $deleteUserAds = $database->prepare("DELETE FROM annonces WHERE email = :email");
                $deleteUserAds->bindValue(":email", $_SESSION['email']);
                $deleteUserAds->execute();

                // Supprimer le compte de l'utilisateur
                $deleteUser = $database->prepare("DELETE FROM demarcheurs WHERE email = :email");
                $deleteUser->bindValue(":email", $_SESSION['email']);
                $deleteUser->execute();

                session_unset();
                session_destroy();
                ?>
                <script>
                    window.location.href="register.php";
                </script>
                <?php

            }else{
                ?>
                <script>
                    swal("Oups", "Mot de passe incorrect", "error")
                </script>
                <?php
            }

        }else{
            ?>
            <script>
                swal("Oups", "Veuillez entrer votre mot de passe pour confirmer la suppression de votre compte", "error");
            </script>
            <?php
        }

    }

?>

<main class="main">

<div class="site-breadcrumb" style="background: url(../assets/img/breadcrumb/01.jpg)">
<div class="container">
<h2 class="breadcrumb-title">Paramètres</h2>
<ul class="breadcrumb-menu">
<li><a href="index.php">Accueil</a></li>
<li class="active">Paramètres</li>
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
<img src="../assets/img/account/user-1.jpg" alt="photo de profil" style="width: 100px;height:100px;">

</div>
<h4><?=$dataUser['username']?></h4>
<p><a href="<?=$dataUser['email']?>" class="__cf_email__" data-cfemail="482227263b2726082d30292538242d662b2725"><?=$dataUser['email']?></a></p>
</div>
<ul class="user-profile-sidebar-list">
<ul class="user-profile-sidebar-list">
<li><a href="profile.php"><i class="far fa-user"></i> Mon profile</a></li>
<li><a href="add-property.php"><i class="far fa-plus-circle"></i> Publier une annonce</a></li>
<!-- <li><a href="profile-favorite.php"><i class="far fa-heart"></i> My Favorite</a></li>
<li><a href="profile-message.php"><i class="far fa-envelope"></i> Messages <span class="badge bg-danger">02</span></a></li> 
<li><a href="profile-save-search.php"><i class="far fa-bookmark"></i> Save Search</a></li>-->
<li><a class="active" href="profile-setting.php"><i class="far fa-cog"></i> Paramètre de profile</a></li>
<li><a href="logout.php"><i class="far fa-sign-out"></i> Déconnexion</a></li>
</ul>
</div>
</div>
<div class="col-lg-9">
<div class="user-profile-wrapper">
<div class="user-profile-card user-profile-property">
<div class="user-profile-card-header">
<h4 class="user-profile-card-title">Mise à jour des informations</h4>
<div class="user-profile-card-header-right">

<a href="add-property.php" class="theme-btn"><span class="far fa-plus-circle"></span>Ajouter une annonce</a>
</div>
</div>

<div class="user-profile-form">
<form method="post">
<div class="row">
<div class="col-md-6">
<div class="form-group">
<label>Username <span class="text-danger">*</span></label>
<input type="text" class="form-control" value="<?=$dataUser['username']?>" placeholder="Username" name="nom">
</div>
</div>
<div class="col-md-6">
<div class="form-group">
<label>Numéro whatsapp <span class="text-danger">*</span> (avec l'indicatif du pays)</label>
<input type="text" class="form-control" value="<?=$dataUser['whatsapp']?>" placeholder="Numéro Whatsapp" name="whatsapp">
</div>
</div>
</div>
<button type="submiit" name="info" class="theme-btn mt-4">Mettre à jour les informations <i class="far fa-user"></i></button>
</form>
</div>
</div>
</div>
<div class="col-lg-12">
<div class="user-profile-card">
<h4 class="user-profile-card-title">Changer votre mot de passe</h4>

<div class="col-lg-12">
<div class="user-profile-form">
<form method="post">
<div class="form-group">
<label>Nouveau mot de passe</label>
<input type="password" class="form-control" placeholder="Nouveau mot de passe" name="new_password">
</div>
<div class="form-group">
<label>Confirmation du mot de passe</label>
<input type="password" class="form-control" placeholder="Confirmation du mot de passe" name="confirm_password">
</div>
<button type="submit" class="theme-btn mt-4" name="password">Changer le mot de passe <i class="far fa-key"></i></button>
</form>
</div>
</div>

<div class="col-md-12 mt-5">
    <h4>Suppression du compte</h4>
    <form method="post" class="mt-2">
        <label for="password">Mot de password <span class="text-danger">*</span></label>
        <input type="password" name="password_delete" id="password" class="form-control mb-3">
        <button type="submit" name="deleteAccount" class="theme-btn">Confirmer la suppression du compte</button>
    </form>
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