<?php

    require("includes/header.php");

    if (isset($_POST['reset'])){

        if (!empty($_POST['email'])){

            $reqExistEmail = $database->prepare("SELECT * FROM demarcheurs WHERE email=:email");
            $reqExistEmail->bindvalue(":email", $_POST['email']);
            $reqExistEmail->execute();

            $countExistEmail = $reqExistEmail->rowCount();

            if ($countExistEmail != 1){

                ?>
                <script>
                    swal("Oups", "Votre adresse email ne figure pas dans la base de donnée, veuillez vous inscrire", "error");
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

                $updateEmail = $database->prepare("UPDATE demarcheurs SET mdp = :mdp WHERE email = :email");
                $updateEmail->bindvalue(":mdp", password_hash($token, PASSWORD_BCRYPT));
                $updateEmail->bindvalue(":email", $_POST['email']);
                $updateEmail->execute();

                // echo $token;

                // Envoi de mail contenant le lien de réinitialisation avec le mail et le token nouvellement envoyé dans la bdd

                $dataAgent = $reqExistEmail->fetch();
                $nom = $dataAgent['nom'];
                $prenoms = $dataAgent['prenoms'];

                $emailFrom = "";
                $to = $email;
                $header = "MIME-Version: 1.0\r\n";
                $header .= "From: ihousespport@gmail.com" . "\r\n";
                $header .= 'Content-Type:text/html; charset="uft-8"' . "\n";
                $header .= 'Content-Transfer-Encoding: 8bit';
                $messages = '
                        <html>
                            <body>
                            
                                <div align="center" style="background: black;padding: 9px;">
                                        <img src="">
                                    <div style="color:#fff;font-style:italic;">Chers '.$nom. ' ' .$prenoms.' vous avez perdu votre mot de passe. Nous vous fournissons un nouveau mot de passe par défaut, veuillez le changer dans les paramètre lorsque vous vous connectez. <br>Nouveau mot de passe : <br>Cliquez ici pour vous connecter <a href="affectlac.com/login.php">Me connecter</a>
                                    
                                    </div>
                                    </div>
                                <div>Ceci est un mail automatique veuillez ne pas y répondre</div>
                            </body>
                        </html>'
                        ;

                mail($to, "Rénitiasaton du mot de passe", $messages, $header);

                // $succesMsg = "Veuillez consulter vos mails afin de procéder à la rénitialisation de votre mot de passe";

                ?>
                <script>
                    swal("Réussi", "Veuillez consulter votre boîte mail, un mail vous a été envoyé. Vérifier dans les spams si vous ne le trouver pas", "success")
                </script>
                <?php

            }

        }

    }



?>

<main class="main">

<div class="site-breadcrumb" style="background: url(assets/img/breadcrumb/01.jpg)">
<div class="container">
<h2 class="breadcrumb-title">Mot de passe oublié</h2>
<ul class="breadcrumb-menu">
<li><a href="index.php">Accueil</a></li>
<li class="active">Mot de passe oublié</li>
</ul>
</div>
</div>

<div class="login-area py-120">
<div class="container">
<div class="col-md-5 mx-auto">
<div class="login-form">
<div class="login-header">
<h4>Conforth0use</h4>
<p>Rénitialiser votre mot de passe</p>
</div>
<form method="post">
<div class="form-group">
<label>Adresse email</label>
<input type="email" name="email" class="form-control" placeholder="Votre adresse email">
<i class="far fa-envelope"></i>
</div>
<div class="d-flex align-items-center">
<button type="submit" name="reset" class="theme-btn"><i class="far fa-key"></i> Envoyer le lien de rénitiallisation</button>
</div>
</form>
</div>
</div>
</div>
</div>

</main>

<?php

    require("includes/footer.php");

?>