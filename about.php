<?php

    require("includes/header.php");

?>

<main class="main">

<div class="site-breadcrumb" style="background: url(assets/img/breadcrumb/01.jpg)">
<div class="container">
<h2 class="breadcrumb-title">A propos</h2>
<ul class="breadcrumb-menu">
<li><a href="index.php">Accueil</a></li>
<li class="active">A propos de nous</li>
</ul>
</div>
</div>

<div class="about-area py-120 mb-30">
<div class="container">
<div class="row align-items-center">
<div class="col-lg-6">
<div class="about-left wow fadeInLeft" data-wow-duration="1s" data-wow-delay=".25s">
<div class="about-img">
<img src="assets/img/about/01.jpg" alt>
</div>
<div class="about-experience">
<h1>25 <span>+</span></h1>
<span class="about-experience-text">ans d'expérience</span>
</div>
<div class="about-shape">
<img src="assets/img/shape/01.svg" alt>
</div>
</div>
</div>
<div class="col-lg-6">
<div class="about-right wow fadeInUp" data-wow-duration="1s" data-wow-delay=".25s">
<div class="site-heading mb-3">
<span class="site-title-tagline">A propos de nous</span>
<h2 class="site-title">
    Notre engagement envers votre satisfaction et confort
</h2>
</div>
<p class="about-text">La liberté, le confort et le plaisir de se loger formidablement reste l'une des priorités de notre existence et pour lesquelles nous nous battons. Vous trouverez à coup sûr la chambre ou la boutique ou l'appartement ou le bureau ou autres locations immobilières que vous cherchez sur notre plateforme communautaire.</p>
<div class="about-list-wrapper">
<ul class="about-list list-unstyled">
<li>
<div class="about-icon"><span class="fas fa-check-circle"></span></div>
<div class="about-list-text">
<p>Large choix de location répondant à vos besoins spécifiques.</p>
</div>
</li>
<li>
<div class="about-icon"><span class="fas fa-check-circle"></span></div>
<div class="about-list-text">
<p>Assistance professionnelle pour vous accompagner à chaque étape de la location.</p>
</div>
</li>
<li>
<div class="about-icon"><span class="fas fa-check-circle"></span></div>
<div class="about-list-text">
<p>Engagement envers la qualité, le confort et la tranquillité d'esprit de nos clients.</p>
</div>
</li>
</ul>
</div>
<div class="about-bottom">
<a href="contact.php" class="theme-btn">Contact <i class="far fa-arrow-right"></i></a>
<div class="about-call">
<div class="about-call-icon">
<i class="fal fa-user-headset"></i>
</div>
<div class="about-call-content">
<span>Appelez nous</span>
<h5 class="about-call-number"><a href="tel:+22998741437">+229 98 74 14 37</a></h5>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>


<div class="counter-area mt-0">
<div class="container">
<div class="counter-wrapper">
<div class="row">
<div class="col-lg-3 col-sm-6">
<div class="counter-box">
    <?php

        $reqAnnoncesNonLouer = $database->prepare("SELECT * FROM annonces");
        $reqAnnoncesNonLouer->execute();

        $countAnnoncesNonLouer = $reqAnnoncesNonLouer->rowCount();

        $reqAnnoncesLouer = $database->prepare("SELECT * FROM annonces_louer");
        $reqAnnoncesLouer->execute();

        $countAnnoncesLouer = $reqAnnoncesLouer->rowCount();

        $nbreLocation = $countAnnoncesLouer + $countAnnoncesNonLouer;

        // Nbre Agent

        $reqAgentImmobilier = $database->prepare("SELECT * FROM demarcheurs");
        $reqAgentImmobilier->execute();

        $countAgentImmobilier = $reqAgentImmobilier->rowCount();

    ?>
<div class="icon">
<i class="fal fa-home"></i>
</div>
<div>
<span class="counter" data-count="+" data-to="<?=$nbreLocation?>" data-speed="3000"><?=$nbreLocation?></span>
<h6 class="title">+ location</h6>
</div>
</div>
</div>
<div class="col-lg-3 col-sm-6">
<div class="counter-box">
<div class="icon">
<i class="fal fa-smile"></i>
</div>
<div>
<span class="counter" data-count="+" data-to="500" data-speed="3000">500</span>
<h6 class="title">+ Clients heureux</h6>
</div>
</div>
</div>
<div class="col-lg-3 col-sm-6">
<div class="counter-box">
<div class="icon">
<i class="fal fa-user-tie"></i>
</div>
<div>
<span class="counter" data-count="+" data-to="<?=$countAgentImmobilier?>" data-speed="3000"><?=$countAgentImmobilier?></span>
<h6 class="title">+ Agents expert</h6>
</div>
</div>
</div>
<div class="col-lg-3 col-sm-6">
<div class="counter-box">
<div class="icon">
<i class="fal fa-award"></i>
</div>
<div>
<span class="counter" data-count="+" data-to="50" data-speed="3000">50</span>
<h6 class="title">+ Certificats</h6>
</div>
</div>
</div>
</div>
</div>
</div>
</div>

<div class="service-area py-120">
    <div class="container">
    <div class="row">
        <div class="site-heading text-center">
            <span class="site-title-tagline">Services</span>
            <h2 class="site-title">Nos services</h2>
            </div>
    <div class="col-md-6 col-lg-4">
    <div class="service-item wow fadeInUp" data-wow-duration="1s" data-wow-delay=".25s">
    <div class="service-icon">
    <i class="flaticon-ruler"></i>
    </div>
    <div class="service-content">
    <h3 class="service-title">
    <a href="#">Choix simplifié</a>
    </h3>
    <p class="service-text">
        Trouvez la location idéale en un clin d'œil grâce à une sélection simplifiée et personnalisée.
    </p>
    <div class="service-arrow">
    <a href="#"><i class="far fa-arrow-right"></i></a>
    </div>
    </div>
    </div>
    </div>
    <div class="col-md-6 col-lg-4">
    <div class="service-item wow fadeInUp" data-wow-duration="1s" data-wow-delay=".50s">
    <div class="service-icon">
    <i class="flaticon-house"></i>
    </div>
    <div class="service-content">
    <h3 class="service-title">
    <a href="#">Large choix</a>
    </h3>
    <p class="service-text">
        Découvrez une large gamme de locations disponibles répondant à différents besoins et budgets.
    </p>
    <div class="service-arrow">
    <a href="#"><i class="far fa-arrow-right"></i></a>
    </div>
    </div>
    </div>
    </div>
    <div class="col-md-6 col-lg-4">
    <div class="service-item wow fadeInUp" data-wow-duration="1s" data-wow-delay=".75s">
    <div class="service-icon">
    <i class="flaticon-maps"></i>
    </div>
    <div class="service-content">
    <h3 class="service-title">
    <a href="#">Assistance 24/7</a>
    </h3>
    <p class="service-text">
        Notre équipe d'assistance est disponible 24 heures sur 24, 7 jours sur 7, pour répondre à tous vos besoins et questions.
    </p>
    <div class="service-arrow">
    <a href="#"><i class="far fa-arrow-right"></i></a>
    </div>
    </div>
    </div>
    </div>
    <div class="col-md-6 col-lg-4">
    <div class="service-item wow fadeInUp" data-wow-duration="1s" data-wow-delay=".25s">
    <div class="service-icon">
    <i class="flaticon-street-view"></i>
    </div>
    <div class="service-content">
    <h3 class="service-title">
    <a href="#">Locations confortables</a>
    </h3>
    <p class="service-text">
        Profitez d'un séjour agréable dans nos locations immobilières confortables équipées de commodités modernes et d'un design accueillant.
    </p>
    <div class="service-arrow">
    <a href="#"><i class="far fa-arrow-right"></i></a>
    </div>
    </div>
    </div>
    </div>
    <div class="col-md-6 col-lg-4">
    <div class="service-item wow fadeInUp" data-wow-duration="1s" data-wow-delay=".50s">
    <div class="service-icon">
    <i class="flaticon-map"></i>
    </div>
    <div class="service-content">
    <h3 class="service-title">
    <a href="#">Localisation idéale</a>
    </h3>
    <p class="service-text">
        Nos locations sont situées dans des emplacements stratégiques, offrant un accès facile aux attractions touristiques et aux transports.
    </p>
    <div class="service-arrow">
    <a href="#"><i class="far fa-arrow-right"></i></a>
    </div>
    </div>
    </div>
    </div>
    <div class="col-md-6 col-lg-4">
    <div class="service-item wow fadeInUp" data-wow-duration="1s" data-wow-delay=".75s">
    <div class="service-icon">
    <i class="flaticon-browser"></i>
    </div>
    <div class="service-content">
    <h3 class="service-title">
    <a href="#">Expérience de qualité</a>
    </h3>
    <p class="service-text">
        Bénéficiez d'une expérience de location immobilière de qualité supérieure avec un service personnalisé et une attention aux détails.
    </p>
    <div class="service-arrow">
    <a href="#"><i class="far fa-arrow-right"></i></a>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>


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
    <h4 class="choose-title">Large sélection de locations</h4>
    <p>Découvrez une vaste sélection de locations à louer, soigneusement publiées par nos agents immobiliers partenaires, pour trouver celle qui correspond parfaitement à vos besoins.</p>
    </div>
    </div>
    <div class="col-md-6 col-lg-4">
    <div class="choose-item wow fadeInUp" data-wow-duration="1s" data-wow-delay=".50s">
    <div class="choose-icon">
    <i class="flaticon-calculator"></i>
    </div>
    <h4 class="choose-title">Confiance et professionnalisme</h4>
    <p>Nous travaillons avec des agents immobiliers professionnels et dignes de confiance qui s'engagent à vous offrir des locations immobilière de qualité, pour une expérience de location en toute tranquillité.</p>
    </div>
    </div>
    <div class="col-md-6 col-lg-4">
    <div class="choose-item wow fadeInUp" data-wow-duration="1s" data-wow-delay=".75s">
    <div class="choose-icon">
    <i class="flaticon-house"></i>
    </div>
    <h4 class="choose-title">Facilité de recherche</h4>
    <p>Naviguez facilement à travers nos annonces de locations à louer, triez-les selon vos critères et trouvez rapidement celle qui répond à vos préférences, grâce à notre interface conviviale.</p>
    </div>
    </div>
    </div>
    </div>
    </div>
</div>


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


<!-- <div class="team-area py-120">
<div class="container">
<div class="row">
<div class="col-lg-6 mx-auto wow fadeInDown" data-wow-duration="1s" data-wow-delay=".25s">
<div class="site-heading text-center">
<span class="site-title-tagline">Notre équipe</span>
<h2 class="site-title">Les membres de notre équipe</h2>
</div>
</div>
</div>
<div class="row">
<div class="col-md-6 col-lg-3">
<div class="team-item wow fadeInUp" data-wow-duration="1s" data-wow-delay=".25s">
<div class="team-img">
<img src="assets/img/team/01.jpg" alt="thumb">
</div>
<div class="team-content">
<div class="team-bio">
<h5><a href="#">Edna Craig</a></h5>
<span>CEO</span>
</div>
<div class="team-social">
<ul class="team-social-btn">
<li><span><i class="far fa-share-alt"></i></span></li>
<li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
<li><a href="#"><i class="fab fa-twitter"></i></a></li>
<li><a href="#"><i class="fab fa-instagram"></i></a></li>
<li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
</ul>
</div>
</div>
</div>
</div>
<div class="col-md-6 col-lg-3">
<div class="team-item wow fadeInUp" data-wow-duration="1s" data-wow-delay=".50s">
<div class="team-img">
<img src="assets/img/team/02.jpg" alt="thumb">
</div>
<div class="team-content">
<div class="team-bio">
<h5><a href="#">Jeffrey Cox</a></h5>
<span>Dev</span>
</div>
<div class="team-social">
<ul class="team-social-btn">
<li><span><i class="far fa-share-alt"></i></span></li>
<li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
<li><a href="#"><i class="fab fa-twitter"></i></a></li>
<li><a href="#"><i class="fab fa-instagram"></i></a></li>
<li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
</ul>
</div>
</div>
</div>
</div>
<div class="col-md-6 col-lg-3">
<div class="team-item wow fadeInUp" data-wow-duration="1s" data-wow-delay=".75s">
<div class="team-img">
<img src="assets/img/team/03.jpg" alt="thumb">
</div>
<div class="team-content">
<div class="team-bio">
<h5><a href="#">Audrey Gadis</a></h5>
<span>Agent</span>
</div>
<div class="team-social">
<ul class="team-social-btn">
<li><span><i class="far fa-share-alt"></i></span></li>
<li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
<li><a href="#"><i class="fab fa-twitter"></i></a></li>
<li><a href="#"><i class="fab fa-instagram"></i></a></li>
<li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
</ul>
</div>
</div>
</div>
</div>
<div class="col-md-6 col-lg-3">
<div class="team-item wow fadeInUp" data-wow-duration="1s" data-wow-delay="1s">
<div class="team-img">
<img src="assets/img/team/04.jpg" alt="thumb">
</div>
<div class="team-content">
<div class="team-bio">
<h5><a href="#">Rodger Garza</a></h5>
<span>Agent</span>
</div>
<div class="team-social">
<ul class="team-social-btn">
<li><span><i class="far fa-share-alt"></i></span></li>
<li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
<li><a href="#"><i class="fab fa-twitter"></i></a></li>
<li><a href="#"><i class="fab fa-instagram"></i></a></li>
<li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
</ul>
</div>
</div>
</div>
</div>
</div>
</div>
</div> -->


<div class="partner-area bg pt-50 pb-50">
<div class="container">
<div class="partner-wrapper partner-slider owl-carousel owl-theme">
<img src="assets/img/partner/01.png" alt="thumb">
<img src="assets/img/partner/02.png" alt="thumb">
<img src="assets/img/partner/03.png" alt="thumb">
<img src="assets/img/partner/04.png" alt="thumb">
<img src="assets/img/partner/01.png" alt="thumb">
<img src="assets/img/partner/02.png" alt="thumb">
<img src="assets/img/partner/03.png" alt="thumb">
</div>
</div>
</div>

</main>

<?php
    require("includes/footer.php");
?>