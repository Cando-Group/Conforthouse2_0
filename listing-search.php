<?php

    if (isset($_SESSION['email'])){
        require("includes/header_connect.php");
    }else{
        require("includes/header.php");
    }

    require("database/database.php");

    if (isset($_GET['search']) && (!empty($_GET['search']))){

        $search = ucwords($_GET['search']);

        // $reqMot = $database->prepare("SELECT * FROM livres WHERE nom=:nom OR auteur=:auteur OR prix=:prix AND statut=:statut ORDER BY id DESC");
        // $reqMot->bindvalue(":nom", $mot);
        // $reqMot->bindvalue(":auteur", $mot);
        // $reqMot->bindvalue(":prix", $mot);
        // $reqMot->bindvalue(":statut", 1);
        // $reqMot->execute();

        $reqMot = $database->prepare('SELECT * FROM annonces WHERE titre LIKE "%'.$search.'%" OR localisation LIKE "%'.$search.'%" OR prix LIKE "%'.$search.'%" OR description LIKE "%'.$search.'%" OR pays LIKE "%'.$search.'%" AND louer=:louer ORDER BY id DESC');
        $reqMot->bindvalue(":louer", "non");
		$reqMot->execute();

        $countMot = $reqMot->rowCount();


    }

?>

<main class="main">

<div class="site-breadcrumb" style="background: url(assets/img/breadcrumb/01.jpg)">
<div class="container">
<h2 class="breadcrumb-title"><?php
    if ($countMot > 1){
        echo $countMot. " résultats trouvés";
    }else{
        echo $countMot. " résultat trouvé";
    }
?></h2>
<ul class="breadcrumb-menu">
<li><a href="index.php">Accueil</a></li>
<li class="active">Résultats de recherche</li>
</ul>
</div>
</div>

<div class="property-listing py-120">
      <div class="container">
        <div class="row">
          <?php
          
          // Afficher les données paginées
          if ($countMot > 0) { // Vérifier que la requête a réussi et qu'il y a des résultats
              while ($row = $reqMot->fetch()) {
                  // Afficher ici les détails de chaque enregistrement (par exemple, le nom de la chambre, la description, etc.)

                  $reqAgent = $database->prepare("SELECT * FROM demarcheurs WHERE email=:email AND validation=:statut");
                  $reqAgent->bindvalue(":email", $row['email']);
                  $reqAgent->bindvalue(":statut", 1);
                  $reqAgent->execute();

                  $dataAgent = $reqAgent->fetch();

                  $photoChambre = $row['photo'];

                  // $photoProfile = $dataAgent['photo'];

                  ?>
              
                    <div class="col-md-6 col-lg-4 ">
                        <div class="listing-item wow fadeInUp" data-wow-duration="1s" data-wow-delay=".75s">
                            <span class="listing-badge"><?=$row['mots']?></span>
                            <span class="listing-badge-bottom"><?=$row['categorie']?></span>
                            <div class="listing-img">
                            <img src="upload/location/<?=$photoChambre?>" alt="Photo de la chambre" style="height:228px!important;width:100%;">
                            </div>
                            <div class="listing-content">
                            <h4 class="listing-title"><a href="#"><?=$row['localisation']?></a></h4>
                            <p class="listing-sub-title"><?=substr($row['description'], 0, 100)?> ...</p>
                            <div class="listing-price">
                                <div class="listing-price-info">
                                <p class="listing-price-title">Prix</p>
                                </div>
                                <h6 class="listing-price-amount"> <?=$row['prix']?> F / Mois</h6>
                            </div>
                            <div class="listing-bottom">
                                <div class="listing-author">
                                <div class="listing-author-img">
                                    <img src="upload/profile/<?=$dataAgent['photo']?>" alt="Profile" style="width:45px;height:45px;">
                                </div>
                                <h5><a href="agent-single.php?agent=<?=$dataAgent['email']?>"><?=$dataAgent['nom']?> <?=ucwords($dataAgent['prenoms'])?></a></h5>
                                </div>
                                <a href="property-single.php?id_annonces=<?=$row['id_annonces']?>" class="listing-btn">Détails</a>
                            </div>
                            </div>
                        </div>
                    </div>

                      
                  <?php
              }
          } else {
              ?>
              <span class="theme-btn">Aucune location trouvée</span>
              <?php
          }

          
          ?>

        </div>
      </div>
    </div>

</main>

<?php
    require("includes/footer.php");
?>