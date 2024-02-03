<?php

    require("includes/header.php");

    // Change photo annonces

    // $update = $database->prepare("UPDATE annonces SET photo=:photo");
    // $update->bindvalue(":photo", "03.jpg");
    // $update->execute();

    // echo "Update terminé";


    // Count dun nombre d'annonce par catégorie

    // ----- Chambres Familiale

    $reqFamiliale = $database->prepare("SELECT * FROM annonces WHERE categorie=:categorie AND statut=:statut  AND louer = :louer");
    $reqFamiliale->bindvalue(":categorie", "Chambres Familiale");
    $reqFamiliale->bindvalue(":louer", "non");
    $reqFamiliale->bindvalue(":statut", 1);
    $reqFamiliale->execute();

    $countFamiliale = $reqFamiliale->rowcount();

    // ----- Chambres étudiantes

    $reqEtudiantes = $database->prepare("SELECT * FROM annonces WHERE categorie=:categorie AND statut=:statut AND louer=:louer");
    $reqEtudiantes->bindvalue(":categorie", "Chambres étudiants");
    $reqEtudiantes->bindvalue(":statut", 1);
    $reqEtudiantes->bindvalue(":louer", "non");
    $reqEtudiantes->execute();

    $countEtudiantes = $reqEtudiantes->rowcount();

    // ----- Boutique

    $reqBoutique = $database->prepare("SELECT * FROM annonces WHERE categorie=:categorie AND louer=:louer AND statut=:statut");
    $reqBoutique->bindvalue(":louer", "non");
    $reqBoutique->bindvalue(":categorie", "Boutique");
    $reqBoutique->bindvalue(":statut", 1);
    $reqBoutique->execute();

    $countBoutique = $reqBoutique->rowcount();

    // ----- Appartement

    $reqAppartement = $database->prepare("SELECT * FROM annonces WHERE categorie=:categorie AND statut=:statut AND louer=:louer");
    $reqAppartement->bindvalue(":categorie", "Appartement");
    $reqAppartement->bindvalue(":louer", "non");
    $reqAppartement->bindvalue(":statut", 1);
    $reqAppartement->execute();

    $countAppartement = $reqAppartement->rowcount();

    // ----- Bureau

    $reqConference = $database->prepare("SELECT * FROM annonces WHERE categorie=:categorie AND statut=:statut AND louer=:louer");
    $reqConference->bindvalue(":categorie", "Bureau");
    $reqConference->bindvalue(":louer", "non");
    $reqConference->bindvalue(":statut", 1);
    $reqConference->execute();

    $countConference = $reqConference->rowcount();

    // ----- Autres

    $reqAutres = $database->prepare("SELECT * FROM annonces WHERE categorie=:categorie AND statut=:statut AND louer=:louer");
    $reqAutres->bindvalue(":louer", "non");
    $reqAutres->bindvalue(":categorie", "Autres");
    $reqAutres->bindvalue(":statut", 1);
    $reqAutres->execute();

    $countAutres = $reqAutres->rowcount();

?>

<main class="main">

<div class="category-area py-120">
    <div class="container">
    <div class="row">
    <div class="col-lg-6 mx-auto wow fadeInDown" data-wow-duration="1s" data-wow-delay=".25s">
    <div class="site-heading text-center">
    <span class="site-title-tagline">Catégories</span>
    <h2 class="site-title">Choisissez votre catégorie</h2>
    </div>
    </div>
    </div>
    <div class="row">
    <div class="col-6 col-md-4 col-lg-2">
    <div class="category-item wow fadeInUp" data-wow-duration="1s" data-wow-delay=".25s">
    <a href="familiales.php">
    <div class="category-icon">
    <i class="flaticon-apartment"></i>
    </div>
    <div class="category-content">
    <h4 class="category-title">Chambres familiales</h4>
    <span class="category-property"><?=$countFamiliale?></span>
    </div>
    </a>
    </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
    <div class="category-item wow fadeInUp" data-wow-duration="1s" data-wow-delay=".50s">
    <a href="etudiantes.php">
    <div class="category-icon">
    <i class="flaticon-business-and-trade"></i>
    </div>
    <div class="category-content">
    <h4 class="category-title">Chambres étudiants / personnelles</h4>
    <span class="category-property"><?=$countEtudiantes?></span>
    </div>
    </a>
    </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
    <div class="category-item wow fadeInUp" data-wow-duration="1s" data-wow-delay=".75s">
    <a href="boutique.php">
    <div class="category-icon">
    <i class="flaticon-home"></i>
    </div>
    <div class="category-content">
    <h4 class="category-title">Boutiques</h4>
    <span class="category-property"><?=$countBoutique?></span>
    </div>
    </a>
    </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
    <div class="category-item wow fadeInUp" data-wow-duration="1s" data-wow-delay="1s">
    <a href="appartements.php">
    <div class="category-icon">
    <i class="flaticon-villa"></i>
    </div>
    <div class="category-content">
    <h4 class="category-title">Appartements</h4>
    <span class="category-property"><?=$countAppartement?></span>
    </div>
    </a>
    </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
    <div class="category-item wow fadeInUp" data-wow-duration="1s" data-wow-delay="1.25s">
    <a href="conference.php">
    <div class="category-icon">
    <i class="flaticon-living-room"></i>
    </div>
    <div class="category-content">
    <h4 class="category-title">Bureaux</h4>
    <span class="category-property"><?=$countAppartement?></span>
    </div>
    </a>
    </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
    <div class="category-item wow fadeInUp" data-wow-duration="1s" data-wow-delay="1.50s">
    <a href="autres.php">
    <div class="category-icon">
    <i class="flaticon-houses"></i>
    </div>
    <div class="category-content">
    <h4 class="category-title">Autres</h4>
    <span class="category-property"><?=$countAutres?></span>
    </div>
    </a>
    </div>
    </div>
    </div>
    </div>
</div>

    <?php

        $reqChambres = $database->prepare("SELECT * FROM annonces WHERE statut=:statut AND louer=:louer ORDER BY id DESC LIMIT 9");
        $reqChambres->bindvalue(":statut", 1);
        $reqChambres->bindvalue(":louer", "non");
        $reqChambres->execute();

    ?>


    <div class="property-listing py-50">
        <div class="container">
        <div class="row">
        <div class="col-lg-6 mx-auto wow fadeInDown" data-wow-duration="1s" data-wow-delay=".25s">
        <div class="site-heading text-center mb-30">
        <span class="site-title-tagline">Découvrez nos locations immobilière</span>
        <h2 class="site-title">Plongez dans le confort</h2>
        </div>
        </div>
        </div>
            <div class="row">
                <?php

                    while ($dataChambres = $reqChambres->fetch()){

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
                                    <h5><a href="agent-single.php?agent=<?=$dataAgent['email']?>"><?=$dataAgent['nom']?> <?=ucwords($dataAgent['prenoms'])?></a></h5>
                                </div>
                                <a href="property-single.php?id_annonces=<?=$dataChambres['id_annonces']?>" class="listing-btn">Détails</a>
                                </div>
                            </div>
                            </div>
                        </div>

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
<div class="video-area pb-120">
<div class="container-fluid px-0">
<div class="video-content" style="background-image: url(assets/img/video/01.jpg);">
<div class="row align-items-center">
<div class="col-lg-12">
<div class="video-wrapper">
<a class="play-btn popup-youtube" href="https://youtu.be/UCGCGpdFIuw">
<i class="fas fa-play"></i>
</a>
</div>
</div>
</div>
</div>
</div>
</div>


<!-- <div class="location-area pb-120">
<div class="container">
<div class="row">
<div class="col-lg-6 mx-auto wow fadeInDown" data-wow-duration="1s" data-wow-delay=".25s">
<div class="site-heading text-center">
<span class="site-title-tagline">Localisation</span>
<h2 class="site-title">Choisir une ville</h2>
</div>
</div>
</div>
<div class="row align-items-center">
<div class="col-md-12 col-lg-6">
<div class="location-item wow fadeInUp" data-wow-duration="1s" data-wow-delay=".25s">
<div class="location-img">
<img src="assets/img/location/01.jpg" alt>
</div>
<div class="location-info">
<h3>Cotonou</h3>
<span>56 Chambres</span>
</div>
<a href="list-chambre.php" class="location-btn"><i class="far fa-arrow-right"></i></a>
</div>
</div>
<div class="col-md-6 col-lg-3">
<div class="location-item wow fadeInUp" data-wow-duration="1s" data-wow-delay=".50s">
<div class="location-img">
<img src="assets/img/location/02.jpg" alt>
</div>
<div class="location-info">
<h3>Abomey-Calavi</h3>
<span>25 Chambres</span>
</div>
<a href="list-chambre.php" class="location-btn"><i class="far fa-arrow-right"></i></a>
</div>
</div>
<div class="col-md-6 col-lg-3">
<div class="location-item wow fadeInUp" data-wow-duration="1s" data-wow-delay=".75s">
<div class="location-img">
<img src="assets/img/location/03.jpg" alt>
</div>
<div class="location-info">
<h3>Porto-Novo</h3>
<span>30 Chambres</span>
</div>
<a href="list-chambre.php" class="location-btn"><i class="far fa-arrow-right"></i></a>
</div>
</div>
<div class="col-md-6 col-lg-3">
<div class="location-item wow fadeInUp" data-wow-duration="1s" data-wow-delay=".25s">
<div class="location-img">
<img src="assets/img/location/04.jpg" alt>
</div>
<div class="location-info">
<h3>Natitingou</h3>
<span>35 Chambres</span>
</div>
<a href="list-chambre.php" class="location-btn"><i class="far fa-arrow-right"></i></a>
</div>
</div>
<div class="col-md-6 col-lg-3">
<div class="location-item wow fadeInUp" data-wow-duration="1s" data-wow-delay=".50s">
<div class="location-img">
<img src="assets/img/location/05.jpg" alt>
</div>
<div class="location-info">
<h3>Abomey</h3>
<span>28 Chambres</span>
</div>
<a href="list-chambre.php" class="location-btn"><i class="far fa-arrow-right"></i></a>
</div>
</div>
<div class="col-md-12 col-lg-6">
<div class="location-item wow fadeInUp" data-wow-duration="1s" data-wow-delay=".75s">
<div class="location-img">
<img src="assets/img/location/06.jpg" alt>
</div>
<div class="location-info">
<h3>Parakou</h3>
<span>50 Chambres</span>
</div>
<a href="list-chambre.php" class="location-btn"><i class="far fa-arrow-right"></i></a>
</div>
</div>
</div>
</div>
</div> -->


<div class="choose-area bg pt-70 pb-70">
<div class="container">
<div class="row">
<div class="col-lg-6 mx-auto wow fadeInDown" data-wow-duration="1s" data-wow-delay=".25s">
<div class="site-heading text-center">
<span class="site-title-tagline">ConfortHouse</span>
<h2 class="site-title">Pourquoi nous choisir</h2>
</div>
</div>
</div>
<div class="choose-wrapper">
<div class="row justify-content-center">
<div class="col-md-6 col-lg-4">
<div class="choose-item wow fadeInUp" data-wow-duration="1s" data-wow-delay=".25s">
<div class="choose-icon">
<i class="flaticon-discord"></i>
</div>
<h4 class="choose-title">Large sélection de chambres</h4>
<p>Découvrez une vaste sélection de chambres à louer, soigneusement publiées par nos agents immobiliers partenaires, pour trouver celle qui correspond parfaitement à vos besoins.</p>
</div>
</div>
<div class="col-md-6 col-lg-4">
<div class="choose-item wow fadeInUp" data-wow-duration="1s" data-wow-delay=".50s">
<div class="choose-icon">
<i class="flaticon-calculator"></i>
</div>
<h4 class="choose-title">Confiance et professionnalisme</h4>
<p>Nous travaillons avec des agents immobiliers professionnels et dignes de confiance qui s'engagent à vous offrir des chambres de qualité, pour une expérience de location en toute tranquillité.</p>
</div>
</div>
<div class="col-md-6 col-lg-4">
<div class="choose-item wow fadeInUp" data-wow-duration="1s" data-wow-delay=".75s">
<div class="choose-icon">
<i class="flaticon-house"></i>
</div>
<h4 class="choose-title">Facilité de recherche</h4>
<p>Naviguez facilement à travers nos annonces de chambres à louer, triez-les selon vos critères et trouvez rapidement celle qui répond à vos préférences, grâce à notre interface conviviale.</p>
</div>
</div>
</div>
</div>
</div>
</div>


<!-- Agents place -->


<div class="testimonial-area py-120">
<div class="container">
<div class="row">
<div class="col-lg-6 mx-auto wow fadeInDown" data-wow-duration="1s" data-wow-delay=".25s">
<div class="site-heading text-center">
<span class="site-title-tagline">Témoignages</span>
<h2 class="site-title text-white">Ce que nos clients disent</h2>
</div>
</div>
</div>
<div class="testimonial-slider owl-carousel owl-theme">
<div class="testimonial-single">
<div class="testimonial-content">
<div class="testimonial-author-img">
<img src="assets/img/testimonial/user.jpg" alt>
</div>
<div class="testimonial-author-info">
<h4>Awa Sow</h4>
<p>Cliente</p>
</div>
</div>
<div class="testimonial-quote">
<p>
    J'ai été agréablement surpris par la variété des chambres disponibles sur ce site. J'ai pu trouver une chambre confortable dans un quartier idéal grâce à leurs nombreuses options.
</p>
<div class="testimonial-quote-icon">
<img src="assets/img/icon/quote.svg" alt>
</div>
</div>
<div class="testimonial-rate">
<i class="fas fa-star"></i>
<i class="fas fa-star"></i>
<i class="fas fa-star"></i>
<i class="fas fa-star"></i>
<i class="fas fa-star"></i>
</div>
</div>
<div class="testimonial-single">
<div class="testimonial-content">
<div class="testimonial-author-img">
<img src="assets/img/testimonial/user.jpg" alt>
</div>
<div class="testimonial-author-info">
<h4>Ayanda Nkosi</h4>
<p>Cliente</p>
</div>
</div>
<div class="testimonial-quote">
<p>
    Ce site est devenu ma référence pour la recherche de chambres à louer. Les témoignages positifs ne mentent pas, c'est une plateforme fiable et pratique.
</p>
<div class="testimonial-quote-icon">
<img src="assets/img/icon/quote.svg" alt>
</div>
</div>
<div class="testimonial-rate">
<i class="fas fa-star"></i>
<i class="fas fa-star"></i>
<i class="fas fa-star"></i>
<i class="fas fa-star"></i>
<i class="fas fa-star"></i>
</div>
</div>
<div class="testimonial-single">
<div class="testimonial-content">
<div class="testimonial-author-img">
<img src="assets/img/testimonial/user.jpg" alt>
</div>
<div class="testimonial-author-info">
<h4>Nia Johnson</h4>
<p>Client</p>
</div>
</div>
<div class="testimonial-quote">
<p>
    Je recommande chaudement ce site pour trouver une chambre à louer. Les agents immobiliers sont compétents et les options de filtrage facilitent la recherche.
</p>
<div class="testimonial-quote-icon">
<img src="assets/img/icon/quote.svg" alt>
</div>
</div>
<div class="testimonial-rate">
<i class="fas fa-star"></i>
<i class="fas fa-star"></i>
<i class="fas fa-star"></i>
<i class="fas fa-star"></i>
<i class="fas fa-star"></i>
</div>
</div>
<div class="testimonial-single">
<div class="testimonial-content">
<div class="testimonial-author-img">
<img src="assets/img/testimonial/user.jpg" alt>
</div>
<div class="testimonial-author-info">
<h4>Adjovi Dossou</h4>
<p>Client</p>
</div>
</div>
<div class="testimonial-quote">
<p>
    J'ai loué un bureau via ce site et j'ai été impressionné par le niveau de service. L'agent immobilier a été très professionnel et le bureau était exactement comme décrit.
</p>
<div class="testimonial-quote-icon">
<img src="assets/img/icon/quote.svg" alt>
</div>
</div>
<div class="testimonial-rate">
<i class="fas fa-star"></i>
<i class="fas fa-star"></i>
<i class="fas fa-star"></i>
<i class="fas fa-star"></i>
<i class="fas fa-star"></i>
</div>
</div>
<div class="testimonial-single">
<div class="testimonial-content">
<div class="testimonial-author-img">
<img src="assets/img/testimonial/user.jpg" alt>
</div>
<div class="testimonial-author-info">
<h4>Kossi Améyo</h4>
<p>Client</p>
</div>
</div>
<div class="testimonial-quote">
<p>
    La recherche d'une chambre à louer n'a jamais été aussi facile. J'ai rapidement trouvé une chambre qui correspondait à mes besoins et l'agent a été très réactif. Merci !
</p>
<div class="testimonial-quote-icon">
<img src="assets/img/icon/quote.svg" alt>
</div>
</div>
<div class="testimonial-rate">
<i class="fas fa-star"></i>
<i class="fas fa-star"></i>
<i class="fas fa-star"></i>
<i class="fas fa-star"></i>
<i class="fas fa-star"></i>
</div>
</div>
</div>
</div>
</div>




<div class="cta-area">
<div class="container">
<div class="row">
<div class="col-lg-7 mx-auto text-center">
<div class="cta-text">
<h1>Nous sommes là pour vous</h1>
<p>N'hésitez pas à nous contacter pour toute question, demande d'information ou pour discuter de vos besoins spécifiques en matière de location immobilière. Notre équipe est disponible pour répondre à toutes vos demandes avec diligence et vous offrir une assistance personnalisée. </p>
</div>
<a href="contact.php" class="theme-btn mt-30">Contactez nous <i class="far fa-arrow-right"></i></a>
</div>
</div>
</div>
</div>


<div class="blog-area py-120">

    <?php

        $reqArticle = $database->prepare("SELECT * FROM blog WHERE statut=:statut ORDER BY id DESC LIMIT 0, 3");
        $reqArticle->bindvalue(":statut", 1);
        $reqArticle->execute();

        $countArticle = $reqArticle->rowCount();

    ?>

<div class="container">
<div class="row">
<div class="col-lg-6 mx-auto wow fadeInDown" data-wow-duration="1s" data-wow-delay=".25s">
<div class="site-heading text-center">
<span class="site-title-tagline">Notre Blog</span>
<h2 class="site-title">Nos récentes informations</h2>
</div>
</div>
</div>
<div class="row">
    <?php

        if ($countArticle){
            while ($dataArticle = $reqArticle->fetch()) {
                $photo = $dataArticle['image'];
                ?>
                <div class="col-md-6 col-lg-4">
                    <div class="blog-item wow fadeInUp" data-wow-duration="1s" data-wow-delay=".25s">
                        <div class="blog-item-img">
                            <img src="upload/Blog/<?=$photo?>" alt="Thumb">
                        </div>
                        <div class="blog-item-info">
                            <h4 class="blog-title">
                            <a href="#"><?=$dataArticle['titre']?></a>
                            </h4>
                            <div class="blog-item-meta">
                            <ul>
                            <li><a href="#"><i class="far fa-user-circle"></i> By ConfortHouse</a></li>
                            <li><a href="#"><i class="far fa-calendar-alt"></i> <?=$dataArticle['date'][8] . $dataArticle['date'][9] . $dataArticle['date'][7] . $dataArticle['date'][5] . $dataArticle['date'][6] . $dataArticle['date'][4] . $dataArticle['date'][0] . $dataArticle['date'][1] . $dataArticle['date'][2] . $dataArticle['date'][3]?></a></li>
                            </ul>
                        </div>
                        <p>
                            <?=substr($dataArticle['texte'], 0, 100)?> ....
                            
                        </p>
                        <a class="theme-btn" href="blog-single.php?id=<?=$dataArticle['id_article']?>">LIre plus<i class="far fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <?php
    
            }
        }else{
            #........
        }

    ?>




</div>
</div>
</div>

</main>

<?php
    require("includes/footer.php")
?>