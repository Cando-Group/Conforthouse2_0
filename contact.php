<?php

    require("includes/header.php");

    if (isset($_POST['submit'])){

        $name = strip_tags($_POST['name']);
        $email = strip_tags($_POST['email']);
        $subject = strip_tags($_POST['subject']);
        $message = strip_tags($_POST['message']);

        if (!empty($name) && !empty($email) && !empty($subject) && !empty($message)){

            $insertContact = $database->prepare("INSERT INTO contacts(nom, email, sujet, message) VALUES(:nom, :email, :sujet, :message)");
            $insertContact->bindvalue(":nom", $name);
            $insertContact->bindvalue(":email", $email);
            $insertContact->bindvalue(":sujet", $subject);
            $insertContact->bindvalue(":message", $message);
            $insertContact->execute();

            ?>
            <script>
                swal("Réussi", "Votre requête a été pris en compte", "success");
            </script>
            <?php

        }

    }

?>

<main class="main">

<div class="site-breadcrumb" style="background: url(assets/img/breadcrumb/01.jpg)">
<div class="container">
<h2 class="breadcrumb-title">Contactez nous</h2>
<ul class="breadcrumb-menu">
<li><a href="index.php">Accueil</a></li>
<li class="active">Contactez nous</li>
</ul>
</div>
</div>

<div class="contact-area py-120">
<div class="container">
<div class="contact-wrapper">
<div class="row">
<div class="col-lg-4">
<div class="contact-content">
<div class="contact-info">
<div class="contact-info-icon">
<i class="fal fa-map-marker-alt"></i>
</div>
<div class="contact-info-content">
<h5>Localisation</h5>
<p>Cotonou, Bénin</p>
</div>
</div>
<div class="contact-info">
<div class="contact-info-icon">
<i class="fal fa-phone"></i>
</div>
<div class="contact-info-content">
<h5>Téléphone</h5>
<p><a href="tel:+22998741437">+229 98 74 14 37</a></p>
</div>
</div>
<div class="contact-info">
<div class="contact-info-icon">
<i class="fal fa-envelope"></i>
</div>
<div class="contact-info-content">
<h5>Adresse email</h5>
<p><a href="mailto:ihousespport@gmail.com" class="__cf_email__" >ihousespport@gmail.com</a></p>
</div>
</div>
<div class="contact-info">
<div class="contact-info-icon">
<i class="fal fa-clock"></i>
</div>
<div class="contact-info-content">
<h5>Ouverture</h5>
<p>7J/7 et 24H/24</p>
</div>
</div>
</div>
</div>
<div class="col-lg-8 align-self-center">
<div class="contact-form">
<div class="contact-form-header">
<h2>Contactez-nous</h2>
<p>Nous sommes là pour répondre à tous vos besoins. N'hésitez pas à nous contacter en utilisant le formulaire ci-dessous. Nous serons ravis de vous aider et de vous fournir les informations nécessaires. </p>
</div>
<form method="post" id="contact-form">
<div class="row">
<div class="col-md-6">
<div class="form-group">
<input type="text" class="form-control" name="name" placeholder="Votre Nom" required>
</div>
</div>
<div class="col-md-6">
<div class="form-group">
<input type="email" class="form-control" name="email" placeholder="Votre adresse email" required>
</div>
</div>
</div>
<div class="form-group">
<input type="text" class="form-control" name="subject" placeholder="Votre Sujet" required>
</div>
<div class="form-group">
<textarea name="message" cols="30" rows="5" class="form-control" placeholder="Ecrivez votre message"></textarea>
</div>
<button type="submit" class="theme-btn" name="submit">Envoyer votre message <i class="far fa-paper-plane"></i></button>
<div class="col-md-12 mt-3">
<div class="form-messege text-success"></div>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>


<div class="contact-map">
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4060773.177337468!2d-2.267438312500039!3d6.297444967635123!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1024a923ef476b71%3A0xd028e3a940370797!2sCando%20Group!5e0!3m2!1sfr!2sbj!4v1687946716768!5m2!1sfr!2sbj" style="border:0;" allowfullscreen loading="lazy"></iframe>
</div>
</main>

<?php
    require("includes/footer.php");
?>