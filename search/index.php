<?php

if (isset($_POST['recherche'])){

    if (!empty($_POST['search'])){

        header("Location:../listing-search.php?search=".ucwords($_POST['search']));

    }else{
        $error = "Veuillez entrer un paramètre de recherche";
    }

}

?>


<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="author" content="colorlib.com">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet" />

    <!-- Inclure SweetAlert via un lien CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Google Analytics Conforthouse -->
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-WWWL4R4JLB"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-WWWL4R4JLB');
    </script>
    
  </head>
  <body>

    <?php
        if (isset($error)){
            ?>
            <script>
                swal("Oups", "<?=$error?>", "info");
            </script>
            <?php
        }
    ?>

    <div class="fermer">
        <p><a href="../index.php" style="text-decoration:none;color:white;">Fermer</a></p>
    </div>

    <div class="search">
      <form method="post">
        <div class="inner-form">
          <div class="input-field second-wrap">
            <input id="search" type="text" name="search" placeholder="    Entrer une ville, un prix ou un type de location" />
          </div>
          <div class="input-field third-wrap">
            <button class="btn-search" type="submit" name="recherche">Search</button>
          </div>
        </div>
      </form>
    </div>
    <script>
      

    </script>
  </body>
</html>
