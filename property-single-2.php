<?php

    require("includes/header.php");

    // Ajout d'une vue a l'annonce

    $ipVue = $_SERVER['REMOTE_ADDR'];

    $addVue = $database->prepare("INSERT INTO vue(ip, id_annonces) VALUES(:ip, :id_annonces)");
    $addVue->bindValue(":ip", $ipVue);
    $addVue->bindValue(":id_annonces", $_GET['id_annonces']);
    $addVue->execute();

    // Annonces ID

    if (isset($_GET['id_annonces']) && !empty($_GET['id_annonces'])){

        $reqChambre = $database->prepare("SELECT * FROM annonces WHERE statut=:statut AND id_annonces=:id_annonces");
        $reqChambre->bindvalue(":statut", 1);
        $reqChambre->bindvalue(":id_annonces",  $_GET['id_annonces']);
        $reqChambre->execute();

        $dataChambre = $reqChambre->fetch();

        $reqAgentChambre = $database->prepare("SELECT * FROM demarcheurs WHERE email=:email");
        $reqAgentChambre->bindvalue(":email", $dataChambre['email']);
        $reqAgentChambre->execute();

        $dataAgent = $reqAgentChambre->fetch();

        $count = $reqAgentChambre->rowCount();

        ?>
        <main class="main">

            <div class="site-breadcrumb" style="background: url(assets/img/breadcrumb/01.jpg)">
            <div class="container">
            <h2 class="breadcrumb-title">Détail de la chambre</h2>
            <ul class="breadcrumb-menu">
            <li><a href="index.php">Accueil</a></li>
            <li class="active">Détail de la chambre</li>
            </ul>
            </div>
            </div>

            <div class="property-single py-120">
            <div class="container">
            <div class="row">
            <div class="col-lg-8 mb-5">
            <div class="property-single-wrapper">
            <div class="property-single-slider owl-carousel owl-theme">
            <img src="assets/img/property/single-1.jpg" alt>
            <img src="assets/img/property/single-2.jpg" alt>
            <img src="assets/img/property/single-3.jpg" alt>
            <img src="assets/img/property/single-4.jpg" alt>
            </div>
            <div class="property-single-meta">
            <div class="property-single-meta-left">
            <h4><?=$dataChambre['localisation']?></h4>
            <span><?=$dataChambre['mots']?></span>
            </div>
            <div class="property-single-meta-right">
            <div class="property-single-rating-box">
            <h6 class="property-single-price"><?=$dataChambre['prix']?> FCFA</h6>

            </div>
            <div class="property-single-meta-option">
            <a href="#"><i class="far fa-share-alt"></i></a>
            <a href="#" id="printButton"><i class="far fa-print"></i></a>
            <a style="color:white;"><i class="far fa-heart"></i></a>
            <a id="reload" style="color:white;"><i class="far fa-arrows-repeat"></i></a>
            </div>

            <script>
                document.getElementById("printButton").addEventListener("click", function() {
                    window.print(); // Déclenche l'action d'impression
                    
                    // Ou pour simuler la pression des touches Ctrl+P
                    // var keyboardEvent = new KeyboardEvent("keydown", { key: "p", ctrlKey: true });
                    // window.dispatchEvent(keyboardEvent);
                });

                var reloadButton = document.getElementById("reload");

                // Ajoutez un écouteur d'événements au clic du bouton
                reloadButton.addEventListener("click", function() {
                    // Utilisez la méthode reload() pour rafraîchir la page
                    location.reload();
                });


            </script>

            </div>
            </div>
            <div class="property-single-content">
            <h4>Description</h4>
            <div class="property-single-description">
            <p>
                <?=$dataChambre['description']?>
            </p>
            
            </div>
            </div>

            <?php

                $reqComment = $database->prepare("SELECT * FROM commentaire_annonces WHERE annonce_id=:id_annonces");
                $reqComment->bindvalue(":id_annonces", $_GET["id_annonces"]);
                $reqComment->execute();

                $countCommentaire = $reqComment->rowCount();

            ?>

            <div class="property-single-content">
            <h4>Discussions (<?=$countCommentaire?>)</h4>
            <?php

                if ($countCommentaire != 0){
                    while($dataComment = $reqComment->fetch()){
                        ?>
                        <div class="property-single-info">
                        <div class="property-single-comments">
                        <div class="blog-comments mb-0">
                        <div class="blog-comments-wrapper">
                        <div class="blog-comments-single">
                        <div class="blog-comments-img"><img src="assets/img/blog/com-1.jpg" alt="thumb" style="width:40px;height:40px;"></div>
                        <div class="blog-comments-content">
                        <h5><?=$dataComment['nom']?></h5>
                        <span><i class="far fa-clock"></i> <?=$dataComment['date_creation']?></span>
                        <p><?=$dataComment['contenu']?></p>
                        <?php
                            if (isset($_SESSION['email'])){
                                ?>
                                <a href="#"><i class="far fa-reply"></i> Répondre</a>
                                <?php
                            }
                        ?>
                        </div>
                        </div>
                        <div class="blog-comments-single blog-comments-reply">
                        <div class="blog-comments-img"><img src="assets/img/blog/com-2.jpg" alt="thumb"></div>
                        <div class="blog-comments-content">
                        <h5>Daniel Wellman</h5>
                        <span><i class="far fa-clock"></i> 29 August, 2022</span>
                        <p>Laboriosam amet repellat inventore cum? Nulla, in veritatis itaque voluptatibus repellat est omnis voluptates quisquam beatae nostrum molestiae? Consequatur eum laudantium necessitatibus temporibus optio nesciunt ratione repudiandae alias qui sapiente.</p>
                        <a href="#"><i class="far fa-reply"></i> Reply</a>
                        </div>
                        </div>

                        <div class="blog-comments-single" style="visibility:hidden;">
                                            <div class="blog-comments-img"><img src="assets/img/blog/com-3.jpg" alt="thumb"></div>
                                                <div class="blog-comments-content">
                                                    <h5>Kenneth Evans</h5>
                                                    <span><i class="far fa-clock"></i> 29 August, 2022</span>
                                                    <p>There are many variations of passages the majority have
                                                    suffered in some injected humour or randomised words which
                                                    don't look even slightly believable.</p>
                                                    <a href="#"><i class="far fa-reply"></i> Reply</a>
                                                </div>
                                            </div>
                                        </div>
                        <?php
                    }
                }else{
                    ?>
                    <span class="theme-btn">Aucune discussion trouvé</span>
                    <?php
                }

            ?>
            
            <div class="blog-comments-form">
            <h3>Laisser un mot</h3>

            <?php

                if (isset($_POST['comment'])){
                    if (!empty($_POST['comment_name']) && !empty($_POST['comment_email']) && !empty($_POST['comment_commentaire'])){
                        $commentName = strip_tags($_POST['comment_name']);
                        $commentEmail = strip_tags($_POST['comment_email']);
                        $commentCommentaire = strip_tags($_POST['comment_commentaire']);

                        function token_random_string($leng=40){

                            $str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                            $token = '';
                            for ($i=0;$i<$leng;$i++){
                                $token.=$str[rand(0, strlen($str)-1)];
                            }
                            return $token;
                        }
    
                        $token = token_random_string(15);

                        $insertComment = $database->prepare("INSERT INTO commentaire_annonces(contenu, token_comment, annonce_id, email, nom) VALUES(:contenu, :token_comment, :id_annonces, :email, :nom)");
                        $insertComment->bindvalue(":contenu", $commentCommentaire);
                        $insertComment->bindvalue(":id_annonces", $_GET['id_annonces']);
                        $insertComment->bindvalue(":token_comment", $token);
                        $insertComment->bindvalue(":email", $commentEmail);
                        $insertComment->bindvalue(":nom", $commentName);
                        $insertComment->execute();

                        $success = "Votre commentaire a été bien enregistré";

                        if (isset($success)){
                            ?>
                            <script>
                                swal("Bravo", "<?=$success?>", "success")
                            </script>
                            <?php
                        }
                    }
                }

            ?>
            <form method="post">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group review-rating">
                            <label>On vous écoute</label>
                        <div>
                            <i class="far fa-star"></i>
                            <i class="far fa-star"></i>
                            <i class="far fa-star"></i>
                            <i class="far fa-star"></i>
                            <i class="far fa-star"></i>
                        </div>
                    </div>
                </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            <input type="text" class="form-control" placeholder="Nom*" name="comment_name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            <input type="email" class="form-control" placeholder="Email*" name="comment_email">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <textarea class="form-control" rows="5" placeholder="Commentaire*" name="comment_commentaire"></textarea>
                            </div>
                            <button type="submit" class="theme-btn" name="comment">Commenter <i class="far fa-paper-plane"></i></button>
                        </div>
                </div>
            </form>

            </div>

                

            </div>
            </div>
            </div>
            <div class="col-lg-4">
            <div class="property-single-sidebar">
            <div class="property-single-content mt-0">

            <h4>Votre décision</h4>

            

            <div class="property-single-info">
            <div class="booking-btn mt-30">
            <a id="sendWhatsApp" class="theme-btn" data-phone-number="<?=$dataAgent['whatsapp']?>">Je suis interressé <i class="far fa-arrow-right"></i></a>
            </div>

            <script>
                document.getElementById("sendWhatsApp").addEventListener("click", function() {
                    var phoneNumber = this.getAttribute("data-phone-number"); // Récupérer le numéro de téléphone
                    var annonceLink = window.location.href; // Lien de l'annonce actuelle
                    var whatsappMessage = "Je suis intéressé par cette annonce : " + annonceLink;

                    var whatsappURL = "https://api.whatsapp.com/send?phone=" + phoneNumber + "&text=" + encodeURIComponent(whatsappMessage);

                    window.open(whatsappURL, "_blank");
                });
            </script>

            </div>
            </div>
            <div class="property-single-content">
            <h4>Contact de l'agent</h4>
            <div class="property-single-info">
            <div class="property-single-agent">
            <div class="property-single-agent-content">
            <div class="property-single-agent-img">
            <img src="upload/profile/<?=$dataAgent['photo']?>" alt="Photo de profil de l'agent">
            </div>
            <div class="property-single-agent-info">
            <h5><?=ucwords($dataAgent['nom'])?> <?=ucwords($dataAgent['prenoms'])?></h5>
            <ul>
            <li><a href="tel:<?=$dataAgent['telephone']?>"><i class="far fa-phone"></i>Téléphone</a></li>
            <li><a href="mailto:<?=$dataAgent['email']?>"><i class="far fa-envelope"></i><span class="__cf_email__" data-cfemail="d0b9beb6bf90b5a8b1bda0bcb5feb3bfbd"></span>Email</a></li>
            </ul>
            </div>
            </div>

            </div>
            </div>
            </div>

            </div>
            </div>
            </div>
            </div>
            </div>
            </div>
            </div>
            </div>
            

            <?php

                // Parametre de l'annonce actuelle

                $categorie = $dataChambre['categorie'];
                $type = $dataChambre['mots'];
                $id_annonces = $_GET['id_annonces'];

                $reqAnnoncesSimilaires = $database->prepare("SELECT * FROM annonces WHERE mots=:type AND categorie=:categorie AND id_annonces!=:id_annonces ORDER BY id DESC LIMIT 9");
                $reqAnnoncesSimilaires->bindvalue(":type", $type);
                $reqAnnoncesSimilaires->bindvalue(":categorie", $categorie);
                $reqAnnoncesSimilaires->bindvalue(":id_annonces", $id_annonces);
                $reqAnnoncesSimilaires->execute();

            ?>


            <div class="property-listing py-50">
                <div class="container">
                <div class="row">
                <div class="col-lg-6 mx-auto wow fadeInDown" data-wow-duration="1s" data-wow-delay=".25s">
                <div class="site-heading text-center mb-30">
                <span class="site-title-tagline">Annonces Similaires</span>
                <h2 class="site-title">Découvrez les annonnces similaires</h2>
                </div>
                </div>
                </div>
                    <div class="row">
                        <?php

                            while ($dataChambres = $reqAnnoncesSimilaires->fetch()){

                                $reqAgent = $database->prepare("SELECT * FROM demarcheurs WHERE email=:email AND validation=:statut");
                                $reqAgent->bindvalue(":email", $dataChambres['email']);
                                $reqAgent->bindvalue(":statut", 1);
                                $reqAgent->execute();


                                $dataAgent = $reqAgent->fetch();

                                $photoChambre = $dataChambres['photo'];

                                $photoProfile = $dataAgent['photo'];

                                ?>

                                <div class="col-md-6 col-lg-4 ">
                                    <div class="listing-item wow fadeInUp" data-wow-duration="1s" data-wow-delay=".75s">
                                    <span class="listing-badge"><?=$dataChambres['categorie']?></span>
                                    <div class="listing-img">
                                        <img src="upload/location/<?=$photoChambre?>" alt="Photo de la chambre" style="height:228px!important;width:100%;">
                                    </div>
                                    <div class="listing-content">
                                        <h4 class="listing-title"><a href="#"><?=$dataChambres['localisation']?></a></h4>
                                        <p class="listing-sub-title"><?=substr($dataChambres['description'], 0, 100)?> ...</p>
                                        <div class="listing-price">
                                        <div class="listing-price-info">
                                            <p class="listing-price-title">Prix</p>
                                            </div>
                                            <h6 class="listing-price-amount"> <?=$dataChambres['prix']?> F / Mois</h6>
                                        </div>
                                        <div class="listing-bottom">
                                        <div class="listing-author">
                                            <div class="listing-author-img">
                                            <img src="upload/profile/<?=$dataAgent['photo']?>" alt="Profile" style="width:45px;height:45px;">
                                            </div>
                                            <h5><?=$dataAgent['nom']?> <?=ucwords($dataAgent['prenoms'])?></h5>
                                        </div>
                                        <a href="property-single.php?id_annonces=<?=$dataChambres['id_annonces']?>" class="listing-btn">Détails</a>
                                        </div>
                                    </div>
                                    </div>

                                    
                                </div>

                                

                                <?php
                            }

                        ?>
                        <div class="text-center">
                            <!-- Metttre un if pour reguler les categories et savoir les diriger convenablement -->
                            <?php

                                if ($categorie == "Chambres Familiale"){
                                    ?>
                                    <a href="familiales.php" class="theme-btn">Voir plus de Chambres Familiales</a>
                                    <?php
                                }elseif ($categorie == "Autres"){
                                    ?>
                                    <a href="autres.php" class="theme-btn">Voir plus de chambre : Autres</a>
                                    <?php
                                }elseif ($categorie == "Bureau"){
                                    ?>
                                    <a href="conference.php" class="theme-btn">Voir plus de Bureaux</a>
                                    <?php
                                }elseif ($categorie == "Appartement"){
                                    ?>
                                    <a href="appartements.php" class="theme-btn">Voir plus d'Appartements</a>
                                    <?php
                                }elseif ($categorie == "Chambres étudiants"){
                                    ?>
                                    <a href="etudiantes.php" class="theme-btn">Voir plus de Chambres étudiantes</a>
                                    <?php
                                }elseif ($categorie == "Boutique"){
                                    ?>
                                    <a href="boutique.php" class="theme-btn">Voir plus de Boutiques</a>
                                    <?php
                                }

                            ?>
                        </div>
                    </div>
                </div>
                
                </div>
                
                </div>
                
                
                </div>
                
                
            </div>

        </main>
        <?php

    }else{
        ?>
        <script>
            window.location.href="index.php";
        </script>
        <?php
    }

    

?>



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

<!-- Mirrored from live.themewild.com/homfind/property-single.php by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 21 Jun 2023 20:04:50 GMT -->
</html>