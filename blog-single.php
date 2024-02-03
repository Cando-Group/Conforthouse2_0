<?php

    require('includes/header.php');

    $reqArticleBlog = $database->prepare("SELECT * FROM blog WHERE id_article=:id AND statut=:statut");
    $reqArticleBlog->bindvalue(":id", $_GET['id']);
    $reqArticleBlog->bindvalue(":statut", 1);
    $reqArticleBlog->execute();

    $dataTitre = $reqArticleBlog->fetch();


?>

<main class="main">

<div class="site-breadcrumb" style="background: url(assets/img/breadcrumb/01.jpg)">
<div class="container">
<h2 class="breadcrumb-title">Blog Détail</h2>
<ul class="breadcrumb-menu">
<li><a href="index.php">Accueil</a></li>
<li class="active"><?=$dataTitre['titre']?></li>
</ul>
</div>
</div>

<div class="blog-single-area pt-120 pb-120">
<div class="container">
<div class="row">
<div class="col-lg-8">
<div class="blog-single-wrapper">
<div class="blog-single-content">
<div class="blog-thumb-img">
<img src="assets/img/blog/single.jpg" alt="thumb">
</div>
<div class="blog-info">
<div class="blog-meta">
<div class="blog-meta-left">
<ul>
<li><i class="far fa-user"></i><a href="#">Jean R Gunter</a></li>
<li><i class="far fa-comments"></i>3.2k Comments</li>
<li><i class="far fa-thumbs-up"></i>1.4k Like</li>
</ul>
</div>
<div class="blog-meta-right">
<a href="#" class="share-btn"><i class="far fa-share-alt"></i>Share</a>
</div>
</div>
<div class="blog-details">
<h3 class="blog-details-title mb-20">It is a long established fact that a reader</h3>
<p class="mb-10">
Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.
</p>
<p class="mb-10">
But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful.
</p>
<blockquote class="blockqoute">
It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution.
<h6 class="blockqoute-author">Mark Crawford</h6>
</blockquote>
<p class="mb-20">
In a free hour when our power of choice is untrammelled and when nothing prevents our being able to do what we like best, every pleasure is to be welcomed and every pain avoided. But in certain circumstances and owing to the claims of duty or the obligations of business it will frequently occur that pleasures have to be repudiated and annoyances accepted. The wise man therefore always holds in these matters to this principle of selection.
</p>
<div class="row">
<div class="col-md-6 mb-20">
<img src="assets/img/blog/01.jpg" alt>
</div>
<div class="col-md-6 mb-20">
<img src="assets/img/blog/02.jpg" alt>
</div>
</div>
<p class="mb-20">
Power of choice is untrammelled and when nothing prevents our being able to do what we like best, every pleasure is to be welcomed and every pain avoided. But in certain circumstances and owing to the claims of duty or the obligations of business it will frequently occur that pleasures have to be repudiated and annoyances accepted. The wise man therefore always holds in these matters to this principle of selection.
</p>
<hr>
<div class="blog-details-tags pb-20">
<h5>Tags : </h5>
<ul>
<li><a href="#">Real Estate</a></li>
<li><a href="#">Business</a></li>
<li><a href="#">Apartment</a></li>
</ul>
</div>
</div>
<div class="blog-author">
<div class="blog-author-img">
<img src="assets/img/blog/author.jpg" alt>
</div>
<div class="author-info">
<h6>Author</h6>
<h3 class="author-name">Roger D Duque</h3>
<p>It is a long established fact that a reader will be distracted by the abcd readable content of a page when looking at its layout that more less.</p>
<div class="author-social">
<a href="#"><i class="fab fa-facebook-f"></i></a>
<a href="#"><i class="fab fa-twitter"></i></a>
<a href="#"><i class="fab fa-instagram"></i></a>
<a href="#"><i class="fab fa-whatsapp"></i></a>
</div>
</div>
</div>
</div>
<div class="blog-comments">
<h3>Comments (20)</h3>
<div class="blog-comments-wrapper">
<div class="blog-comments-single">
<div class="blog-comments-img"><img src="assets/img/blog/com-1.jpg" alt="thumb"></div>
<div class="blog-comments-content">
<h5>Jesse Sinkler</h5>
<span><i class="far fa-clock"></i> 12 May, 2023</span>
<p>There are many variations of passages the majority have suffered in some injected humour or randomised words which don't look even slightly believable.</p>
<a href="#"><i class="far fa-reply"></i> Reply</a>
</div>
</div>
<div class="blog-comments-single blog-comments-reply">
<div class="blog-comments-img"><img src="assets/img/blog/com-2.jpg" alt="thumb"></div>
<div class="blog-comments-content">
<h5>Daniel Wellman</h5>
<span><i class="far fa-clock"></i> 12 May, 2023</span>
<p>There are many variations of passages the majority have suffered in some injected humour or randomised words which don't look even slightly believable.</p>
<a href="#"><i class="far fa-reply"></i> Reply</a>
</div>
</div>
<div class="blog-comments-single">
<div class="blog-comments-img"><img src="assets/img/blog/com-3.jpg" alt="thumb"></div>
<div class="blog-comments-content">
<h5>Kenneth Evans</h5>
<span><i class="far fa-clock"></i> 12 May, 2023</span>
<p>There are many variations of passages the majority have suffered in some injected humour or randomised words which don't look even slightly believable.</p>
<a href="#"><i class="far fa-reply"></i> Reply</a>
</div>
</div>
</div>
<div class="blog-comments-form">
<h3>Leave A Comment</h3>
<form action="#">
<div class="row">
<div class="col-md-6">
<div class="form-group">
<input type="text" class="form-control" placeholder="Your Name*">
</div>
</div>
<div class="col-md-6">
<div class="form-group">
<input type="email" class="form-control" placeholder="Your Email*">
</div>
</div>
<div class="col-md-12">
<div class="form-group">
<textarea class="form-control" rows="5" placeholder="Your Comment*"></textarea>
</div>
<button type="submit" class="theme-btn">Post Comment <i class="far fa-paper-plane"></i></button>
</div>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
<div class="col-lg-4">
<aside class="sidebar">

<div class="widget search">
<h5 class="widget-title">Search</h5>
<form class="blog-search-form">
<input type="text" class="form-control" placeholder="Search Here...">
<button type="submit"><i class="far fa-search"></i></button>
</form>
</div>

<div class="widget category">
<h5 class="widget-title">Category</h5>
<div class="category-list">
<a href="#"><i class="far fa-arrow-right"></i>Apartments<span>(20)</span></a>
<a href="#"><i class="far fa-arrow-right"></i>Offices<span>(10)</span></a>
<a href="#"><i class="far fa-arrow-right"></i>Luxary Villas<span>(15)</span></a>
<a href="#"><i class="far fa-arrow-right"></i>Duplex House<span>(30)</span></a>
<a href="#"><i class="far fa-arrow-right"></i>Commercial<span>(25)</span></a>
</div>
</div>

<div class="widget recent-post">
<h5 class="widget-title">Recent Post</h5>
<div class="recent-post-single">
<div class="recent-post-img">
<img src="assets/img/blog/bs-1.jpg" alt="thumb">
</div>
<div class="recent-post-bio">
<h6><a href="#">It is a long established fact that a reader layout</a></h6>
<span><i class="far fa-clock"></i>12 May, 2023</span>
</div>
</div>
<div class="recent-post-single">
<div class="recent-post-img">
<img src="assets/img/blog/bs-2.jpg" alt="thumb">
</div>
<div class="recent-post-bio">
<h6><a href="#">It is a long established fact that a reader layout</a></h6>
<span><i class="far fa-clock"></i>12 May, 2023</span>
</div>
</div>
<div class="recent-post-single">
<div class="recent-post-img">
<img src="assets/img/blog/bs-3.jpg" alt="thumb">
</div>
<div class="recent-post-bio">
<h6><a href="#">It is a long established fact that a reader layout</a></h6>
<span><i class="far fa-clock"></i>12 May, 2023</span>
</div>
</div>
</div>

<div class="widget social-share">
<h5 class="widget-title">Follow Us</h5>
<div class="social-share-link">
<a href="#"><i class="fab fa-facebook-f"></i></a>
<a href="#"><i class="fab fa-twitter"></i></a>
<a href="#"><i class="fab fa-dribbble"></i></a>
<a href="#"><i class="fab fa-whatsapp"></i></a>
<a href="#"><i class="fab fa-youtube"></i></a>
</div>
</div>

<div class="widget sidebar-tag">
<h5 class="widget-title">Popular Tags</h5>
<div class="tag-list">
<a href="#">Rea Estate</a>
<a href="#">Business</a>
<a href="#">Villa</a>
<a href="#">House</a>
<a href="#">Apartment</a>
<a href="#">Modern</a>
<a href="#">Luxury</a>
<a href="#">Commerical</a>
</div>
</div>
</aside>
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
<a href="#" class="footer-logo">
<img src="assets/img/logo/logo-light.png" alt>
</a>
<p class="mb-4">
We are many variations of passages available but the majority have suffered alteration
in some form by injected humour words believable.
</p>
<ul class="footer-contact">
<li><a href="tel:+21236547898"><i class="far fa-phone"></i>+2 123 654 7898</a></li>
<li><i class="far fa-map-marker-alt"></i>25/B Milford Road, New York</li>
<li><a href="https://live.themewild.com/cdn-cgi/l/email-protection#20494e464f604558414d504c450e434f4d"><i class="far fa-envelope"></i><span class="__cf_email__" data-cfemail="95fcfbf3fad5f0edf4f8e5f9f0bbf6faf8">[email&#160;protected]</span></a></li>
</ul>
</div>
</div>
<div class="col-md-6 col-lg-2">
<div class="footer-widget-box list">
<h4 class="footer-widget-title">Quick Links</h4>
<ul class="footer-list">
<li><a href="#"><i class="fas fa-angle-double-right"></i> About Us</a></li>
<li><a href="#"><i class="fas fa-angle-double-right"></i> FAQ's</a></li>
<li><a href="#"><i class="fas fa-angle-double-right"></i> Terms Of Service</a></li>
<li><a href="#"><i class="fas fa-angle-double-right"></i> Privacy policy</a></li>
<li><a href="#"><i class="fas fa-angle-double-right"></i> Our Team</a></li>
<li><a href="#"><i class="fas fa-angle-double-right"></i> Support</a></li>
</ul>
</div>
</div>
<div class="col-md-6 col-lg-3">
<div class="footer-widget-box list">
<h4 class="footer-widget-title">Top Category</h4>
<ul class="footer-list">
<li><a href="#"><i class="fas fa-angle-double-right"></i> Apartment</a></li>
<li><a href="#"><i class="fas fa-angle-double-right"></i> Villas</a></li>
<li><a href="#"><i class="fas fa-angle-double-right"></i> Commercial</a></li>
<li><a href="#"><i class="fas fa-angle-double-right"></i> My Houses</a></li>
<li><a href="#"><i class="fas fa-angle-double-right"></i> Offices</a></li>
<li><a href="#"><i class="fas fa-angle-double-right"></i> Garage</a></li>
</ul>
</div>
</div>
<div class="col-md-6 col-lg-3">
<div class="footer-widget-box list">
<h4 class="footer-widget-title">Newsletter</h4>
<div class="footer-newsletter">
<p>Subscribe Our Newsletter To Get Latest Update And News</p>
<div class="subscribe-form">
<form action="#">
<input type="email" class="form-control" placeholder="Your Email">
<button class="theme-btn" type="submit">
Subscribe Now <i class="far fa-paper-plane"></i>
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
&copy; Copyright <span id="date"></span> <a href="#"> HOMFIND </a> All Rights Reserved.
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

<!-- Mirrored from live.themewild.com/homfind/blog-single.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 21 Jun 2023 20:05:25 GMT -->
</html>