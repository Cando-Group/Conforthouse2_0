<?php

    require("includes/header.php");

    if (isset($_POST['login'])){

        if (!empty($_POST['email']) && !empty($_POST['password'])){

            $reqUserConnect = $database->prepare("SELECT * FROM demarcheurs WHERE email=:email");
            $reqUserConnect->bindvalue(":email", $_POST['email']);
            $reqUserConnect->execute();

            $user = $reqUserConnect->fetch();

            if ($user && password_verify($_POST['password'], $user['mdp'])){

                $_SESSION['email'] = $_POST['email'];

                $reqIDUser = $database->prepare("SELECT * FROM demarcheurs WHERE email=:email");
                $reqIDUser->bindvalue(":email", $_POST['email']);
                $reqIDUser->execute();

                $dataIDUser = $reqIDUser->fetch();

                $_SESSION['id'] = $dataIDUser['id'];

                if (($user['token'] != "Valider") && $user['validation'] != 1){
                    ?>
                    <script>
                        swal("Oups", "Veuillez confirmer votre compte par le mail qui vous a été envoyé", "error")
                    </script>
                    <?php
                }else{
                    ?>
                    <script>
                        window.location.href="add-property.php";
                    </script>
                    <?php
                }

                

            }else{
                ?>
                <script>
                    swal("Oups", "Identifiants incorrect", "error");
                </script>
                <?php
            }

        }

    }

?>

<main class="main">

<div class="site-breadcrumb" style="background: url(assets/img/breadcrumb/01.jpg)">
<div class="container">
<h2 class="breadcrumb-title">Connexion</h2>
<ul class="breadcrumb-menu">
<li><a href="index.php">Accueil</a></li>
<li class="active">Connexion</li>
</ul>
</div>
</div>

<div class="login-area py-120">
<div class="container">
<div class="col-md-5 mx-auto">
<div class="login-form">
<div class="login-header">
ConfortHouse
<p>Connectez-vous à votre compte</p>
</div>
<form method="post">
<div class="form-group">
<label>Adresse email</label>
<input type="email" class="form-control" name="email" placeholder="Votre Adresse Email">
<i class="far fa-envelope"></i>
</div>
<div class="form-group">
<label>Password</label>
<input type="password" class="form-control" name="password" placeholder="Votre mot de passe ">
<i class="far fa-lock"></i>
</div>
<div class="d-flex justify-content-between mb-3">

<a href="forgot-password.php" class="forgot-pass">Mot de passe oublié ?</a>
</div>
<div class="d-flex align-items-center">
<button type="submit" name="login" class="theme-btn"><i class="far fa-sign-in"></i> Se connecter</button>
</div>
</form>
<div class="login-footer">
<!-- <div class="login-divider"><span>Or</span></div>
<div class="social-login">
<a href="#" class="btn-fb"><i class="fab fa-facebook"></i> Login With Facebook</a>
<a href="#" class="btn-gl"><i class="fab fa-google"></i> Login With Google</a>
</div> -->
<p>Pas de compte? <a href="register.php">S'inscrire</a></p>
</div>
</div>
</div>
</div>
</div>

</main>

<?php
    require("includes/footer.php")
?>