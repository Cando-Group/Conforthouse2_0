<?php
session_start();
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
                  PSC ADMIN
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
        <form>

            <div class="row justify-content-between align-items-center">
              <div class="col">
                <div class="row align-items-center">
                  <div class="col-auto">

                    <!-- Avatar -->
                    <div class="avatar">
                      <img class="avatar-img rounded-circle" src="authadmin/authimg/<?= $_SESSION['username']?>.jpg" alt="...">
                    </div>

                  </div>
                  <div class="col ms-n2">

                    <!-- Heading -->
                    <h4 class="mb-1">
                      Your avatar
                    </h4>

                    <!-- Text -->
                    <small class="text-muted">
                      PNG or JPG no bigger than 1000px wide and tall.
                    </small>

                  </div>
                </div> <!-- / .row -->
              </div>
              <div class="col-auto">

                <!-- Button -->
                <button class="btn btn-sm btn-primary">
                  Upload
                </button>

              </div>
            </div> <!-- / .row -->

            <!-- Divider -->
            <hr class="my-5">

            <div class="row">
              <div class="col-12 col-md-6">

                <!-- First name -->
                <div class="form-group">

                  <!-- Label -->
                  <label class="form-label">
                    First name
                  </label>

                  <!-- Input -->
                  <input type="text" class="form-control">

                </div>

              </div>
              <div class="col-12 col-md-6">

                <!-- Last name -->
                <div class="form-group">

                  <!-- Label -->
                  <label class="form-label">
                    Last name
                  </label>

                  <!-- Input -->
                  <input type="text" class="form-control">

                </div>

              </div>
              <div class="col-12">

                <!-- Email address -->
                <div class="form-group">

                  <!-- Label -->
                  <label class="mb-1">
                    Email address
                  </label>

                  <!-- Form text -->
                  <small class="form-text text-muted">
                    This contact will be shown to others publicly, so choose it carefully.
                  </small>

                  <!-- Input -->
                  <input type="email" class="form-control">

                </div>

              </div>
              <div class="col-12 col-md-6">

                <!-- Phone -->
                <div class="form-group">

                  <!-- Label -->
                  <label class="form-label">
                    Phone
                  </label>

                  <!-- Input -->
                  <input type="text" class="form-control mb-3" placeholder="(___)___-____" data-inputmask="'mask': '(999)999-9999'">

                </div>

              </div>
              <div class="col-12 col-md-6">

                <!-- Birthday -->
                <div class="form-group">

                  <!-- Label -->
                  <label class="form-label">
                    Birthday
                  </label>

                  <!-- Input -->
                  <input type="text" class="form-control" data-flatpickr>

                </div>

              </div>
            </div> <!-- / .row -->

            <!-- Button -->
            <button class="btn btn-primary">
              Save changes
            </button>

            <!-- Divider -->
            <hr class="my-5">

            <div class="row">
              <div class="col-12 col-md-6">

                <!-- Public profile -->
                <div class="form-group">

                  <!-- Label -->
                  <label class="mb-1">
                    Public profile
                  </label>

                  <!-- Form text -->
                  <small class="form-text text-muted">
                    Making your profile public means that anyone on the Dashkit network will be able to find you.
                  </small>

                  <div class="row">
                    <div class="col-auto">

                      <!-- Switch -->
                      <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="switchOne" />
                        <label class="form-check-label" for="switchOne"></label>
                      </div>

                    </div>
                    <div class="col ms-n2">

                      <!-- Help text -->
                      <small class="text-muted">
                        You're currently invisible
                      </small>

                    </div>
                  </div> <!-- / .row -->
                </div>

              </div>
              <div class="col-12 col-md-6">

                <!-- Allow for additional Bookings -->
                <div class="form-group">

                  <!-- Label -->
                  <label class="mb-1">
                    Allow for additional Bookings
                  </label>

                  <!-- Form text -->
                  <small class="form-text text-muted">
                    If you are available for hire outside of the current situation, you can encourage others to hire you.
                  </small>

                  <div class="row">
                    <div class="col-auto">

                      <!-- Switch -->
                      <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="switchTwo" checked />
                        <label class="form-check-label" for="switchTwo"></label>
                      </div>

                    </div>
                    <div class="col ms-n2">

                      <!-- Help text -->
                      <small class="text-muted">
                        You're currently available
                      </small>

                    </div>
                  </div> <!-- / .row -->
                </div>

              </div>
            </div> <!-- / .row -->

            <!-- Divider -->
            <hr class="mt-4 mb-5">

            <div class="row justify-content-between">
              <div class="col-12 col-md-6">

                <!-- Heading -->
                <h4>
                  Delete your account
                </h4>

                <!-- Text -->
                <p class="small text-muted mb-md-0">
                  Please note, deleting your account is a permanent action and will no be recoverable once completed.
                </p>

              </div>
              <div class="col-auto">

                <!-- Button -->
                <button class="btn btn-danger">
                  Delete
                </button>

              </div>
            </div> <!-- / .row -->

          </form>
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
