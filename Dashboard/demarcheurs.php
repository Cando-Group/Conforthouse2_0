<?php

session_start();
  require_once('../database/database.php');
  
  // demarcheurs.php

    if (isset($_GET['success']) && $_GET['success'] == 1) {
        echo "<script>alert('Agents supprimés avec succès');</script>";
    } elseif (isset($_GET['error']) && $_GET['error'] == 1) {
        echo "<script>alert('Une erreur de base de données s'est produite');</script>";
    } elseif (isset($_GET['error']) && $_GET['error'] == 2) {
        echo "<script>alert('Paramètres manquants');</script>";
    }
  
?>

<!DOCTYPE html>
<html lang="en">
  <meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc." />
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="" type="image/x-icon"/>
    
    <!-- Libs CSS -->
    <link rel="stylesheet" href="assets/css/libs.bundle.css" />
    
    <!-- Theme CSS -->
    <link rel="stylesheet" href="assets/css/theme.bundle.css" id="stylesheetLight" />
    <link rel="stylesheet" href="assets/css/theme-dark.bundle.css" id="stylesheetDark" />
    
    <style>
        .Photo{
            width: 50px;
            height: 50px;
            border-radius: 100px;

        }
        .btn-outline-green{
            border-color: #17b978;
        }
        .btn-outline-green:hover{
            background-color: #26794A;
            color: #f1f1f1;
            border-color:transparent;
        }
    </style>
    
    <!-- Title -->
    <title>PSC ADMIN</title>
    
   </head>
  <body>


    <!-- OFFCANVAS -->

    
    <!-- Offcanvas: Search -->
    <div class="offcanvas offcanvas-start" id="sidebarOffcanvasSearch" tabindex="-1">
      <div class="offcanvas-body">
    
        <!-- Form -->
        <form class="mb-4">
          <div class="input-group input-group-merge input-group-rounded input-group-reverse">
            <input class="form-control list-search" type="search" placeholder="Search">
            <div class="input-group-text">
              <span class="fe fe-search"></span>
            </div>
          </div>
        </form>
    
        <!-- List group -->
    
    
      </div>
    </div>
    
    <!-- Offcanvas: Activity -->
    <div class="offcanvas offcanvas-start" id="sidebarOffcanvasActivity" tabindex="-1">
      <div class="offcanvas-header">
    
        <!-- Title -->
        <h4 class="offcanvas-title">
          Notifications
        </h4>
    
        <!-- Navs -->
    
    
      </div>
      <div class="offcanvas-body">
        <div class="tab-content">
          <div class="tab-pane fade show active" >
    
           
    
          </div>
         
        </div>
      </div>
    </div>

    <!-- NAVIGATION -->
    <nav class="navbar navbar-vertical fixed-start navbar-expand-md " >
      <div class="container-fluid">
    
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarCollapse" aria-controls="sidebarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
    
        <!-- Brand -->
        <a class="navbar-brand" href="index.php">
          <img src="assets/img/logo.svg" class="navbar-brand-img mx-auto" alt="...">
        </a>
    
        <!-- User (xs) -->
        <div class="navbar-user d-md-none">
    
          <!-- Dropdown -->
          <div class="dropdown">
    
            <!-- Toggle -->
            <a href="#" id="sidebarIcon" class="dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <div class="avatar avatar-sm avatar-online">
                <img src="authadmin/authimg/<?= $_SESSION['username']?>.jpg" class="avatar-img rounded-circle" alt="...">
              </div>
            </a>
    
            <!-- Menu -->
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="sidebarIcon">
              <a href="profile-posts.php" class="dropdown-item">Profile</a>
              <a href="account-general.php" class="dropdown-item">Parametres</a>
              <hr class="dropdown-divider">
              <a href="deconnect.php" class="dropdown-item">Deconnexion</a>
            </div>
    
          </div>
    
        </div>
    
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidebarCollapse">
    
          <!-- Form -->
          <form class="mt-4 mb-3 d-md-none">
            <div class="input-group input-group-rounded input-group-merge input-group-reverse">
              <input class="form-control" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-text">
                <span class="fe fe-search"></span>
              </div>
            </div>
          </form>
    
          <!-- Navigation -->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="index.php" >
                <i class="fe fe-home"></i> Statistics
              </a>
            
            </li>
            <hr class="navbar-divider my-3">
            <li class="nav-item">
              <a class="nav-link" href="users.php" >
                <i class="fe fe-user"></i> Gestionnaire d'utilisateurs
              </a>
              
            </li>
            <li class="nav-item">
              <a class="nav-link " href="demarcheurs.php">
                <i class="fe fe-users"></i> Gestionnaire de démarcheurs
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="pub.php" >
                <i class="fe fe-clipboard"></i> Gestionnaire d'annonces
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="coloc.php" >
                <i class="fe fe-clipboard"></i> Annonces de colocation
              </a>
            </li>
           
          </ul>
    
          <!-- Divider -->
          <hr class="navbar-divider my-3">
    
        
    
          <!-- Navigation -->
          <ul class="navbar-nav mb-md-4">
            <li class="nav-item ">
              <a class="nav-link"  href="message.php" >
                <span class="fe fe-send"></span> Messages
              </a>
            </li>
          </ul>
    
          <!-- Push content down -->
          <div class="mt-auto"></div>
    
          
    
            <!-- User (md) -->
            <div class="navbar-user d-none d-md-flex" id="sidebarUser">
    
              <!-- Icon -->
              <a class="navbar-user-link" data-bs-toggle="offcanvas" href="#sidebarOffcanvasActivity" aria-controls="sidebarOffcanvasActivity">
                <span class="icon">
                  <i class="fe fe-bell"></i>
                </span>
              </a>
    
              <!-- Dropup -->
              <div class="dropup">
    
                <!-- Toggle -->
                <a href="#" id="sidebarIconCopy" class="dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <div class="avatar avatar-sm avatar-online">
                    <img src="authadmin/authimg/<?= $_SESSION['username']?>.jpg" class="avatar-img rounded-circle" alt="...">
                  </div>
                </a>
    
                <!-- Menu -->
                <div class="dropdown-menu" aria-labelledby="sidebarIconCopy">
                  <a href="profile-posts.php" class="dropdown-item">Profile</a>
                  <a href="account-general.php" class="dropdown-item">Settings</a>
                  <hr class="dropdown-divider">
                  <a href="deconnect.php" class="dropdown-item">Logout</a>
                </div>
    
              </div>
    
              <!-- Icon -->
              <a class="navbar-user-link" data-bs-toggle="offcanvas" href="#sidebarOffcanvasSearch" aria-controls="sidebarOffcanvasSearch">
                <span class="icon">
                  <i class="fe fe-search"></i>
                </span>
              </a>
    
            </div>
    
        </div> <!-- / .navbar-collapse -->
    
      </div>
    </nav>
   


    <!-- MAIN CONTENT -->
    <div class="main-content">

      <nav class="navbar navbar-expand-md navbar-light d-none d-md-flex" id="topbar">
  <div class="container-fluid">

    <!-- Form -->
    <form class="form-inline me-4 d-none d-md-flex">
      <div class="input-group input-group-flush input-group-merge input-group-reverse" data-list='{"valueNames": ["name"]}'>

        <!-- Input -->
        <input type="search" class="form-control dropdown-toggle list-search" data-bs-toggle="dropdown" placeholder="Search" aria-label="Search" />

        <!-- Prepend -->
        <div class="input-group-text">
          <i class="fe fe-search"></i>
        </div>

        <!-- Menu -->
        <div class="dropdown-menu dropdown-menu-card">
          <div class="card-body">

          
          </div>
        </div> <!-- / .dropdown-menu -->

      </div>
    </form>

    <!-- User -->
    <div class="navbar-user">

      <!-- Dropdown -->
      <div class="dropdown me-4 d-none d-md-flex">

        <!-- Toggle -->
        <a href="#" class="navbar-user-link" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="icon active">
            <i class="fe fe-bell"></i>
          </span>
        </a>

        <!-- Menu -->
        <div class="dropdown-menu dropdown-menu-end dropdown-menu-card">
          <div class="card-header">

            <!-- Title -->
            <h5 class="card-header-title">
              Notifications
            </h5>

            <!-- Link -->
            <a href="#!" class="small">
              View all
            </a>

          </div> <!-- / .card-header -->
          <div class="card-body">

            <!-- List group -->
            
          </div>
        </div> <!-- / .dropdown-menu -->
      </div>

      <!-- Dropdown -->
      <div class="dropdown">

        <!-- Toggle -->
        <a href="#" class="avatar avatar-sm avatar-online dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <img src="authadmin/authimg/<?= $_SESSION['username']?>.jpg" alt="..." class="avatar-img rounded-circle" />
        </a>

        <!-- Menu -->
        <div class="dropdown-menu dropdown-menu-end">
          <a href="profile-posts.php" class="dropdown-item">Profile</a>
          <a href="account-general.php" class="dropdown-item">Settings</a>
          <hr class="dropdown-divider" />
          <a href="deconnect.php" class="dropdown-item">Logout</a>
        </div>

      </div>

    </div>

  </div>
</nav>

      

      <!-- HEADER -->
      <div class="header">
        <div class="container-fluid">

          <!-- Body -->
          <div class="header-body">
            <div class="row align-items-end">
              <div class="col">

                <!-- Pretitle -->
                <h6 class="header-pretitle">
                  Tableau de bord
                </h6>

                <!-- Title -->
                <h1 class="header-title">
                  Listes des démarcheurs
                </h1>

              </div>
              <div class="col-auto">

                <!-- Button -->
                <a href="deconnect.php" class="btn btn-primary lift">
                  Deconnexion
                </a>

              </div>
            </div> <!-- / .row -->
          </div> <!-- / .header-body -->

        </div>
      </div> <!-- / .header -->

      <!-- CARDS -->
      <div class="container-fluid">
        <div class="col-12">

            <!-- Card -->
            <div class="table-responsive">
              <table class="table table-sm table-nowrap card-table">
                <thead>
                  <tr>
                    <th>

                        <a href="#" class="text-muted list-sort" data-sort="id">
                            Photo
                        </a>

                    </th>
                    <th>
                        
                      <a href="#" class="text-muted list-sort" data-sort="nom">
                        Nom
                      </a>
                    </th>
                    <th>
                      <a href="#" class="text-muted list-sort" data-sort="prenom">
                        Prénoms
                      </a>
                    </th>
                    <th>
                      <a href="#" class="text-muted list-sort" data-sort="prenom">
                        Email
                      </a>
                    </th>
                    <th>
                      <a href="#" class="text-muted list-sort" data-sort="prenom">
                        Pays
                      </a>
                    </th>
                    <th>
                      <a href="#" class="text-muted list-sort" data-sort="prenom">
                        Ville
                      </a>
                    </th>
                    <th>
                      <a href="#" class="text-muted list-sort" data-sort="prenom">
                        Sexe
                      </a>
                    </th>
                    <th>
                      <a href="#" class="text-muted list-sort" data-sort="date">
                        Téléphone
                      </a>
                    </th>
                    <th>
                      <a href="#" class="text-muted list-sort" data-sort="profession">
                        Nombres d'annonces
                      </a>
                    </th>
                    <th>
                      <a href="#" class="text-muted list-sort" data-sort="profession">
                        Date inscription
                      </a>
                    </th>
                    <th>
                      <a href="#" class="text-muted list-sort" data-sort="status">
                        Status
                      </a>
                    </th>
                    <th colspan="2">
                      <a href="#" class="text-muted list-sort" data-sort="">
                        Action
                      </a>
                    </th>
                  </tr>
                </thead>
                <tbody class="list">
                    <?php

                        $listDemarcheurRecup = $database->prepare('SELECT * FROM demarcheurs ORDER BY id DESC');
                        $listDemarcheurRecup->execute();
                        
                        while ($dataDemarcheurList = $listDemarcheurRecup->fetch()){
                            ?>
                                <tr>
                        
                        <td class="orders-order">
                        <a href="../upload/profile/<?= $dataDemarcheurList['photo']?>"><img src="../upload/profile/<?=$dataDemarcheurList['photo']?>
                                     " alt="" class="img-responsive Photo"></a>
                        </td>
                        <td class="orders-order">
                        <?= $dataDemarcheurList['nom']?>
                        </td>
                        <td class="orders-product">
                            <?= $dataDemarcheurList['prenoms']?>
                        </td>
                        <td class="orders-product">
                            <?= $dataDemarcheurList['email']?>
                        </td>
                        <td class="orders-product">
                            <?= $dataDemarcheurList['pays']?>
                        </td>
                        <td class="orders-product">
                            <?= $dataDemarcheurList['ville']?>
                        </td>
                        <td class="orders-product">
                            <?= $dataDemarcheurList['sexe']?>
                        </td>
                        <td class="orders-date">

                        <!-- Telephone -->
                        <?= $dataDemarcheurList['telephone']?>

                        </td>
                        <!-- Nbre d'annonces-->
                        <?php

                                $nbrAnnonce = $database->prepare('SELECT *  FROM annonces WHERE prenoms=:prenom AND statut=:statut');
                                $nbrAnnonce->bindvalue(':prenom', $dataDemarcheurList['prenoms']);
                                $nbrAnnonce->bindvalue(':statut', 1);
                                $nbrAnnonce->execute();
                                $countAnnonceDemarcheur = $nbrAnnonce->rowCount();
                            ?>
                        <td class="orders-total">
                            <?= $countAnnonceDemarcheur?>
                        </td>
                        
                        <td class="order-date">
                        <?= $dataDemarcheurList['save_date']?>
                        </td>
                        <!-- Statut-->
                        
                        <td class="orders-status">

                        <!-- Badge -->
                        <div>
                            <?php
                                if ($dataDemarcheurList['validation'] == 1){
                                    ?>
                                    <span class="badge bg-success-soft" style="font-size:18px;"><?= "Actif"?></span>
                            <?php
                                    }else{
                                        ?>
                                        <span class="badge bg-danger-soft" style="font-size:18px;"><?= "Non actif"?></span>
                            <?php            
                                    }
                            ?>
                            
                        </div>
                        </td>

                    
                        <td>

                            <a href="<?php
                                        if ($dataDemarcheurList['validation'] == 1){
                                            echo 'disable.php?id='.$dataDemarcheurList['id']."&email=".$dataDemarcheurList['email']."&tel=".$dataDemarcheurList['telephone'];
                                        }else{
                                            echo 'active.php?id='.$dataDemarcheurList['id']."&email=".$dataDemarcheurList['email']."&tel=".$dataDemarcheurList['telephone'];
                                        }
                                    ?>
                            " class="btn <?php
                                        if ($dataDemarcheurList['validation'] == 1){
                                            echo 'btn-outline-danger';
                                        }else{
                                            echo 'btn-outline-green';
                                        }
                                    ?> mb-2">
                                    <?php
                                        if ($dataDemarcheurList['validation'] == 1){
                                            echo 'Désactiver';
                                        }else{
                                            echo 'Activer';
                                        }
                                    ?></a>
                            <a href="delete_two.php?id=<?=$dataDemarcheurList['id']?>" class="btn btn-danger mb-2">Supprimer</a>

                        </td>
                    </tr>
                    <?php        

                        }
                    ?>
                  
                </tbody>
              </table>
            </div>

          </div>
      </div>

    </div><!-- / .main-content -->

    <!-- JAVASCRIPT -->
    <!-- Map JS -->
    <script src='../api.mapbox.com/mapbox-gl-js/v0.53.0/mapbox-gl.js'></script>
    
    <!-- Vendor JS -->
    <script src="assets/js/vendor.bundle.js"></script>
    
    <!-- Theme JS -->
    <script src="assets/js/theme.bundle.js"></script>

  </body>
</html>
