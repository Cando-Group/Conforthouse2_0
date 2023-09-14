<?php
session_start();

    if (isset($_POST['admin'])){
        
        if (!empty($_POST['username']) && !empty($_POST['password'])){

            require_once('../database/database.php');

            $addAdmin = $database->prepare('INSERT INTO admin (username, password) VALUES(:username, :password)');
            $addAdmin->bindvalue(':username', ucwords($_POST['username']));
            $addAdmin->bindvalue(':password', sha1($_POST['password']));
            $addAdmin->execute();

            $addSucces = "Admin".$_POST['username']." ajouté avec succès";

        }
        
    }

    /* ------------------------------- 
            MEMBRE DE L'EQUIPE
    ---------------------------------*/

    if (isset($_POST['submit'])){

        // 1. Nom de l'img
        $nom_image = $_FILES['photo']['name'];
            
        //2. Le dossier où se trouve l'img
        $temporaire = $_FILES['photo']['tmp_name'];
    
        //3. extension de notre image
        $extens =strrchr($nom_image, '.');
    
        //4.Extension autoriser
        $autoriser = array('.png', '.PNG', '.jpg', '.JPG', '.jpeg', '.JPEG');
    
        //5.dossier de destination
        $destination = '../assets/images/agents/'.$nom_image;

        //Vérifier que les champs ne sont pas vide
        if (!empty($_POST['nom']) || !empty($_POST['role']) || !empty($_FILES['photo'])){

            require_once('../database/database.php');

            if (in_array($extens, $autoriser)){
            
                if (move_uploaded_file($temporaire, $destination)){
                    // insertion de l'img
                    $nom = $_POST['nom'];
                    $insertionEquipe = $database->prepare('INSERT INTO team(nom, role, photo) VALUES(:nom, :role, :photo)');
                    $insertionEquipe->bindvalue(':nom', $_POST['nom']);
                    $insertionEquipe->bindvalue(':role', $_POST['role']);
                    $insertionEquipe->bindvalue(':photo', $nom_image);

                    $insertionEquipe->execute();
                    
                    $successMsg = "$nom ajouté avec succès";
                }
            }

        }else{
            
            $errorMsg = "Renseignez tous les champs SVP";
        }

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
    
    <style>body { display: none; }</style>
    
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
                <a href="authadmin/authimg/<?= $_SESSION['username']?>.jpg"><img src="authadmin/authimg/<?= $_SESSION['username']?>.jpg" class="avatar-img rounded-circle" alt="..."></a>
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

      

<div class="header">

    <!-- Image -->
    <img src="assets/img/covers/profile-cover-1.jpg" class="header-img-top" alt="...">

    <div class="container-fluid">

      <!-- Body -->
      <div class="header-body mt-n5 mt-md-n6">
        <div class="row align-items-end">
          <div class="col-auto">

            <!-- Avatar -->
            <div class="avatar avatar-xxl header-avatar-top">
              <a href="authadmin/authimg/<?= $_SESSION['username']?>.jpg"><img src="authadmin/authimg/<?= $_SESSION['username']?>.jpg" alt="..." class="avatar-img rounded-circle border border-4 border-body"></a>
            </div>

          </div>
          <div class="col mb-3 ms-n3 ms-md-n2">

            <!-- Pretitle -->
            <h6 class="header-pretitle">
              Members
            </h6>

            <!-- Title -->
            <h1 class="header-title">
              <?= $_SESSION['username']?>
            </h1>

          </div>
          <div class="col-12 col-md-auto mt-2 mt-md-0 mb-md-3">

            <!-- Button -->
            <a href="#!" class="btn btn-primary d-block d-md-inline-block lift">
              Subscribe
            </a>

          </div>
        </div> <!-- / .row -->
       
      </div> <!-- / .header-body -->

    </div>
  </div>

    <?php
        if (isset($_SESSION['username']) && $_SESSION['username']=='Carmel' || $_SESSION['username'] == "Candide"){
            ?>
        <div class="container">
            <div class="row">

            <div class="col-xs-12">
                
                <div class="card-body">
                    <center><h2 style="text-decoration:underline crimson 2px;">Ajout Membre de l'équipe</h2></center>
                </div>

				  	<form class="form-horizontal" method="post" enctype="multipart/form-data">
				  		<div class="form-group">
					  			<div class="col-xs-12">
						  			<div class="form-block">
							  			<label for="username">Nom et prénoms</label>
							  			<input id="username" class="form-control" type="text" name="nom" placeholder="Nom et prénoms du membre *" required>
						  			</div>
					  			</div>
					  			<div class="col-xs-12">
						  			<div class="form-block">
							  			<label for="role">Rôle</label>
							  			<input id="role" class="form-control" type="text" name="role" placeholder="Role du membre *" required>
						  			</div>
					  			</div>
                                  <div class="col-xs-12">
						  			<div class="form-block">
							  			<label for="photo">Photo</label>
							  			<input id="photo" class="form-control" type="file" name="photo" placeholder="Photo du membre *" required>
                                        
						  			</div>
					  			</div>
				  		</div>
				  		<div class="form-group">
                            <input class="btn btn-custom btn-primary" type="submit" name="submit" value="Ajouter le membre" style="border-radius: 10px;">
				  		</div>
				  	</form>
                    
			  	</div>
            </div>

            <div class="col-xs-12">
                
                <div class="card-body">
                    <center><h2 style="text-decoration:underline crimson 5px;">Ajout Administrateur</h2></center>
                </div>

				  	<form class="form-horizontal" method="post" action="">
				  		<div class="form-group">
					  			<div class="col-xs-12">
						  			<div class="form-block">
							  			<label for="username">Username Admin</label>
							  			<input id="username" class="form-control" type="text" name="username" placeholder="Username *" required>
						  			</div>
					  			</div>
					  			<div class="col-xs-12">
						  			<div class="form-block">
							  			<label for="password">Password</label>
							  			<input id="password" class="form-control" type="password" name="password" placeholder="Mot de passe de l'administrateur *" required>
						  			</div>
					  			</div>
				  		</div>
				  		<div class="form-group">
				  			<div class="text-center">
				  				<input class="btn btn-custom btn-primary" type="submit" name="admin" value="Ajouter Admin" style="border-radius: 10px;">
				  			</div>
				  		</div>
				  	</form>
                    
			  	</div>
            </div>
            <hr>
            <div class="container-fluid">
        <div class="col-12">

            <!-- Card Liste Administrateur -->
            <div class="table-responsive">
                <center><h2 style="text-decoration:underline crimson 5px;">Liste des Administrateurs</h2></center>
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
                        Username
                      </a>
                    </th>
                    <th colspan="2">
                      <a href="#" class="text-muted list-sort" data-sort="">
                        Action
                      </a>
                    </th>
                  </tr>
                </thead>
                <?php
                    require_once('../database/database.php');

                    $listAdmin = $database->prepare('SELECT * FROM admin');
                    $listAdmin->execute();


                ?>
                <tbody class="list">
                    <?php
                        while ($dataAdmin = $listAdmin->fetch()){
                            if ($dataAdmin['username'] != 'Carmel' && $dataAdmin['username'] != 'Candide'){

                            ?>
                            <tr>
                                <td>
                                    <a href="authadmin/authimg/<?= $dataAdmin['username']?>.jpg"><img src="authadmin/authimg/<?= $dataAdmin['username']?>.jpg" alt="" style="width:50px;height:50px;border-radius:100px;"></a>
                                </td>
                                <td>
                                    <?= $dataAdmin['username']?>
                                </td>
                                <td>
                                    <a href="delete_admin.php?username=<?=$dataAdmin['username']?>" class="btn btn-danger">Supprimer</a>
                                </td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                    
                  
                </tbody>
              </table>
            </div>

            <!-- Carte Liste Membres-->

            <div class="table-responsive">
                <center><h2 style="text-decoration:underline crimson 5px;">Liste des Membres de l'équipe</h2></center>
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
                        Username
                      </a>
                    </th>
                    <th colspan="2">
                      <a href="#" class="text-muted list-sort" data-sort="">
                        Action
                      </a>
                    </th>
                  </tr>
                </thead>
                <?php
                    require_once('../database/database.php');

                    $listMembre = $database->prepare('SELECT * FROM team');
                    $listMembre->execute();


                ?>
                <tbody class="liste">
                    <?php
                        while ($dataMembre = $listMembre->fetch()){
                            ?>
                            <tr>
                                <td>
                                    <a href="../assets/images/agents/<?= $dataMembre['photo']?>"><img src="../assets/images/agents/<?= $dataMembre['photo']?>" alt="" style="width:50px;height:50px;border-radius:100px;"></a>
                                </td>
                                <td>
                                    <?= $dataMembre['nom']?>
                                </td>
                                <td>
                                    <a href="delete_membre.php?id=<?=$dataMembre['id']?>" class="btn btn-danger">Supprimer</a>
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

        </div>
    <?php        
        }else{
            echo '';    
        }
    ?>
    <div>
        
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
