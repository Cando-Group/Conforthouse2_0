<?php

    require("includes/header.php");

    // Requête

?>

<main class="main">

<div class="site-breadcrumb" style="background: url(assets/img/breadcrumb/01.jpg)">
<div class="container">
<h2 class="breadcrumb-title">Boutique</h2>
<ul class="breadcrumb-menu">
<li><a href="index.php">Accueil</a></li>
<li class="active">Boutique</li>
</ul>
</div>
</div>

<div class="property-listing py-120">
        <div class="container">
            <div class="row">
<?php
// Paramètres de pagination
$elementsParPage = 9; // Nombre d'éléments à afficher par page
$pageActuelle = isset($_GET['page']) ? $_GET['page'] : 1; // Récupérer la page actuelle depuis l'URL, par défaut 1

// Calculer l'offset pour la requête SQL
$offset = ($pageActuelle - 1) * $elementsParPage;

// Requête avec condition WHERE et bindValue pour sécuriser la requête
$reqEtudiantes = $database->prepare("SELECT * FROM annonces WHERE categorie=:categorie AND statut = :statut AND louer = :louer ORDER BY id DESC LIMIT :offset, :elementsParPage ");
$reqEtudiantes->bindValue(":statut", 1);
$reqEtudiantes->bindValue(":categorie", "Boutique");
$reqEtudiantes->bindValue(":louer", "non");
$reqEtudiantes->bindValue(":offset", $offset, PDO::PARAM_INT);
$reqEtudiantes->bindValue(":elementsParPage", $elementsParPage, PDO::PARAM_INT);
$reqEtudiantes->execute();

$countEtudiantes = $reqEtudiantes->rowCount();


// Afficher les données paginées
if ($countEtudiantes > 0) { // Vérifier que la requête a réussi et qu'il y a des résultats
    while ($row = $reqEtudiantes->fetch()) {
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
    echo "<span class='theme-btn'>Aucune chambre trouvée.</span>";
}

// Requête pour compter le nombre total d'enregistrements dans la table avec la condition WHERE
$reqCount = $database->prepare("SELECT COUNT(*) AS total FROM annonces WHERE statut = :statut AND louer = :louer");
$reqCount->bindValue(":statut", 1, PDO::PARAM_INT);
$reqCount->bindValue(":louer", "non", PDO::PARAM_STR);
$reqCount->execute();

$totalElements = $reqCount->fetch(PDO::FETCH_ASSOC)["total"];

// Calculer le nombre total de pages
$totalPages = ceil($totalElements / $elementsParPage);

// Afficher les liens de pagination
echo "<div class='pagination-area'>";
echo "<div aria-label='Page navigation example'>";
echo "<ul class='pagination'>";


echo "</ul>";
echo "</div>";
echo "</div>";
?>

</div>
        </div>
    </div>

<!-- Le reste de votre code HTML -->



    
        <!-- Votre code HTML existant pour la partie de pagination -->
        <div class="pagination-area mb-5">
            <div aria-label="Page navigation example">
                <ul class="pagination">
                <li class="page-item">
                    <a class="page-link" href="boutique.php?page=<?php echo $pageActuelle - 1; ?>" aria-label="Previous">
                    <span aria-hidden="true"><i class="far fa-angle-double-left"></i></span>
                    </a>
                </li>
                <!-- Vous pouvez laisser les liens statiques pour les pages 1, 2 et 3 pour l'instant -->
                <li class="page-item <?php echo ($pageActuelle == 1) ? 'active' : ''; ?>"><a class="page-link" href="boutique.php?page=1">1</a></li>
                <li class="page-item <?php echo ($pageActuelle == 2) ? 'active' : ''; ?>"><a class="page-link" href="boutique.php?page=2">2</a></li>
                <li class="page-item <?php echo ($pageActuelle == 3) ? 'active' : ''; ?>"><a class="page-link" href="boutique.php?page=3">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="boutique.php?page=<?php echo $pageActuelle + 1; ?>" aria-label="Next">
                    <span aria-hidden="true"><i class="far fa-angle-double-right"></i></span>
                    </a>
                </li>
                </ul>
            </div>
        </div>


<script>
  var currentPage = 1; // Variable pour stocker la page actuelle

  // Fonction pour charger une page spécifique via AJAX
  function loadPage(page) {
    // Remplacez "etudiantes.php" par le chemin de votre script PHP pour charger les pages suivantes
    var url = "etudiantes.php?page=" + page;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("pagination").innerHTML = this.responseText;
        currentPage = page; // Mettre à jour la page actuelle après le chargement de la nouvelle page
      }
    };
    xhttp.open("GET", url, true);
    xhttp.send();
  }

  // Fonction pour charger la page suivante
  function loadNextPage() {
    var nextPage = currentPage + 1;
    loadPage(nextPage);
  }

  // Fonction pour charger la page précédente
  function loadPreviousPage() {
    if (currentPage > 1) {
      var previousPage = currentPage - 1;
      loadPage(previousPage);
    }
  }
</script>




</div>
</div>

</main>

<?php
    require("includes/footer.php")
?>