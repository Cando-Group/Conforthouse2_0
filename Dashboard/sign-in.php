<?php
    if (isset($_POST['adminConnect'])){

        if (!empty($_POST['username']) && !empty($_POST['password'])){

            require_once('../database.php');

            $verifyConnect = $database->prepare('SELECT * FROM admin WHERE username=:username AND password=:password');
            $verifyConnect->bindvalue(':username', ucwords($_POST['username']));
            $verifyConnect->bindvalue(':password', sha1($_POST['password']));
            $verifyConnect->execute();

            $countInfo = $verifyConnect->fetch();

            if ($countInfo){
                
                session_start();
                $_SESSION['username'] = $countInfo['username'];
                header('Location:index.php?root='.$_SESSION['username']);
            }else{
                echo "Informations incorrect";
            }

        }else{
            echo "Remplir tous les champs";
        }

    }
?>

<!doctype html>
<html lang="en">
  
<!-- Mirrored from dashkit.goodthemes.co/sign-in-illustration.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 09 May 2022 10:14:08 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc." />
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/favicon/favicon.ico" type="image/x-icon"/>
    
    <!-- Map CSS -->
    <link rel="stylesheet" href="../api.mapbox.com/mapbox-gl-js/v0.53.0/mapbox-gl.css" />
    
    <!-- Libs CSS -->
    <link rel="stylesheet" href="assets/css/libs.bundle.css" />
    
    <!-- Theme CSS -->
    <link rel="stylesheet" href="assets/css/theme.bundle.css" id="stylesheetLight" />
    <link rel="stylesheet" href="assets/css/theme-dark.bundle.css" id="stylesheetDark" />
    
    <style>body { display: none; }</style>
    
    <!-- Title -->
    <title>Dashkit</title>
    
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-156446909-1"></script><script>window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag("js", new Date());gtag("config", "UA-156446909-1");</script>
  </head>
  <body class="d-flex align-items-center bg-auth border-top border-top-2 border-primary">

    <!-- CONTENT
    ================================================== -->
    <div class="container">
      <div class="row align-items-center">
        <div class="col-12 col-md-6 offset-xl-2 offset-md-1 order-md-2 mb-5 mb-md-0">

          <!-- Image -->
          <div class="text-center">
            <img src="assets/img/illustrations/happiness.svg" alt="..." class="img-fluid">
          </div>

        </div>
        <div class="col-12 col-md-5 col-xl-4 order-md-1 my-5">

          <!-- Heading -->
          <h1 class="display-4 text-center mb-3">
            Sign in
          </h1>

          <!-- Subheading -->
          <p class="text-muted text-center mb-5">
            Free access to our dashboard.
          </p>

          <!-- Form -->
          <form method="post">

            <!-- Email address -->
            <div class="form-group">

              <!-- Label -->
              <label class="form-label">
                Username
              </label>

              <!-- Input -->
              <input type="text" class="form-control" placeholder="Username" name="username">

            </div>

            <!-- Password -->
            <div class="form-group">
              <div class="row">
                <div class="col">

                  <!-- Label -->
                  <label class="form-label">
                    Password
                  </label>

                </div>
                <div class="col-auto">

                 

                </div>
              </div> <!-- / .row -->

              <!-- Input group -->
              <div class="input-group ">

                <!-- Input -->
                <input class="form-control" type="password" placeholder="Enter your password" name="password">

                <!-- Icon -->
                <span class="input-group-text">
                  <i class="fe fe-eye"></i>
                </span>

              </div>
            </div>

            <!-- Submit -->
            <input class="btn btn-lg w-100 btn-primary mb-3" type="submit" name="adminConnect" value="Sign in">

            

          </form>

        </div>
      </div> <!-- / .row -->
    </div> <!-- / .container -->

    <!-- JAVASCRIPT -->
    <!-- Map JS -->
    
    <!-- Vendor JS -->
    <script src="assets/js/vendor.bundle.js"></script>
    
    <!-- Theme JS -->
    <script src="assets/js/theme.bundle.js"></script>

  </body>

<!-- Mirrored from dashkit.goodthemes.co/sign-in-illustration.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 09 May 2022 10:14:08 GMT -->
</html>
