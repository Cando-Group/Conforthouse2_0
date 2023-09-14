<?php

    require("includes/header_connect.php");

    $id = $_GET['id_annonces'];

    $reqAnnonceInfo = $database->prepare("SELECT * FROM annonces WHERE id_annonces=:id AND louer=:louer");
    $reqAnnonceInfo->bindvalue(":id", $id);
    $reqAnnonceInfo->bindvalue(":louer", "non");
    $reqAnnonceInfo->execute();

    $dataAnnonceInfo = $reqAnnonceInfo->fetch();

    if (isset($_POST['submit'])){

        $titre = htmlspecialchars(htmlentities($_POST['titre']));
        $type = htmlspecialchars(htmlentities($_POST['type']));
        $categories = htmlspecialchars(htmlentities($_POST['categories']));
        $prix = htmlspecialchars(htmlentities($_POST['prix']));
        $localisation = htmlspecialchars(htmlentities($_POST['localisation']));
        // $photos = $_FILES['photos'];
        $description = htmlspecialchars(htmlentities($_POST['description']));

        if (!empty($titre) && !empty($type) && !empty($categories) && !empty($prix) && !empty($localisation) && !empty($description)){

            // Photo du livre

                // 1. Nom de l'img
                $name_image = $_FILES['photos']['name'];
                    
                //2. Le dossier où se trouve l'img
                $temporaire = $_FILES['photos']['tmp_name'];
            
                //3. extension de notre image
                $extens =strrchr($name_image, '.');
            
                //4.Extension autoriser
                $autoriser = array('.png', '.PNG', '.jpg', '.JPG', '.jpeg', '.JPEG');
            
                //5.dossier de destination
                $destination = 'upload/location/'.$name_image;


                if (in_array($extens, $autoriser)){

                    if (move_uploaded_file($temporaire, $destination)){

                        $update = $database->prepare("UPDATE annonces SET prenoms = :prenoms, email = :email, tel = :tel, titre = :titre, prix = :prix, localisation = :localisation, mots = :mots, categorie = :categories, photo = :photo, description = :descriptionn, pays = :pays WHERE id_annonces = :id_annonces");
                        $update->bindvalue(":titre", $titre);
                        $update->bindvalue(":prix", $prix);
                        $update->bindvalue(":localisation", $localisation);
                        $update->bindvalue(":mots", $type);
                        $update->bindvalue(":categories", $categories);
                        $update->bindvalue(":photo", $name_image);
                        $update->bindvalue(":descriptionn", $description);
                        $update->bindvalue(":pays", $dataUser["pays"]);
                        $update->bindvalue(":id_annonces", $id);

                        $update->execute();

                        // A faire plus tard



                    }

                }


                ?>
                <script>
                    swal("Réussi", "Annonces modifié", "success");
                </script>
                <?php

        }else{

            ?>
            <script>
                swal("Oups", "Veuillez remplir les champs", "error");
            </script>
            <?php

        }

    }

?>

<main class="main">

<div class="site-breadcrumb" style="background: url(assets/img/breadcrumb/01.jpg)">
<div class="container">
<h2 class="breadcrumb-title">Ajouter une annonce</h2>
<ul class="breadcrumb-menu">
<li><a href="index.php">Accueil</a></li>
<li class="active">Ajouter une annonce</li>
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
<img src="upload/profile/<?=$dataUser['photo']?>" alt="Photo de profil" style="width: 100px;height:100px;">

</div>
<h4><?=$dataUser['nom']?> <?=$dataUser['prenoms']?></h4>
<p><a href="mailto:candidesodokinpro@gmail.com" class="__cf_email__" ><?=$_SESSION['email']?></a></p>
</div>
<ul class="user-profile-sidebar-list">
<li><a href="dashboard.php"><i class="far fa-gauge-high"></i> Tableau de bord</a></li>
<li><a href="profile.php"><i class="far fa-user"></i> Mon profile</a></li>
<li><a href="profile-property.php"><i class="far fa-home"></i> Mes annonces</a></li>
<li><a class="active" href="add-property.php"><i class="far fa-plus-circle"></i> Publier une annonce</a></li>
<!-- <li><a href="profile-favorite.php"><i class="far fa-heart"></i> My Favorite</a></li>
<li><a href="profile-message.php"><i class="far fa-envelope"></i> Messages <span class="badge bg-danger">02</span></a></li> 
<li><a href="profile-save-search.php"><i class="far fa-bookmark"></i> Save Search</a></li>-->
<li><a href="profile-setting.php"><i class="far fa-cog"></i> Paramètre de profile</a></li>
<li><a href="logout.php"><i class="far fa-sign-out"></i> Déconnexion</a></li>
</ul>
</div>
</div>
<div class="col-lg-9">
<div class="row">
    <div class="user-profile-wrapper">
        <div class="user-profile-card add-property">
        <h4 class="user-profile-card-title">Ajouter une annonce</h4>
        <div class="col-lg-12">
        <div class="add-property-form">
        <h5 class="fw-bold mb-4">Informations basiques</h5>
        <form method="post" enctype="multipart/form-data">
        <div class="row align-items-center">
        <div class="col-lg-12">
        <div class="form-group">
        <label>Titre</label>
        <input type="text" class="form-control" name="titre" placeholder="Entrer le quartier ou le village ou l'arrondissement" value="<?=$dataAnnonceInfo['titre']?>">
        </div>
        </div>
        <div class="col-lg-6">
        <div class="form-group">
        <label>Type</label>
        <select class="select" name="type">
            <option value="<?=$dataAnnonceInfo['mots']?>"><?=$dataAnnonceInfo['mots']?></option>
        <option value>Sélectionner un type</option>
        <option value="Sanitaire">Sanitaire</option>
        <option value="Appartement">Appartement</option>
        <option value="Simple">Simple</option>
        </select>
        </div>
        </div>
        <div class="col-lg-6">
        <div class="form-group">
        <label>Catégrories</label>
        <select class="select" name="categories">
        <option value="<?=$dataAnnonceInfo['categorie']?>"><?=$dataAnnonceInfo['categorie']?></option>
        <option value>Selectionner une catégorie</option>
        <option value="Chambres Familiale">Chambre familiales</option>
        <option value="Chambres etudiants">Chambre étudiantes / personnelles</option>
        <option value="Appartement">Appartement</option>
        <option value="Bureau">Bureau</option>
        <option value="Boutique">Boutique</option>
        <option value="Autres">Autres</option>
        </select>
        </div>
        </div>
        <div class="col-lg-6">
        <div class="form-group">
        <label>Prix</label>
        <input type="text" class="form-control" name="prix" placeholder="Entrer un prix" value="<?=$dataAnnonceInfo['prix']?>">
        </div>
        </div>
        <div class="col-lg-6">
        <div class="form-group">
        <label>Localisation</label>
        <select class="select" name="localisation">
            <option value="<?=$dataAnnonceInfo['localisation']?>"><?=$dataAnnonceInfo['mots']?></option>
            <option value="">Choisir une ville</option>
            <option value="Abomey">Abomey</option>
            <option value="Abomey-Calavi">Abomey-Calavi</option>
            <option value="Adja-Ouèrè">Adja-Ouèrè</option>
            <option value="Adjohoun">Adjohoun</option>
            <option value="Aguégués">Aguégués</option>
            <option value="Aplahoué">Aplahoué</option>
            <option value="Athiémé">Athiémé</option>
            <option value="Banikoara">Banikoara</option>
            <option value="Bassila">Bassila</option>
            <option value="Bembèrèkè">Bembèrèkè</option>
            <option value="Bohicon">Bohicon</option>
            <option value="Bopa">Bopa</option>
            <option value="Boukoumbé">Boukoumbé</option>
            <option value="Comé">Comé</option>
            <option value="Copargo">Copargo</option>
            <option value="Covè">Covè</option>
            <option value="Dangbo">Dangbo</option>
            <option value="Djakotomey">Djakotomey</option>
            <option value="Djidja">Djidja</option>
            <option value="Djougou">Djougou</option>
            <option value="Dogbo">Dogbo</option>
            <option value="Glazoué">Glazoué</option>
            <option value="Godomey">Godomey</option>
            <option value="Grand-Popo">Grand-Popo</option>
            <option value="Gogounou">Gogounou</option>
            <option value="Hévié">Hévié</option>
            <option value="Houéyogbé">Houéyogbé</option>
            <option value="Ifangni">Ifangni</option>
            <option value="Kalalé">Kalalé</option>
            <option value="Karimama">Karimama</option>
            <option value="Kandi">Kandi</option>
            <option value="Klouékanmè">Klouékanmè</option>
            <option value="Kétou">Kétou</option>
            <option value="Kouandé">Kouandé</option>
            <option value="Lokossa">Lokossa</option>
            <option value="Malanville">Malanville</option>
            <option value="Matéri">Matéri</option>
            <option value="Natitingou">Natitingou</option>
            <option value="N'dali">N'dali</option>
            <option value="Nikki">Nikki</option>
            <option value="Ouidah">Ouidah</option>
            <option value="Ouaké">Ouaké</option>
            <option value="Ouèssè">Ouèssè</option>
            <option value="Parakou">Parakou</option>
            <option value="Pehonko">Pehonko</option>
            <option value="Pobè">Pobè</option>
            <option value="Porto-Novo">Porto-Novo</option>
            <option value="Sô-Ava">Sô-Ava</option>
            <option value="Savalou">Savalou</option>
            <option value="Savé">Savé</option>
            <option value="Segbana">Segbana</option>
            <option value="Ségbana">Ségbana</option>
            <option value="Sinendé">Sinendé</option>
            <option value="So-Ava">So-Ava</option>
            <option value="Sakété">Sakété</option>
            <option value="Tchaourou">Tchaourou</option>
            <option value="Tchetti">Tchetti</option>
            <option value="Tanguiéta">Tanguiéta</option>
            <option value="Tchaourou">Tchaourou</option>
            <option value="Télimélé">Télimélé</option>
            <option value="Tori-Bossito">Tori-Bossito</option>
            <option value="Toffo">Toffo</option>
            <option value="Toviklin">Toviklin</option>
            <option value="Zè">Zè</option>
            <option value="Zagnanado">Zagnanado</option>
        </select>
        </div>
        </div>
        <h5 class="fw-bold my-4">Photos</h5>
        <div class="col-lg-12">
        <div class="form-group">
        <div class="property-upload-wrapper">
        <div class="property-img-upload">
        <span><i class="far fa-images"></i> Sélectionner vos photos</span>
        </div>
        <input type="file" class="property-img-file" name="photos">
        </div>
        </div>
        </div>
        <!-- <h5 class="fw-bold my-4">Location</h5> -->
        <div class="col-lg-6">
        <!-- <div class="form-group">
        <label>Address</label>
        <input type="text" class="form-control" placeholder="Enter address"> -->
        </div>
        </div>
        <div class="col-lg-6">
        <!-- <div class="form-group">
        <label>City</label>
        <input type="text" class="form-control" placeholder="Enter city"> -->
        </div>
        </div>
        <div class="col-lg-6">
        <!-- <div class="form-group">
        <label>State</label>
        <input type="text" class="form-control" placeholder="Enter state"> -->
        </div>
        </div>
        <div class="col-lg-6">
        <!-- <div class="form-group">
        <label>Zip Code</label>
        <input type="text" class="form-control" placeholder="Enter zip code"> -->
        </div>
        </div>
        <h5 class="fw-bold my-4">Information détaillée</h5>
        <div class="col-lg-12">
        <div class="form-group">
        <label>Description</label>
        <textarea class="form-control" name="description" placeholder="Description" cols="30" rows="5" value="<?=$dataAnnonceInfo['mots']?>"><?=$dataAnnonceInfo['mots']?></textarea>
        </div>
        </div>
        <div class="col-lg-4">
        <!-- <div class="form-group">
        <label>Built Years</label>
        <select class="select">
        <option value>Built Year</option>
        <option value="1">2022</option>
        <option value="2">2021</option>
        <option value="3">2020</option>
        <option value="4">2019</option>
        <option value="5">2018</option>
        </select>
        </div> -->
        </div>
        <div class="col-lg-4">
        <!-- <div class="form-group">
        <label>Garage(Optional)</label>
        <select class="select">
        <option value>Select Garage</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        </select>
        </div> -->
        </div>
        <div class="col-lg-4">
        <!-- <div class="form-group">
        <label>Rooms(Optional)</label>
        <select class="select">
        <option value>Select Rooms</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        </select>
        </div> -->
        </div>
        <!-- <h5 class="fw-bold my-4">Amenities</h5> -->
        <div class="col-6 col-md-3">
        <!-- <div class="form-check">
        <input class="form-check-input" name="property-aminity" type="checkbox" value id="property-aminity1">
        <label class="form-check-label" for="property-aminity1">
        Air Conditioning
        </label>
        </div> -->
        </div>
        <div class="col-6 col-md-3">
        <!-- <div class="form-check">
        <input class="form-check-input" name="property-aminity" type="checkbox" value id="property-aminity2">
        <label class="form-check-label" for="property-aminity2">
        Barbeque
        </label>
        </div>
        </div>
        <div class="col-6 col-md-3">
        <div class="form-check"> -->
        <!-- <input class="form-check-input" name="property-aminity" type="checkbox" value id="property-aminity3">
        <label class="form-check-label" for="property-aminity3">
        Dryer
        </label>
        </div> -->
        </div>
        <div class="col-6 col-md-3">
        <!-- <div class="form-check">
        <input class="form-check-input" name="property-aminity" type="checkbox" value id="property-aminity4">
        <label class="form-check-label" for="property-aminity4">
        Gym
        </label>
        </div> -->
        </div>
        <div class="col-6 col-md-3">
        <!-- <div class="form-check">
        <input class="form-check-input" name="property-aminity" type="checkbox" value id="property-aminity5">
        <label class="form-check-label" for="property-aminity5">
        Laundry
        </label>
        </div> -->
        </div>
        <div class="col-6 col-md-3">
        <!-- <div class="form-check">
        <input class="form-check-input" name="property-aminity" type="checkbox" value id="property-aminity6">
        <label class="form-check-label" for="property-aminity6">
        Lawn
        </label>
        </div> -->
        </div>
        <div class="col-6 col-md-3">
        <!-- <div class="form-check">
        <input class="form-check-input" name="property-aminity" type="checkbox" value id="property-aminity7">
        <label class="form-check-label" for="property-aminity7">
        Microwave
        </label>
        </div> -->
        </div>
        <div class="col-6 col-md-3">
        <!-- <div class="form-check">
        <input class="form-check-input" name="property-aminity" type="checkbox" value id="property-aminity8">
        <label class="form-check-label" for="property-aminity8">
        Outdoor Shower
        </label>
        </div> -->
        </div>
        <div class="col-6 col-md-3">
        <!-- <div class="form-check">
        <input class="form-check-input" name="property-aminity" type="checkbox" value id="property-aminity9">
        <label class="form-check-label" for="property-aminity9">
        Refrigerator
        </label>
        </div> -->
        </div>
        <div class="col-6 col-md-3">
        <!-- <div class="form-check">
        <input class="form-check-input" name="property-aminity" type="checkbox" value id="property-aminity10">
        <label class="form-check-label" for="property-aminity10">
        Sauna
        </label>
        </div> -->
        </div>
        <div class="col-6 col-md-3">
        <!-- <div class="form-check">
        <input class="form-check-input" name="property-aminity" type="checkbox" value id="property-aminity11">
        <label class="form-check-label" for="property-aminity11">
        Swimming Pool
        </label>
        </div> -->
        </div>
        <div class="col-6 col-md-3">
        <!-- <div class="form-check">
        <input class="form-check-input" name="property-aminity" type="checkbox" value id="property-aminity12">
        <label class="form-check-label" for="property-aminity12">
        TV Cable
        </label>
        </div> -->
        </div>
        <div class="col-6 col-md-3">
        <!-- <div class="form-check">
        <input class="form-check-input" name="property-aminity" type="checkbox" value id="property-aminity13">
        <label class="form-check-label" for="property-aminity13">
        Washer
        </label>
        </div> -->
        </div>
        <div class="col-6 col-md-3">
        <!-- <div class="form-check">
        <input class="form-check-input" name="property-aminity" type="checkbox" value id="property-aminity14">
        <label class="form-check-label" for="property-aminity14">
        WiFi
        </label>
        </div> -->
        </div>
        <div class="col-6 col-md-3">
        <!-- <div class="form-check">
        <input class="form-check-input" name="property-aminity" type="checkbox" value id="property-aminity15">
        <label class="form-check-label" for="property-aminity15">
        Window Cover
        </label>
        </div> -->
        </div>
        <!-- <h5 class="fw-bold my-4">Contact Information</h5> -->
        <div class="col-lg-4">
        <!-- <div class="form-group">
        <label>Name</label>
        <input type="text" class="form-control" placeholder="Enter name">
        </div> -->
        </div>
        <div class="col-lg-4">
        <!-- <div class="form-group">
        <label>Email</label>
        <input type="text" class="form-control" placeholder="Enter email">
        </div> -->
        </div>
        <div class="col-lg-4">
        <!-- <div class="form-group">
        <label>Phone</label>
        <input type="text" class="form-control" placeholder="Enter phone">
        </div> -->
        </div>
        <div class="col-12 mt-4">
        <!-- <div class="form-check">
        <input class="form-check-input" name="agree" type="checkbox" value id="agree">
        <label class="form-check-label" for="agree">
        I Agree With Your Terms Of Services And Privacy Policy.
        </label>
        </div> -->
        </div>
        <div class="col-lg-12 my-4">
        <button type="submit" name="submit" class="theme-btn">Modifier   l'annonce</button>
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

<footer class="footer-area">
<div class="footer-widget">
<div class="container">
<div class="row footer-widget-wrapper pt-100 pb-70">
<div class="col-md-6 col-lg-4">
<div class="footer-widget-box about-us">
<a href="#" class="footer-logo text-light">
ConfortHouse
</a>
<p class="mb-4">
    ConfortHouse est votre destination ultime pour trouver la location de chambre idéale. Notre plateforme offre un large choix de chambres de qualité, un processus facile et sécurisé, ainsi qu'un service client exceptionnel pour répondre à tous vos besoins.
</p>
<ul class="footer-contact">
<li><a href="tel:+22951378825"><i class="far fa-phone"></i>+229 51 37 88 25</a></li>
<li><i class="far fa-map-marker-alt"></i>Cotonou, Bénin</li>
<li><a href="mailto:candidesodokinpro@gmail.com"><i class="far fa-envelope"></i><span class="__cf_email__" data-cfemail="88e1e6eee7c8edf0e9e5f8e4eda6ebe7e5">candidesodokinpro@gmail.com</span></a></li>
</ul>
</div>
</div>
<div class="col-md-6 col-lg-2">
<div class="footer-widget-box list">
<h4 class="footer-widget-title">Liens utiles</h4>
<ul class="footer-list">
<li><a href="about.php"><i class="fas fa-angle-double-right"></i> A propos</a></li>
<li><a href="faq.php"><i class="fas fa-angle-double-right"></i> FAQ's</a></li>
<li><a href="terms.php"><i class="fas fa-angle-double-right"></i> Conditions d'utilisations</a></li>
<li><a href="privacy.php"><i class="fas fa-angle-double-right"></i> Politique de confidentialité</a></li>
<li><a href="contact.php"><i class="fas fa-angle-double-right"></i> Contacts</a></li>
<li><a href="register.php"><i class="fas fa-angle-double-right"></i> S'inscrire</a></li>
</ul>
</div>
</div>
<div class="col-md-6 col-lg-3">
<div class="footer-widget-box list">
<h4 class="footer-widget-title">Catégories</h4>
<ul class="footer-list">
<li><a href="#"><i class="fas fa-angle-double-right"></i> Chambres familiales</a></li>
<li><a href="#"><i class="fas fa-angle-double-right"></i> Chambres étudiants</a></li>
<li><a href="#"><i class="fas fa-angle-double-right"></i> Chambres d'hôtel</a></li>
<li><a href="#"><i class="fas fa-angle-double-right"></i> Studio</a></li>
<li><a href="#"><i class="fas fa-angle-double-right"></i> Bureau</a></li>
<li><a href="#"><i class="fas fa-angle-double-right"></i> Boutique</a></li>
</ul>
</div>
</div>
<div class="col-md-6 col-lg-3">
<div class="footer-widget-box list">
<h4 class="footer-widget-title">Newsletter</h4>
<div class="footer-newsletter">
<p>Souscrivez à notre newsletter pour recevoir de nos nouvelles</p>
<div class="subscribe-form">
<form action="#">
<input type="email" class="form-control" placeholder="Votre adresse email">
<button class="theme-btn" type="submit">
Souscrire <i class="far fa-paper-plane"></i>
</button>
</form>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="copyright">
<div class="container">
<div class="row">
<div class="col-md-6 align-self-center">
<p class="copyright-text">
&copy; Copyright <span id="date"></span> <a href="#"> ConfortHouse </a> Tous droits réservés.
</p>
</div>
<div class="col-md-6 align-self-center">
<ul class="footer-social">
<li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
<li><a href="#"><i class="fab fa-twitter"></i></a></li>
<li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
<li><a href="#"><i class="fab fa-youtube"></i></a></li>
</ul>
</div>
</div>
</div>
</div>
</footer>


<a href="#" id="scroll-top"><i class="far fa-angle-up"></i></a>


<script data-cfasync="false" src="../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="assets/js/jquery-3.6.0.min.js"></script>
<script src="assets/js/modernizr.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/imagesloaded.pkgd.min.js"></script>
<script src="assets/js/jquery.magnific-popup.min.js"></script>
<script src="assets/js/isotope.pkgd.min.js"></script>
<script src="assets/js/jquery.appear.min.js"></script>
<script src="assets/js/jquery.easing.min.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script src="assets/js/counter-up.js"></script>
<script src="assets/js/masonry.pkgd.min.js"></script>
<script src="assets/js/jquery.nice-select.min.js"></script>
<script src="assets/js/jquery-ui.min.js"></script>
<script src="assets/js/wow.min.js"></script>
<script src="assets/js/main.js"></script>
</body>

</html>