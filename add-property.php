<?php

    require("includes/header_connect.php");

    // $reqUser = $database->prepare("SELECT * FROM demarcheurs WHERE email=:email");
    // $reqUser->bindvalue(":email", $_SESSION["email"]);
    // $reqUser->execute();

    // $dataUser = $reqUser->fetch();

    $pays = $dataUser['pays'];

    if (isset($_POST['submit'])){

        $titre = strip_tags($_POST['titre']);
        $type = $_POST['type'];
        $categories = $_POST['categories'];
        $prix = strip_tags($_POST['prix']);
        $localisation = $_POST['localisation'];
        $photos = $_FILES['photos'];
        $description = strip_tags($_POST['description']);

        if (!empty($titre) && !empty($type) && !empty($categories) && !empty($prix) && !empty($localisation) && !empty($description) && !empty($photos)){

            $reqExistAnnonce = $database->prepare("SELECT * FROM annonces WHERE description=:description AND statut=:statut AND email=:email");;
            $reqExistAnnonce->bindvalue(":description", $description);
            $reqExistAnnonce->bindvalue(":statut", 1);
            $reqExistAnnonce->bindvalue(":email", $_SESSION['email']);
            $reqExistAnnonce->execute();

            $countAnnoncesExist = $reqExistAnnonce->rowCount();
            // echo $_SESSION['email'];
            // echo $countAnnoncesExist;

            if ($countAnnoncesExist != 0){

                ?>
                <script>
                    swal("Oups", "Cette annonce existe déjà", "error");
                </script>
                <?php

            }else{
                
                // Photo du livre

                // 1. Nom de l'img
                $name_image = $_FILES['photos']['name'];
                        
                //2. Le dossier où se trouve l'img
                $temporaire = $_FILES['photos']['tmp_name'];
            
                //3. extension de notre image
                $extens =strrchr($name_image, '.');
            
                //4.Extension autoriser
                $autoriser = array('.png', '.PNG', '.jpg', '.JPG', '.jpeg', '.JPEG');
            
                //5.dossier de destination
                $destination = 'upload/location/'.$name_image;


                if (in_array($extens, $autoriser)){

                    if (move_uploaded_file($temporaire, $destination)){

                        function token_random_string($leng=40){

                            $str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                            $token = '';
                            for ($i=0;$i<$leng;$i++){
                                $token.=$str[rand(0, strlen($str)-1)];
                            }
                            return $token;
                        }

                        $token = token_random_string(10);

                        $insert = $database->prepare("INSERT INTO annonces (id_annonces, prenoms, email, tel, titre, prix, localisation, mots, categorie, photo, description, pays) VALUES(:id_annonces, :prenoms, :email, :tel, :titre, :prix, :localisation, :mots, :categories, :photo, :description, :pays)");
                        $insert->bindvalue(":id_annonces", $token);
                        $insert->bindvalue(":prenoms", $dataUser['prenoms']);
                        $insert->bindvalue(":email", $_SESSION['email']);
                        $insert->bindvalue(":tel", $dataUser['telephone']);
                        $insert->bindvalue(":titre", $titre);
                        $insert->bindvalue(":prix", $prix);
                        $insert->bindvalue(":localisation", $localisation);
                        $insert->bindvalue(":mots", $type);
                        $insert->bindvalue(":categories", $categories);
                        $insert->bindvalue(":photo", $name_image);
                        $insert->bindvalue(":description", $description);
                        $insert->bindvalue(":pays", $dataUser["pays"]);
                        $insert->execute();

                        ?>
                        <script>
                            swal("Réussi", "Annonce publié", "success");
                        </script>
                        <?php


                    }else{
                        ?>
                        <script>
                            swal("Oups", "Une erreur est survenue lors du téléchargement du fichier", "error");
                        </script>
                        <?php
                    }

                }else{
                    ?>
                    <script>
                        swal("Oups", "Le format du fichier ne correspond pas", "error");
                    </script>
                    <?php
                }

            }

        }else{
            ?>
            <script>
                swal("Oups", "Remplissez les champs", "info");
            </script>
            <?php
        }

    }

?>

<main class="main">

<div class="site-breadcrumb" style="background: url(assets/img/breadcrumb/01.jpg)">
<div class="container">
<h2 class="breadcrumb-title">Ajouter une annonce</h2>
<ul class="breadcrumb-menu">
<li><a href="index.php">Accueil</a></li>
<li class="active">Ajouter une annonce</li>
</ul>
</div>
</div>

<?php
    if (empty($dataUser['whatsapp'])){
        ?>
        <div class="card">
        <div class="card-body">
            
            <div class="alert alert-info solid alert-right-icon alert-dismissible fade show">
                <span><i class="fa-solid fa-bell" style="color: #c64a15;"></i></span>
                <button type="button" class="close h-100 text-center" data-bs-dismiss="alert" aria-label="Close"><i class="fa-duotone fa-circle-xmark" style="--fa-primary-color: #a42219; --fa-secondary-color: #a42219;"></i>
                </button> 
                <p class="text-center">
                Veuillez ajouter votre numéro Whatsapp pour que les utilisateurs vous contact. Allez dans Paramètre. 
                </p>
            </div>
            </div>
        </div>
        <?php
    }
?>

<div class="user-profile py-120">
<div class="container">
<div class="row">
<div class="col-lg-3">
<div class="user-profile-sidebar">
<div class="user-profile-sidebar-top">
<div class="user-profile-img">
<img src="upload/profile/<?=$dataUser['photo']?>" alt="Photo de profil" style="width: 100px;height:100px;">

</div>
<h4><?=$dataUser['nom']?> <?=$dataUser['prenoms']?></h4>
<p><a href="mailto:<?=$_SESSION['email']?>" class="__cf_email__" ><?=$_SESSION['email']?></a></p>
</div>
<ul class="user-profile-sidebar-list">
<li><a href="dashboard.php"><i class="far fa-gauge-high"></i> Tableau de bord</a></li>
<li><a href="profile.php"><i class="far fa-user"></i> Mon profile</a></li>
<li><a href="profile-property.php"><i class="far fa-home"></i> Mes annonces</a></li>
<li><a class="active" href="add-property.php"><i class="far fa-plus-circle"></i> Publier une annonce</a></li>
<!-- <li><a href="profile-favorite.php"><i class="far fa-heart"></i> My Favorite</a></li>
<li><a href="profile-message.php"><i class="far fa-envelope"></i> Messages <span class="badge bg-danger">02</span></a></li> 
<li><a href="profile-save-search.php"><i class="far fa-bookmark"></i> Save Search</a></li>-->
<li><a href="profile-setting.php"><i class="far fa-cog"></i> Paramètre de profile</a></li>
<li><a href="logout.php"><i class="far fa-sign-out"></i> Déconnexion</a></li>
</ul>
</div>
</div>
<div class="col-lg-9">
<div class="row">
    <div class="user-profile-wrapper">
        <div class="user-profile-card add-property">
        <h4 class="user-profile-card-title">Ajouter une annonce</h4>
        <div class="col-lg-12">
        <div class="add-property-form">
        <h5 class="fw-bold mb-4">Informations basiques</h5>
        <form method="post" enctype="multipart/form-data">
        <div class="row align-items-center">
        <div class="col-lg-12">
        <div class="form-group">
        <label>Titre</label>
        <input type="text" class="form-control" name="titre" placeholder="Entrer le quartier ou le village ou l'arrondissement">
        </div>
        </div>
        <div class="col-lg-6">
        <div class="form-group">
        <label>Type</label>
        <select class="select" name="type">
        <option value>Sélectionner un type</option>
        <option value="Sanitaire">Sanitaire</option>
        <option value="Semi-sanitaire">Semi-sanitaire</option>
        <option value="Appartement">Appartement</option>
        <option value="Villa">Villa</option>
        <option value="Ordinaire">Ordinaire</option>
        <option value="Entré-couché">Entré-couché</option>
        </select>
        </div>
        </div>
        <div class="col-lg-6">
        <div class="form-group">
        <label>Catégrories</label>
        <select class="select" name="categories">
        <option value>Selectionner une catégorie</option>
        <option value="Chambres Familiale">Chambre familiales</option>
        <option value="Chambres étudiants">Chambre étudiantes / personnelles</option>
        <option value="Appartement">Appartements</option>
        <option value="Bureau">Bureaux</option>
        <option value="Boutique">Boutiques</option>
        <option value="Autres">Autres</option>
        </select>
        </div>
        </div>
        <div class="col-lg-6">
        <div class="form-group">
        <label>Prix</label>
        <input type="text" class="form-control" name="prix" placeholder="Entrer un prix">
        </div>
        </div>
        <div class="col-lg-6">
        <div class="form-group">
            <?php
                $paysUser = $dataUser['pays'];
            ?>
        <label>Localisation</label>
        <?php

            if ($pays == "Afghanistan"){
                ?>
                <select class="select" name="localisation">
                    <option value="Andkhoi">Andkhoi</option>
                    <option value="Aqchah">Aqchah</option>
                    <option value="Asadabad">Asadabad</option>
                    <option value="Aybak">Aybak</option>
                    <option value="Baglan">Baglan</option>
                    <option value="Balkh">Balkh</option>
                    <option value="Bamiyan">Bamiyan</option>
                    <option value="Chahab">Chahab</option>
                    <option value="Charikar">Charikar</option>
                    <option value="Emam Saheb">Emam Saheb</option>
                    <option value="Faïzâbâd">Faïzâbâd</option>
                    <option value="Farâh">Farâh</option>
                    <option value="Gardez">Gardez</option>
                    <option value="Ghazni">Ghazni</option>
                    <option value="Gurian">Gurian</option>
                    <option value="Hérat">Hérat</option>
                    <option value="Jalalabad">Jalalabad</option>
                    <option value="Kaboul">Kaboul</option>
                    <option value="Kandahâr">Kandahâr</option>
                    <option value="Khan Abad">Khan Abad</option>
                    <option value="Khost">Khost</option>
                    <option value="Khulm">Khulm</option>
                    <option value="Kondôz">Kondôz</option>
                    <option value="Kushk">Kushk</option>
                    <option value="Lashkar Gah">Lashkar Gah</option>
                    <option value="Maimana">Maimana</option>
                    <option value="Mazar-e-Charif">Mazar-e-Charif</option>
                    <option value="Paghman">Paghman</option>
                    <option value="Pol-e Khomri">Pol-e Khomri</option>
                    <option value="Qala-I-Naw">Qala-I-Naw</option>
                    <option value="Qal'eh-ye Zal">Qal'eh-ye Zal</option>
                    <option value="Rustaq">Rustaq</option>
                    <option value="Sang Charak">Sang Charak</option>
                    <option value="Sar-é Pol">Sar-é Pol</option>
                    <option value="Sheberghan">Sheberghan</option>
                    <option value="Taloqan">Taloqan</option>
                    <option value="Zarandj">Zarandj</option>
                </select>
                <?php
            }elseif ($pays == "Afrique du Sud"){
                ?>
                <select class="select" name="localisation">
                    <option value="Alberton">Alberton</option>
                    <option value="Benoni">Benoni</option>
                    <option value="Bethal">Bethal</option>
                    <option value="Bisho">Bisho</option>
                    <option value="Bloemfontein">Bloemfontein</option>
                    <option value="Boksburg">Boksburg</option>
                    <option value="Botshabelo">Botshabelo</option>
                    <option value="Brakpan">Brakpan</option>
                    <option value="Brits">Brits</option>
                    <option value="Carletonville">Carletonville</option>
                    <option value="Centurion">Centurion</option>
                    <option value="Delmas">Delmas</option>
                    <option value="Dundee">Dundee</option>
                    <option value="Durban">Durban</option>
                    <option value="East London">East London</option>
                    <option value="Embalenhle">Embalenhle</option>
                    <option value="Emnambithi">Emnambithi</option>
                    <option value="Epumalanga">Epumalanga</option>
                    <option value="George">George</option>
                    <option value="Johannesburg">Johannesburg</option>
                    <option value="Kimberley">Kimberley</option>
                    <option value="Klerksdorp">Klerksdorp</option>
                    <option value="Kroonstad">Kroonstad</option>
                    <option value="Krugersdorp">Krugersdorp</option>
                    <option value="Kutlwanong">Kutlwanong</option>
                    <option value="Le Cap">Le Cap</option>
                    <option value="Mabopane">Mabopane</option>
                    <option value="Middelburg">Middelburg</option>
                    <option value="Midrand">Midrand</option>
                    <option value="Nelspruit">Nelspruit</option>
                    <option value="Newcastle">Newcastle</option>
                    <option value="Nigel">Nigel</option>
                    <option value="Orkney">Orkney</option>
                    <option value="Paarl">Paarl</option>
                    <option value="Phalaborwa">Phalaborwa</option>
                    <option value="Piet Retief">Piet Retief</option>
                    <option value="Pietermaritzburg">Pietermaritzburg</option>
                    <option value="Polokwane">Polokwane</option>
                    <option value="Port Elizabeth">Port Elizabeth</option>
                    <option value="Potchefstroom">Potchefstroom</option>
                    <option value="Potgietersrus">Potgietersrus</option>
                    <option value="Pretoria">Pretoria</option>
                    <option value="Queenstown">Queenstown</option>
                    <option value="Randfontein">Randfontein</option>
                    <option value="Richards Bay">Richards Bay</option>
                    <option value="Rustenburg">Rustenburg</option>
                    <option value="Somerset West">Somerset West</option>
                    <option value="Soweto">Soweto</option>
                    <option value="Springs">Springs</option>
                    <option value="Stellenbosch">Stellenbosch</option>
                    <option value="Stilfontein">Stilfontein</option>
                    <option value="Tembisa">Tembisa</option>
                    <option value="Uitenhage">Uitenhage</option>
                    <option value="Vanderbijlpark">Vanderbijlpark</option>
                    <option value="Vereeniging">Vereeniging</option>
                    <option value="Virginia">Virginia</option>
                    <option value="Vryheid">Vryheid</option>
                    <option value="Warmbath">Warmbath</option>
                    <option value="Welkom">Welkom</option>
                    <option value="Westonaria">Westonaria</option>
                    <option value="Witbank">Witbank</option>
                    <option value="Worcester">Worcester</option>
                </select>

                <?php
            }elseif ($pays == "Albanie"){
                ?>
                <select class="select" name="localisation">
                    <option value="Bajram Curr">Bajram Curr</option>
                    <option value="Ballsh">Ballsh</option>
                    <option value="Berat">Berat</option>
                    <option value="Bilisht">Bilisht</option>
                    <option value="Bulqiza">Bulqiza</option>
                    <option value="Burrel">Burrel</option>
                    <option value="Cërrik">Cërrik</option>
                    <option value="Çorovodë">Çorovodë</option>
                    <option value="Durrës">Durrës</option>
                    <option value="Elbasan">Elbasan</option>
                    <option value="Erseka">Erseka</option>
                    <option value="Fier">Fier</option>
                    <option value="Fushë-Kruja">Fushë-Kruja</option>
                    <option value="Gjirokastra">Gjirokastra</option>
                    <option value="Gramsh">Gramsh</option>
                    <option value="Kamza">Kamza</option>
                    <option value="Kavaja">Kavaja</option>
                    <option value="Korça">Korça</option>
                    <option value="Krujë">Krujë</option>
                    <option value="Kuçovë">Kuçovë</option>
                    <option value="Kukës">Kukës</option>
                    <option value="Laç">Laç</option>
                    <option value="Lezha">Lezha</option>
                    <option value="Librazhd">Librazhd</option>
                    <option value="Lushnja">Lushnja</option>
                    <option value="Mamurras">Mamurras</option>
                    <option value="Patos">Patos</option>
                    <option value="Peqin">Peqin</option>
                    <option value="Përmet">Përmet</option>
                    <option value="Peshkopi">Peshkopi</option>
                    <option value="Pogradec">Pogradec</option>
                    <option value="Poliçan">Poliçan</option>
                    <option value="Puka">Puka</option>
                    <option value="Roskovec">Roskovec</option>
                    <option value="Rrëshen">Rrëshen</option>
                    <option value="Rrogozhina">Rrogozhina</option>
                    <option value="Saranda">Saranda</option>
                    <option value="Selenica">Selenica</option>
                    <option value="Shijak">Shijak</option>
                    <option value="Shkodra">Shkodra</option>
                    <option value="Tepelen">Tepelen</option>
                    <option value="Tirana">Tirana</option>
                    <option value="Vlora">Vlora</option>
                    <option value="Vora">Vora</option>
                </select>
                <?php
            }elseif ($pays == "Algerie"){
                ?>
                <select class="select" name="localisation">
                    <option value="Bajram Curr">Bajram Curr</option>
                    <option value="Ballsh">Ballsh</option>
                    <option value="Berat">Berat</option>
                    <option value="Bilisht">Bilisht</option>
                    <option value="Bulqiza">Bulqiza</option>
                    <option value="Burrel">Burrel</option>
                    <option value="Cërrik">Cërrik</option>
                    <option value="Çorovodë">Çorovodë</option>
                    <option value="Durrës">Durrës</option>
                    <option value="Elbasan">Elbasan</option>
                    <option value="Erseka">Erseka</option>
                    <option value="Fier">Fier</option>
                    <option value="Fushë-Kruja">Fushë-Kruja</option>
                    <option value="Gjirokastra">Gjirokastra</option>
                    <option value="Gramsh">Gramsh</option>
                    <option value="Kamza">Kamza</option>
                    <option value="Kavaja">Kavaja</option>
                    <option value="Korça">Korça</option>
                    <option value="Krujë">Krujë</option>
                    <option value="Kuçovë">Kuçovë</option>
                    <option value="Kukës">Kukës</option>
                    <option value="Laç">Laç</option>
                    <option value="Lezha">Lezha</option>
                    <option value="Librazhd">Librazhd</option>
                    <option value="Lushnja">Lushnja</option>
                    <option value="Mamurras">Mamurras</option>
                    <option value="Patos">Patos</option>
                    <option value="Peqin">Peqin</option>
                    <option value="Përmet">Përmet</option>
                    <option value="Peshkopi">Peshkopi</option>
                    <option value="Pogradec">Pogradec</option>
                    <option value="Poliçan">Poliçan</option>
                    <option value="Puka">Puka</option>
                    <option value="Roskovec">Roskovec</option>
                    <option value="Rrëshen">Rrëshen</option>
                    <option value="Rrogozhina">Rrogozhina</option>
                    <option value="Saranda">Saranda</option>
                    <option value="Selenica">Selenica</option>
                    <option value="Shijak">Shijak</option>
                    <option value="Shkodra">Shkodra</option>
                    <option value="Tepelen">Tepelen</option>
                    <option value="Tirana">Tirana</option>
                    <option value="Vlora">Vlora</option>
                    <option value="Vora">Vora</option>
                </select>

                <?php
            }elseif ($pays == "Allemagne"){
                ?>
                <select class="select" name="localisation">
                    <option value="Aalen">Aalen</option>
                    <option value="Ahlen">Ahlen</option>
                    <option value="Aix-la-Chapelle">Aix-la-Chapelle</option>
                    <option value="Arnsberg">Arnsberg</option>
                    <option value="Aschaffenbourg">Aschaffenbourg</option>
                    <option value="Augsbourg">Augsbourg</option>
                    <option value="Bad Homburg vor der Höhe">Bad Homburg vor der Höhe</option>
                    <option value="Bad Salzuflen">Bad Salzuflen</option>
                    <option value="Baden-Baden">Baden-Baden</option>
                    <option value="Bade-Wurtemberg">Bade-Wurtemberg</option>
                    <option value="Bamberg">Bamberg</option>
                    <option value="Basse-Saxe">Basse-Saxe</option>
                    <option value="Bavière">Bavière</option>
                    <option value="Bayreuth">Bayreuth</option>
                    <option value="Bergheim">Bergheim</option>
                    <option value="Bergisch Gladbach">Bergisch Gladbach</option>
                    <option value="Bergkamen">Bergkamen</option>
                    <option value="Berlin">Berlin</option>
                    <option value="Bielefeld">Bielefeld</option>
                    <option value="Bocholt">Bocholt</option>
                    <option value="Bochum">Bochum</option>
                    <option value="Bonn">Bonn</option>
                    <option value="Bottrop">Bottrop</option>
                    <option value="Brandebourg">Brandebourg</option>
                    <option value="Brandebourg-sur-la-Havel">Brandebourg-sur-la-Havel</option>
                    <option value="Brême">Brême</option>
                    <option value="Bremerhaven">Bremerhaven</option>
                    <option value="Brunswick">Brunswick</option>
                    <option value="Cassel">Cassel</option>
                    <option value="Castrop-Rauxel">Castrop-Rauxel</option>
                    <option value="Celle">Celle</option>
                    <option value="Chemnitz">Chemnitz</option>
                    <option value="Coblence">Coblence</option>
                    <option value="Cologne">Cologne</option>
                    <option value="Constance">Constance</option>
                    <option value="Cottbus">Cottbus</option>
                    <option value="Cuxhaven">Cuxhaven</option>
                    <option value="Darmstadt">Darmstadt</option>
                    <option value="Delmenhorst">Delmenhorst</option>
                    <option value="Dessau-Roßlau">Dessau-Roßlau</option>
                    <option value="Detmold">Detmold</option>
                    <option value="Dinslaken">Dinslaken</option>
                    <option value="Dormagen">Dormagen</option>
                    <option value="Dorsten">Dorsten</option>
                    <option value="Dortmund">Dortmund</option>
                    <option value="Dresde">Dresde</option>
                    <option value="Duisbourg">Duisbourg</option>
                    <option value="Düren">Düren</option>
                    <option value="Düsseldorf">Düsseldorf</option>
                    <option value="Emden">Emden</option>
                    <option value="Erftstadt">Erftstadt</option>
                    <option value="Erfurt">Erfurt</option>
                    <option value="Erlangen">Erlangen</option>
                    <option value="Eschweiler">Eschweiler</option>
                    <option value="Essen">Essen</option>
                    <option value="Esslingen am Neckar">Esslingen am Neckar</option>
                    <option value="Euskirchen">Euskirchen</option>
                    <option value="Flensbourg">Flensbourg</option>
                    <option value="Francfort-sur-le-Main">Francfort-sur-le-Main</option>
                    <option value="Francfort-sur-l'Oder">Francfort-sur-l'Oder</option>
                    <option value="Fribourg-en-Brisgau">Fribourg-en-Brisgau</option>
                    <option value="Friedrichshafen">Friedrichshafen</option>
                    <option value="Fulda">Fulda</option>
                    <option value="Fürth">Fürth</option>
                    <option value="Garbsen">Garbsen</option>
                    <option value="Gelsenkirchen">Gelsenkirchen</option>
                    <option value="Gera">Gera</option>
                    <option value="Giessen">Giessen</option>
                    <option value="Gladbeck">Gladbeck</option>
                    <option value="Göppingen">Göppingen</option>
                    <option value="Görlitz">Görlitz</option>
                    <option value="Göttingen">Göttingen</option>
                    <option value="Greifswald">Greifswald</option>
                    <option value="Grevenbroich">Grevenbroich</option>
                    <option value="Gummersbach">Gummersbach</option>
                    <option value="Gütersloh">Gütersloh</option>
                    <option value="Hagen">Hagen</option>
                    <option value="Halle">Halle</option>
                    <option value="Hambourg">Hambourg</option>
                    <option value="Hamelin">Hamelin</option>
                    <option value="Hamm">Hamm</option>
                    <option value="Hanau">Hanau</option>
                    <option value="Hanovre">Hanovre</option>
                    <option value="Hattingen">Hattingen</option>
                    <option value="Heidelberg">Heidelberg</option>
                    <option value="Heilbronn">Heilbronn</option>
                    <option value="Herford">Herford</option>
                    <option value="Herne">Herne</option>
                    <option value="Herten">Herten</option>
                    <option value="Hesse">Hesse</option>
                    <option value="Hilden">Hilden</option>
                    <option value="Hildesheim">Hildesheim</option>
                    <option value="Hürth">Hürth</option>
                    <option value="Ibbenbüren">Ibbenbüren</option>
                    <option value="Iéna">Iéna</option>
                    <option value="Ingolstadt">Ingolstadt</option>
                    <option value="Iserlohn">Iserlohn</option>
                    <option value="Kaiserslautern">Kaiserslautern</option>
                    <option value="Karlsruhe">Karlsruhe</option>
                    <option value="Kempten">Kempten</option>
                    <option value="Kerpen">Kerpen</option>
                    <option value="Kiel">Kiel</option>
                    <option value="Krefeld">Krefeld</option>
                    <option value="Landshut">Landshut</option>
                    <option value="Langenfeld (Rheinland)">Langenfeld (Rheinland)</option>
                    <option value="Langenhagen">Langenhagen</option>
                    <option value="Leipzig">Leipzig</option>
                    <option value="Leverkusen">Leverkusen</option>
                    <option value="Lingen">Lingen</option>
                    <option value="Lippstadt">Lippstadt</option>
                    <option value="Lübeck">Lübeck</option>
                    <option value="Lüdenscheid">Lüdenscheid</option>
                    <option value="Ludwigsbourg">Ludwigsbourg</option>
                    <option value="Ludwigshafen">Ludwigshafen</option>
                    <option value="Lunebourg">Lunebourg</option>
                    <option value="Lünen">Lünen</option>
                    <option value="Magdebourg">Magdebourg</option>
                    <option value="Mannheim">Mannheim</option>
                    <option value="Marbourg">Marbourg</option>
                    <option value="Marl">Marl</option>
                    <option value="Mayence">Mayence</option>
                    <option value="Mecklembourg-Poméranie-Occidentale">Mecklembourg-Poméranie-Occidentale</option>
                    <option value="Meerbusch">Meerbusch</option>
                    <option value="Menden">Menden</option>
                    <option value="Minden">Minden</option>
                    <option value="Moers">Moers</option>
                    <option value="Mönchengladbach">Mönchengladbach</option>
                    <option value="Mülheim">Mülheim</option>
                    <option value="Munich">Munich</option>
                    <option value="Münster">Münster</option>
                    <option value="Neubrandenbourg">Neubrandenbourg</option>
                    <option value="Neumünster">Neumünster</option>
                    <option value="Neuss">Neuss</option>
                    <option value="Neustadt an der Weinstraße">Neustadt an der Weinstraße</option>
                    <option value="Neu-Ulm">Neu-Ulm</option>
                    <option value="Neuwied">Neuwied</option>
                    <option value="Norderstedt">Norderstedt</option>
                    <option value="Nordhorn">Nordhorn</option>
                    <option value="Nuremberg">Nuremberg</option>
                    <option value="Oberhausen">Oberhausen</option>
                    <option value="Offenbach-sur-le-Main">Offenbach-sur-le-Main</option>
                    <option value="Offenbourg">Offenbourg</option>
                    <option value="Oldenbourg">Oldenbourg</option>
                    <option value="Osnabrück">Osnabrück</option>
                    <option value="Paderborn">Paderborn</option>
                    <option value="Passau">Passau</option>
                    <option value="Pforzheim">Pforzheim</option>
                    <option value="Plauen">Plauen</option>
                    <option value="Potsdam">Potsdam</option>
                    <option value="Pulheim">Pulheim</option>
                    <option value="Ratingen">Ratingen</option>
                    <option value="Ratisbonne">Ratisbonne</option>
                    <option value="Recklinghausen">Recklinghausen</option>
                    <option value="Remscheid">Remscheid</option>
                    <option value="Reutlingen">Reutlingen</option>
                    <option value="Rheine">Rheine</option>
                    <option value="Rhénanie-du-Nord-Westphalie">Rhénanie-du-Nord-Westphalie</option>
                    <option value="Rhénanie-Palatinat">Rhénanie-Palatinat</option>
                    <option value="Rosenheim">Rosenheim</option>
                    <option value="Rostock">Rostock</option>
                    <option value="Rüsselsheim">Rüsselsheim</option>
                    <option value="Salzgitter">Salzgitter</option>
                    <option value="Sankt Augustin">Sankt Augustin</option>
                    <option value="Sarre">Sarre</option>
                    <option value="Sarrebruck">Sarrebruck</option>
                    <option value="Saxe">Saxe</option>
                    <option value="Saxe-Anhalt">Saxe-Anhalt</option>
                    <option value="Schleswig-Holstein">Schleswig-Holstein</option>
                    <option value="Schwäbisch Gmünd">Schwäbisch Gmünd</option>
                    <option value="Schweinfurt">Schweinfurt</option>
                    <option value="Schwerin">Schwerin</option>
                    <option value="Siegen">Siegen</option>
                    <option value="Sindelfingen">Sindelfingen</option>
                    <option value="Solingen">Solingen</option>
                    <option value="Stolberg">Stolberg</option>
                    <option value="Stralsund">Stralsund</option>
                    <option value="Stuttgart">Stuttgart</option>
                    <option value="Thuringe">Thuringe</option>
                    <option value="Trèves">Trèves</option>
                    <option value="Troisdorf">Troisdorf</option>
                    <option value="Tübingen">Tübingen</option>
                    <option value="Ulm">Ulm</option>
                    <option value="Unna">Unna</option>
                    <option value="Velbert">Velbert</option>
                    <option value="Viersen">Viersen</option>
                    <option value="Villingen-Schwenningen">Villingen-Schwenningen</option>
                    <option value="Waiblingen">Waiblingen</option>
                    <option value="Weimar">Weimar</option>
                    <option value="Wesel">Wesel</option>
                    <option value="Wetzlar">Wetzlar</option>
                    <option value="Wiesbaden">Wiesbaden</option>
                    <option value="Wilhelmshaven">Wilhelmshaven</option>
                    <option value="Willich">Willich</option>
                    <option value="Witten">Witten</option>
                    <option value="Wolfenbüttel">Wolfenbüttel</option>
                    <option value="Wolfsbourg">Wolfsbourg</option>
                    <option value="Worms">Worms</option>
                    <option value="Wuppertal">Wuppertal</option>
                    <option value="Wurtzbourg">Wurtzbourg</option>
                    <option value="Zwickau">Zwickau</option>
                </select>

                <?php
            }elseif ($pays == "Andorre"){
                ?>
                <select class="select" name="localisation">
                    <option value="Aixirivall">Aixirivall</option>
                    <option value="Aixovall">Aixovall</option>
                    <option value="Andorre-la-Vieille">Andorre-la-Vieille</option>
                    <option value="Ansalonga">Ansalonga</option>
                    <option value="Anyós">Anyós</option>
                    <option value="Arans">Arans</option>
                    <option value="Arinsal">Arinsal</option>
                    <option value="Aubinyà">Aubinyà</option>
                    <option value="Bixessarri">Bixessarri</option>
                    <option value="Canillo">Canillo</option>
                    <option value="Certers">Certers</option>
                    <option value="El Forn">El Forn</option>
                    <option value="El Serrat">El Serrat</option>
                    <option value="El Tarter">El Tarter</option>
                    <option value="El Vilar">El Vilar</option>
                    <option value="Els Plans">Els Plans</option>
                    <option value="Encamp">Encamp</option>
                    <option value="Erts">Erts</option>
                    <option value="Escaldes-Engordany">Escaldes-Engordany</option>
                    <option value="Escàs">Escàs</option>
                    <option value="Fontaneda">Fontaneda</option>
                    <option value="Incles">Incles</option>
                    <option value="Juberri">Juberri</option>
                    <option value="La Cortinada">La Cortinada</option>
                    <option value="La Massana">La Massana</option>
                    <option value="L'Aldosa de Canillo">L'Aldosa de Canillo</option>
                    <option value="L'Aldosa de la Massana">L'Aldosa de la Massana</option>
                    <option value="Le Pas de la Case">Le Pas de la Case</option>
                    <option value="Les Bons">Les Bons</option>
                    <option value="Llorts">Llorts</option>
                    <option value="Llumeneres">Llumeneres</option>
                    <option value="Meritxell">Meritxell</option>
                    <option value="Nagol">Nagol</option>
                    <option value="Ordino">Ordino</option>
                    <option value="Pal">Pal</option>
                    <option value="Prats">Prats</option>
                    <option value="Ransol">Ransol</option>
                    <option value="Sant Julià de Lòria">Sant Julià de Lòria</option>
                    <option value="Santa Coloma d'Andorra">Santa Coloma d'Andorra</option>
                    <option value="Segudet">Segudet</option>
                    <option value="Sispony">Sispony</option>
                    <option value="Soldeu">Soldeu</option>
                    <option value="Sornàs">Sornàs</option>
                    <option value="Vila">Vila</option>
                </select>

                <?php
            }elseif ($pays == "Angola"){
                ?>
                <select class="select" name="localisation">
                    <option value="Benguela">Benguela</option>
                    <option value="Caála">Caála</option>
                    <option value="Cabinda">Cabinda</option>
                    <option value="Caconda">Caconda</option>
                    <option value="Caluquembe">Caluquembe</option>
                    <option value="Camabatela">Camabatela</option>
                    <option value="Camacupa">Camacupa</option>
                    <option value="Cangamba">Cangamba</option>
                    <option value="Catabola">Catabola</option>
                    <option value="Catumbela">Catumbela</option>
                    <option value="Caxito">Caxito</option>
                    <option value="Gabela">Gabela</option>
                    <option value="Huambo">Huambo</option>
                    <option value="Kuito">Kuito</option>
                    <option value="Lobito">Lobito</option>
                    <option value="Longonjo">Longonjo</option>
                    <option value="Luau">Luau</option>
                    <option value="Lubango">Lubango</option>
                    <option value="Lucapa">Lucapa</option>
                    <option value="Luena">Luena</option>
                    <option value="Malanje">Malanje</option>
                    <option value="Mbanza-Kongo">Mbanza-Kongo</option>
                    <option value="Menongue">Menongue</option>
                    <option value="Namibe">Namibe</option>
                    <option value="N'Dalantando">N'Dalantando</option>
                    <option value="N'zeto">N'zeto</option>
                    <option value="Ondjiva">Ondjiva</option>
                    <option value="Saurimo">Saurimo</option>
                    <option value="Soyo">Soyo</option>
                    <option value="Sumbe">Sumbe</option>
                    <option value="Tomboa">Tomboa</option>
                    <option value="Uíge">Uíge</option>
                    <option value="Waku-Kungo">Waku-Kungo</option>
                </select>

                <?php
            }elseif ($pays == "Antigua-et-Barbuda"){
                ?>
                <select class="select" name="localisation">
                    <option value="All Saints">All Saints</option>
                    <option value="Bolands">Bolands</option>
                    <option value="Carlisle">Carlisle</option>
                    <option value="Cedar Grove">Cedar Grove</option>
                    <option value="Liberta">Liberta</option>
                    <option value="Parham">Parham</option>
                    <option value="Pigotts">Pigotts</option>
                    <option value="Potters village">Potters village</option>
                    <option value="Saint John's">Saint John's</option>
                    <option value="Swetes">Swetes</option>
                </select>
                <?php
            }elseif ($pays == "Arabie Saoudite"){
                ?>
                <select class="select" name="localisation">
                    <option value="Abha">Abha</option>
                    <option value="Ahad Rafida">Ahad Rafida</option>
                    <option value="Al Bahah">Al Bahah</option>
                    <option value="Al Khardj">Al Khardj</option>
                    <option value="al-Hawiyya">al-Hawiyya</option>
                    <option value="Al-Hufuf">Al-Hufuf</option>
                    <option value="al-Mubarraz">al-Mubarraz</option>
                    <option value="al-Qatif">al-Qatif</option>
                    <option value="al-Qurayyat">al-Qurayyat</option>
                    <option value="'Ar'ar">'Ar'ar</option>
                    <option value="Ar-Rass">Ar-Rass</option>
                    <option value="Bahra">Bahra</option>
                    <option value="Bishah">Bishah</option>
                    <option value="Buraydah">Buraydah</option>
                    <option value="Dammam">Dammam</option>
                    <option value="Dawadimi">Dawadimi</option>
                    <option value="Dhahran">Dhahran</option>
                    <option value="Djeddah">Djeddah</option>
                    <option value="Hafar Al-Batin">Hafar Al-Batin</option>
                    <option value="Hail">Hail</option>
                    <option value="Jizan">Jizan</option>
                    <option value="Jubayl">Jubayl</option>
                    <option value="Khamis Mushait">Khamis Mushait</option>
                    <option value="Khobar">Khobar</option>
                    <option value="La Mecque">La Mecque</option>
                    <option value="Médine">Médine</option>
                    <option value="Najran">Najran</option>
                    <option value="Ras al-Khafji">Ras al-Khafji</option>
                    <option value="Riyad">Riyad</option>
                    <option value="Sabya">Sabya</option>
                    <option value="Saihat">Saihat</option>
                    <option value="Sakaka">Sakaka</option>
                    <option value="Sharurah">Sharurah</option>
                    <option value="Tabuk">Tabuk</option>
                    <option value="Taëf">Taëf</option>
                    <option value="Tarut">Tarut</option>
                    <option value="Tuqba">Tuqba</option>
                    <option value="Unaizah">Unaizah</option>
                    <option value="Wadi ad-Dawasir">Wadi ad-Dawasir</option>
                    <option value="Yanbu'">Yanbu'</option>
                    <option value="Zulfi">Zulfi</option>
                </select>

                <?php
            }elseif ($pays == "Argentine"){
                ?>
                <select class="select" name="localisation">
                    <option value="Aguilares">Aguilares</option>
                    <option value="Alta Gracia">Alta Gracia</option>
                    <option value="Azul">Azul</option>
                    <option value="Bahía Blanca">Bahía Blanca</option>
                    <option value="Balcarce">Balcarce</option>
                    <option value="Bariloche">Bariloche</option>
                    <option value="Bell Ville">Bell Ville</option>
                    <option value="Bragado">Bragado</option>
                    <option value="Buenos Aires">Buenos Aires</option>
                    <option value="Caleta Olivia">Caleta Olivia</option>
                    <option value="Campana">Campana</option>
                    <option value="Casilda">Casilda</option>
                    <option value="Catamarca">Catamarca</option>
                    <option value="Chacabuco">Chacabuco</option>
                    <option value="Chascomús">Chascomús</option>
                    <option value="Chilecito">Chilecito</option>
                    <option value="Chivilcoy">Chivilcoy</option>
                    <option value="Cipolletti">Cipolletti</option>
                    <option value="City Bell">City Bell</option>
                    <option value="Ciudad Perico">Ciudad Perico</option>
                    <option value="Clorinda">Clorinda</option>
                    <option value="Comodoro Rivadavia">Comodoro Rivadavia</option>
                    <option value="Concepción">Concepción</option>
                    <option value="Concepción del Uruguay">Concepción del Uruguay</option>
                    <option value="Concordia">Concordia</option>
                    <option value="Córdoba">Córdoba</option>
                    <option value="Corrientes">Corrientes</option>
                    <option value="Curuzú Cuatiá">Curuzú Cuatiá</option>
                    <option value="Cutral Có">Cutral Có</option>
                    <option value="Eldorado">Eldorado</option>
                    <option value="Esperanza">Esperanza</option>
                    <option value="Formosa">Formosa</option>
                    <option value="General Pico">General Pico</option>
                    <option value="General Roca">General Roca</option>
                    <option value="General San Martín">General San Martín</option>
                    <option value="Goya">Goya</option>
                    <option value="Gualeguay">Gualeguay</option>
                    <option value="Gualeguaychú">Gualeguaychú</option>
                    <option value="Junín">Junín</option>
                    <option value="La Plata">La Plata</option>
                    <option value="La Rioja">La Rioja</option>
                    <option value="Luján">Luján</option>
                    <option value="Mar del Plata">Mar del Plata</option>
                    <option value="Mendoza">Mendoza</option>
                    <option value="Necochea">Necochea</option>
                    <option value="Neuquén">Neuquén</option>
                    <option value="Nueve de Julio">Nueve de Julio</option>
                    <option value="Oberá">Oberá</option>
                    <option value="Olavarría">Olavarría</option>
                    <option value="Orán">Orán</option>
                    <option value="Paraná">Paraná</option>
                    <option value="Paso de los Libres">Paso de los Libres</option>
                    <option value="Pehuajó">Pehuajó</option>
                    <option value="Pergamino">Pergamino</option>
                    <option value="Posadas">Posadas</option>
                    <option value="Puerto Iguazú">Puerto Iguazú</option>
                    <option value="Puerto Madryn">Puerto Madryn</option>
                    <option value="Rafaela">Rafaela</option>
                    <option value="Reconquista">Reconquista</option>
                    <option value="Resistencia">Resistencia</option>
                    <option value="Río Cuarto">Río Cuarto</option>
                    <option value="Rio Gallegos">Rio Gallegos</option>
                    <option value="Río Grande">Río Grande</option>
                    <option value="Río Tercero">Río Tercero</option>
                    <option value="Roque Sáenz Peña">Roque Sáenz Peña</option>
                    <option value="Rosario">Rosario</option>
                    <option value="Salta">Salta</option>
                    <option value="San Francisco">San Francisco</option>
                    <option value="San Juan">San Juan</option>
                    <option value="San Lorenzo">San Lorenzo</option>
                    <option value="San Luis">San Luis</option>
                    <option value="San Martín">San Martín</option>
                    <option value="San Miguel de Tucumán">San Miguel de Tucumán</option>
                    <option value="San Nicolás de los Arroyos">San Nicolás de los Arroyos</option>
                    <option value="San Pedro">San Pedro</option>
                    <option value="San Pedro de Jujuy">San Pedro de Jujuy</option>
                    <option value="San Rafael">San Rafael</option>
                    <option value="San Salvador de Jujuy">San Salvador de Jujuy</option>
                    <option value="Santa Fe">Santa Fe</option>
                    <option value="Santa Rosa">Santa Rosa</option>
                    <option value="Santiago del Estero">Santiago del Estero</option>
                    <option value="Tafí Viejo">Tafí Viejo</option>
                    <option value="Tandil">Tandil</option>
                    <option value="Tartagal">Tartagal</option>
                    <option value="Trelew">Trelew</option>
                    <option value="Trenque Lauquen">Trenque Lauquen</option>
                    <option value="Tres Arroyos">Tres Arroyos</option>
                    <option value="Ushuaïa">Ushuaïa</option>
                    <option value="Venado Tuerto">Venado Tuerto</option>
                    <option value="Viedma">Viedma</option>
                    <option value="Villa Ángela">Villa Ángela</option>
                    <option value="Villa Carlos Paz">Villa Carlos Paz</option>
                    <option value="Villa Constitución">Villa Constitución</option>
                    <option value="Villa María">Villa María</option>
                    <option value="Villa Mercedes">Villa Mercedes</option>
                    <option value="Villaguay">Villaguay</option>
                    <option value="Zapala">Zapala</option>
                    <option value="Zárate">Zárate</option>
                </select>

                <?php
            }elseif ($pays == "Armenie"){
                ?>
                <select class="select" name="localisation">
                    <option value="Abovyan">Abovyan</option>
                    <option value="Achtarak">Achtarak</option>
                    <option value="Agarak">Agarak</option>
                    <option value="Akhtala">Akhtala</option>
                    <option value="Alaverdi">Alaverdi</option>
                    <option value="Aparan">Aparan</option>
                    <option value="Ararat">Ararat</option>
                    <option value="Armavir">Armavir</option>
                    <option value="Artachat">Artachat</option>
                    <option value="Artik">Artik</option>
                    <option value="Ayrum">Ayrum</option>
                    <option value="Berd">Berd</option>
                    <option value="Byureghavan">Byureghavan</option>
                    <option value="Charentsavan">Charentsavan</option>
                    <option value="Dastakert">Dastakert</option>
                    <option value="Dilidjan">Dilidjan</option>
                    <option value="Djermouk">Djermouk</option>
                    <option value="Eghegnazor">Eghegnazor</option>
                    <option value="Eghvard">Eghvard</option>
                    <option value="Erevan">Erevan</option>
                    <option value="Etchmiadzin">Etchmiadzin</option>
                    <option value="Gavar">Gavar</option>
                    <option value="Goris">Goris</option>
                    <option value="Gyumri">Gyumri</option>
                    <option value="Hrazdan">Hrazdan</option>
                    <option value="Idjevan">Idjevan</option>
                    <option value="Kajaran">Kajaran</option>
                    <option value="Kapan">Kapan</option>
                    <option value="Maralik">Maralik</option>
                    <option value="Martouni">Martouni</option>
                    <option value="Masis">Masis</option>
                    <option value="Megri">Megri</option>
                    <option value="Metsamor">Metsamor</option>
                    <option value="Nor-Hachn">Nor-Hachn</option>
                    <option value="Noyemberian">Noyemberian</option>
                    <option value="Sevan">Sevan</option>
                    <option value="Shamlugh">Shamlugh</option>
                    <option value="Sisian">Sisian</option>
                    <option value="Spitak">Spitak</option>
                    <option value="Stepanavan">Stepanavan</option>
                    <option value="Tachir">Tachir</option>
                    <option value="Talin">Talin</option>
                    <option value="Tjambarak">Tjambarak</option>
                    <option value="Toumanian">Toumanian</option>
                    <option value="Tsakhkadzor">Tsakhkadzor</option>
                    <option value="Vanadzor">Vanadzor</option>
                    <option value="Vardenis">Vardenis</option>
                    <option value="Vayk">Vayk</option>
                    <option value="Vedi">Vedi</option>
                </select>

                <?php
            }elseif ($pays == "Australie"){
                ?>
                <select class="select" name="localisation">
                    <option value="Adélaïde">Adélaïde</option>
                    <option value="Albany">Albany</option>
                    <option value="Albury">Albury</option>
                    <option value="Alice Springs">Alice Springs</option>
                    <option value="Ballarat">Ballarat</option>
                    <option value="Bathurst">Bathurst</option>
                    <option value="Bendigo">Bendigo</option>
                    <option value="Brisbane">Brisbane</option>
                    <option value="Bunbury">Bunbury</option>
                    <option value="Bundaberg">Bundaberg</option>
                    <option value="Cairns">Cairns</option>
                    <option value="Caloundra">Caloundra</option>
                    <option value="Canberra">Canberra</option>
                    <option value="Coffs Harbour">Coffs Harbour</option>
                    <option value="Darwin">Darwin</option>
                    <option value="Devonport">Devonport</option>
                    <option value="Dubbo">Dubbo</option>
                    <option value="Gawler">Gawler</option>
                    <option value="Geelong">Geelong</option>
                    <option value="Geraldton">Geraldton</option>
                    <option value="Gladstone">Gladstone</option>
                    <option value="Gold Coast">Gold Coast</option>
                    <option value="Goulburn">Goulburn</option>
                    <option value="Hervey Bay">Hervey Bay</option>
                    <option value="Hobart">Hobart</option>
                    <option value="Kalgoorlie-Boulder">Kalgoorlie-Boulder</option>
                    <option value="Launceston">Launceston</option>
                    <option value="Lismore">Lismore</option>
                    <option value="Mackay">Mackay</option>
                    <option value="Maitland">Maitland</option>
                    <option value="Mandurah">Mandurah</option>
                    <option value="Maryborough">Maryborough</option>
                    <option value="Melbourne">Melbourne</option>
                    <option value="Melton">Melton</option>
                    <option value="Mildura">Mildura</option>
                    <option value="Mount Gambier">Mount Gambier</option>
                    <option value="Newcastle">Newcastle</option>
                    <option value="Nowra-Bomaderry">Nowra-Bomaderry</option>
                    <option value="Orange">Orange</option>
                    <option value="Palmerston">Palmerston</option>
                    <option value="Perth">Perth</option>
                    <option value="Port Macquarie">Port Macquarie</option>
                    <option value="Rockhampton">Rockhampton</option>
                    <option value="Shepparton">Shepparton</option>
                    <option value="Sunbury">Sunbury</option>
                    <option value="Sydney">Sydney</option>
                    <option value="Tamworth">Tamworth</option>
                    <option value="Toowoomba">Toowoomba</option>
                    <option value="Townsville">Townsville</option>
                    <option value="Traralgon">Traralgon</option>
                    <option value="Wagga Wagga">Wagga Wagga</option>
                    <option value="Warrnambool">Warrnambool</option>
                    <option value="Whyalla">Whyalla</option>
                    <option value="Wollongong">Wollongong</option>
                </select>

                <?php
            }elseif ($pays == "Autriche"){
                ?>
                <select class="select" name="localisation">
                    <option value="Amstetten">Amstetten</option>
                    <option value="Ansfelden">Ansfelden</option>
                    <option value="Bad Ischl">Bad Ischl</option>
                    <option value="Bad Vöslau">Bad Vöslau</option>
                    <option value="Baden bei Wien">Baden bei Wien</option>
                    <option value="Bischofshofen">Bischofshofen</option>
                    <option value="Bludenz">Bludenz</option>
                    <option value="Braunau am Inn">Braunau am Inn</option>
                    <option value="Brégence">Brégence</option>
                    <option value="Bruck an der Mur">Bruck an der Mur</option>
                    <option value="Brunn am Gebirge">Brunn am Gebirge</option>
                    <option value="Dornbirn">Dornbirn</option>
                    <option value="Ebreichsdorf">Ebreichsdorf</option>
                    <option value="Eisenstadt">Eisenstadt</option>
                    <option value="Enns">Enns</option>
                    <option value="Feldkirch">Feldkirch</option>
                    <option value="Feldkirchen in Kärnten">Feldkirchen in Kärnten</option>
                    <option value="Gänserndorf">Gänserndorf</option>
                    <option value="Gerasdorf bei Wien">Gerasdorf bei Wien</option>
                    <option value="Gmunden">Gmunden</option>
                    <option value="Gotzis">Gotzis</option>
                    <option value="Graz">Graz</option>
                    <option value="Groß-Enzersdorf">Groß-Enzersdorf</option>
                    <option value="Hall in Tirol">Hall in Tirol</option>
                    <option value="Hallein">Hallein</option>
                    <option value="Hard">Hard</option>
                    <option value="Hohenems">Hohenems</option>
                    <option value="Hollabrunn">Hollabrunn</option>
                    <option value="Innsbruck">Innsbruck</option>
                    <option value="Kapfenberg">Kapfenberg</option>
                    <option value="Klagenfurt">Klagenfurt</option>
                    <option value="Klosterneuburg">Klosterneuburg</option>
                    <option value="Knittelfeld">Knittelfeld</option>
                    <option value="Korneuburg">Korneuburg</option>
                    <option value="Krems an der Donau">Krems an der Donau</option>
                    <option value="Kufstein">Kufstein</option>
                    <option value="Leoben">Leoben</option>
                    <option value="Leonding">Leonding</option>
                    <option value="Lienz">Lienz</option>
                    <option value="Linz">Linz</option>
                    <option value="Lustenau">Lustenau</option>
                    <option value="Marchtrenk">Marchtrenk</option>
                    <option value="Mistelbach">Mistelbach</option>
                    <option value="Mödling">Mödling</option>
                    <option value="Neunkirchen">Neunkirchen</option>
                    <option value="Perchtoldsdorf">Perchtoldsdorf</option>
                    <option value="Rankweil">Rankweil</option>
                    <option value="Ried im Innkreis">Ried im Innkreis</option>
                    <option value="Saalfelden">Saalfelden</option>
                    <option value="Salzbourg">Salzbourg</option>
                    <option value="Sankt Andrä">Sankt Andrä</option>
                    <option value="Sankt Johann im Pongau">Sankt Johann im Pongau</option>
                    <option value="Sankt Pölten">Sankt Pölten</option>
                    <option value="Sankt Veit an der Glan">Sankt Veit an der Glan</option>
                    <option value="Schwaz">Schwaz</option>
                    <option value="Schwechat">Schwechat</option>
                    <option value="Seekirchen am Wallersee">Seekirchen am Wallersee</option>
                    <option value="Spittal an der Drau">Spittal an der Drau</option>
                    <option value="Steyr">Steyr</option>
                    <option value="Stockerau">Stockerau</option>
                    <option value="Telfs">Telfs</option>
                    <option value="Ternitz">Ternitz</option>
                    <option value="Traiskirchen">Traiskirchen</option>
                    <option value="Traun">Traun</option>
                    <option value="Trofaiach">Trofaiach</option>
                    <option value="Tulln">Tulln</option>
                    <option value="Vienne">Vienne</option>
                    <option value="Villach">Villach</option>
                    <option value="Vöcklabruck">Vöcklabruck</option>
                    <option value="Völkermarkt">Völkermarkt</option>
                    <option value="Waidhofen an der Ybbs">Waidhofen an der Ybbs</option>
                    <option value="Wals-Siezenheim">Wals-Siezenheim</option>
                    <option value="Wels">Wels</option>
                    <option value="Wiener Neustadt">Wiener Neustadt</option>
                    <option value="Wolfsberg">Wolfsberg</option>
                    <option value="Wörgl">Wörgl</option>
                    <option value="Zwettl">Zwettl</option>
                </select>

                <?php
            }elseif ($pays == "Azerbaidjan"){
                ?>
                <select class="select" name="localisation">
                    <option value="Ağcabədi">Ağcabədi</option>
                    <option value="Ağdam">Ağdam</option>
                    <option value="Ağdaş">Ağdaş</option>
                    <option value="Bakixanov">Bakixanov</option>
                    <option value="Bakou">Bakou</option>
                    <option value="Bərdə">Bərdə</option>
                    <option value="Biləcəri">Biləcəri</option>
                    <option value="Binə">Binə</option>
                    <option value="Buzovna">Buzovna</option>
                    <option value="Cəlilabad">Cəlilabad</option>
                    <option value="Dəvəçi">Dəvəçi</option>
                    <option value="Əmircan">Əmircan</option>
                    <option value="Fizuli">Fizuli</option>
                    <option value="Gandja">Gandja</option>
                    <option value="Göyçay">Göyçay</option>
                    <option value="Hacı Zeynalabdin">Hacı Zeynalabdin</option>
                    <option value="Hacıqabul">Hacıqabul</option>
                    <option value="Hövsan">Hövsan</option>
                    <option value="Ievlakh">Ievlakh</option>
                    <option value="İmişli">İmişli</option>
                    <option value="Lankaran">Lankaran</option>
                    <option value="Lökbatan">Lökbatan</option>
                    <option value="Maştağa">Maştağa</option>
                    <option value="Mingachevir">Mingachevir</option>
                    <option value="Nakhitchevan">Nakhitchevan</option>
                    <option value="Qaraçuxur">Qaraçuxur</option>
                    <option value="Qazax">Qazax</option>
                    <option value="Quba">Quba</option>
                    <option value="Rəsulzadə">Rəsulzadə</option>
                    <option value="Sabirabad">Sabirabad</option>
                    <option value="Sabunçu">Sabunçu</option>
                    <option value="Sahil">Sahil</option>
                    <option value="Salyan">Salyan</option>
                    <option value="Şəmkir">Şəmkir</option>
                    <option value="Shaki">Shaki</option>
                    <option value="Shamakhi">Shamakhi</option>
                    <option value="Şirvan">Şirvan</option>
                    <option value="Siyəzən">Siyəzən</option>
                    <option value="Stepanakert">Stepanakert</option>
                    <option value="Sumqayıt">Sumqayıt</option>
                    <option value="Xaçmaz">Xaçmaz</option>
                    <option value="Xırdalan">Xırdalan</option>
                    <option value="Zabrat">Zabrat</option>
                </select>

                <?php
            }elseif ($pays == "Bahamas"){
                ?>
                <select class="select" name="localisation">
                    <option value="Albert Town">Albert Town</option>
                    <option value="Alice Town">Alice Town</option>
                    <option value="Andros Town">Andros Town</option>
                    <option value="Arthur's Town">Arthur's Town</option>
                    <option value="Clarence Town">Clarence Town</option>
                    <option value="Cockburn Town">Cockburn Town</option>
                    <option value="Colonel Hill">Colonel Hill</option>
                    <option value="Congo Town">Congo Town</option>
                    <option value="Coopers Town">Coopers Town</option>
                    <option value="Duncan Town">Duncan Town</option>
                    <option value="Dunmore Town">Dunmore Town</option>
                    <option value="Freeport">Freeport</option>
                    <option value="George Town">George Town</option>
                    <option value="Great Harbour">Great Harbour</option>
                    <option value="High Rock">High Rock</option>
                    <option value="Marsh Harbour">Marsh Harbour</option>
                    <option value="Matthew Town">Matthew Town</option>
                    <option value="Nassau">Nassau</option>
                    <option value="Nicholls Town">Nicholls Town</option>
                    <option value="Pirates Well">Pirates Well</option>
                    <option value="Port Nelson">Port Nelson</option>
                    <option value="Rock Sound">Rock Sound</option>
                    <option value="Snug Corner">Snug Corner</option>
                    <option value="Spanish Wells">Spanish Wells</option>
                    <option value="Sweeting Cay">Sweeting Cay</option>
                    <option value="West End">West End</option>
                </select>

                <?php
            }elseif ($pays == "Bahrein"){
                ?>
                <select class="select" name="localisation">
                    <option value="A'ali">A'ali</option>
                    <option value="al Hidd">al Hidd</option>
                    <option value="Al-Budayyia">Al-Budayyia</option>
                    <option value="al-Malikiyya">al-Malikiyya</option>
                    <option value="al-Muharraq">al-Muharraq</option>
                    <option value="ar-Rifa al-gharbi">ar-Rifa al-gharbi</option>
                    <option value="Jidd Haffs">Jidd Haffs</option>
                    <option value="Madinat Hamad">Madinat Hamad</option>
                    <option value="Madinat 'Isa">Madinat 'Isa</option>
                    <option value="Manama">Manama</option>
                    <option value="Sitra">Sitra</option>
                </select>

                <?php
            }elseif ($pays == "Bangladesh"){
                ?>
                <select class="select" name="localisation">
                    <option value="Bagerhat">Bagerhat</option>
                    <option value="Barisal">Barisal</option>
                    <option value="Begamganj">Begamganj</option>
                    <option value="Bhairab">Bhairab</option>
                    <option value="Bogra">Bogra</option>
                    <option value="Brahmanbaria">Brahmanbaria</option>
                    <option value="Chakaria">Chakaria</option>
                    <option value="Chandpur">Chandpur</option>
                    <option value="Chittagong">Chittagong</option>
                    <option value="Chuadanga">Chuadanga</option>
                    <option value="Comilla">Comilla</option>
                    <option value="Cox's Bazar">Cox's Bazar</option>
                    <option value="Dhaka">Dhaka</option>
                    <option value="Dinajpur">Dinajpur</option>
                    <option value="Dohar">Dohar</option>
                    <option value="Faridpur">Faridpur</option>
                    <option value="Feni">Feni</option>
                    <option value="Gaibanda">Gaibanda</option>
                    <option value="Gazipur">Gazipur</option>
                    <option value="Ghorashal">Ghorashal</option>
                    <option value="Gopalpur">Gopalpur</option>
                    <option value="Habiganj">Habiganj</option>
                    <option value="Ishwardi">Ishwardi</option>
                    <option value="Jaipurhat">Jaipurhat</option>
                    <option value="Jamalpur">Jamalpur</option>
                    <option value="Jessore">Jessore</option>
                    <option value="Jhinaidah">Jhinaidah</option>
                    <option value="Kadamrasul">Kadamrasul</option>
                    <option value="Kaunia">Kaunia</option>
                    <option value="Khulna">Khulna</option>
                    <option value="Kishorganj">Kishorganj</option>
                    <option value="Kurigram">Kurigram</option>
                    <option value="Kushtia">Kushtia</option>
                    <option value="Laksham">Laksham</option>
                    <option value="Lakshmipur">Lakshmipur</option>
                    <option value="Lalmonirhat">Lalmonirhat</option>
                    <option value="Madaripur">Madaripur</option>
                    <option value="Madhabdi">Madhabdi</option>
                    <option value="Magura">Magura</option>
                    <option value="Maimansingh">Maimansingh</option>
                    <option value="Manikganj">Manikganj</option>
                    <option value="Matlab Bazar">Matlab Bazar</option>
                    <option value="Mirkadim">Mirkadim</option>
                    <option value="Mongla">Mongla</option>
                    <option value="Munsiganj">Munsiganj</option>
                    <option value="Naogaon">Naogaon</option>
                    <option value="Narayanganj">Narayanganj</option>
                    <option value="Nator">Nator</option>
                    <option value="Nawabganj">Nawabganj</option>
                    <option value="Netrokona">Netrokona</option>
                    <option value="Noakhali">Noakhali</option>
                    <option value="Noapara">Noapara</option>
                    <option value="Pabna">Pabna</option>
                    <option value="Patuakhali">Patuakhali</option>
                    <option value="Pirojpur">Pirojpur</option>
                    <option value="Rajbari">Rajbari</option>
                    <option value="Râjshâhî">Râjshâhî</option>
                    <option value="Rangamati">Rangamati</option>
                    <option value="Rangpur">Rangpur</option>
                    <option value="Raozan">Raozan</option>
                    <option value="Sabhar">Sabhar</option>
                    <option value="Saiyadpur">Saiyadpur</option>
                    <option value="Sarishabari">Sarishabari</option>
                    <option value="Satkhira">Satkhira</option>
                    <option value="Shahzadpur">Shahzadpur</option>
                    <option value="Sherpur">Sherpur</option>
                    <option value="Sirajganj">Sirajganj</option>
                    <option value="Sunamganj">Sunamganj</option>
                    <option value="Sylhet">Sylhet</option>
                    <option value="Tangail">Tangail</option>
                    <option value="Tongi">Tongi</option>
                </select>

                <?php
            }elseif ($pays == "Barbade"){
                ?>
                <select class="select" name="localisation">
                    <option value="Bathsheba">Bathsheba</option>
                    <option value="Blackmans">Blackmans</option>
                    <option value="Bridgetown">Bridgetown</option>
                    <option value="Bulkeley">Bulkeley</option>
                    <option value="Crane">Crane</option>
                    <option value="Grab Hill">Grab Hill</option>
                    <option value="Greenland">Greenland</option>
                    <option value="Hillaby">Hillaby</option>
                    <option value="Holetown">Holetown</option>
                    <option value="Oistins">Oistins</option>
                    <option value="Speightstown">Speightstown</option>
                </select>

                <?php
            }elseif ($pays == "Belgique"){
                ?>
                <select class="select" name="localisation">
                    <option value="Aerschot">Aerschot (Aarschot)</option>
                    <option value="Alost">Alost (Aalst)</option>
                    <option value="Andenne">Andenne</option>
                    <option value="Ans">Ans</option>
                    <option value="Antoing">Antoing</option>
                    <option value="Anvers">Anvers (Antwerpen)</option>
                    <option value="Arlon">Arlon</option>
                    <option value="Ath">Ath</option>
                    <option value="Aubange">Aubange</option>
                    <option value="Audembourg">Audembourg (Oudenburg)</option>
                    <option value="Audenarde">Audenarde (Oudenaarde)</option>
                    <option value="Bastogne">Bastogne</option>
                    <option value="Beaumont">Beaumont</option>
                    <option value="Beauraing">Beauraing</option>
                    <option value="Beringen">Beringen</option>
                    <option value="Bilzen">Bilzen</option>
                    <option value="Binche">Binche</option>
                    <option value="Blankenberghe">Blankenberghe (Blankenberge)</option>
                    <option value="Bouillon">Bouillon</option>
                    <option value="Braine-le-Comte">Braine-le-Comte</option>
                    <option value="Bree">Brée (Bree)</option>
                    <option value="Brugge">Bruges (Brugge)</option>
                    <option value="Brussel">Bruxelles (Brussel)</option>
                    <option value="Charleroi">Charleroi</option>
                    <option value="Chatelet">Châtelet</option>
                    <option value="Chievres">Chièvres</option>
                    <option value="Chimay">Chimay</option>
                    <option value="Chiny">Chiny</option>
                    <option value="Ciney">Ciney</option>
                    <option value="Comines-Warneton">Comines-Warneton</option>
                    <option value="Kortrijk">Courtrai (Kortrijk)</option>
                    <option value="Couvin">Couvin</option>
                    <option value="Damme">Damme</option>
                    <option value="Deinze">Deinze</option>
                    <option value="Diest">Diest</option>
                    <option value="Dilsen-Stokkem">Dilsen-Stokkem</option>
                    <option value="Dinant">Dinant</option>
                    <option value="Diksmuide">Dixmude (Diksmuide)</option>
                    <option value="Durbuy">Durbuy</option>
                    <option value="Eeklo">Eeklo</option>
                    <option value="Enghien">Enghien</option>
                    <option value="Eupen">Eupen</option>
                    <option value="Fleurus">Fleurus</option>
                    <option value="Florenville">Florenville</option>
                    <option value="Fontaine-l-Eveque">Fontaine-l'Évêque</option>
                    <option value="Fosses-la-Ville">Fosses-la-Ville</option>
                    <option value="Veurne">Furnes (Veurne)</option>
                    <option value="Gent">Gand (Gent)</option>
                    <option value="Geel">Geel</option>
                    <option value="Gembloux">Gembloux</option>
                    <option value="Genappe">Genappe</option>
                    <option value="Genk">Genk</option>
                    <option value="Gistel">Gistel</option>
                    <option value="Geraardsbergen">Grammont (Geraardsbergen)</option>
                    <option value="Halle">Hal (Halle)</option>
                    <option value="Halen">Halen</option>
                    <option value="Hamont-Achel">Hamont-Achel</option>
                    <option value="Hannut">Hannut</option>
                    <option value="Harelbeke">Harelbeke</option>
                    <option value="Hasselt">Hasselt</option>
                    <option value="Herk-de-Stad">Herck-la-Ville (Herk-de-Stad)</option>
                    <option value="Herentals">Herentals</option>
                    <option value="Herstal">Herstal</option>
                    <option value="Herve">Herve</option>
                    <option value="Hoogstraten">Hoogstraten</option>
                    <option value="Houffalize">Houffalize</option>
                    <option value="Huy">Huy</option>
                    <option value="Izegem">Iseghem (Izegem)</option>
                    <option value="La Louviere">La Louvière</option>
                    <option value="La Roche-en-Ardenne">La Roche-en-Ardenne</option>
                    <option value="Landen">Landen</option>
                    <option value="Le Roeulx">Le Rœulx</option>
                    <option value="Zoutleeuw">Léau (Zoutleeuw)</option>
                    <option value="Lessines">Lessines</option>
                    <option value="Leuze-en-Hainaut">Leuze-en-Hainaut</option>
                    <option value="Liege">Liège</option>
                    <option value="Lier">Lierre (Lier)</option>
                    <option value="Limbourg">Limbourg</option>
                    <option value="Lokeren">Lokeren</option>
                    <option value="Lommel">Lommel</option>
                    <option value="Borgloon">Looz (Borgloon)</option>
                    <option value="Lo-Reninge">Lo-Reninge</option>
                    <option value="Leuven">Louvain (Leuven)</option>
                    <option value="Maaseik">Maaseik</option>
                    <option value="Mechelen">Malines (Mechelen)</option>
                    <option value="Malmedy">Malmedy</option>
                    <option value="Marche-en-Famenne">Marche-en-Famenne</option>
                    <option value="Menen">Menin (Menen)</option>
                    <option value="Mesen">Messines (Mesen)</option>
                    <option value="Bergen">Mons (Bergen)</option>
                    <option value="Scherpenheuvel-Zichem">Montaigu-Zichem (Scherpenheuvel-Zichem)</option>
                    <option value="Mortsel">Mortsel</option>
                    <option value="Mouscron">Mouscron</option>
                    <option value="Namur">Namur</option>
                    <option value="Neufchateau">Neufchâteau</option>
                    <option value="Nieuwpoort">Nieuport (Nieuwpoort)</option>
                    <option value="Ninove">Ninove</option>
                    <option value="Nijvel">Nivelles (Nijvel)</option>
                    <option value="Oostende">Ostende (Oostende)</option>
                    <option value="Ottignies-Louvain-la-Neuve">Ottignies-Louvain-la-Neuve</option>
                    <option value="Peer">Peer</option>
                    <option value="Peruwelz">Péruwelz</option>
                    <option value="Philippeville">Philippeville</option>
                    <option value="Poperinge">Poperinge</option>
                    <option value="Ronse">Renaix (Ronse)</option>
                    <option value="Rochefort">Rochefort</option>
                    <option value="Roeselare">Roulers (Roeselare)</option>
                    <option value="Saint-Ghislain">Saint-Ghislain</option>
                    <option value="Saint-Hubert">Saint-Hubert</option>
                    <option value="Sint-Niklaas">Saint-Nicolas (Sint-Niklaas)</option>
                    <option value="Sint-Truiden">Saint-Trond (Sint-Truiden)</option>
                    <option value="Sankt Vith">Saint-Vith (Sankt Vith)</option>
                    <option value="Seraing">Seraing</option>
                    <option value="Soignies">Soignies</option>
                    <option value="Spa">Spa</option>
                    <option value="Stavelot">Stavelot</option>
                    <option value="Dendermonde">Termonde (Dendermonde)</option>
                    <option value="Torhout">Thourout (Torhout)</option>
                    <option value="Thuin">Thuin</option>
                    <option value="Tielt">Tielt</option>
                    <option value="Tienen">Tirlemont (Tienen)</option>
                    <option value="Tongeren">Tongres (Tongeren)</option>
                    <option value="Tournai">Tournai</option>
                    <option value="Tubize">Tubize</option>
                    <option value="Turnhout">Turnhout</option>
                    <option value="Verviers">Verviers</option>
                    <option value="Vilvoorde">Vilvorde (Vilvoorde)</option>
                    <option value="Virton">Virton</option>
                    <option value="Vise">Visé</option>
                    <option value="Walcourt">Walcourt</option>
                    <option value="Waregem">Waregem</option>
                    <option value="Waremme">Waremme</option>
                    <option value="Wavre">Wavre</option>
                    <option value="Wervik">Wervicq (Wervik)</option>
                    <option value="Ieper">Ypres (Ieper)</option>
                    <option value="Zottegem">Zottegem</option>
                </select>

                <?php
            }elseif ($pays == "Belize"){
                ?>
                <select class="select" name="localisation">
                    <option value="Belize City">Belize City</option>
                    <option value="Belmopan">Belmopan</option>
                    <option value="Benque Viejo">Benque Viejo</option>
                    <option value="Corozal Town">Corozal Town</option>
                    <option value="Dangriga">Dangriga</option>
                    <option value="Guinea Grass">Guinea Grass</option>
                    <option value="Ladyville">Ladyville</option>
                    <option value="Little Belize">Little Belize</option>
                    <option value="Mango Creek">Mango Creek</option>
                    <option value="Orange Walk Town">Orange Walk Town</option>
                    <option value="Punta Gorda">Punta Gorda</option>
                    <option value="San Antonio">San Antonio</option>
                    <option value="San Ignacio">San Ignacio</option>
                    <option value="San Jose">San Jose</option>
                    <option value="San Pedro">San Pedro</option>
                    <option value="Shipyard">Shipyard</option>
                    <option value="Spanish Lookout">Spanish Lookout</option>
                    <option value="Trial Farm">Trial Farm</option>
                    <option value="Valley of Peace">Valley of Peace</option>
                </select>

                <?php
            }elseif ($pays == "Benin"){
                ?>
                <select class="select" name="localisation">
                    <option value="Abomey">Abomey</option>
                    <option value="Abomey Calavi">Abomey Calavi</option>
                    <option value="Agbangnizoun">Agbangnizoun</option>
                    <option value="Allada">Allada</option>
                    <option value="Aplahoué">Aplahoué</option>
                    <option value="Avrankou">Avrankou</option>
                    <option value="Athiémé">Athiémé</option>
                    <option value="Banikoara">Banikoara</option>
                    <option value="Bassila">Bassila</option>
                    <option value="Bembéréké">Bembéréké</option>
                    <option value="Beterou">Beterou</option>
                    <option value="Bohicon">Bohicon</option>
                    <option value="Bori">Bori</option>
                    <option value="Boukoumbé">Boukoumbé</option>
                    <option value="Comè">Comè</option>
                    <option value="Cotonou">Cotonou</option>
                    <option value="Covè">Covè</option>
                    <option value="Dassa-Zoumé">Dassa-Zoumé</option>
                    <option value="Djidja">Djidja</option>
                    <option value="Djougou">Djougou</option>
                    <option value="Dogbo-Tota">Dogbo-Tota</option>
                    <option value="Glazoué">Glazoué</option>
                    <option value="Gogounou">Gogounou</option>
                    <option value="Grand-Popo">Grand-Popo</option>
                    <option value="Kandi">Kandi</option>
                    <option value="kérou">kérou</option>
                    <option value="Kétou">Kétou</option>
                    <option value="kouandé">kouandé</option>
                    <option value="Lokossa">Lokossa</option>
                    <option value="Malanville">Malanville</option>
                    <option value="Manala">Manala</option>
                    <option value="Matéri">Matéri</option>
                    <option value="Natitingou">Natitingou</option>
                    <option value="Ndali">Ndali</option>
                    <option value="Nikki">Nikki</option>
                    <option value="Ouidah">Ouidah</option>
                    <option value="Parakou">Parakou</option>
                    <option value="Pobé">Pobé</option>
                    <option value="Porto-Novo">Porto-Novo</option>
                    <option value="Sakété">Sakété</option>
                    <option value="Savalou">Savalou</option>
                    <option value="Savè">Savè</option>
                    <option value="ségbana">ségbana</option>
                    <option value="Tchaourou">Tchaourou</option>
                    <option value="Tanguiéta">Tanguiéta</option>
                    <option value="Zè">Zè</option>
                </select>

                <?php
            }elseif ($pays == "Bhoutan"){
                ?>
                <select class="select" name="localisation">
                    <option value="Bumthang">Bumthang</option>
                    <option value="Gedu">Gedu</option>
                    <option value="Geylegphug">Geylegphug</option>
                    <option value="Gomtu">Gomtu</option>
                    <option value="Mongar">Mongar</option>
                    <option value="Phuentsholing">Phuentsholing</option>
                    <option value="Samdrup Jongkhar">Samdrup Jongkhar</option>
                    <option value="Samtse">Samtse</option>
                    <option value="Thimphou">Thimphou</option>
                    <option value="Wangdue">Wangdue</option>
                </select>

                <?php
            }elseif ($pays == "Bielorussie"){
                ?>
                <select class="select" name="localisation">
                    <option value="Baran">Baran</option>
                    <option value="Baranovitchi">Baranovitchi</option>
                    <option value="Belooziorsk">Belooziorsk</option>
                    <option value="Berezino">Berezino</option>
                    <option value="Berioza">Berioza</option>
                    <option value="Beriozovka">Beriozovka</option>
                    <option value="Bobrouïsk">Bobrouïsk</option>
                    <option value="Borissov">Borissov</option>
                    <option value="Bouda-Kocheliovo">Bouda-Kocheliovo</option>
                    <option value="Braslav">Braslav</option>
                    <option value="Brest">Brest</option>
                    <option value="Bychow">Bychow</option>
                    <option value="Chklov">Chklov</option>
                    <option value="Chtchoutchine">Chtchoutchine</option>
                    <option value="David-Gorodok">David-Gorodok</option>
                    <option value="Diatlovo">Diatlovo</option>
                    <option value="Disna">Disna</option>
                    <option value="Dobrouch">Dobrouch</option>
                    <option value="Dokchitsy">Dokchitsy</option>
                    <option value="Doubrovno">Doubrovno</option>
                    <option value="Droguitchine">Droguitchine</option>
                    <option value="Dzerjinsk">Dzerjinsk</option>
                    <option value="Fanipol">Fanipol</option>
                    <option value="Gantsevitchi">Gantsevitchi</option>
                    <option value="Gloubokoïe">Gloubokoïe</option>
                    <option value="Gomel">Gomel</option>
                    <option value="Gorki">Gorki</option>
                    <option value="Gorodok">Gorodok</option>
                    <option value="Grodno">Grodno</option>
                    <option value="Ivanovo">Ivanovo</option>
                    <option value="Ivatsevitchi">Ivatsevitchi</option>
                    <option value="Ivie">Ivie</option>
                    <option value="Jabinka">Jabinka</option>
                    <option value="Jitkovitchi">Jitkovitchi</option>
                    <option value="Jlobine">Jlobine</option>
                    <option value="Jodino">Jodino</option>
                    <option value="Kalinkovitchi">Kalinkovitchi</option>
                    <option value="Kamenets">Kamenets</option>
                    <option value="Khoïniki">Khoïniki</option>
                    <option value="Kirovsk">Kirovsk</option>
                    <option value="Kletsk">Kletsk</option>
                    <option value="Klimovitchi">Klimovitchi</option>
                    <option value="Klitchev">Klitchev</option>
                    <option value="Kobrin">Kobrin</option>
                    <option value="Kopyl">Kopyl</option>
                    <option value="Kossovo">Kossovo</option>
                    <option value="Kostioukovitchi">Kostioukovitchi</option>
                    <option value="Kritchev">Kritchev</option>
                    <option value="Kroupki">Kroupki</option>
                    <option value="Lepel">Lepel</option>
                    <option value="Liakhovitchi">Liakhovitchi</option>
                    <option value="Lida">Lida</option>
                    <option value="Logojsk">Logojsk</option>
                    <option value="Louninets">Louninets</option>
                    <option value="Luban">Luban</option>
                    <option value="Malorita">Malorita</option>
                    <option value="Marina Gorka">Marina Gorka</option>
                    <option value="Miadel">Miadel</option>
                    <option value="Mikachevitchi">Mikachevitchi</option>
                    <option value="Minsk">Minsk</option>
                    <option value="Miory">Miory</option>
                    <option value="Moguilev">Moguilev</option>
                    <option value="Molodetschno">Molodetschno</option>
                    <option value="Mosty">Mosty</option>
                    <option value="Mozyr">Mozyr</option>
                    <option value="Mstislawl">Mstislawl</option>
                    <option value="Narovlia">Narovlia</option>
                    <option value="Nesvij">Nesvij</option>
                    <option value="Novogroudok">Novogroudok</option>
                    <option value="Novoloukoml">Novoloukoml</option>
                    <option value="Novopolotsk">Novopolotsk</option>
                    <option value="Ochmiany">Ochmiany</option>
                    <option value="Orcha">Orcha</option>
                    <option value="Ossipovitchi">Ossipovitchi</option>
                    <option value="Ostrovets">Ostrovets</option>
                    <option value="Petrikov">Petrikov</option>
                    <option value="Pinsk">Pinsk</option>
                    <option value="Polotsk">Polotsk</option>
                    <option value="Postavy">Postavy</option>
                    <option value="Proujany">Proujany</option>
                    <option value="Retchitsa">Retchitsa</option>
                    <option value="Rogatchev">Rogatchev</option>
                    <option value="Senno">Senno</option>
                    <option value="Skidel">Skidel</option>
                    <option value="Slavgorod">Slavgorod</option>
                    <option value="Slonim">Slonim</option>
                    <option value="Sloutsk">Sloutsk</option>
                    <option value="Smolevitchi">Smolevitchi</option>
                    <option value="Smorgon">Smorgon</option>
                    <option value="Soligorsk">Soligorsk</option>
                    <option value="Starye Dorogi">Starye Dorogi</option>
                    <option value="Stolbtsy">Stolbtsy</option>
                    <option value="Stoline">Stoline</option>
                    <option value="Svetlogorsk">Svetlogorsk</option>
                    <option value="Svislotch">Svislotch</option>
                    <option value="Tchachniki">Tchachniki</option>
                    <option value="Tchaoussy">Tchaoussy</option>
                    <option value="Tcherikov">Tcherikov</option>
                    <option value="Tcherven">Tcherven</option>
                    <option value="Tchetchersk">Tchetchersk</option>
                    <option value="Tolotchine">Tolotchine</option>
                    <option value="Tourov">Tourov</option>
                    <option value="Uzda">Uzda</option>
                    <option value="Vassilievitchy">Vassilievitchy</option>
                    <option value="Verkhnedvinsk">Verkhnedvinsk</option>
                    <option value="Vetka">Vetka</option>
                    <option value="Vileïka">Vileïka</option>
                    <option value="Vitebsk">Vitebsk</option>
                    <option value="Volkovysk">Volkovysk</option>
                    <option value="Volojyn">Volojyn</option>
                    <option value="Vyssokoïe">Vyssokoïe</option>
                    <option value="Yelsk">Yelsk</option>
                    <option value="Zaslavl">Zaslavl</option>
                </select>

                <?php
            }elseif ($pays == "Bolivie"){
                ?>
                <select class="select" name="localisation">
                    <option value="Achocalla">Achocalla</option>
                    <option value="Ascensión de Guarayos">Ascensión de Guarayos</option>
                    <option value="Bermejo">Bermejo</option>
                    <option value="Camiri">Camiri</option>
                    <option value="Caranavi">Caranavi</option>
                    <option value="Challapata">Challapata</option>
                    <option value="Cobija">Cobija</option>
                    <option value="Cochabamba">Cochabamba</option>
                    <option value="Colcapirhua">Colcapirhua</option>
                    <option value="Cotoca">Cotoca</option>
                    <option value="El Alto">El Alto</option>
                    <option value="El Torno">El Torno</option>
                    <option value="Guayaramerín">Guayaramerín</option>
                    <option value="Huanuni">Huanuni</option>
                    <option value="La Guardia">La Guardia</option>
                    <option value="La Paz">La Paz</option>
                    <option value="Llallagua">Llallagua</option>
                    <option value="Mineros">Mineros</option>
                    <option value="Montero">Montero</option>
                    <option value="Oruro">Oruro</option>
                    <option value="Patacamaya">Patacamaya</option>
                    <option value="Portachuelo">Portachuelo</option>
                    <option value="Potosí">Potosí</option>
                    <option value="Puerto Quijarro">Puerto Quijarro</option>
                    <option value="Puerto Suárez">Puerto Suárez</option>
                    <option value="Punata">Punata</option>
                    <option value="Quillacollo">Quillacollo</option>
                    <option value="Riberalta">Riberalta</option>
                    <option value="Roboré">Roboré</option>
                    <option value="Rurrenabaque">Rurrenabaque</option>
                    <option value="Sacaba">Sacaba</option>
                    <option value="San Borja">San Borja</option>
                    <option value="San Ignacio de Moxos">San Ignacio de Moxos</option>
                    <option value="San Ignacio de Velasco">San Ignacio de Velasco</option>
                    <option value="San José de Chiquitos">San José de Chiquitos</option>
                    <option value="San Julián">San Julián</option>
                    <option value="Santa Ana del Yacuma">Santa Ana del Yacuma</option>
                    <option value="Santa Cruz de la Sierra">Santa Cruz de la Sierra</option>
                    <option value="Sipe Sipe">Sipe Sipe</option>
                    <option value="Sucre">Sucre</option>
                    <option value="Tarija">Tarija</option>
                    <option value="Tiquipaya">Tiquipaya</option>
                    <option value="Trinidad">Trinidad</option>
                    <option value="Tupiza">Tupiza</option>
                    <option value="Uyuni">Uyuni</option>
                    <option value="Vallegrande">Vallegrande</option>
                    <option value="Viacha">Viacha</option>
                    <option value="Villamontes">Villamontes</option>
                    <option value="Villazón">Villazón</option>
                    <option value="Vinto">Vinto</option>
                    <option value="Warnes">Warnes</option>
                    <option value="Yacuiba">Yacuiba</option>
                    <option value="Yapacaní">Yapacaní</option>
                </select>

                <?php
            }elseif ($pays == "Bosnie-Herzegovine"){
                ?>
                <select class="select" name="localisation">
                    <option value="Banja Luka">Banja Luka</option>
                    <option value="Bihać">Bihać</option>
                    <option value="Bijeljina">Bijeljina</option>
                    <option value="Bileća">Bileća</option>
                    <option value="Bosanska Krupa">Bosanska Krupa</option>
                    <option value="Brčko">Brčko</option>
                    <option value="Bugojno">Bugojno</option>
                    <option value="Cazin">Cazin</option>
                    <option value="Doboj">Doboj</option>
                    <option value="Foča">Foča</option>
                    <option value="Goražde">Goražde</option>
                    <option value="Gračanica">Gračanica</option>
                    <option value="Gradačac">Gradačac</option>
                    <option value="Gradiška">Gradiška</option>
                    <option value="Kakanj">Kakanj</option>
                    <option value="Kiseljak">Kiseljak</option>
                    <option value="Konjic">Konjic</option>
                    <option value="Livno">Livno</option>
                    <option value="Lukavac">Lukavac</option>
                    <option value="Mostar">Mostar</option>
                    <option value="Mrkonjić Grad">Mrkonjić Grad</option>
                    <option value="Novi Travnik">Novi Travnik</option>
                    <option value="Odžak">Odžak</option>
                    <option value="Prijedor">Prijedor</option>
                    <option value="Prozor">Prozor</option>
                    <option value="Sanski Most">Sanski Most</option>
                    <option value="Sarajevo">Sarajevo</option>
                    <option value="Šipovo">Šipovo</option>
                    <option value="Travnik">Travnik</option>
                    <option value="Trebinje">Trebinje</option>
                    <option value="Tuzla">Tuzla</option>
                    <option value="Velika Kladuša">Velika Kladuša</option>
                    <option value="Visoko">Visoko</option>
                    <option value="Zavidovići">Zavidovići</option>
                    <option value="Zenica">Zenica</option>
                    <option value="Živinice">Živinice</option>
                </select>

                <?php
            }elseif ($pays == "Botswana"){
                ?>
                <select class="select" name="localisation">
                    <option value="Bobonong">Bobonong</option>
                    <option value="Francistown">Francistown</option>
                    <option value="Gabane">Gabane</option>
                    <option value="Gaborone">Gaborone</option>
                    <option value="Ghanzi">Ghanzi</option>
                    <option value="Gumare">Gumare</option>
                    <option value="Jwaneng">Jwaneng</option>
                    <option value="Kanye">Kanye</option>
                    <option value="Kasane">Kasane</option>
                    <option value="Kopong">Kopong</option>
                    <option value="Lerala">Lerala</option>
                    <option value="Letlhakane">Letlhakane</option>
                    <option value="Letlhakeng">Letlhakeng</option>
                    <option value="Lobatse">Lobatse</option>
                    <option value="Mahalapye">Mahalapye</option>
                    <option value="Maun">Maun</option>
                    <option value="Metsimotlhaba">Metsimotlhaba</option>
                    <option value="Mmadinare">Mmadinare</option>
                    <option value="Mochudi">Mochudi</option>
                    <option value="Mogoditshane">Mogoditshane</option>
                    <option value="Molapowabojang">Molapowabojang</option>
                    <option value="Molepolole">Molepolole</option>
                    <option value="Moshupa">Moshupa</option>
                    <option value="Orapa">Orapa</option>
                    <option value="Otse">Otse</option>
                    <option value="Palapye">Palapye</option>
                    <option value="Ramotswa">Ramotswa</option>
                    <option value="Selebi-Phikwe">Selebi-Phikwe</option>
                    <option value="Serowe">Serowe</option>
                    <option value="Shakawe">Shakawe</option>
                    <option value="Shoshong">Shoshong</option>
                    <option value="Thamaga">Thamaga</option>
                    <option value="Tlokweng">Tlokweng</option>
                    <option value="Tonota">Tonota</option>
                    <option value="Tsabong">Tsabong</option>
                    <option value="Tutume">Tutume</option>
                </select>

                <?php
            }elseif ($pays == "Bresil"){
                ?>
                <select class="select" name="localisation">
                    <option value="Alvorada">Alvorada</option>
                    <option value="Ananindeua">Ananindeua</option>
                    <option value="Anápolis">Anápolis</option>
                    <option value="Aparecida de Goiânia">Aparecida de Goiânia</option>
                    <option value="Aracaju">Aracaju</option>
                    <option value="Arapiraca">Arapiraca</option>
                    <option value="Barueri">Barueri</option>
                    <option value="Bauru">Bauru</option>
                    <option value="Belém">Belém</option>
                    <option value="Belford Roxo">Belford Roxo</option>
                    <option value="Belo Horizonte">Belo Horizonte</option>
                    <option value="Betim">Betim</option>
                    <option value="Blumenau">Blumenau</option>
                    <option value="Boa Vista">Boa Vista</option>
                    <option value="Brasília">Brasília</option>
                    <option value="Camacari">Camacari</option>
                    <option value="Campina Grande">Campina Grande</option>
                    <option value="Campinas">Campinas</option>
                    <option value="Campo Grande">Campo Grande</option>
                    <option value="Campos dos Goytacazes">Campos dos Goytacazes</option>
                    <option value="Canoas">Canoas</option>
                    <option value="Carapicuíba">Carapicuíba</option>
                    <option value="Cariacica">Cariacica</option>
                    <option value="Caruaru">Caruaru</option>
                    <option value="Cascavel">Cascavel</option>
                    <option value="Caucaia">Caucaia</option>
                    <option value="Caxias do Sul">Caxias do Sul</option>
                    <option value="Colombo">Colombo</option>
                    <option value="Contagem">Contagem</option>
                    <option value="Cuiabá">Cuiabá</option>
                    <option value="Curitiba">Curitiba</option>
                    <option value="Diadema">Diadema</option>
                    <option value="Divinópolis">Divinópolis</option>
                    <option value="Duque de Caxias">Duque de Caxias</option>
                    <option value="Embu">Embu</option>
                    <option value="Feira de Santana">Feira de Santana</option>
                    <option value="Florianópolis">Florianópolis</option>
                    <option value="Fortaleza">Fortaleza</option>
                    <option value="Foz do Iguaçu">Foz do Iguaçu</option>
                    <option value="Franca">Franca</option>
                    <option value="Goiânia">Goiânia</option>
                    <option value="Governador Valadares">Governador Valadares</option>
                    <option value="Gravatai">Gravatai</option>
                    <option value="Guarujá">Guarujá</option>
                    <option value="Guarulhos">Guarulhos</option>
                    <option value="Ilhéus">Ilhéus</option>
                    <option value="Imperatriz">Imperatriz</option>
                    <option value="Ipatinga">Ipatinga</option>
                    <option value="Itaboraí">Itaboraí</option>
                    <option value="Itabuna">Itabuna</option>
                    <option value="Itaquaquecetuba">Itaquaquecetuba</option>
                    <option value="Jaboatão dos Guararapes">Jaboatão dos Guararapes</option>
                    <option value="Jacareí">Jacareí</option>
                    <option value="João Pessoa">João Pessoa</option>
                    <option value="Joinville">Joinville</option>
                    <option value="Juazeiro">Juazeiro</option>
                    <option value="Juazeiro do Norte">Juazeiro do Norte</option>
                    <option value="Juiz de Fora">Juiz de Fora</option>
                    <option value="Jundiaí">Jundiaí</option>
                    <option value="Limeira">Limeira</option>
                    <option value="Londrina">Londrina</option>
                    <option value="Macapá">Macapá</option>
                    <option value="Maceió">Maceió</option>
                    <option value="Magé">Magé</option>
                    <option value="Manaus">Manaus</option>
                    <option value="Marília">Marília</option>
                    <option value="Maringá">Maringá</option>
                    <option value="Mauá">Mauá</option>
                    <option value="Mogi das Cruzes">Mogi das Cruzes</option>
                    <option value="Montes Claros">Montes Claros</option>
                    <option value="Mossoró">Mossoró</option>
                    <option value="Natal">Natal</option>
                    <option value="Niterói">Niterói</option>
                    <option value="Nova Iguaçu">Nova Iguaçu</option>
                    <option value="Novo Hamburgo">Novo Hamburgo</option>
                    <option value="Olinda">Olinda</option>
                    <option value="Osasco">Osasco</option>
                    <option value="Paulista">Paulista</option>
                    <option value="Pelotas">Pelotas</option>
                    <option value="Petrolina">Petrolina</option>
                    <option value="Petrópolis">Petrópolis</option>
                    <option value="Piracicaba">Piracicaba</option>
                    <option value="Ponta Grossa">Ponta Grossa</option>
                    <option value="Porto Alegre">Porto Alegre</option>
                    <option value="Porto Velho">Porto Velho</option>
                    <option value="Praia Grande">Praia Grande</option>
                    <option value="Presidente Prudente">Presidente Prudente</option>
                    <option value="Recife">Recife</option>
                    <option value="Ribeirão das Neves">Ribeirão das Neves</option>
                    <option value="Ribeirão Preto">Ribeirão Preto</option>
                    <option value="Rio Branco">Rio Branco</option>
                    <option value="Rio de Janeiro">Rio de Janeiro</option>
                    <option value="Salvador da Bahia">Salvador da Bahia</option>
                    <option value="Santa Luzia">Santa Luzia</option>
                    <option value="Santa Maria">Santa Maria</option>
                    <option value="Santarém">Santarém</option>
                    <option value="Santo André">Santo André</option>
                    <option value="Santos">Santos</option>
                    <option value="São Bernardo do Campo">São Bernardo do Campo</option>
                    <option value="São Carlos">São Carlos</option>
                    <option value="São Gonçalo">São Gonçalo</option>
                    <option value="São João de Meriti">São João de Meriti</option>
                    <option value="São José do Rio Preto">São José do Rio Preto</option>
                    <option value="São José dos Campos">São José dos Campos</option>
                    <option value="São José dos Pinhais">São José dos Pinhais</option>
                    <option value="São Leopoldo">São Leopoldo</option>
                    <option value="São Luís">São Luís</option>
                    <option value="São Paulo">São Paulo</option>
                    <option value="São Vicente">São Vicente</option>
                    <option value="Serra">Serra</option>
                    <option value="Sete Lagoas">Sete Lagoas</option>
                    <option value="Sorocaba">Sorocaba</option>
                    <option value="Sumaré">Sumaré</option>
                    <option value="Suzano">Suzano</option>
                    <option value="Taboão da Serra">Taboão da Serra</option>
                    <option value="Taubaté">Taubaté</option>
                    <option value="Teresina">Teresina</option>
                    <option value="Uberaba">Uberaba</option>
                    <option value="Uberlândia">Uberlândia</option>
                    <option value="Varzea Grande">Varzea Grande</option>
                    <option value="Viamao">Viamao</option>
                    <option value="Vila Velha">Vila Velha</option>
                    <option value="Vitória">Vitória</option>
                    <option value="Vitoria da Conquista">Vitoria da Conquista</option>
                    <option value="Volta Redonda">Volta Redonda</option>
                </select>

                <?php
            }elseif ($pays == "Brunei"){
                ?>
                <select name="localisation" class="select">
                    <option value="Bandar Seri Begawan">Bandar Seri Begawan</option>
                    <option value="Kuala Belait">Kuala Belait</option>
                    <option value="Seria">Seria</option>
                    <option value="Tutong">Tutong</option>
                    <option value="Bangar">Bangar</option>
                    <option value="Sukang">Sukang</option>
                    <option value="Panaga">Panaga</option>
                    <option value="Lumut">Lumut</option>
                    <option value="Labu">Labu</option>
                    <option value="Pekan Tutong">Pekan Tutong</option>
                    <option value="Kianggeh">Kianggeh</option>
                    <option value="Jerudong">Jerudong</option>
                    <option value="Pekan Muara">Pekan Muara</option>
                    <option value="Pekan Seria">Pekan Seria</option>
                    <option value="Kuala Balai">Kuala Balai</option>
                    <option value="Sungai Kebun">Sungai Kebun</option>
                    <option value="Serasa">Serasa</option>
                    <option value="Kapok">Kapok</option>
                    <option value="Kilanas">Kilanas</option>
                    <option value="Panaga Club">Panaga Club</option>
                    <option value="Mentiri">Mentiri</option>
                    <option value="Kampong Batong">Kampong Batong</option>
                    <option value="Peramu">Peramu</option>
                    <option value="Pekan Tutong">Pekan Tutong</option>
                    <option value="Kianggeh">Kianggeh</option>
                    <option value="Kuala Lurah">Kuala Lurah</option>
                    <option value="Serasa">Serasa</option>
                    <option value="Sungai Liang">Sungai Liang</option>
                    <option value="Sungai Kebun">Sungai Kebun</option>
                    <option value="Limbang">Limbang</option>
                    <option value="Melilas">Melilas</option>
                    <option value="Mukim Ukong">Mukim Ukong</option>
                    <option value="Mentiri">Mentiri</option>
                    <option value="Kampong Kapok">Kampong Kapok</option>
                    <option value="Kampong Pandan">Kampong Pandan</option>
                    <option value="Kampong Serusup">Kampong Serusup</option>
                    <option value="Kampong Sungai Akar">Kampong Sungai Akar</option>
                    <option value="Kampong Bunut">Kampong Bunut</option>
                    <option value="Kampong Batu Marang">Kampong Batu Marang</option>
                    <option value="Kampong Belimbing">Kampong Belimbing</option>
                    <option value="Kampong Burong Pingai Berakas">Kampong Burong Pingai Berakas</option>
                    <option value="Kampong Kiarong">Kampong Kiarong</option>
                    <option value="Kampong Madang">Kampong Madang</option>
                    <option value="Kampong Manggis">Kampong Manggis</option>
                    <option value="Kampong Mata-Mata">Kampong Mata-Mata</option>
                    <option value="Kampong Menglait">Kampong Menglait</option>
                    <option value="Kampong Meragang">Kampong Meragang</option>
                    <option value="Kampong Pengkalan Batu">Kampong Pengkalan Batu</option>
                    <option value="Kampong Serasa">Kampong Serasa</option>
                    <option value="Kampong Sengkurong">Kampong Sengkurong</option>
                    <option value="Kampong Subok">Kampong Subok</option>
                    <option value="Kampong Tamoi">Kampong Tamoi</option>
                    <option value="Kampong Tanjung Bunut">Kampong Tanjung Bunut</option>
                    <option value="Kampong Tanjung Nangka">Kampong Tanjung Nangka</option>
                    <option value="Kampong Tanjung Pelumpong">Kampong Tanjung Pelumpong</option>
                    <option value="Kampong Tanjung Uban">Kampong Tanjung Uban</option>
                    <option value="Kampong Tungku">Kampong Tungku</option>
                    <option value="Kampong Wasan">Kampong Wasan</option>
                    <option value="Muara">Muara</option>
                    <option value="Sengkurong">Sengkurong</option>
                    <option value="Serasa">Serasa</option>
                    <option value="Sungai Kebun">Sungai Kebun</option>
                    <option value="Sungai Kedayan">Sungai Kedayan</option>
                    <option value="Sungai Kuning">Sungai Kuning</option>
                    <option value="Sungai Lampai">Sungai Lampai</option>
                    <option value="Sungai Tilong">Sungai Tilong</option>
                    <option value="Tanjong Nangka">Tanjong Nangka</option>
                    <option value="Tanjong Pelumpong">Tanjong Pelumpong</option>
                    <option value="Tanjong Plentong">Tanjong Plentong</option>
                    <option value="Tanjong Uban">Tanjong Uban</option>
                    <option value="Tasek Meradun">Tasek Meradun</option>
                    <option value="Batu Apoi">Batu Apoi</option>
                    <option value="Temburong">Temburong</option>
                    <option value="Ukong">Ukong</option>
                    <!-- Ajoutez d'autres villes ici -->
                </select>

                <?php
            }elseif ($pays == "Bulgarie"){
                ?>
                <select class="select" name="localisation">
                    <option value="Asenovgrad">Asenovgrad</option>
                    <option value="Aytos">Aytos</option>
                    <option value="Blagoevgrad">Blagoevgrad</option>
                    <option value="Botevgrad">Botevgrad</option>
                    <option value="Bourgas">Bourgas</option>
                    <option value="Choumen">Choumen</option>
                    <option value="Dimitrovgrad">Dimitrovgrad</option>
                    <option value="Dobritch">Dobritch</option>
                    <option value="Dupnitsa">Dupnitsa</option>
                    <option value="Gabrovo">Gabrovo</option>
                    <option value="Gorna Oryahovitsa">Gorna Oryahovitsa</option>
                    <option value="Haskovo">Haskovo</option>
                    <option value="Kardjali">Kardjali</option>
                    <option value="Karlovo">Karlovo</option>
                    <option value="Kazanlak">Kazanlak</option>
                    <option value="Kyoustendil">Kyoustendil</option>
                    <option value="Lom">Lom</option>
                    <option value="Lovetch">Lovetch</option>
                    <option value="Montana">Montana</option>
                    <option value="Nova Zagora">Nova Zagora</option>
                    <option value="Pazardjik">Pazardjik</option>
                    <option value="Pernik">Pernik</option>
                    <option value="Petritch">Petritch</option>
                    <option value="Pleven">Pleven</option>
                    <option value="Plovdiv">Plovdiv</option>
                    <option value="Razgrad">Razgrad</option>
                    <option value="Roussé">Roussé</option>
                    <option value="Samokov">Samokov</option>
                    <option value="Sandanski">Sandanski</option>
                    <option value="Sevlievo">Sevlievo</option>
                    <option value="Silistra">Silistra</option>
                    <option value="Sliven">Sliven</option>
                    <option value="Smolyan">Smolyan</option>
                    <option value="Sofia">Sofia</option>
                    <option value="Stara Zagora">Stara Zagora</option>
                    <option value="Svichtov">Svichtov</option>
                    <option value="Targovichte">Targovichte</option>
                    <option value="Trojan">Trojan</option>
                    <option value="Varna">Varna</option>
                    <option value="Veliko Tarnovo">Veliko Tarnovo</option>
                    <option value="Velingrad">Velingrad</option>
                    <option value="Vidin">Vidin</option>
                    <option value="Vratsa">Vratsa</option>
                    <option value="Yambol">Yambol</option>
                </select>

                <?php
            }elseif ($pays == "Burkina Faso"){
                ?>
                <select class="select" name="localisation">
                    <option value="Aribinda">Aribinda</option>
                    <option value="Banfora">Banfora</option>
                    <option value="Batie">Batie</option>
                    <option value="Bekuy">Bekuy</option>
                    <option value="Bobo dioulasso">Bobo dioulasso</option>
                    <option value="Bogande">Bogande</option>
                    <option value="Boromo">Boromo</option>
                    <option value="Boulsa">Boulsa</option>
                    <option value="Bousse">Bousse</option>
                    <option value="Dano">Dano</option>
                    <option value="Dedougou">Dedougou</option>
                    <option value="Diapaga">Diapaga</option>
                    <option value="Diebougou">Diebougou</option>
                    <option value="Djibo">Djibo</option>
                    <option value="Dori">Dori</option>
                    <option value="Fada n'gourma">Fada n'gourma</option>
                    <option value="Gao">Gao</option>
                    <option value="Gaoua">Gaoua</option>
                    <option value="Garango">Garango</option>
                    <option value="Gayeri">Gayeri</option>
                    <option value="Gorom-gorom">Gorom-gorom</option>
                    <option value="Gourcy">Gourcy</option>
                    <option value="Hounde">Hounde</option>
                    <option value="Kampti">Kampti</option>
                    <option value="Kantchari">Kantchari</option>
                    <option value="Kaya">Kaya</option>
                    <option value="Koalla">Koalla</option>
                    <option value="Koloko">Koloko</option>
                    <option value="Kombissiri">Kombissiri</option>
                    <option value="Kongoussi">Kongoussi</option>
                    <option value="Koudougou">Koudougou</option>
                    <option value="Koupela">Koupela</option>
                    <option value="Leo">Leo</option>
                    <option value="Loropeni">Loropeni</option>
                    <option value="Louta">Louta</option>
                    <option value="Manga">Manga</option>
                    <option value="Nayouri">Nayouri</option>
                    <option value="Nouna">Nouna</option>
                    <option value="Orodara">Orodara</option>
                    <option value="Ouagadougou">Ouagadougou</option>
                    <option value="Ouahigouya">Ouahigouya</option>
                    <option value="Pa">Pa</option>
                    <option value="Pama">Pama</option>
                    <option value="Po">Po</option>
                    <option value="Reo">Reo</option>
                    <option value="Sindou">Sindou</option>
                    <option value="Tenkodogo">Tenkodogo</option>
                    <option value="Tougan">Tougan</option>
                    <option value="Yako">Yako</option>
                    <option value="Yambi">Yambi</option>
                    <option value="Ziniare">Ziniare</option>
                    <option value="Zorgo">Zorgo</option>
                </select>

                <?php
            }elseif ($pays == "Burundi"){
                ?>
                <select class="select" name="localisation">
                    <option value="Bubanza">Bubanza</option>
                    <option value="Bujumbura">Bujumbura</option>
                    <option value="Bururi">Bururi</option>
                    <option value="Cankuzo">Cankuzo</option>
                    <option value="Cibitoke">Cibitoke</option>
                    <option value="Gatumba">Gatumba</option>
                    <option value="Gihofi">Gihofi</option>
                    <option value="Gitega">Gitega</option>
                    <option value="Karuzi">Karuzi</option>
                    <option value="Kayanza">Kayanza</option>
                    <option value="Kirundo">Kirundo</option>
                    <option value="Makamba">Makamba</option>
                    <option value="Muramvya">Muramvya</option>
                    <option value="Muyinga">Muyinga</option>
                    <option value="Mwaro">Mwaro</option>
                    <option value="Ngozi">Ngozi</option>
                    <option value="Nyanza Lac">Nyanza Lac</option>
                    <option value="Rumonge">Rumonge</option>
                    <option value="Rutana">Rutana</option>
                    <option value="Ruyigi">Ruyigi</option>
                </select>

                <?php
            }elseif ($pays == "Cambodge"){
                ?>
                <select class="select" name="localisation">
                    <option value="Banlung">Banlung</option>
                    <option value="Battambang">Battambang</option>
                    <option value="Kampong Cham">Kampong Cham</option>
                    <option value="Kampong Chhnang">Kampong Chhnang</option>
                    <option value="Kampong Spoe">Kampong Spoe</option>
                    <option value="Kampong Thum">Kampong Thum</option>
                    <option value="Kampong Trach">Kampong Trach</option>
                    <option value="Kampot">Kampot</option>
                    <option value="Kaoh Kong">Kaoh Kong</option>
                    <option value="Kep">Kep</option>
                    <option value="Kokir">Kokir</option>
                    <option value="Kratie">Kratie</option>
                    <option value="Lumphat">Lumphat</option>
                    <option value="Pailin">Pailin</option>
                    <option value="Paoy Pet">Paoy Pet</option>
                    <option value="Peam Ro">Peam Ro</option>
                    <option value="Phnom Penh">Phnom Penh</option>
                    <option value="Phumi Samraong">Phumi Samraong</option>
                    <option value="Pouthisat">Pouthisat</option>
                    <option value="Prey Veng">Prey Veng</option>
                    <option value="Saen Monourom">Saen Monourom</option>
                    <option value="Siem Reap">Siem Reap</option>
                    <option value="Sihanoukville">Sihanoukville</option>
                    <option value="Sisophon">Sisophon</option>
                    <option value="Sre Ambel">Sre Ambel</option>
                    <option value="Stoeng Treng">Stoeng Treng</option>
                    <option value="Suong">Suong</option>
                    <option value="Svay Rieng">Svay Rieng</option>
                    <option value="Ta Khmau">Ta Khmau</option>
                    <option value="Takeo">Takeo</option>
                    <option value="Tbeng Meancheay">Tbeng Meancheay</option>
                </select>

                <?php
            }elseif ($pays == "Cameroun"){
                ?>
                <select class="select" name="localisation">
                    <option value="Abong-Mbang">Abong-Mbang</option>
                    <option value="Akonolinga">Akonolinga</option>
                    <option value="Bafang">Bafang</option>
                    <option value="Bafia">Bafia</option>
                    <option value="Bafoussam">Bafoussam</option>
                    <option value="Bali">Bali</option>
                    <option value="Bamenda">Bamenda</option>
                    <option value="Bangangté">Bangangté</option>
                    <option value="Banyo">Banyo</option>
                    <option value="Batibo">Batibo</option>
                    <option value="Batouri">Batouri</option>
                    <option value="Bélabo">Bélabo</option>
                    <option value="Bertoua">Bertoua</option>
                    <option value="Blangoua">Blangoua</option>
                    <option value="Bogo">Bogo</option>
                    <option value="Buea">Buea</option>
                    <option value="Douala">Douala</option>
                    <option value="Dschang">Dschang</option>
                    <option value="Ebolowa">Ebolowa</option>
                    <option value="Edéa">Edéa</option>
                    <option value="Eséka">Eséka</option>
                    <option value="Figuil">Figuil</option>
                    <option value="Fontem">Fontem</option>
                    <option value="Foumban">Foumban</option>
                    <option value="Foumbot">Foumbot</option>
                    <option value="Fundong">Fundong</option>
                    <option value="Garoua">Garoua</option>
                    <option value="Garoua-Boulaï">Garoua-Boulaï</option>
                    <option value="Gazawa">Gazawa</option>
                    <option value="Guider">Guider</option>
                    <option value="Guidiguis">Guidiguis</option>
                    <option value="Kaélé">Kaélé</option>
                    <option value="Kékem">Kékem</option>
                    <option value="Kousséri">Kousséri</option>
                    <option value="Koutaba">Koutaba</option>
                    <option value="Kribi">Kribi</option>
                    <option value="Kumba">Kumba</option>
                    <option value="Kumbo">Kumbo</option>
                    <option value="Limbé">Limbé</option>
                    <option value="Loum">Loum</option>
                    <option value="Maga">Maga</option>
                    <option value="Magba">Magba</option>
                    <option value="Makénéné">Makénéné</option>
                    <option value="Mamfé">Mamfé</option>
                    <option value="Manjo">Manjo</option>
                    <option value="Maroua">Maroua</option>
                    <option value="Mbalmayo">Mbalmayo</option>
                    <option value="Mbandjock">Mbandjock</option>
                    <option value="Mbanga">Mbanga</option>
                    <option value="Mbouda">Mbouda</option>
                    <option value="Meiganga">Meiganga</option>
                    <option value="Melong">Melong</option>
                    <option value="Mokolo">Mokolo</option>
                    <option value="Mora">Mora</option>
                    <option value="Muyuka">Muyuka</option>
                    <option value="Nanga-Eboko">Nanga-Eboko</option>
                    <option value="Ndop">Ndop</option>
                    <option value="Ngaoundal">Ngaoundal</option>
                    <option value="Ngaoundéré">Ngaoundéré</option>
                    <option value="Nkambé">Nkambé</option>
                    <option value="Nkongsamba">Nkongsamba</option>
                    <option value="Nkoteng">Nkoteng</option>
                    <option value="Obala">Obala</option>
                    <option value="Pitoa">Pitoa</option>
                    <option value="Sangmélima">Sangmélima</option>
                    <option value="Tcholliré">Tcholliré</option>
                    <option value="Tibati">Tibati</option>
                    <option value="Tiko">Tiko</option>
                    <option value="Tombel">Tombel</option>
                    <option value="Tonga">Tonga</option>
                    <option value="Touboro">Touboro</option>
                    <option value="Wum">Wum</option>
                    <option value="Yabassi">Yabassi</option>
                    <option value="Yagoua">Yagoua</option>
                    <option value="Yaoundé">Yaoundé</option>
                    <option value="Yokadouma">Yokadouma</option>
                </select>

                <?php
            }elseif ($pays == "Cananda"){
                ?>
                <select class="select" name="localisation">
                    <option value="Abbotsford">Abbotsford</option>
                    <option value="Armstrong">Armstrong</option>
                    <option value="Burnaby">Burnaby</option>
                    <option value="Campbell River">Campbell River</option>
                    <option value="Castlegar">Castlegar</option>
                    <option value="Chilliwack">Chilliwack</option>
                    <option value="Cloverdale">Cloverdale</option>
                    <option value="Colwood">Colwood</option>
                    <option value="Coquitlam">Coquitlam</option>
                    <option value="Courtenay">Courtenay</option>
                    <option value="Cranbrook">Cranbrook</option>
                    <option value="Dawson Creek">Dawson Creek</option>
                    <option value="Duncan">Duncan</option>
                    <option value="Enderby">Enderby</option>
                    <option value="Fernie">Fernie</option>
                    <option value="Fort St. John">Fort St. John</option>
                    <option value="Grand Forks">Grand Forks</option>
                    <option value="Greenwood">Greenwood</option>
                    <option value="Kamloops">Kamloops</option>
                    <option value="Kelowna">Kelowna</option>
                    <option value="Kimberley">Kimberley</option>
                    <option value="Kitimat">Kitimat</option>
                    <option value="Langford">Langford</option>
                    <option value="Langley">Langley</option>
                    <option value="Merritt">Merritt</option>
                    <option value="Mission">Mission</option>
                    <option value="Nanaimo">Nanaimo</option>
                    <option value="Nelson">Nelson</option>
                    <option value="New Westminster">New Westminster</option>
                    <option value="North Vancouver">North Vancouver</option>
                    <option value="Parksville">Parksville</option>
                    <option value="Penticton">Penticton</option>
                    <option value="Pitt Meadows">Pitt Meadows</option>
                    <option value="Port Alberni">Port Alberni</option>
                    <option value="Port Coquitlam">Port Coquitlam</option>
                    <option value="Port Moody">Port Moody</option>
                    <option value="Powell River">Powell River</option>
                    <option value="Prince George">Prince George</option>
                    <option value="Prince Rupert">Prince Rupert</option>
                    <option value="Quesnel">Quesnel</option>
                    <option value="Revelstoke">Revelstoke</option>
                    <option value="Richmond">Richmond</option>
                    <option value="Rossland">Rossland</option>
                    <option value="Salmon Arm">Salmon Arm</option>
                    <option value="Surrey">Surrey</option>
                    <option value="Terrace">Terrace</option>
                    <option value="Trail">Trail</option>
                    <option value="Vancouver">Vancouver</option>
                    <option value="Vernon">Vernon</option>
                    <option value="Victoria">Victoria</option>
                    <option value="White Rock">White Rock</option>
                    <option value="Williams Lake">Williams Lake</option>
                </select>

                <?php
            }elseif ($pays == "Cap-vert"){
                ?>
                <select class="select" name="localisation">
                    <option value="Alto Hospicio">Alto Hospicio</option>
                    <option value="Angol">Angol</option>
                    <option value="Antofagasta">Antofagasta</option>
                    <option value="Arica">Arica</option>
                    <option value="Buin">Buin</option>
                    <option value="Calama">Calama</option>
                    <option value="Chiguayante">Chiguayante</option>
                    <option value="Chillán">Chillán</option>
                    <option value="Colina">Colina</option>
                    <option value="Concepción">Concepción</option>
                    <option value="Copiapó">Copiapó</option>
                    <option value="Coquimbo">Coquimbo</option>
                    <option value="Coronel">Coronel</option>
                    <option value="Coyhaique">Coyhaique</option>
                    <option value="Curicó">Curicó</option>
                    <option value="Hualpén">Hualpén</option>
                    <option value="Iquique">Iquique</option>
                    <option value="La Calera">La Calera</option>
                    <option value="La Serena">La Serena</option>
                    <option value="Linares">Linares</option>
                    <option value="Los Andes">Los Andes</option>
                    <option value="Los Ángeles">Los Ángeles</option>
                    <option value="Lota">Lota</option>
                    <option value="Melipilla">Melipilla</option>
                    <option value="Osorno">Osorno</option>
                    <option value="Ovalle">Ovalle</option>
                    <option value="Peñaflor">Peñaflor</option>
                    <option value="Penco">Penco</option>
                    <option value="Puente Alto">Puente Alto</option>
                    <option value="Puerto Montt">Puerto Montt</option>
                    <option value="Punta Arenas">Punta Arenas</option>
                    <option value="Quillota">Quillota</option>
                    <option value="Quilpué">Quilpué</option>
                    <option value="Rancagua">Rancagua</option>
                    <option value="San Antonio">San Antonio</option>
                    <option value="San Bernardo">San Bernardo</option>
                    <option value="San Felipe">San Felipe</option>
                    <option value="San Fernando">San Fernando</option>
                    <option value="San Pedro de la Paz">San Pedro de la Paz</option>
                    <option value="Santiago du Chili">Santiago du Chili</option>
                    <option value="Talagante">Talagante</option>
                    <option value="Talca">Talca</option>
                    <option value="Talcahuano">Talcahuano</option>
                    <option value="Temuco">Temuco</option>
                    <option value="Tomé">Tomé</option>
                    <option value="Valdivia">Valdivia</option>
                    <option value="Vallenar">Vallenar</option>
                    <option value="Valparaíso">Valparaíso</option>
                    <option value="Villa Alemana">Villa Alemana</option>
                    <option value="Viña del Mar">Viña del Mar</option>
                </select>

                <?php
            }elseif ($pays == "Chili"){
                ?>
                <select class="select" name="localisation">
                    <option value="Assomada">Assomada</option>
                    <option value="Calheta de São Miguel">Calheta de São Miguel</option>
                    <option value="Espargos">Espargos</option>
                    <option value="Mindelo">Mindelo</option>
                    <option value="Pedra Badejo">Pedra Badejo</option>
                    <option value="Picos">Picos</option>
                    <option value="Porto Novo">Porto Novo</option>
                    <option value="Praia">Praia</option>
                    <option value="Ribeira Brava">Ribeira Brava</option>
                    <option value="Santa Maria">Santa Maria</option>
                    <option value="São Filipe">São Filipe</option>
                    <option value="Tarrafal">Tarrafal</option>
                    <option value="Vila do Maio">Vila do Maio</option>
                </select>

                <?php
            }elseif ($pays == "Chine"){
                ?>
                <select class="select" name="localisation">
                    <option value="Canton">Canton</option>
                    <option value="Changchun">Changchun</option>
                    <option value="Changsha">Changsha</option>
                    <option value="Chengdu">Chengdu</option>
                    <option value="Chongqing">Chongqing</option>
                    <option value="Dalian">Dalian</option>
                    <option value="Dongguan">Dongguan</option>
                    <option value="Hangzhou">Hangzhou</option>
                    <option value="Harbin">Harbin</option>
                    <option value="Hong Kong">Hong Kong</option>
                    <option value="Jinan">Jinan</option>
                    <option value="Nanchang">Nanchang</option>
                    <option value="Nankin">Nankin</option>
                    <option value="Pékin">Pékin</option>
                    <option value="Qingdao">Qingdao</option>
                    <option value="Shanghai">Shanghai</option>
                    <option value="Shenyang">Shenyang</option>
                    <option value="Shenzhen">Shenzhen</option>
                    <option value="Shijiazhuang">Shijiazhuang</option>
                    <option value="Tianjin">Tianjin</option>
                    <option value="Wuhan">Wuhan</option>
                    <option value="Xi'an">Xi'an</option>
                </select>

                <?php
            }elseif ($pays == "Chypre"){
                ?>
                <select class="select" name="localisation">
                    <option value="Aglantsiá">Aglantsiá</option>
                    <option value="Aradíppou">Aradíppou</option>
                    <option value="Athiénou">Athiénou</option>
                    <option value="Avgórou">Avgórou</option>
                    <option value="Áyios Athanásios">Áyios Athanásios</option>
                    <option value="Áyios Dométios">Áyios Dométios</option>
                    <option value="Dáli">Dáli</option>
                    <option value="Derýnia">Derýnia</option>
                    <option value="Dromolaxiá">Dromolaxiá</option>
                    <option value="Émpa">Émpa</option>
                    <option value="Éngomi">Éngomi</option>
                    <option value="Famagouste">Famagouste</option>
                    <option value="Géri">Géri</option>
                    <option value="Geroskípou">Geroskípou</option>
                    <option value="Gialoúsa">Gialoúsa</option>
                    <option value="Káto Polemídia">Káto Polemídia</option>
                    <option value="Kyrenia">Kyrenia</option>
                    <option value="Kythréa">Kythréa</option>
                    <option value="Lakatámia">Lakatámia</option>
                    <option value="Lápithos">Lápithos</option>
                    <option value="Larnaca">Larnaca</option>
                    <option value="Latsiá">Latsiá</option>
                    <option value="Lefke">Lefke</option>
                    <option value="Limassol">Limassol</option>
                    <option value="Liopétri">Liopétri</option>
                    <option value="Livádia">Livádia</option>
                    <option value="Mésa Yitoniá">Mésa Yitoniá</option>
                    <option value="Morfou">Morfou</option>
                    <option value="Nicosie">Nicosie</option>
                    <option value="Ormídia">Ormídia</option>
                    <option value="Paleométocho">Paleométocho</option>
                    <option value="Paphos">Paphos</option>
                    <option value="Paralímni">Paralímni</option>
                    <option value="Rizokárpaso">Rizokárpaso</option>
                    <option value="Sotíra">Sotíra</option>
                    <option value="Stróvolos">Stróvolos</option>
                    <option value="Tríkomo">Tríkomo</option>
                    <option value="Tséri">Tséri</option>
                    <option value="Xylofágou">Xylofágou</option>
                    <option value="Yermasóyia">Yermasóyia</option>
                    <option value="Ýpsonas">Ýpsonas</option>
                </select>

                <?php
            }elseif ($pays == "Colombie"){
                ?>
                <select class="select" name="localisation">
                    <option value="Aguachica">Aguachica</option>
                    <option value="Apartadó">Apartadó</option>
                    <option value="Arauca">Arauca</option>
                    <option value="Armenia">Armenia</option>
                    <option value="Barrancabermeja">Barrancabermeja</option>
                    <option value="Barranquilla">Barranquilla</option>
                    <option value="Bello">Bello</option>
                    <option value="Bogota">Bogota</option>
                    <option value="Bucaramanga">Bucaramanga</option>
                    <option value="Buenaventura">Buenaventura</option>
                    <option value="Buga">Buga</option>
                    <option value="Cali">Cali</option>
                    <option value="Cartago">Cartago</option>
                    <option value="Carthagène des Indes">Carthagène des Indes</option>
                    <option value="Caucasia">Caucasia</option>
                    <option value="Cereté">Cereté</option>
                    <option value="Chía">Chía</option>
                    <option value="Ciénaga">Ciénaga</option>
                    <option value="Cúcuta">Cúcuta</option>
                    <option value="Dosquebradas">Dosquebradas</option>
                    <option value="Duitama">Duitama</option>
                    <option value="Envigado">Envigado</option>
                    <option value="Facatativá">Facatativá</option>
                    <option value="Florencia">Florencia</option>
                    <option value="Floridablanca">Floridablanca</option>
                    <option value="Fusagasugá">Fusagasugá</option>
                    <option value="Girardot">Girardot</option>
                    <option value="Girón">Girón</option>
                    <option value="Ibagué">Ibagué</option>
                    <option value="Ipiales">Ipiales</option>
                    <option value="Itagüí">Itagüí</option>
                    <option value="Jamundí">Jamundí</option>
                    <option value="Los Patios">Los Patios</option>
                    <option value="Magangué">Magangué</option>
                    <option value="Maicao">Maicao</option>
                    <option value="Malambo">Malambo</option>
                    <option value="Manizales">Manizales</option>
                    <option value="Medellín">Medellín</option>
                    <option value="Montería">Montería</option>
                    <option value="Neiva">Neiva</option>
                    <option value="Ocaña">Ocaña</option>
                    <option value="Palmira">Palmira</option>
                    <option value="Pamplona">Pamplona</option>
                    <option value="Pasto">Pasto</option>
                    <option value="Pereira">Pereira</option>
                    <option value="Piedecuesta">Piedecuesta</option>
                    <option value="Pitalito">Pitalito</option>
                    <option value="Popayán">Popayán</option>
                    <option value="Quibdó">Quibdó</option>
                    <option value="Riohacha">Riohacha</option>
                    <option value="Rionegro">Rionegro</option>
                    <option value="Sabanalarga">Sabanalarga</option>
                    <option value="Sahagún">Sahagún</option>
                    <option value="Santa Cruz de Lorica">Santa Cruz de Lorica</option>
                    <option value="Santa Marta">Santa Marta</option>
                    <option value="Sincelejo">Sincelejo</option>
                    <option value="Soacha">Soacha</option>
                    <option value="Sogamoso">Sogamoso</option>
                    <option value="Soledad">Soledad</option>
                    <option value="Tibú">Tibú</option>
                    <option value="Tuluá">Tuluá</option>
                    <option value="Tumaco">Tumaco</option>
                    <option value="Tunja">Tunja</option>
                    <option value="Turbo">Turbo</option>
                    <option value="Valledupar">Valledupar</option>
                    <option value="Villa del Rosario">Villa del Rosario</option>
                    <option value="Villavicencio">Villavicencio</option>
                    <option value="Yopal">Yopal</option>
                    <option value="Yumbo">Yumbo</option>
                    <option value="Zipaquirá">Zipaquirá</option>
                </select>

                <?php
            }elseif ($pays == "Comores"){
                ?>
                <select class="select" name="localisation">
                    <option value="Adda Daouéni">Adda Daouéni</option>
                    <option value="Barakani">Barakani</option>
                    <option value="Batsa">Batsa</option>
                    <option value="Bazmini">Bazmini</option>
                    <option value="Chandra">Chandra</option>
                    <option value="Dindri">Dindri</option>
                    <option value="Domoni">Domoni</option>
                    <option value="Fomboni">Fomboni</option>
                    <option value="Foumbouni">Foumbouni</option>
                    <option value="Iconi">Iconi</option>
                    <option value="Itsandzeni">Itsandzeni</option>
                    <option value="Jimlimi">Jimlimi</option>
                    <option value="Koki">Koki</option>
                    <option value="Koni Djodjo">Koni Djodjo</option>
                    <option value="Magnassini">Magnassini</option>
                    <option value="Mbambao Mtsanga">Mbambao Mtsanga</option>
                    <option value="Mbéni">Mbéni</option>
                    <option value="Mirontsi">Mirontsi</option>
                    <option value="Mitsamiouli">Mitsamiouli</option>
                    <option value="Mitsoudjé-Troumbeni">Mitsoudjé-Troumbeni</option>
                    <option value="Moroni">Moroni</option>
                    <option value="Moya">Moya</option>
                    <option value="Mramani">Mramani</option>
                    <option value="Mrémani">Mrémani</option>
                    <option value="Mutsamudu">Mutsamudu</option>
                    <option value="Mvouni">Mvouni</option>
                    <option value="Ngandzalé">Ngandzalé</option>
                    <option value="Nkourani Sima">Nkourani Sima</option>
                    <option value="Ouani">Ouani</option>
                    <option value="Ouellah Hamahamet">Ouellah Hamahamet</option>
                    <option value="Ounkazi">Ounkazi</option>
                    <option value="Sima">Sima</option>
                    <option value="Singani">Singani</option>
                    <option value="Tsembéhou">Tsembéhou</option>
                </select>

                <?php
            }elseif ($pays == "Congo"){
                ?>
                <select class="select" name="localisation">
                    <option value="Brazzaville">Brazzaville</option>
                    <option value="Pointe-Noire">Pointe-Noire</option>
                    <option value="Dolisie">Dolisie</option>
                    <option value="Nkayi">Nkayi</option>
                    <option value="Owando">Owando</option>
                    <option value="Impfondo">Impfondo</option>
                    <option value="Kinkala">Kinkala</option>
                    <option value="Mossendjo">Mossendjo</option>
                    <option value="Sibiti">Sibiti</option>
                    <option value="Ewo">Ewo</option>
                    <option value="Gamboma">Gamboma</option>
                    <option value="Ouésso">Ouésso</option>
                    <option value="Loandjili">Loandjili</option>
                    <option value="Madingou">Madingou</option>
                    <option value="Kayes">Kayes</option>
                    <option value="Mossendjo">Mossendjo</option>
                    <option value="Sibiti">Sibiti</option>
                    <option value="Ewo">Ewo</option>
                    <option value="Gamboma">Gamboma</option>
                    <option value="Ouésso">Ouésso</option>
                    <option value="Loandjili">Loandjili</option>
                    <option value="Madingou">Madingou</option>
                    <option value="Kayes">Kayes</option>
                </select>

                <?php
            }elseif ($pays == "Coree du Nord"){
                ?>
                <select class="select" name="localisation">
                    <option value="Anju">Anju</option>
                    <option value="Ch'ŏngjin">Ch'ŏngjin</option>
                    <option value="Haeju">Haeju</option>
                    <option value="Hamhŭng">Hamhŭng</option>
                    <option value="Hoeryŏng">Hoeryŏng</option>
                    <option value="Hŭich'ŏn">Hŭich'ŏn</option>
                    <option value="Hyesan">Hyesan</option>
                    <option value="Jŏngju">Jŏngju</option>
                    <option value="Kaech'ŏn">Kaech'ŏn</option>
                    <option value="Kaesŏng">Kaesŏng</option>
                    <option value="Kanggye">Kanggye</option>
                    <option value="Kimch'aek">Kimch'aek</option>
                    <option value="Kusong">Kusong</option>
                    <option value="Manpho">Manpho</option>
                    <option value="Munch'ŏn">Munch'ŏn</option>
                    <option value="Nampho">Nampho</option>
                    <option value="Pyongsong">Pyongsong</option>
                    <option value="Pyongyang">Pyongyang</option>
                    <option value="Rasŏn">Rasŏn</option>
                    <option value="Sariwŏn">Sariwŏn</option>
                    <option value="Sinpho">Sinpho</option>
                    <option value="Sinŭiju">Sinŭiju</option>
                    <option value="Songrim">Songrim</option>
                    <option value="Sunchon">Sunchon</option>
                    <option value="Tanch'ŏn">Tanch'ŏn</option>
                    <option value="Tŏkch'ŏn">Tŏkch'ŏn</option>
                    <option value="Wŏnsan">Wŏnsan</option>
                </select>

                <?php
            }elseif ($pays == "Coree du Sud"){
                ?>
                <select class="select" name="localisation">
                    <option value="Andong">Andong</option>
                    <option value="Ansan">Ansan</option>
                    <option value="Anseong">Anseong</option>
                    <option value="Anyang">Anyang</option>
                    <option value="Asan">Asan</option>
                    <option value="Boryeong">Boryeong</option>
                    <option value="Bucheon">Bucheon</option>
                    <option value="Busan">Busan</option>
                    <option value="Changwon">Changwon</option>
                    <option value="Cheonan">Cheonan</option>
                    <option value="Cheongju">Cheongju</option>
                    <option value="Chuncheon">Chuncheon</option>
                    <option value="Chungju">Chungju</option>
                    <option value="Daegu">Daegu</option>
                    <option value="Daejeon">Daejeon</option>
                    <option value="Dangjin">Dangjin</option>
                    <option value="Dongducheon">Dongducheon</option>
                    <option value="Donghae">Donghae</option>
                    <option value="Gangneung">Gangneung</option>
                    <option value="Geoje">Geoje</option>
                    <option value="Gimcheon">Gimcheon</option>
                    <option value="Gimhae">Gimhae</option>
                    <option value="Gimje">Gimje</option>
                    <option value="Gimpo">Gimpo</option>
                    <option value="Gongju">Gongju</option>
                    <option value="Goyang">Goyang</option>
                    <option value="Gumi">Gumi</option>
                    <option value="Gunpo">Gunpo</option>
                    <option value="Gunsan">Gunsan</option>
                    <option value="Guri">Guri</option>
                    <option value="Gwacheon">Gwacheon</option>
                    <option value="Gwangju">Gwangju</option>
                    <option value="Gwangmyeong">Gwangmyeong</option>
                    <option value="Gwangyang">Gwangyang</option>
                    <option value="Gyeongju">Gyeongju</option>
                    <option value="Gyeongsan">Gyeongsan</option>
                    <option value="Gyeryong">Gyeryong</option>
                    <option value="Hanam">Hanam</option>
                    <option value="Hwaseong">Hwaseong</option>
                    <option value="Icheon">Icheon</option>
                    <option value="Iksan">Iksan</option>
                    <option value="Incheon">Incheon</option>
                    <option value="Jecheon">Jecheon</option>
                    <option value="Jeju">Jeju</option>
                    <option value="Jeongeup">Jeongeup</option>
                    <option value="Jeonju">Jeonju</option>
                    <option value="Jinju">Jinju</option>
                    <option value="Miryang">Miryang</option>
                    <option value="Mokpo">Mokpo</option>
                    <option value="Mungyeong">Mungyeong</option>
                    <option value="Naju">Naju</option>
                    <option value="Namwon">Namwon</option>
                    <option value="Namyangju">Namyangju</option>
                    <option value="Nonsan">Nonsan</option>
                    <option value="Osan">Osan</option>
                    <option value="Paju">Paju</option>
                    <option value="Pocheon">Pocheon</option>
                    <option value="Pohang">Pohang</option>
                    <option value="Pyeongtaek">Pyeongtaek</option>
                    <option value="Sacheon">Sacheon</option>
                    <option value="Samcheok">Samcheok</option>
                    <option value="Sangju">Sangju</option>
                    <option value="Sejong">Sejong</option>
                    <option value="Seogwipo">Seogwipo</option>
                    <option value="Seongnam">Seongnam</option>
                    <option value="Seosan">Seosan</option>
                    <option value="Séoul">Séoul</option>
                    <option value="Siheung">Siheung</option>
                    <option value="Sokcho">Sokcho</option>
                    <option value="Suncheon">Suncheon</option>
                    <option value="Suwon">Suwon</option>
                    <option value="Taebaek">Taebaek</option>
                    <option value="Tongyeong">Tongyeong</option>
                    <option value="Uijeongbu">Uijeongbu</option>
                    <option value="Uiwang">Uiwang</option>
                    <option value="Ulsan">Ulsan</option>
                    <option value="Wonju">Wonju</option>
                    <option value="Yangju">Yangju</option>
                    <option value="Yangsan">Yangsan</option>
                    <option value="Yeoju">Yeoju</option>
                    <option value="Yeongcheon">Yeongcheon</option>
                    <option value="Yeongju">Yeongju</option>
                    <option value="Yeosu">Yeosu</option>
                    <option value="Yongin">Yongin</option>
                </select>

                <?php
            }elseif ($pays == "Costa Rica"){
                ?>
                <select class="select" name="localisation">
                    <option value="Aguacaliente">Aguacaliente</option>
                    <option value="Alajuela">Alajuela</option>
                    <option value="Aserrí">Aserrí</option>
                    <option value="Calle Blancos">Calle Blancos</option>
                    <option value="Cañas">Cañas</option>
                    <option value="Cartago">Cartago</option>
                    <option value="Chacarita">Chacarita</option>
                    <option value="Concepción">Concepción</option>
                    <option value="Curridabat">Curridabat</option>
                    <option value="Desamparados">Desamparados</option>
                    <option value="El Tejar">El Tejar</option>
                    <option value="Guadalupe">Guadalupe</option>
                    <option value="Heredia">Heredia</option>
                    <option value="Ipís">Ipís</option>
                    <option value="Liberia">Liberia</option>
                    <option value="Paraíso">Paraíso</option>
                    <option value="Patalillo">Patalillo</option>
                    <option value="Patarrá">Patarrá</option>
                    <option value="Puerto Limón">Puerto Limón</option>
                    <option value="Puntarenas">Puntarenas</option>
                    <option value="Purral">Purral</option>
                    <option value="Quesada">Quesada</option>
                    <option value="San Antonio">San Antonio</option>
                    <option value="San Felipe">San Felipe</option>
                    <option value="San Francisco">San Francisco</option>
                    <option value="San Isidro de El General">San Isidro de El General</option>
                    <option value="San José">San José</option>
                    <option value="San José de Alajuela">San José de Alajuela</option>
                    <option value="San Juan de Tibás">San Juan de Tibás</option>
                    <option value="San Miguel">San Miguel</option>
                    <option value="San Nicolás">San Nicolás</option>
                    <option value="San Pablo">San Pablo</option>
                    <option value="San Pedro Montes de Oca">San Pedro Montes de Oca</option>
                    <option value="San Rafael Abajo">San Rafael Abajo</option>
                    <option value="San Rafael de Coronado">San Rafael de Coronado</option>
                    <option value="San Rafael de Oreamuno">San Rafael de Oreamuno</option>
                    <option value="San Vicente de Moravia">San Vicente de Moravia</option>
                    <option value="Tirrases">Tirrases</option>
                    <option value="Turrialba">Turrialba</option>
                    <option value="Ulloa">Ulloa</option>
                    </select>

                <?php
            }elseif ($pays == "Côte d'Ivoire"){
                ?>
                <select class="select" name="localisation">
                    <option value="Abengourou">Abengourou</option>
                    <option value="Abidjan">Abidjan</option>
                    <option value="Aboisso">Aboisso</option>
                    <option value="Adzopé">Adzopé</option>
                    <option value="Agboville">Agboville</option>
                    <option value="Anyama">Anyama</option>
                    <option value="Bingerville">Bingerville</option>
                    <option value="Bloléquin">Bloléquin</option>
                    <option value="Bondoukou">Bondoukou</option>
                    <option value="Bonon">Bonon</option>
                    <option value="Bonoua">Bonoua</option>
                    <option value="Bouaflé">Bouaflé</option>
                    <option value="Bouaké">Bouaké</option>
                    <option value="Buyo">Buyo</option>
                    <option value="Dabou">Dabou</option>
                    <option value="Daloa">Daloa</option>
                    <option value="Danané">Danané</option>
                    <option value="Dania">Dania</option>
                    <option value="Daoukro">Daoukro</option>
                    <option value="Divo">Divo</option>
                    <option value="Duékoué">Duékoué</option>
                    <option value="Ferké">Ferké</option>
                    <option value="Gabiadji">Gabiadji</option>
                    <option value="Gagnoa">Gagnoa</option>
                    <option value="Grand-Bassam">Grand-Bassam</option>
                    <option value="Grand-Béreby">Grand-Béreby</option>
                    <option value="Grand-Zattry">Grand-Zattry</option>
                    <option value="Guiglo">Guiglo</option>
                    <option value="Issia">Issia</option>
                    <option value="Korhogo">Korhogo</option>
                    <option value="Lakota">Lakota</option>
                    <option value="Man">Man</option>
                    <option value="Méagui">Méagui</option>
                    <option value="Okrouyo">Okrouyo</option>
                    <option value="Oumé">Oumé</option>
                    <option value="Saïoua">Saïoua</option>
                    <option value="San-Pédro">San-Pédro</option>
                    <option value="Séguéla">Séguéla</option>
                    <option value="Seitifla">Seitifla</option>
                    <option value="Sinfra">Sinfra</option>
                    <option value="Soubré">Soubré</option>
                    <option value="Vavoua">Vavoua</option>
                    <option value="Yamoussoukro">Yamoussoukro</option>
                    <option value="Zouan-Hounien">Zouan-Hounien</option>
                </select>

                <?php
            }elseif ($pays == "Croatie"){
                ?>
                
                <select class="select" name="localisation">
                    <option value="Bakar">Bakar</option>
                    <option value="Beli Manastir">Beli Manastir</option>
                    <option value="Belišće">Belišće</option>
                    <option value="Benkovac">Benkovac</option>  
                    <option value="Biograd na Moru">Biograd na Moru</option>
                    <option value="Bjelovar">Bjelovar</option>
                    <option value="Buje">Buje</option>
                    <option value="Buzet">Buzet</option>
                    <option value="Čabar">Čabar</option> 
                    <option value="Čakovec">Čakovec</option>
                    <option value="Čazma">Čazma</option>
                    <option value="Cres">Cres</option>
                    <option value="Crikvenica">Crikvenica</option>
                    <option value="Đakovo">Đakovo</option>
                    <option value="Daruvar">Daruvar</option>
                    <option value="Delnice">Delnice</option>
                    <option value="Donja Stubica">Donja Stubica</option>
                    <option value="Donji Miholjac">Donji Miholjac</option>
                    <option value="Drniš">Drniš</option>
                    <option value="Dubrovnik">Dubrovnik</option>
                    <option value="Duga Resa">Duga Resa</option>
                    <option value="Dugo Selo">Dugo Selo</option>
                    <option value="Đurđevac">Đurđevac</option>
                    <option value="Garešnica">Garešnica</option>
                    <option value="Glina">Glina</option>
                    <option value="Gospić">Gospić</option>
                    <option value="Grubišno Polje">Grubišno Polje</option>
                    <option value="Hrvatska Kostajnica">Hrvatska Kostajnica</option>
                    <option value="Hvar">Hvar</option>
                    <option value="Ilok">Ilok</option>
                    <option value="Imotski">Imotski</option>
                    <option value="Ivanec">Ivanec</option>
                    <option value="Ivanić-Grad">Ivanić-Grad</option>
                    <option value="Jastrebarsko">Jastrebarsko</option>
                    <option value="Karlovac">Karlovac</option>
                    <option value="Kastav">Kastav</option>
                    <option value="Kaštela">Kaštela</option>
                    <option value="Klanjec">Klanjec</option>
                    <option value="Knin">Knin</option>
                    <option value="Komiža">Komiža</option>
                    <option value="Koprivnica">Koprivnica</option>
                    <option value="Korčula">Korčula</option>
                    <option value="Kraljevica">Kraljevica</option>
                    <option value="Krapina">Krapina</option>
                    <option value="Križevci">Križevci</option>
                    <option value="Krk">Krk</option>
                    <option value="Kutina">Kutina</option>
                    <option value="Labin">Labin</option>
                    <option value="Lepoglava">Lepoglava</option>
                    <option value="Lipik">Lipik</option>
                    <option value="Ludbreg">Ludbreg</option>
                    <option value="Makarska">Makarska</option>
                    <option value="Mali Lošinj">Mali Lošinj</option>
                    <option value="Metković">Metković</option>
                    <option value="Mursko Središće">Mursko Središće</option>
                    <option value="Našice">Našice</option>
                    <option value="Nin">Nin</option>
                    <option value="Nova Gradiška">Nova Gradiška</option>
                    <option value="Novalja">Novalja</option>
                    <option value="Novi Marof">Novi Marof</option>
                    <option value="Novi Vinodolski">Novi Vinodolski</option>
                    <option value="Novigrad">Novigrad</option>
                    <option value="Novska">Novska</option>
                    <option value="Obrovac">Obrovac</option>
                    <option value="Ogulin">Ogulin</option>
                    <option value="Omiš">Omiš</option>
                    <option value="Opatija">Opatija</option>
                    <option value="Opuzen">Opuzen</option>
                    <option value="Orahovica">Orahovica</option>
                    <option value="Oroslavje">Oroslavje</option>
                    <option value="Osijek">Osijek</option>
                    <option value="Otočac">Otočac</option>
                    <option value="Otok">Otok</option>
                    <option value="Ozalj">Ozalj</option>
                    <option value="Pag">Pag</option>
                    <option value="Pakrac">Pakrac</option>
                    <option value="Pazin">Pazin</option>
                    <option value="Petrinja">Petrinja</option>
                    <option value="Pleternica">Pleternica</option>
                    <option value="Ploče">Ploče</option>
                    <option value="Poreč">Poreč</option> 
                    <option value="Požega">Požega</option>
                    <option value="Pregrada">Pregrada</option>
                    <option value="Prelog">Prelog</option>
                    <option value="Pula">Pula</option>
                    <option value="Rab">Rab</option>
                    <option value="Rijeka">Rijeka</option>
                    <option value="Rovinj">Rovinj</option>
                    <option value="Samobor">Samobor</option>
                    <option value="Senj">Senj</option>
                    <option value="Šibenik">Šibenik</option>
                    <option value="Sinj">Sinj</option>
                    <option value="Sisak">Sisak</option>
                    <option value="Skradin">Skradin</option>
                    <option value="Slatina">Slatina</option>
                    <option value="Slavonski Brod">Slavonski Brod</option>
                    <option value="Slunj">Slunj</option>
                    <option value="Solin">Solin</option>
                    <option value="Split">Split</option>
                    <option value="Stari Grad">Stari Grad</option>
                    <option value="Supetar">Supetar</option>
                    <option value="Sveta Nedelja">Sveta Nedelja</option>
                    <option value="Sveti Ivan Zelina">Sveti Ivan Zelina</option>
                    <option value="Trilj">Trilj</option>
                    <option value="Trogir">Trogir</option>
                    <option value="Umag">Umag</option>
                    <option value="Valpovo">Valpovo</option>
                    <option value="Varaždin">Varaždin</option>
                    <option value="Varaždinske Toplice">Varaždinske Toplice</option>
                    <option value="Velika Gorica">Velika Gorica</option>
                    <option value="Vinkovci">Vinkovci</option> 
                    <option value="Virovitica">Virovitica</option>
                    <option value="Vis">Vis</option>
                    <option value="Vodice">Vodice</option>
                    <option value="Vodnjan">Vodnjan</option>
                    <option value="Vrbovec">Vrbovec</option>
                    <option value="Vrbovsko">Vrbovsko</option>
                    <option value="Vrgorac">Vrgorac</option>
                    <option value="Vrlika">Vrlika</option>
                    <option value="Vukovar">Vukovar</option>
                    <option value="Zabok">Zabok</option>
                    <option value="Zadar">Zadar</option>
                    <option value="Zagreb">Zagreb</option>
                </select>
                <?php
            }elseif ($pays == "Cuba"){
                ?>
                <select class="select" name="localisation">
                    <option value="Artemisa">Artemisa</option>
                    <option value="Banes">Banes</option>
                    <option value="Baracoa">Baracoa</option>
                    <option value="Bayamo">Bayamo</option>
                    <option value="Cabaiguán">Cabaiguán</option>
                    <option value="Caibarién">Caibarién</option>
                    <option value="Camagüey">Camagüey</option>
                    <option value="Cárdenas">Cárdenas</option>
                    <option value="Ciego de Ávila">Ciego de Ávila</option>
                    <option value="Cienfuegos">Cienfuegos</option>
                    <option value="Colón">Colón</option>
                    <option value="Contramaestre">Contramaestre</option>
                    <option value="Florida">Florida</option>
                    <option value="Guantánamo">Guantánamo</option>
                    <option value="Güines">Güines</option>
                    <option value="Holguín">Holguín</option>
                    <option value="La Havane">La Havane</option>
                    <option value="Las Tunas">Las Tunas</option>
                    <option value="Manzanillo">Manzanillo</option>
                    <option value="Matanzas">Matanzas</option>
                    <option value="Moa">Moa</option>
                    <option value="Morón">Morón</option>
                    <option value="Nueva Gerona">Nueva Gerona</option>
                    <option value="Nuevitas">Nuevitas</option>
                    <option value="Palma Soriano">Palma Soriano</option>
                    <option value="Pinar del Río">Pinar del Río</option>
                    <option value="Placetas">Placetas</option>
                    <option value="Port au Père">Port au Père</option>
                    <option value="Sagua la Grande">Sagua la Grande</option>
                    <option value="San Antonio de los Baños">San Antonio de los Baños</option>
                    <option value="San José de las Lajas">San José de las Lajas</option>
                    <option value="San Luis">San Luis</option>
                    <option value="Sancti Spíritus">Sancti Spíritus</option>
                    <option value="Santa Clara">Santa Clara</option>
                    <option value="Santiago de Cuba">Santiago de Cuba</option>
                    <option value="Trinidad">Trinidad</option>
                </select>

                <?php
            }elseif ($pays == "Danemark"){
                ?>
                <select class="select" name="localisation">
                    <option value="Aalborg">Aalborg</option>
                    <option value="Aarhus">Aarhus</option>
                    <option value="Copenhague">Copenhague</option>
                    <option value="Esbjerg">Esbjerg</option>
                    <option value="Fredericia">Fredericia</option>
                    <option value="Frederikshavn">Frederikshavn</option>
                    <option value="Greve">Greve</option>
                    <option value="Haderslev">Haderslev</option>
                    <option value="Helsingør">Helsingør</option>
                    <option value="Herning">Herning</option>
                    <option value="Hillerød">Hillerød</option>
                    <option value="Hjørring">Hjørring</option>
                    <option value="Holbæk">Holbæk</option>
                    <option value="Holstebro">Holstebro</option>
                    <option value="Horsens">Horsens</option>
                    <option value="Hørsholm">Hørsholm</option>
                    <option value="Køge">Køge</option>
                    <option value="Kolding">Kolding</option>
                    <option value="Næstved">Næstved</option>
                    <option value="Odense">Odense</option>
                    <option value="Randers">Randers</option>
                    <option value="Roskilde">Roskilde</option>
                    <option value="Silkeborg">Silkeborg</option>
                    <option value="Skive">Skive</option>
                    <option value="Slagelse">Slagelse</option>
                    <option value="Sønderborg">Sønderborg</option>
                    <option value="Svendborg">Svendborg</option>
                    <option value="Taastrup">Taastrup</option>
                    <option value="Vejle">Vejle</option>
                    <option value="Viborg">Viborg</option>
                </select>

                <?php
            }elseif ($pays == "Djibouti"){
                ?>
                <select class="select" name="localisation">
                    <option value="Alaili Dadda">Alaili Dadda</option>
                    <option value="Ali Sabieh">Ali Sabieh</option>
                    <option value="Arta">Arta</option>
                    <option value="Dikhil">Dikhil</option>
                    <option value="Djibouti">Djibouti</option>
                    <option value="Dorra">Dorra</option>
                    <option value="Galafi">Galafi</option>
                    <option value="Holhol">Holhol</option>
                    <option value="Loyada">Loyada</option>
                    <option value="Obock">Obock</option>
                    <option value="Tadjourah">Tadjourah</option>
                </select>

                <?php
            }elseif ($pays == "Dominique"){
                ?>
                <select class="select" name="localisation">
                    <option value="Atkinson">Atkinson</option>
                    <option value="Berekua">Berekua</option>
                    <option value="Calibishie">Calibishie</option>
                    <option value="Canefield">Canefield</option>
                    <option value="Castle-Bruce">Castle-Bruce</option>
                    <option value="Coulihaut">Coulihaut</option>
                    <option value="La-Plaine">La-Plaine</option>
                    <option value="Mahaut">Mahaut</option>
                    <option value="Marigot">Marigot</option>
                    <option value="Pointe-Michel">Pointe-Michel</option>
                    <option value="Pont-Cassé">Pont-Cassé</option>
                    <option value="Portsmouth">Portsmouth</option>
                    <option value="Rosalie">Rosalie</option>
                    <option value="Roseau">Roseau</option>
                    <option value="Saint-Joseph">Saint-Joseph</option>
                    <option value="Salisbury">Salisbury</option>
                    <option value="Soufrière">Soufrière</option>
                    <option value="Wesley">Wesley</option>
                    <option value="Woodford-Hill">Woodford-Hill</option>
                </select>

                <?php
            }elseif ($pays == "Egypte"){
                ?>
                <select class="select" name="localisation">
                    <option value="أبو كبير">أبو كبير</option>
                    <option value="أخميم">أخميم</option>
                    <option value="إدفو">إدفو</option>
                    <option value="أسوان">أسوان</option>
                    <option value="أسيوط">أسيوط</option>
                    <option value="الإسكندرية">الإسكندرية</option>
                    <option value="الإسماعيلية">الإسماعيلية</option>
                    <option value="الأقصر">الأقصر</option>
                    <option value="الجيزة">الجيزة</option>
                    <option value="الحوامدية">الحوامدية</option>
                    <option value="الزقازيق">الزقازيق</option>
                    <option value="السويس">السويس</option>
                    <option value="العريش">العريش</option>
                    <option value="الغردقة">الغردقة</option>
                    <option value="الفيوم">الفيوم</option>
                    <option value="القاهرة">القاهرة</option>
                    <option value="المحلة الكبرى">المحلة الكبرى</option>
                    <option value="المطرية">المطرية</option>
                    <option value="المنصورة">المنصورة</option>
                    <option value="المنيا">المنيا</option>
                    <option value="بلبيس">بلبيس</option>
                    <option value="بنها">بنها</option>
                    <option value="بنى سويف">بنى سويف</option>
                    <option value="بور سعيد">بور سعيد</option>
                    <option value="جرجا">جرجا</option>
                    <option value="دسوق">دسوق</option>
                    <option value="دمنهور">دمنهور</option>
                    <option value="دمياط">دمياط</option>
                    <option value="سوهاج">سوهاج</option>
                    <option value="شبرا الخيمة">شبرا الخيمة</option>
                    <option value="شبين الكوم">شبين الكوم</option>
                    <option value="طنطا">طنطا</option>
                    <option value="عشرة رمضان">عشرة رمضان</option>
                    <option value="قليوب">قليوب</option>
                    <option value="قنا">قنا</option>
                    <option value="كفر الدوار">كفر الدوار</option>
                    <option value="كفر الشيخ">كفر الشيخ</option>
                    <option value="مدينة ستة اكتوبر">مدينة ستة اكتوبر</option>
                    <option value="مرسى مطروح">مرسى مطروح</option>
                    <option value="ملوى">ملوى</option>
                    <option value="ميت غمر">ميت غمر</option>
                </select>

                <?php
            }elseif ($pays == "Emirats Arabes Unis"){
                ?>
                <select class="select" name="localisation">
                    <option value="Abou Dabi">Abou Dabi</option>
                    <option value="Ajman">Ajman</option>
                    <option value="Al Ain">Al Ain</option>
                    <option value="Charjah">Charjah</option>
                    <option value="Dubaï">Dubaï</option>
                    <option value="Foudjaïrah">Foudjaïrah</option>
                    <option value="Khor Fakkan">Khor Fakkan</option>
                    <option value="Oumm al Qaïwaïn">Oumm al Qaïwaïn</option>
                    <option value="Ras el-Khaïmah">Ras el-Khaïmah</option>
                </select>

                <?php
            }elseif ($pays == "Equateur"){
                ?>
                <select class="select" name="localisation">
                    <option value="Banganbola">Banganbola</option>
                    <option value="Basankusu">Basankusu</option>
                    <option value="Bikoro">Bikoro</option>
                    <option value="Boende">Boende</option>
                    <option value="Bokonzi">Bokonzi</option>
                    <option value="Bokungu">Bokungu</option>
                    <option value="Bolomba">Bolomba</option>
                    <option value="Bomongo">Bomongo</option>
                    <option value="Bosobolo">Bosobolo</option>
                    <option value="Budjala">Budjala</option>
                    <option value="Bumba">Bumba</option>
                    <option value="Businga">Businga</option>
                    <option value="Bwamanda">Bwamanda</option>
                    <option value="Djolu">Djolu</option>
                    <option value="Ekafera">Ekafera</option>
                    <option value="Gbadolite">Gbadolite</option>
                    <option value="Gemena">Gemena</option>
                    <option value="Ikela">Ikela</option>
                    <option value="Ingende">Ingende</option>
                    <option value="Karawa">Karawa</option>
                    <option value="Libenge">Libenge</option>
                    <option value="Lisala">Lisala</option>
                    <option value="Loko">Loko</option>
                    <option value="Lukolela">Lukolela</option>
                    <option value="Makanza">Makanza</option>
                    <option value="Mbandaka">Mbandaka</option>
                    <option value="Mbaya">Mbaya</option>
                    <option value="Monkoto">Monkoto</option>
                    <option value="Pimu">Pimu</option>
                    <option value="Tandala">Tandala</option>
                    <option value="Wapinda">Wapinda</option>
                    <option value="Zongo">Zongo</option>
                </select>

                <?php
            }elseif ($pays == "Erythree"){
                ?>
                <select class="select" name="localisation">
                    <option value="Adi Keyh">Adi Keyh</option>
                    <option value="Adi Quala">Adi Quala</option>
                    <option value="Agordat">Agordat</option>
                    <option value="Asmara">Asmara</option>
                    <option value="Assab">Assab</option>
                    <option value="Barentu">Barentu</option>
                    <option value="Beylul">Beylul</option>
                    <option value="Dek'emhare">Dek'emhare</option>
                    <option value="Édd">Édd</option>
                    <option value="Ghinda">Ghinda</option>
                    <option value="Himbirti">Himbirti</option>
                    <option value="Keren">Keren</option>
                    <option value="Massaoua">Massaoua</option>
                    <option value="Mendefera">Mendefera</option>
                    <option value="Mersa Fatma">Mersa Fatma</option>
                    <option value="Nakfa">Nakfa</option>
                    <option value="Nefasit">Nefasit</option>
                    <option value="Segeneiti">Segeneiti</option>
                    <option value="Senafe">Senafe</option>
                    <option value="Teseney">Teseney</option>
                </select>

                <?php
            }elseif ($pays == "Espagne"){
                ?>
                <select class="select" name="localisation">
                    <option value="Albacete">Albacete</option>
                    <option value="Alcalá de Guadaíra">Alcalá de Guadaíra</option>
                    <option value="Alcalá de Henares">Alcalá de Henares</option>
                    <option value="Alcobendas">Alcobendas</option>
                    <option value="Alcorcón">Alcorcón</option>
                    <option value="Alcoy">Alcoy</option>
                    <option value="Algésiras">Algésiras</option>
                    <option value="Alicante">Alicante</option>
                    <option value="Almería">Almería</option>
                    <option value="Aranjuez">Aranjuez</option>
                    <option value="Arganda del Rey">Arganda del Rey</option>
                    <option value="Arona">Arona</option>
                    <option value="Arrecife">Arrecife</option>
                    <option value="Ávila">Ávila</option>
                    <option value="Avilés">Avilés</option>
                    <option value="Badajoz">Badajoz</option>
                    <option value="Badalone">Badalone</option>
                    <option value="Barakaldo">Barakaldo</option>
                    <option value="Barcelone">Barcelone</option>
                    <option value="Benalmádena">Benalmádena</option>
                    <option value="Benidorm">Benidorm</option>
                    <option value="Bilbao">Bilbao</option>
                    <option value="Boadilla del Monte">Boadilla del Monte</option>
                    <option value="Burgos">Burgos</option>
                    <option value="Cáceres">Cáceres</option>
                    <option value="Cadix">Cadix</option>
                    <option value="Carthagène">Carthagène</option>
                    <option value="Castelldefels">Castelldefels</option>
                    <option value="Castellón de la Plana">Castellón de la Plana</option>
                    <option value="Cerdanyola del Vallès">Cerdanyola del Vallès</option>
                    <option value="Ceuta">Ceuta</option>
                    <option value="Chiclana de la Frontera">Chiclana de la Frontera</option>
                    <option value="Ciudad Real">Ciudad Real</option>
                    <option value="Collado Villalba">Collado Villalba</option>
                    <option value="Cordoue">Cordoue</option>
                    <option value="Cornellà de Llobregat">Cornellà de Llobregat</option>
                    <option value="Coslada">Coslada</option>
                    <option value="Cuenca">Cuenca</option>
                    <option value="Dos Hermanas">Dos Hermanas</option>
                    <option value="El Ejido">El Ejido</option>
                    <option value="El Prat de Llobregat">El Prat de Llobregat</option>
                    <option value="El Puerto de Santa María">El Puerto de Santa María</option>
                    <option value="Elche">Elche</option>
                    <option value="Elda">Elda</option>
                    <option value="Estepona">Estepona</option>
                    <option value="Ferrol">Ferrol</option>
                    <option value="Fuengirola">Fuengirola</option>
                    <option value="Fuenlabrada">Fuenlabrada</option>
                    <option value="Gandia">Gandia</option>
                    <option value="Gérone">Gérone</option>
                    <option value="Getafe">Getafe</option>
                    <option value="Getxo">Getxo</option>
                    <option value="Gijón">Gijón</option>
                    <option value="Granollers">Granollers</option>
                    <option value="Grenade">Grenade</option>
                    <option value="Guadalajara">Guadalajara</option>
                    <option value="Huelva">Huelva</option>
                    <option value="Huesca">Huesca</option>
                    <option value="Irun">Irun</option>
                    <option value="Jaén">Jaén</option>
                    <option value="Jerez de la Frontera">Jerez de la Frontera</option>
                    <option value="La Corogne">La Corogne</option>
                    <option value="La Línea de la Concepción">La Línea de la Concepción</option>
                    <option value="Las Palmas de Gran Canaria">Las Palmas de Gran Canaria</option>
                    <option value="Las Rozas de Madrid">Las Rozas de Madrid</option>
                    <option value="Leganés">Leganés</option>
                    <option value="León">León</option>
                    <option value="Lérida">Lérida</option>
                    <option value="L'Hospitalet de Llobregat">L'Hospitalet de Llobregat</option>
                    <option value="Linares">Linares</option>
                    <option value="Logrogne">Logrogne</option>
                    <option value="Lorca">Lorca</option>
                    <option value="Lugo">Lugo</option>
                    <option value="Madrid">Madrid</option>
                    <option value="Majadahonda">Majadahonda</option>
                    <option value="Malaga">Malaga</option>
                    <option value="Manresa">Manresa</option>
                    <option value="Marbella">Marbella</option>
                    <option value="Mataró">Mataró</option>
                    <option value="Melilla">Melilla</option>
                    <option value="Mérida">Mérida</option>
                    <option value="Mijas">Mijas</option>
                    <option value="Molina de Segura">Molina de Segura</option>
                    <option value="Mollet del Vallès">Mollet del Vallès</option>
                    <option value="Móstoles">Móstoles</option>
                    <option value="Motril">Motril</option>
                    <option value="Murcie">Murcie</option>
                    <option value="Orense">Orense</option>
                    <option value="Orihuela">Orihuela</option>
                    <option value="Oviedo">Oviedo</option>
                    <option value="Palencia">Palencia</option>
                    <option value="Palma de Majorque">Palma de Majorque</option>
                    <option value="Pampelune">Pampelune</option>
                    <option value="Parla">Parla</option>
                    <option value="Paterna">Paterna</option>
                    <option value="Pinto">Pinto</option>
                    <option value="Ponferrada">Ponferrada</option>
                    <option value="Pontevedra">Pontevedra</option>
                    <option value="Pozuelo de Alarcón">Pozuelo de Alarcón</option>
                    <option value="Reus">Reus</option>
                    <option value="Rivas-Vaciamadrid">Rivas-Vaciamadrid</option>
                    <option value="Roquetas de Mar">Roquetas de Mar</option>
                    <option value="Rubí">Rubí</option>
                    <option value="Sabadell">Sabadell</option>
                    <option value="Sagonte">Sagonte</option>
                    <option value="Saint-Jacques-de-Compostelle">Saint-Jacques-de-Compostelle</option>
                    <option value="Saint-Sébastien">Saint-Sébastien</option>
                    <option value="Salamanque">Salamanque</option>
                    <option value="San Bartolomé de Tirajana">San Bartolomé de Tirajana</option>
                    <option value="San Cristóbal de La Laguna">San Cristóbal de La Laguna</option>
                    <option value="San Fernando">San Fernando</option>
                    <option value="San Sebastián de los Reyes">San Sebastián de los Reyes</option>
                    <option value="San Vicente del Raspeig">San Vicente del Raspeig</option>
                    <option value="Sanlúcar de Barrameda">Sanlúcar de Barrameda</option>
                    <option value="Sant Boi de Llobregat">Sant Boi de Llobregat</option>
                    <option value="Sant Cugat del Vallès">Sant Cugat del Vallès</option>
                    <option value="Santa Coloma de Gramenet">Santa Coloma de Gramenet</option>
                    <option value="Santa Cruz de Tenerife">Santa Cruz de Tenerife</option>
                    <option value="Santa Lucía de Tirajana">Santa Lucía de Tirajana</option>
                    <option value="Santander">Santander</option>
                    <option value="Saragosse">Saragosse</option>
                    <option value="Ségovie">Ségovie</option>
                    <option value="Séville">Séville</option>
                    <option value="Siero">Siero</option>
                    <option value="Talavera de la Reina">Talavera de la Reina</option>
                    <option value="Tarragone">Tarragone</option>
                    <option value="Telde">Telde</option>
                    <option value="Terrassa">Terrassa</option>
                    <option value="Toledo">Toledo</option>
                    <option value="Torrejón de Ardoz">Torrejón de Ardoz</option>
                    <option value="Torrelavega">Torrelavega</option>
                    <option value="Torremolinos">Torremolinos</option>
                    <option value="Torrent">Torrent</option>
                    <option value="Torrevieja">Torrevieja</option>
                    <option value="Utrera">Utrera</option>
                    <option value="Valdemoro">Valdemoro</option>
                    <option value="Valence">Valence</option>
                    <option value="Valladolid">Valladolid</option>
                    <option value="Vélez-Málaga">Vélez-Málaga</option>
                    <option value="Vigo">Vigo</option>
                    <option value="Viladecans">Viladecans</option>
                    <option value="Vilanova i la Geltrú">Vilanova i la Geltrú</option>
                    <option value="Vila-real">Vila-real</option>
                    <option value="Vitoria-Gasteiz">Vitoria-Gasteiz</option>
                    <option value="Zamora">Zamora</option>
                </select>

                <?php
            }elseif ($pays == "Estonie"){
                ?>
                <select class="select" name="localisation">
                    <option value="Arukula">Arukula</option>
                    <option value="Aseri">Aseri</option>
                    <option value="Elva">Elva</option>
                    <option value="Haabneeme">Haabneeme</option>
                    <option value="Haapsalu">Haapsalu</option>
                    <option value="Jogeva">Jogeva</option>
                    <option value="Johvi">Johvi</option>
                    <option value="Juri">Juri</option>
                    <option value="Kadrina">Kadrina</option>
                    <option value="Kardla">Kardla</option>
                    <option value="Karksi-nuia">Karksi-nuia</option>
                    <option value="Kehra">Kehra</option>
                    <option value="Kehtna">Kehtna</option>
                    <option value="Keila">Keila</option>
                    <option value="Kilingi-nomme">Kilingi-nomme</option>
                    <option value="Kivioli">Kivioli</option>
                    <option value="Kohila">Kohila</option>
                    <option value="Kohtla-jarve">Kohtla-jarve</option>
                    <option value="Kose">Kose</option>
                    <option value="Kunda">Kunda</option>
                    <option value="Kuressaare">Kuressaare</option>
                    <option value="Laagri">Laagri</option>
                    <option value="Loksa">Loksa</option>
                    <option value="Loo">Loo</option>
                    <option value="Maardu">Maardu</option>
                    <option value="Marjamaa">Marjamaa</option>
                    <option value="Mustvee">Mustvee</option>
                    <option value="Narva">Narva</option>
                    <option value="Narva-joesuu">Narva-joesuu</option>
                    <option value="Otepaa">Otepaa</option>
                    <option value="Paide">Paide</option>
                    <option value="Paikuse">Paikuse</option>
                    <option value="Paldiski">Paldiski</option>
                    <option value="Parnu">Parnu</option>
                    <option value="Poltsamaa">Poltsamaa</option>
                    <option value="Polva">Polva</option>
                    <option value="Pussi">Pussi</option>
                    <option value="Rakvere">Rakvere</option>
                    <option value="Rapina">Rapina</option>
                    <option value="Rapla">Rapla</option>
                    <option value="Rummu">Rummu</option>
                    <option value="Saku">Saku</option>
                    <option value="Saue">Saue</option>
                    <option value="Sillamae">Sillamae</option>
                    <option value="Sindi">Sindi</option>
                    <option value="Tabasalu">Tabasalu</option>
                    <option value="Tallinn">Tallinn</option>
                    <option value="Tamsalu">Tamsalu</option>
                    <option value="Tapa">Tapa</option>
                    <option value="Tartu">Tartu</option>
                    <option value="Torva">Torva</option>
                    <option value="Torvandi">Torvandi</option>
                    <option value="Turi">Turi</option>
                    <option value="Vaike-maarja">Vaike-maarja</option>
                    <option value="Valga">Valga</option>
                    <option value="Vandra">Vandra</option>
                    <option value="Viimsi">Viimsi</option>
                    <option value="Viljandi">Viljandi</option>
                    <option value="Vohma">Vohma</option>
                    <option value="Voru">Voru</option>
                </select>

                <?php
            }elseif ($pays == "Etats Unis"){
                ?>
                <select class="select" name="localisation">
                    <option value="Albuquerque">Albuquerque</option>
                    <option value="Amarillo">Amarillo</option>
                    <option value="Anaheim">Anaheim</option>
                    <option value="Anchorage">Anchorage</option>
                    <option value="Arlington">Arlington</option>
                    <option value="Atlanta">Atlanta</option>
                    <option value="Aurora">Aurora</option>
                    <option value="Austin">Austin</option>
                    <option value="Bakersfield">Bakersfield</option>
                    <option value="Baltimore">Baltimore</option>
                    <option value="Baton Rouge">Baton Rouge</option>
                    <option value="Birmingham">Birmingham</option>
                    <option value="Boise">Boise</option>
                    <option value="Boston">Boston</option>
                    <option value="Buffalo">Buffalo</option>
                    <option value="Chandler">Chandler</option>
                    <option value="Charlotte">Charlotte</option>
                    <option value="Chesapeake">Chesapeake</option>
                    <option value="Chicago">Chicago</option>
                    <option value="Chula Vista">Chula Vista</option>
                    <option value="Cincinnati">Cincinnati</option>
                    <option value="Cleveland">Cleveland</option>
                    <option value="Colorado Springs">Colorado Springs</option>
                    <option value="Columbus">Columbus</option>
                    <option value="Comté d'Arlington">Comté d'Arlington</option>
                    <option value="Corpus Christi">Corpus Christi</option>
                    <option value="Dallas">Dallas</option>
                    <option value="Denver">Denver</option>
                    <option value="Des Moines">Des Moines</option>
                    <option value="Détroit">Détroit</option>
                    <option value="Durham">Durham</option>
                    <option value="El Paso">El Paso</option>
                    <option value="Enterprise">Enterprise</option>
                    <option value="Fayetteville">Fayetteville</option>
                    <option value="Fontana">Fontana</option>
                    <option value="Fort Wayne">Fort Wayne</option>
                    <option value="Fort Worth">Fort Worth</option>
                    <option value="Fremont">Fremont</option>
                    <option value="Fresno">Fresno</option>
                    <option value="Garland">Garland</option>
                    <option value="Gilbert">Gilbert</option>
                    <option value="Glendale">Glendale</option>
                    <option value="Grand Rapids">Grand Rapids</option>
                    <option value="Greensboro">Greensboro</option>
                    <option value="Henderson">Henderson</option>
                    <option value="Hialeah">Hialeah</option>
                    <option value="Honolulu">Honolulu</option>
                    <option value="Houston">Houston</option>
                    <option value="Huntsville">Huntsville</option>
                    <option value="Indianapolis">Indianapolis</option>
                    <option value="Irvine">Irvine</option>
                    <option value="Irving">Irving</option>
                    <option value="Jacksonville">Jacksonville</option>
                    <option value="Jersey City">Jersey City</option>
                    <option value="Kansas City">Kansas City</option>
                    <option value="La Nouvelle-Orléans">La Nouvelle-Orléans</option>
                    <option value="Laredo">Laredo</option>
                    <option value="Las Vegas">Las Vegas</option>
                    <option value="Lexington">Lexington</option>
                    <option value="Lincoln">Lincoln</option>
                    <option value="Long Beach">Long Beach</option>
                    <option value="Los Angeles">Los Angeles</option>
                    <option value="Louisville">Louisville</option>
                    <option value="Lubbock">Lubbock</option>
                    <option value="Madison">Madison</option>
                    <option value="Memphis">Memphis</option>
                    <option value="Mesa">Mesa</option>
                    <option value="Miami">Miami</option>
                    <option value="Milwaukee">Milwaukee</option>
                    <option value="Minneapolis">Minneapolis</option>
                    <option value="Modesto">Modesto</option>
                    <option value="Moreno Valley">Moreno Valley</option>
                    <option value="Nashville">Nashville</option>
                    <option value="New York">New York</option>
                    <option value="Newark">Newark</option>
                    <option value="Norfolk">Norfolk</option>
                    <option value="North Las Vegas">North Las Vegas</option>
                    <option value="Oakland">Oakland</option>
                    <option value="Oklahoma City">Oklahoma City</option>
                    <option value="Omaha">Omaha</option>
                    <option value="Orlando">Orlando</option>
                    <option value="Oxnard">Oxnard</option>
                    <option value="Philadelphie">Philadelphie</option>
                    <option value="Phoenix">Phoenix</option>
                    <option value="Pittsburgh">Pittsburgh</option>
                    <option value="Plano">Plano</option>
                    <option value="Portland">Portland</option>
                    <option value="Raleigh">Raleigh</option>
                    <option value="Reno">Reno</option>
                    <option value="Richmond">Richmond</option>
                    <option value="Riverside">Riverside</option>
                    <option value="Rochester">Rochester</option>
                    <option value="Sacramento">Sacramento</option>
                    <option value="Saint Paul">Saint Paul</option>
                    <option value="Saint-Louis">Saint-Louis</option>
                    <option value="Salt Lake City">Salt Lake City</option>
                    <option value="San Antonio">San Antonio</option>
                    <option value="San Bernardino">San Bernardino</option>
                    <option value="San Diego">San Diego</option>
                    <option value="San Francisco">San Francisco</option>
                    <option value="San José">San José</option>
                    <option value="San Juan">San Juan</option>
                    <option value="Santa Ana">Santa Ana</option>
                    <option value="Santa Clarita">Santa Clarita</option>
                    <option value="Scottsdale">Scottsdale</option>
                    <option value="Seattle">Seattle</option>
                    <option value="Spokane">Spokane</option>
                    <option value="St. Petersburg">St. Petersburg</option>
                    <option value="Stockton">Stockton</option>
                    <option value="Tacoma">Tacoma</option>
                    <option value="Tampa">Tampa</option>
                    <option value="Toledo">Toledo</option>
                    <option value="Tucson">Tucson</option>
                    <option value="Tulsa">Tulsa</option>
                    <option value="Virginia Beach">Virginia Beach</option>
                    <option value="Washington DC">Washington DC</option>
                    <option value="Wichita">Wichita</option>
                    <option value="Winston-Salem">Winston-Salem</option>
                    <option value="Yonkers">Yonkers</option>
                </select>

                <?php
            }elseif ($pays == "Ethiopie"){
                ?>
                <select class="select" name="localisation">
                    <option value="Adama">Adama</option>
                    <option value="Addis-Abeba">Addis-Abeba</option>
                    <option value="Adigrat">Adigrat</option>
                    <option value="Adwa">Adwa</option>
                    <option value="Agaro">Agaro</option>
                    <option value="Aksoum">Aksoum</option>
                    <option value="Alaba Kulito">Alaba Kulito</option>
                    <option value="Alamata">Alamata</option>
                    <option value="Alemaya">Alemaya</option>
                    <option value="Aleta Wendo">Aleta Wendo</option>
                    <option value="Arba Minch">Arba Minch</option>
                    <option value="Areka">Areka</option>
                    <option value="Arsi Negele">Arsi Negele</option>
                    <option value="Asosa">Asosa</option>
                    <option value="Assella">Assella</option>
                    <option value="Awasa">Awasa</option>
                    <option value="Baher Dar">Baher Dar</option>
                    <option value="Balé Robe">Balé Robe</option>
                    <option value="Batu">Batu</option>
                    <option value="Bishoftu">Bishoftu</option>
                    <option value="Boditi">Boditi</option>
                    <option value="Bonga">Bonga</option>
                    <option value="Bule Hora">Bule Hora</option>
                    <option value="Burayu">Burayu</option>
                    <option value="Butajira">Butajira</option>
                    <option value="Chiro">Chiro</option>
                    <option value="Dangila">Dangila</option>
                    <option value="Debre Berhan">Debre Berhan</option>
                    <option value="Debre Marqos">Debre Marqos</option>
                    <option value="Debre Tabor">Debre Tabor</option>
                    <option value="Degehabur">Degehabur</option>
                    <option value="Dembidolo">Dembidolo</option>
                    <option value="Dessie">Dessie</option>
                    <option value="Dila">Dila</option>
                    <option value="Dimtu">Dimtu</option>
                    <option value="Dire Dawa">Dire Dawa</option>
                    <option value="Djidjiga">Djidjiga</option>
                    <option value="Durame">Durame</option>
                    <option value="Finote Selam">Finote Selam</option>
                    <option value="Fitche">Fitche</option>
                    <option value="Gambela">Gambela</option>
                    <option value="Gimbi">Gimbi</option>
                    <option value="Goba">Goba</option>
                    <option value="Gode">Gode</option>
                    <option value="Gondar">Gondar</option>
                    <option value="Hagere Hiywet">Hagere Hiywet</option>
                    <option value="Harar">Harar</option>
                    <option value="Hosaena">Hosaena</option>
                    <option value="Inda Selassié">Inda Selassié</option>
                    <option value="Jimma">Jimma</option>
                    <option value="Jinka">Jinka</option>
                    <option value="Kobo">Kobo</option>
                    <option value="Kombolcha">Kombolcha</option>
                    <option value="Mekele">Mekele</option>
                    <option value="Meki">Meki</option>
                    <option value="Metu">Metu</option>
                    <option value="Mizan Teferi">Mizan Teferi</option>
                    <option value="Mojo">Mojo</option>
                    <option value="Mota">Mota</option>
                    <option value="Negele">Negele</option>
                    <option value="Nekemte">Nekemte</option>
                    <option value="Sawla">Sawla</option>
                    <option value="Sebeta">Sebeta</option>
                    <option value="Shashamané">Shashamané</option>
                    <option value="Sodo">Sodo</option>
                    <option value="Tepi">Tepi</option>
                    <option value="Waliso">Waliso</option>
                    <option value="Weldiya">Weldiya</option>
                    <option value="Welkite">Welkite</option>
                    <option value="Wukro">Wukro</option>
                    <option value="Yirgalem">Yirgalem</option>
                </select>

                <?php
            }elseif ($pays == "Fidji"){
                ?>
                <select class="select" name="localisation">
                    <option value="Ba">Ba</option>
                    <option value="Korovou">Korovou</option>
                    <option value="Labasa">Labasa</option>
                    <option value="Lami">Lami</option>
                    <option value="Lautoka">Lautoka</option>
                    <option value="Levuka">Levuka</option>
                    <option value="Nabouwalu">Nabouwalu</option>
                    <option value="Nadi">Nadi</option>
                    <option value="Nasinu">Nasinu</option>
                    <option value="Nausori">Nausori</option>
                    <option value="Navua">Navua</option>
                    <option value="Pacific Harbour">Pacific Harbour</option>
                    <option value="Rakiraki">Rakiraki</option>
                    <option value="Savusavu">Savusavu</option>
                    <option value="Seaqaqa">Seaqaqa</option>
                    <option value="Sigatoka">Sigatoka</option>
                    <option value="Suva">Suva</option>
                    <option value="Tavua">Tavua</option>
                    <option value="Vatukoula">Vatukoula</option>
                </select>

                <?php
            }elseif ($pays == "Finlande"){
                ?>
                <select class="select" name="localisation">
                    <option value="Äänekoski">Äänekoski</option>
                    <option value="Ähtäri">Ähtäri</option>
                    <option value="Akaa">Akaa</option>
                    <option value="Alajärvi">Alajärvi</option>
                    <option value="Alavus">Alavus</option>
                    <option value="Espoo">Espoo</option>
                    <option value="Forssa">Forssa</option>
                    <option value="Haapajärvi">Haapajärvi</option>
                    <option value="Haapavesi">Haapavesi</option>
                    <option value="Hämeenlinna">Hämeenlinna</option>
                    <option value="Hamina">Hamina</option>
                    <option value="Hanko">Hanko</option>
                    <option value="Harjavalta">Harjavalta</option>
                    <option value="Heinola">Heinola</option>
                    <option value="Helsinki">Helsinki</option>
                    <option value="Huittinen">Huittinen</option>
                    <option value="Hyvinkää">Hyvinkää</option>
                    <option value="Iisalmi">Iisalmi</option>
                    <option value="Ikaalinen">Ikaalinen</option>
                    <option value="Imatra">Imatra</option>
                    <option value="Jämsä">Jämsä</option>
                    <option value="Järvenpää">Järvenpää</option>
                    <option value="Joensuu">Joensuu</option>
                    <option value="Jyväskylä">Jyväskylä</option>
                    <option value="Kaarina">Kaarina</option>
                    <option value="Kajaani">Kajaani</option>
                    <option value="Kalajoki">Kalajoki</option>
                    <option value="Kangasala">Kangasala</option>
                    <option value="Kankaanpää">Kankaanpää</option>
                    <option value="Kannus">Kannus</option>
                    <option value="Karkkila">Karkkila</option>
                    <option value="Kaskinen">Kaskinen</option>
                    <option value="Kauhajoki">Kauhajoki</option>
                    <option value="Kauhava">Kauhava</option>
                    <option value="Kauniainen">Kauniainen</option>
                    <option value="Kemi">Kemi</option>
                    <option value="Kemijärvi">Kemijärvi</option>
                    <option value="Kerava">Kerava</option>
                    <option value="Keuruu">Keuruu</option>
                    <option value="Kitee">Kitee</option>
                    <option value="Kiuruvesi">Kiuruvesi</option>
                    <option value="Kokemäki">Kokemäki</option>
                    <option value="Kokkola">Kokkola</option>
                    <option value="Kotka">Kotka</option>
                    <option value="Kouvola">Kouvola</option>
                    <option value="Kristiinankaupunki">Kristiinankaupunki</option>
                    <option value="Kuhmo">Kuhmo</option>
                    <option value="Kuopio">Kuopio</option>
                    <option value="Kurikka">Kurikka</option>
                    <option value="Kuusamo">Kuusamo</option>
                    <option value="Lahti">Lahti</option>
                    <option value="Laitila">Laitila</option>
                    <option value="Lappeenranta">Lappeenranta</option>
                    <option value="Lapua">Lapua</option>
                    <option value="Lieksa">Lieksa</option>
                    <option value="Lohja">Lohja</option>
                    <option value="Loimaa">Loimaa</option>
                    <option value="Loviisa">Loviisa</option>
                    <option value="Maarianhamina">Maarianhamina</option>
                    <option value="Mänttä-Vilppula">Mänttä-Vilppula</option>
                    <option value="Mikkeli">Mikkeli</option>
                    <option value="Naantali">Naantali</option>
                    <option value="Närpiö">Närpiö</option>
                    <option value="Nivala">Nivala</option>
                    <option value="Nokia">Nokia</option>
                    <option value="Nurmes">Nurmes</option>
                    <option value="Orimattila">Orimattila</option>
                    <option value="Orivesi">Orivesi</option>
                    <option value="Oulainen">Oulainen</option>
                    <option value="Oulu">Oulu</option>
                    <option value="Outokumpu">Outokumpu</option>
                    <option value="Paimio">Paimio</option>
                    <option value="Parainen">Parainen</option>
                    <option value="Parkano">Parkano</option>
                    <option value="Pieksämäki">Pieksämäki</option>
                    <option value="Pietarsaari">Pietarsaari</option>
                    <option value="Pori">Pori</option>
                    <option value="Porvoo">Porvoo</option>
                    <option value="Pudasjärvi">Pudasjärvi</option>
                    <option value="Pyhäjärvi">Pyhäjärvi</option>
                    <option value="Raahe">Raahe</option>
                    <option value="Raasepori">Raasepori</option>
                    <option value="Raisio">Raisio</option>
                    <option value="Rauma">Rauma</option>
                    <option value="Riihimäki">Riihimäki</option>
                    <option value="Rovaniemi">Rovaniemi</option>
                    <option value="Saarijärvi">Saarijärvi</option>
                    <option value="Salo">Salo</option>
                    <option value="Sastamala">Sastamala</option>
                    <option value="Savonlinna">Savonlinna</option>
                    <option value="Seinäjoki">Seinäjoki</option>
                    <option value="Somero">Somero</option>
                    <option value="Suonenjoki">Suonenjoki</option>
                    <option value="Tampere">Tampere</option>
                    <option value="Tornio">Tornio</option>
                    <option value="Turku">Turku</option>
                    <option value="Ulvila">Ulvila</option>
                    <option value="Uusikaarlepyy">Uusikaarlepyy</option>
                    <option value="Uusikaupunki">Uusikaupunki</option>
                    <option value="Vaasa">Vaasa</option>
                    <option value="Valkeakoski">Valkeakoski</option>
                    <option value="Vantaa">Vantaa</option>
                    <option value="Varkaus">Varkaus</option>
                    <option value="Viitasaari">Viitasaari</option>
                    <option value="Virrat">Virrat</option>
                    <option value="Ylivieska">Ylivieska</option>
                    <option value="Ylöjärvi">Ylöjärvi</option>
                </select>

                <?php
            }elseif ($pays == "France"){
                ?>
                <select class="select" name="localisation">
                    <option value="Aix-en-Provence">Aix-en-Provence</option>
                    <option value="Ajaccio">Ajaccio</option>
                    <option value="Amiens">Amiens</option>
                    <option value="Angers">Angers</option>
                    <option value="Antibes">Antibes</option>
                    <option value="Antony">Antony</option>
                    <option value="Argenteuil">Argenteuil</option>
                    <option value="Asnières-sur-Seine">Asnières-sur-Seine</option>
                    <option value="Aubervilliers">Aubervilliers</option>
                    <option value="Aulnay-sous-Bois">Aulnay-sous-Bois</option>
                    <option value="Avignon">Avignon</option>
                    <option value="Beauvais">Beauvais</option>
                    <option value="Besançon">Besançon</option>
                    <option value="Béziers">Béziers</option>
                    <option value="Bondy">Bondy</option>
                    <option value="Bordeaux">Bordeaux</option>
                    <option value="Boulogne-Billancourt">Boulogne-Billancourt</option>
                    <option value="Bourges">Bourges</option>
                    <option value="Brest">Brest</option>
                    <option value="Caen">Caen</option>
                    <option value="Calais">Calais</option>
                    <option value="Cannes">Cannes</option>
                    <option value="Cergy">Cergy</option>
                    <option value="Chambéry">Chambéry</option>
                    <option value="Champigny-sur-Marne">Champigny-sur-Marne</option>
                    <option value="Charleville-Mézières">Charleville-Mézières</option>
                    <option value="Cholet">Cholet</option>
                    <option value="Clermont-Ferrand">Clermont-Ferrand</option>
                    <option value="Clichy">Clichy</option>
                    <option value="Colmar">Colmar</option>
                    <option value="Colombes">Colombes</option>
                    <option value="Courbevoie">Courbevoie</option>
                    <option value="Créteil">Créteil</option>
                    <option value="Dijon">Dijon</option>
                    <option value="Drancy">Drancy</option>
                    <option value="Dunkerque">Dunkerque</option>
                    <option value="Évry">Évry</option>
                    <option value="Grenoble">Grenoble</option>
                    <option value="Hyères">Hyères</option>
                    <option value="Issy-les-Moulineaux">Issy-les-Moulineaux</option>
                    <option value="Ivry-sur-Seine">Ivry-sur-Seine</option>
                    <option value="La Rochelle">La Rochelle</option>
                    <option value="La Roche-sur-Yon">La Roche-sur-Yon</option>
                    <option value="La Seyne-sur-Mer">La Seyne-sur-Mer</option>
                    <option value="Laval">Laval</option>
                    <option value="Le Havre">Le Havre</option>
                    <option value="Le Mans">Le Mans</option>
                    <option value="Levallois-Perret">Levallois-Perret</option>
                    <option value="Lille">Lille</option>
                    <option value="Limoges">Limoges</option>
                    <option value="Lorient">Lorient</option>
                    <option value="Lyon">Lyon</option>
                    <option value="Maisons-Alfort">Maisons-Alfort</option>
                    <option value="Marseille">Marseille</option>
                    <option value="Mérignac">Mérignac</option>
                    <option value="Metz">Metz</option>
                    <option value="Montauban">Montauban</option>
                    <option value="Montpellier">Montpellier</option>
                    <option value="Montreuil">Montreuil</option>
                    <option value="Mulhouse">Mulhouse</option>
                    <option value="Nancy">Nancy</option>
                    <option value="Nanterre">Nanterre</option>
                    <option value="Nantes">Nantes</option>
                    <option value="Neuilly-sur-Seine">Neuilly-sur-Seine</option>
                    <option value="Nice">Nice</option>
                    <option value="Nîmes">Nîmes</option>
                    <option value="Niort">Niort</option>
                    <option value="Noisy-le-Grand">Noisy-le-Grand</option>
                    <option value="Orléans">Orléans</option>
                    <option value="Pantin">Pantin</option>
                    <option value="Paris">Paris</option>
                    <option value="Pau">Pau</option>
                    <option value="Perpignan">Perpignan</option>
                    <option value="Pessac">Pessac</option>
                    <option value="Poitiers">Poitiers</option>
                    <option value="Quimper">Quimper</option>
                    <option value="Reims">Reims</option>
                    <option value="Rennes">Rennes</option>
                    <option value="Roubaix">Roubaix</option>
                    <option value="Rouen">Rouen</option>
                    <option value="Rueil-Malmaison">Rueil-Malmaison</option>
                    <option value="Saint-Denis">Saint-Denis</option>
                    <option value="Saint-Étienne">Saint-Étienne</option>
                    <option value="Saint-Maur-des-Fossés">Saint-Maur-des-Fossés</option>
                    <option value="Saint-Nazaire">Saint-Nazaire</option>
                    <option value="Saint-Quentin">Saint-Quentin</option>
                    <option value="Sarcelles">Sarcelles</option>
                    <option value="Strasbourg">Strasbourg</option>
                    <option value="Toulon">Toulon</option>
                    <option value="Toulouse">Toulouse</option>
                    <option value="Tourcoing">Tourcoing</option>
                    <option value="Tours">Tours</option>
                    <option value="Troyes">Troyes</option>
                    <option value="Valence">Valence</option>
                    <option value="Vannes">Vannes</option>
                    <option value="Vénissieux">Vénissieux</option>
                    <option value="Versailles">Versailles</option>
                    <option value="Villeneuve-d'Ascq">Villeneuve-d'Ascq</option>
                    <option value="Villeurbanne">Villeurbanne</option>
                    <option value="Vitry-sur-Seine">Vitry-sur-Seine</option>
                </select>

                <?php
            }elseif ($pays == "Gabon"){
                ?>
                <select class="select" name="localisation">
                    <option value="Aboumi">Aboumi</option>
                    <option value="Akanda">Akanda</option>
                    <option value="Akiéni">Akiéni</option>
                    <option value="Akok">Akok</option>
                    <option value="Bakoumba">Bakoumba</option>
                    <option value="Bélinga">Bélinga</option>
                    <option value="Bifoun">Bifoun</option>
                    <option value="Bikele">Bikele</option>
                    <option value="Bitam">Bitam</option>
                    <option value="Bongoville">Bongoville</option>
                    <option value="Booué">Booué</option>
                    <option value="Boumango">Boumango</option>
                    <option value="Cap Estérias">Cap Estérias</option>
                    <option value="Cocobeach">Cocobeach</option>
                    <option value="Dienga">Dienga</option>
                    <option value="Donguila">Donguila</option>
                    <option value="Engo Effack">Engo Effack</option>
                    <option value="Enyonga">Enyonga</option>
                    <option value="Esende">Esende</option>
                    <option value="Etéké">Etéké</option>
                    <option value="Fougamou">Fougamou</option>
                    <option value="Franceville">Franceville</option>
                    <option value="Gamba">Gamba</option>
                    <option value="Goumbi">Goumbi</option>
                    <option value="Guiétsou">Guiétsou</option>
                    <option value="Kango">Kango</option>
                    <option value="Kougouleu">Kougouleu</option>
                    <option value="Koulamoutou">Koulamoutou</option>
                    <option value="Lambaréné">Lambaréné</option>
                    <option value="Lastoursville">Lastoursville</option>
                    <option value="Lébamba">Lébamba</option>
                    <option value="Lékoni">Lékoni</option>
                    <option value="Libreville">Libreville</option>
                    <option value="Makokou">Makokou</option>
                    <option value="Mandji">Mandji</option>
                    <option value="Mayemba">Mayemba</option>
                    <option value="Mayibout">Mayibout</option>
                    <option value="Mayumba">Mayumba</option>
                    <option value="Mbigou">Mbigou</option>
                    <option value="Médouneu">Médouneu</option>
                    <option value="Mékambo">Mékambo</option>
                    <option value="Mimongo">Mimongo</option>
                    <option value="Minvoul">Minvoul</option>
                    <option value="Mitzic">Mitzic</option>
                    <option value="Moabi">Moabi</option>
                    <option value="Moanda">Moanda</option>
                    <option value="Mouila">Mouila</option>
                    <option value="Mounana">Mounana</option>
                    <option value="Ndendé">Ndendé</option>
                    <option value="Ndindi">Ndindi</option>
                    <option value="Ndjolé">Ndjolé</option>
                    <option value="Ndzomoe">Ndzomoe</option>
                    <option value="Nkan">Nkan</option>
                    <option value="Ntoum">Ntoum</option>
                    <option value="Nyonié">Nyonié</option>
                    <option value="Okolo">Okolo</option>
                    <option value="Okondja">Okondja</option>
                    <option value="Omboué">Omboué</option>
                    <option value="Onga">Onga</option>
                    <option value="Owendo">Owendo</option>
                    <option value="oyem">oyem</option>
                    <option value="Pana">Pana</option>
                    <option value="Petit Loango">Petit Loango</option>
                    <option value="Port-Gentil">Port-Gentil</option>
                    <option value="Tchibanga">Tchibanga</option>
                    <option value="Tsogni">Tsogni</option>
                    <option value="Yenzi">Yenzi</option>
                </select>

                <?php
            }elseif ($pays == "Georgie"){
                ?>
                <select class="select" name="localisation">
                    <option value="Akhalkalaki">Akhalkalaki</option>
                    <option value="Akhaltsikhé">Akhaltsikhé</option>
                    <option value="Akhmeta">Akhmeta</option>
                    <option value="Batoumi">Batoumi</option>
                    <option value="Bolnissi">Bolnissi</option>
                    <option value="Bordjomi">Bordjomi</option>
                    <option value="Doucheti">Doucheti</option>
                    <option value="Gardabani">Gardabani</option>
                    <option value="Gori">Gori</option>
                    <option value="Gourdjaani">Gourdjaani</option>
                    <option value="Kareli">Kareli</option>
                    <option value="Kaspi">Kaspi</option>
                    <option value="Kazreti">Kazreti</option>
                    <option value="Khachouri">Khachouri</option>
                    <option value="Khoni">Khoni</option>
                    <option value="Kobouleti">Kobouleti</option>
                    <option value="Koutaïssi">Koutaïssi</option>
                    <option value="Kvareli">Kvareli</option>
                    <option value="Lagodekhi">Lagodekhi</option>
                    <option value="Lantchkhouti">Lantchkhouti</option>
                    <option value="Lentekhi">Lentekhi</option>
                    <option value="Marneouli">Marneouli</option>
                    <option value="Mtskheta">Mtskheta</option>
                    <option value="Ozourguéti">Ozourguéti</option>
                    <option value="Poti">Poti</option>
                    <option value="Roustavi">Roustavi</option>
                    <option value="Sagaredjo">Sagaredjo</option>
                    <option value="Samtredia">Samtredia</option>
                    <option value="Satchkhere">Satchkhere</option>
                    <option value="Senaki">Senaki</option>
                    <option value="Surami">Surami</option>
                    <option value="Tbilissi">Tbilissi</option>
                    <option value="Tchiatoura">Tchiatoura</option>
                    <option value="Telavi">Telavi</option>
                    <option value="Tqibuli">Tqibuli</option>
                    <option value="Tsalendschicha">Tsalendschicha</option>
                    <option value="Tskhaltubo">Tskhaltubo</option>
                    <option value="Vale">Vale</option>
                    <option value="Zestaponi">Zestaponi</option>
                    <option value="Zougdidi">Zougdidi</option>
                </select>

                <?php
            }elseif ($pays == "Ghana"){
                ?>
                <select class="select" name="localisation">
                    <option value="Aboso">Aboso</option>
                    <option value="Aburi">Aburi</option>
                    <option value="Accra">Accra</option>
                    <option value="Adenta East">Adenta East</option>
                    <option value="Aflao">Aflao</option>
                    <option value="Agogo">Agogo</option>
                    <option value="Agona Swedru">Agona Swedru</option>
                    <option value="Akim Oda">Akim Oda</option>
                    <option value="Akim Swedru">Akim Swedru</option>
                    <option value="Akropong">Akropong</option>
                    <option value="Akwatia">Akwatia</option>
                    <option value="Anloga">Anloga</option>
                    <option value="Anomabu">Anomabu</option>
                    <option value="Apam">Apam</option>
                    <option value="Asamankese">Asamankese</option>
                    <option value="Ashaiman">Ashaiman</option>
                    <option value="Axim">Axim</option>
                    <option value="Banda Ahenkro">Banda Ahenkro</option>
                    <option value="Bawku">Bawku</option>
                    <option value="Bechem">Bechem</option>
                    <option value="Begoro">Begoro</option>
                    <option value="Bekwai">Bekwai</option>
                    <option value="Berekum">Berekum</option>
                    <option value="Bibiani">Bibiani</option>
                    <option value="Bolgatanga">Bolgatanga</option>
                    <option value="Cape Coast">Cape Coast</option>
                    <option value="Dome">Dome</option>
                    <option value="Duayaw Nkwanta">Duayaw Nkwanta</option>
                    <option value="Dunkwa-on-Offin">Dunkwa-on-Offin</option>
                    <option value="Effiakuma">Effiakuma</option>
                    <option value="Ejura">Ejura</option>
                    <option value="Elmina">Elmina</option>
                    <option value="Foso">Foso</option>
                    <option value="Gbawe">Gbawe</option>
                    <option value="Ho">Ho</option>
                    <option value="Hohoe">Hohoe</option>
                    <option value="Japekrom">Japekrom</option>
                    <option value="Kade">Kade</option>
                    <option value="Keta">Keta</option>
                    <option value="Kete-Krachi">Kete-Krachi</option>
                    <option value="Kibi">Kibi</option>
                    <option value="Kintampo">Kintampo</option>
                    <option value="Koforidua">Koforidua</option>
                    <option value="Konongo">Konongo</option>
                    <option value="Kpandae">Kpandae</option>
                    <option value="Kpandu">Kpandu</option>
                    <option value="Kumasi">Kumasi</option>
                    <option value="Lashibi">Lashibi</option>
                    <option value="Madina">Madina</option>
                    <option value="Mampong">Mampong</option>
                    <option value="Mpraeso">Mpraeso</option>
                    <option value="Mumford">Mumford</option>
                    <option value="Navrongo">Navrongo</option>
                    <option value="Nkawkaw">Nkawkaw</option>
                    <option value="Nsawam">Nsawam</option>
                    <option value="Nungua">Nungua</option>
                    <option value="Nyakrom">Nyakrom</option>
                    <option value="Obuasi">Obuasi</option>
                    <option value="Oduponkpehe">Oduponkpehe</option>
                    <option value="Prestea">Prestea</option>
                    <option value="Salaga">Salaga</option>
                    <option value="Saltpond">Saltpond</option>
                    <option value="Savelugu">Savelugu</option>
                    <option value="Sekondi-Takoradi">Sekondi-Takoradi</option>
                    <option value="Shama">Shama</option>
                    <option value="Somanya">Somanya</option>
                    <option value="Suhum">Suhum</option>
                    <option value="Sunyani">Sunyani</option>
                    <option value="Tafo">Tafo</option>
                    <option value="Taifa">Taifa</option>
                    <option value="Tamale">Tamale</option>
                    <option value="Tarkwa">Tarkwa</option>
                    <option value="Techiman">Techiman</option>
                    <option value="Tema">Tema</option>
                    <option value="Tema New Town">Tema New Town</option>
                    <option value="Teshie">Teshie</option>
                    <option value="Wa">Wa</option>
                    <option value="Wenchi">Wenchi</option>
                    <option value="Winneba">Winneba</option>
                    <option value="Yendi">Yendi</option>
                </select>

                <?php
            }elseif ($pays == "Grece"){
                ?>
                <select class="select" name="localisation">
                    <option value="Acharnés">Acharnés</option>
                    <option value="Agía Paraskeví">Agía Paraskeví</option>
                    <option value="Agía Varvára">Agía Varvára</option>
                    <option value="Ágii Anárgyri">Ágii Anárgyri</option>
                    <option value="Ágios Dimítrios">Ágios Dimítrios</option>
                    <option value="Agrínio">Agrínio</option>
                    <option value="Aigáleo">Aigáleo</option>
                    <option value="Aigion">Aigion</option>
                    <option value="Alexandroúpoli">Alexandroúpoli</option>
                    <option value="Álimos">Álimos</option>
                    <option value="Ambelókipi">Ambelókipi</option>
                    <option value="Áno Liósia">Áno Liósia</option>
                    <option value="Argos">Argos</option>
                    <option value="Argyroupoli">Argyroupoli</option>
                    <option value="Ártemi">Ártemi</option>
                    <option value="Asprópyrgos">Asprópyrgos</option>
                    <option value="Athènes">Athènes</option>
                    <option value="Chaïdari">Chaïdari</option>
                    <option value="Chalándri">Chalándri</option>
                    <option value="Chalcis">Chalcis</option>
                    <option value="Chios">Chios</option>
                    <option value="Cholargós">Cholargós</option>
                    <option value="Corfou">Corfou</option>
                    <option value="Corinthe">Corinthe</option>
                    <option value="Dáfni">Dáfni</option>
                    <option value="Dráma">Dráma</option>
                    <option value="Elefthério-Kordelió">Elefthério-Kordelió</option>
                    <option value="Éleusis">Éleusis</option>
                    <option value="Évosmos">Évosmos</option>
                    <option value="Galátsi">Galátsi</option>
                    <option value="Giannitsá">Giannitsá</option>
                    <option value="Glyfáda">Glyfáda</option>
                    <option value="Héraklion">Héraklion</option>
                    <option value="Ílion">Ílion</option>
                    <option value="Ilioúpoli">Ilioúpoli</option>
                    <option value="Ioannina">Ioannina</option>
                    <option value="Kaisarianí">Kaisarianí</option>
                    <option value="Kalamariá">Kalamariá</option>
                    <option value="Kalamata">Kalamata</option>
                    <option value="Kallithéa">Kallithéa</option>
                    <option value="Kamateró">Kamateró</option>
                    <option value="Kardítsa">Kardítsa</option>
                    <option value="Kateríni">Kateríni</option>
                    <option value="Kavala">Kavala</option>
                    <option value="Keratsíni">Keratsíni</option>
                    <option value="Kifissiá">Kifissiá</option>
                    <option value="Kilkís">Kilkís</option>
                    <option value="Komotiní">Komotiní</option>
                    <option value="Korydallós">Korydallós</option>
                    <option value="Kozáni">Kozáni</option>
                    <option value="La Canée">La Canée</option>
                    <option value="Lamía">Lamía</option>
                    <option value="Larissa">Larissa</option>
                    <option value="Le Pirée">Le Pirée</option>
                    <option value="Livadiá">Livadiá</option>
                    <option value="Maroússi">Maroússi</option>
                    <option value="Mégare">Mégare</option>
                    <option value="Melíssia">Melíssia</option>
                    <option value="Metamórfosi">Metamórfosi</option>
                    <option value="Moscháto">Moscháto</option>
                    <option value="Mytilène">Mytilène</option>
                    <option value="Néa Filadélfia">Néa Filadélfia</option>
                    <option value="Néa Ionía">Néa Ionía</option>
                    <option value="Néa Smýrni">Néa Smýrni</option>
                    <option value="Neápoli">Neápoli</option>
                    <option value="Níkea">Níkea</option>
                    <option value="Paleó Fáliro">Paleó Fáliro</option>
                    <option value="Patras">Patras</option>
                    <option value="Pefki">Pefki</option>
                    <option value="Pérama">Pérama</option>
                    <option value="Peristéri">Peristéri</option>
                    <option value="Petroúpoli">Petroúpoli</option>
                    <option value="Políchni">Políchni</option>
                    <option value="Ptolemaïda">Ptolemaïda</option>
                    <option value="Pyléa">Pyléa</option>
                    <option value="Pyrgos">Pyrgos</option>
                    <option value="Réthymnon">Réthymnon</option>
                    <option value="Rhodes">Rhodes</option>
                    <option value="Salamine">Salamine</option>
                    <option value="Serrès">Serrès</option>
                    <option value="Stavroúpoli">Stavroúpoli</option>
                    <option value="Sykiés">Sykiés</option>
                    <option value="Thèbes">Thèbes</option>
                    <option value="Thessalonique">Thessalonique</option>
                    <option value="Tríkala">Tríkala</option>
                    <option value="Tripoli">Tripoli</option>
                    <option value="Véria">Véria</option>
                    <option value="Vólos">Vólos</option>
                    <option value="Voúla">Voúla</option>
                    <option value="Vrilíssia">Vrilíssia</option>
                    <option value="Výronas">Výronas</option>
                    <option value="Xánthi">Xánthi</option>
                    <option value="Zográfou">Zográfou</option>
                </select>

                <?php
            }elseif ($pays == "Grenade"){
                ?>
                <select class="select" name="localisation">
                    <option value="Gouyave">Gouyave</option>
                    <option value="Grenville">Grenville</option>
                    <option value="Hillsborough">Hillsborough</option>
                    <option value="Saint David">Saint David</option>
                    <option value="Saint-Georges">Saint-Georges</option>
                    <option value="Sauteurs">Sauteurs</option>
                    <option value="Victoria">Victoria</option>
                </select>

                <?php
            }elseif ($pays == "Guatemala"){
                ?>
                <select class="select" name="localisation">
                    <option value="Almolonga">Almolonga</option>
                    <option value="Alotenango">Alotenango</option>
                    <option value="Amatitlán">Amatitlán</option>
                    <option value="Antigua Guatemala">Antigua Guatemala</option>
                    <option value="Asunción Mita">Asunción Mita</option>
                    <option value="Ayutla">Ayutla</option>
                    <option value="Barberena">Barberena</option>
                    <option value="Cantel">Cantel</option>
                    <option value="Chicacao">Chicacao</option>
                    <option value="Chichicastenango">Chichicastenango</option>
                    <option value="Chimaltenango">Chimaltenango</option>
                    <option value="Chinautla">Chinautla</option>
                    <option value="Chiquimula">Chiquimula</option>
                    <option value="Chiquimulilla">Chiquimulilla</option>
                    <option value="Chisec">Chisec</option>
                    <option value="Ciudad Vieja">Ciudad Vieja</option>
                    <option value="Coatepeque">Coatepeque</option>
                    <option value="Cobán">Cobán</option>
                    <option value="Colomba">Colomba</option>
                    <option value="Comitancillo">Comitancillo</option>
                    <option value="Cuilapa">Cuilapa</option>
                    <option value="El Estor">El Estor</option>
                    <option value="El Palmar">El Palmar</option>
                    <option value="El Tejar">El Tejar</option>
                    <option value="Escuintla">Escuintla</option>
                    <option value="Esquipulas">Esquipulas</option>
                    <option value="Flores">Flores</option>
                    <option value="Fraijanes">Fraijanes</option>
                    <option value="Gualán">Gualán</option>
                    <option value="Guastatoya">Guastatoya</option>
                    <option value="Guatemala">Guatemala</option>
                    <option value="Huehuetenango">Huehuetenango</option>
                    <option value="Jacaltenango">Jacaltenango</option>
                    <option value="Jalapa">Jalapa</option>
                    <option value="Jocotenango">Jocotenango</option>
                    <option value="Jutiapa">Jutiapa</option>
                    <option value="La Democracia">La Democracia</option>
                    <option value="La Esperanza">La Esperanza</option>
                    <option value="La Gomera">La Gomera</option>
                    <option value="Livingston">Livingston</option>
                    <option value="Malacatán">Malacatán</option>
                    <option value="Mazatenango">Mazatenango</option>
                    <option value="Melchor de Mencos">Melchor de Mencos</option>
                    <option value="Mixco">Mixco</option>
                    <option value="Momostenango">Momostenango</option>
                    <option value="Morales">Morales</option>
                    <option value="Nahualá">Nahualá</option>
                    <option value="Nueva Concepción">Nueva Concepción</option>
                    <option value="Nuevo San Carlos">Nuevo San Carlos</option>
                    <option value="Olintepeque">Olintepeque</option>
                    <option value="Ostuncalco">Ostuncalco</option>
                    <option value="Palencia">Palencia</option>
                    <option value="Palín">Palín</option>
                    <option value="Panajachel">Panajachel</option>
                    <option value="Panzós">Panzós</option>
                    <option value="Patulul">Patulul</option>
                    <option value="Patzicía">Patzicía</option>
                    <option value="Patzún">Patzún</option>
                    <option value="Poptún">Poptún</option>
                    <option value="Puerto Barrios">Puerto Barrios</option>
                    <option value="Puerto San José">Puerto San José</option>
                    <option value="Quetzaltenango">Quetzaltenango</option>
                    <option value="Retalhuleu">Retalhuleu</option>
                    <option value="Salamá">Salamá</option>
                    <option value="Salcajá">Salcajá</option>
                    <option value="San Andrés Itzapa">San Andrés Itzapa</option>
                    <option value="San Benito">San Benito</option>
                    <option value="San Cristóbal Verapaz">San Cristóbal Verapaz</option>
                    <option value="San Francisco El Alto">San Francisco El Alto</option>
                    <option value="San Francisco Zapotitlán">San Francisco Zapotitlán</option>
                    <option value="San José Pinula">San José Pinula</option>
                    <option value="San Juan Sacatepéquez">San Juan Sacatepéquez</option>
                    <option value="San Lucas Sacatepéquez">San Lucas Sacatepéquez</option>
                    <option value="San Lucas Tolimán">San Lucas Tolimán</option>
                    <option value="San Marcos">San Marcos</option>
                    <option value="San Miguel Petapa">San Miguel Petapa</option>
                    <option value="San Pablo">San Pablo</option>
                    <option value="San Pablo Jocopilas">San Pablo Jocopilas</option>
                    <option value="San Pedro Ayampuc">San Pedro Ayampuc</option>
                    <option value="San Pedro Carchá">San Pedro Carchá</option>
                    <option value="San Pedro Sacatepéquez">San Pedro Sacatepéquez</option>
                    <option value="San Sebastián">San Sebastián</option>
                    <option value="Sanarate">Sanarate</option>
                    <option value="Santa Catalina la Tinta">Santa Catalina la Tinta</option>
                    <option value="Santa Catarina Pinula">Santa Catarina Pinula</option>
                    <option value="Santa Cruz Barillas">Santa Cruz Barillas</option>
                    <option value="Santa Cruz del Quiché">Santa Cruz del Quiché</option>
                    <option value="Santa Lucía Cotzumalguapa">Santa Lucía Cotzumalguapa</option>
                    <option value="Santa María de Jesús">Santa María de Jesús</option>
                    <option value="Santa Maria Nebaj">Santa Maria Nebaj</option>
                    <option value="Santiago Sacatepéquez">Santiago Sacatepéquez</option>
                    <option value="Sololá">Sololá</option>
                    <option value="Sumpango">Sumpango</option>
                    <option value="Tecpán">Tecpán</option>
                    <option value="Tiquisate">Tiquisate</option>
                    <option value="Totonicapán">Totonicapán</option>
                    <option value="Villa Canales">Villa Canales</option>
                    <option value="Villa Nueva">Villa Nueva</option>
                    <option value="Zacapa">Zacapa</option>
                </select>

                <?php
            }elseif ($pays == "Guinee equatoriale"){
                ?>
                <select class="select" name="localisation">
                    <option value="Aconibe">Aconibe</option>
                    <option value="Acurenam">Acurenam</option>
                    <option value="Añisoc">Añisoc</option>
                    <option value="Ayene">Ayene</option>
                    <option value="Baney">Baney</option>
                    <option value="Bata">Bata</option>
                    <option value="Bicurga">Bicurga</option>
                    <option value="Bidjabidjan">Bidjabidjan</option>
                    <option value="Cogo">Cogo</option>
                    <option value="Corisco">Corisco</option>
                    <option value="Ebebiyín">Ebebiyín</option>
                    <option value="Evinayong">Evinayong</option>
                    <option value="Luba">Luba</option>
                    <option value="Machinda">Machinda</option>
                    <option value="Malabo">Malabo</option>
                    <option value="Mbini">Mbini</option>
                    <option value="Mengomeyén">Mengomeyén</option>
                    <option value="Mikomeseng">Mikomeseng</option>
                    <option value="Mongomo">Mongomo</option>
                    <option value="Niefang">Niefang</option>
                    <option value="Nkimi">Nkimi</option>
                    <option value="Nsang">Nsang</option>
                    <option value="Nsok">Nsok</option>
                    <option value="Nsork">Nsork</option>
                    <option value="Rebola">Rebola</option>
                    <option value="San Antonio de Palé">San Antonio de Palé</option>
                </select>

                <?php
            }elseif ($pays == "Guinee-Bissau"){
                ?>
                <select class="select" name="localisation">
                    <option value="Bafatá">Bafatá</option>
                    <option value="Bissau">Bissau</option>
                    <option value="Bissorã">Bissorã</option>
                    <option value="Bolama">Bolama</option>
                    <option value="Buba">Buba</option>
                    <option value="Bubaque">Bubaque</option>
                    <option value="Cacheu">Cacheu</option>
                    <option value="Canchungo">Canchungo</option>
                    <option value="Catió">Catió</option>
                    <option value="Farim">Farim</option>
                    <option value="Fulacunda">Fulacunda</option>
                    <option value="Gabu">Gabu</option>
                    <option value="Mansôa">Mansôa</option>
                    <option value="Quebo">Quebo</option>
                    <option value="Quinhámel">Quinhámel</option>
                </select>

                <?php
            }elseif ($pays == "Guinee"){
                ?>
                <select class="select" name="localisation">
                    <option value="Beyla">Beyla</option>
                    <option value="Boffa">Boffa</option>
                    <option value="Boké">Boké</option>
                    <option value="Conakry">Conakry</option>
                    <option value="Coyah">Coyah</option>
                    <option value="Dabola">Dabola</option>
                    <option value="Dalaba">Dalaba</option>
                    <option value="Dinguiraye">Dinguiraye</option>
                    <option value="Dubreka">Dubreka</option>
                    <option value="Faranah">Faranah</option>
                    <option value="Forecariah">Forecariah</option>
                    <option value="Fria">Fria</option>
                    <option value="Gaoual">Gaoual</option>
                    <option value="Gueckedou">Gueckedou</option>
                    <option value="Kamsar">Kamsar</option>
                    <option value="Kankan">Kankan</option>
                    <option value="Kérouane">Kérouane</option>
                    <option value="Kindia">Kindia</option>
                    <option value="Kissidougou">Kissidougou</option>
                    <option value="Koubia">Koubia</option>
                    <option value="Koundara">Koundara</option>
                    <option value="Kouroussa">Kouroussa</option>
                    <option value="Labé">Labé</option>
                    <option value="Lélouma">Lélouma</option>
                    <option value="Lola">Lola</option>
                    <option value="Macenta">Macenta</option>
                    <option value="Mali">Mali</option>
                    <option value="Mamou">Mamou</option>
                    <option value="Mandiana">Mandiana</option>
                    <option value="N'Zérékoré">N'Zérékoré</option>
                    <option value="Ourouss">Ourouss</option>
                    <option value="Siguiri">Siguiri</option>
                    <option value="Télimélé">Télimélé</option>
                    <option value="Tougué">Tougué</option>
                    <option value="Yomou">Yomou</option>
                    <option value="Youkounkoun">Youkounkoun</option>
                </select>

                <?php
            }elseif ($pays == "Guyana"){
                ?>
                <select class="select" name="localisation">
                    <option value="Anna Regina">Anna Regina</option>
                    <option value="Bartica">Bartica</option>
                    <option value="Charity">Charity</option>
                    <option value="Corriverton">Corriverton</option>
                    <option value="Danielstown">Danielstown</option>
                    <option value="Fort Wellington">Fort Wellington</option>
                    <option value="Georgetown">Georgetown</option>
                    <option value="Ituni">Ituni</option>
                    <option value="Kumaka">Kumaka</option>
                    <option value="Lethem">Lethem</option>
                    <option value="Linden">Linden</option>
                    <option value="Mabaruma">Mabaruma</option>
                    <option value="Mahaica">Mahaica</option>
                    <option value="Mahaicony Village">Mahaicony Village</option>
                    <option value="Mahdia">Mahdia</option>
                    <option value="Nouvelle-Amsterdam">Nouvelle-Amsterdam</option>
                    <option value="Paradise">Paradise</option>
                    <option value="Parika">Parika</option>
                    <option value="Queenstown">Queenstown</option>
                    <option value="Rose Hall">Rose Hall</option>
                    <option value="Rosignol">Rosignol</option>
                    <option value="Skeldon">Skeldon</option>
                    <option value="Vreed en Hoop">Vreed en Hoop</option>
                </select>

                <?php
            }elseif ($pays == "Haïti"){
                ?>
                <select class="select" name="localisation">
                    <option value="Anse-à-Galets">Anse-à-Galets</option>
                    <option value="Anse-d'Ainault">Anse-d'Ainault</option>
                    <option value="Aquin">Aquin</option>
                    <option value="Cap-Haïtien">Cap-Haïtien</option>
                    <option value="Carrefour">Carrefour</option>
                    <option value="Croix-des-Bouquets">Croix-des-Bouquets</option>
                    <option value="Dame-Marie">Dame-Marie</option>
                    <option value="Delmas">Delmas</option>
                    <option value="Desdunes">Desdunes</option>
                    <option value="Dessalines">Dessalines</option>
                    <option value="Fort-Liberté">Fort-Liberté</option>
                    <option value="Grande-Rivière-du-Nord">Grande-Rivière-du-Nord</option>
                    <option value="Gros-Morne">Gros-Morne</option>
                    <option value="Hinche">Hinche</option>
                    <option value="Jacmel">Jacmel</option>
                    <option value="Jérémie">Jérémie</option>
                    <option value="Kenscoff">Kenscoff</option>
                    <option value="Lascahobas">Lascahobas</option>
                    <option value="Léogâne">Léogâne</option>
                    <option value="Les Cayes">Les Cayes</option>
                    <option value="Les Gonaïves">Les Gonaïves</option>
                    <option value="Limbé">Limbé</option>
                    <option value="Miragoâne">Miragoâne</option>
                    <option value="Mirebalais">Mirebalais</option>
                    <option value="Ouanaminthe">Ouanaminthe</option>
                    <option value="Pétion-Ville">Pétion-Ville</option>
                    <option value="Petite-Rivière-de-l'Artibonite">Petite-Rivière-de-l'Artibonite</option>
                    <option value="Petit-Goâve">Petit-Goâve</option>
                    <option value="Pignon">Pignon</option>
                    <option value="Port-au-Prince">Port-au-Prince</option>
                    <option value="Port-de-Paix">Port-de-Paix</option>
                    <option value="Saint-Louis-du-Nord">Saint-Louis-du-Nord</option>
                    <option value="Saint-Marc">Saint-Marc</option>
                    <option value="Saint-Michel-de-l'Attalaye">Saint-Michel-de-l'Attalaye</option>
                    <option value="Saint-Raphaël">Saint-Raphaël</option>
                    <option value="Trou-du-Nord">Trou-du-Nord</option>
                    <option value="Verrettes">Verrettes</option>
                </select>

                <?php
            }elseif ($pays == "Honduras"){
                ?>
                <select class="select" name="localisation">
                    <option value="Catacamas">Catacamas</option>
                    <option value="Choloma">Choloma</option>
                    <option value="Choluteca">Choluteca</option>
                    <option value="Cofradía">Cofradía</option>
                    <option value="Comayagua">Comayagua</option>
                    <option value="Danlí">Danlí</option>
                    <option value="El Paraíso">El Paraíso</option>
                    <option value="El Progreso">El Progreso</option>
                    <option value="Guaimaca">Guaimaca</option>
                    <option value="Intibucá">Intibucá</option>
                    <option value="Juticalpa">Juticalpa</option>
                    <option value="La Ceiba">La Ceiba</option>
                    <option value="La Entrada">La Entrada</option>
                    <option value="La Lima">La Lima</option>
                    <option value="La Paz">La Paz</option>
                    <option value="Marcala">Marcala</option>
                    <option value="Morazán">Morazán</option>
                    <option value="Nacaome">Nacaome</option>
                    <option value="Olanchito">Olanchito</option>
                    <option value="Potrerillos">Potrerillos</option>
                    <option value="Puerto Cortés">Puerto Cortés</option>
                    <option value="San Lorenzo">San Lorenzo</option>
                    <option value="San Pedro Sula">San Pedro Sula</option>
                    <option value="Santa Bárbara">Santa Bárbara</option>
                    <option value="Santa Cruz de Yojoa">Santa Cruz de Yojoa</option>
                    <option value="Santa Rita">Santa Rita</option>
                    <option value="Santa Rosa de Copán">Santa Rosa de Copán</option>
                    <option value="Siguatepeque">Siguatepeque</option>
                    <option value="Sonaguera">Sonaguera</option>
                    <option value="Talanga">Talanga</option>
                    <option value="Tegucigalpa">Tegucigalpa</option>
                    <option value="Tela">Tela</option>
                    <option value="Tocoa">Tocoa</option>
                    <option value="Villanueva">Villanueva</option>
                    <option value="Yoro">Yoro</option>
                </select>

                <?php
            }elseif ($pays == "Hong-Kong"){
                ?>
                <select class="select" name="localisation">
                    <option value="Central and Western">Central and Western</option>
                    <option value="Eastern">Eastern</option>
                    <option value="Islands">Islands</option>
                    <option value="Kowloon City">Kowloon City</option>
                    <option value="Kwai Tsing">Kwai Tsing</option>
                    <option value="Kwun Tong">Kwun Tong</option>
                    <option value="North">North</option>
                    <option value="Sai Kung">Sai Kung</option>
                    <option value="Sha Tin">Sha Tin</option>
                    <option value="Sham Shui Po">Sham Shui Po</option>
                    <option value="Southern">Southern</option>
                    <option value="Tai Po">Tai Po</option>
                    <option value="Tsuen Wan">Tsuen Wan</option>
                    <option value="Tuen Mun">Tuen Mun</option>
                    <option value="Wan Chai">Wan Chai</option>
                    <option value="Wong Tai Sin">Wong Tai Sin</option>
                    <option value="Yau Tsim Mong">Yau Tsim Mong</option>
                    <option value="Yuen Long">Yuen Long</option>
                </select>

                <?php
            }elseif ($pays == "Hongrie"){
                ?>
                <select class="select" name="localisation">
                    <option value="Abádszalók">Abádszalók</option>
                    <option value="Abaújszántó">Abaújszántó</option>
                    <option value="Abony">Abony</option>
                    <option value="Ács">Ács</option>
                    <option value="Adony">Adony</option>
                    <option value="Ajka">Ajka</option>
                    <option value="Albertirsa">Albertirsa</option>
                    <option value="Alsózsolca">Alsózsolca</option>
                    <option value="Aszód">Aszód</option>
                    <option value="Bábolna">Bábolna</option>
                    <option value="Bácsalmás">Bácsalmás</option>
                    <option value="Badacsonytomaj">Badacsonytomaj</option>
                    <option value="Baja">Baja</option>
                    <option value="Baktalórántháza">Baktalórántháza</option>
                    <option value="Balassagyarmat">Balassagyarmat</option>
                    <option value="Balatonalmádi">Balatonalmádi</option>
                    <option value="Balatonboglár">Balatonboglár</option>
                    <option value="Balatonföldvár">Balatonföldvár</option>
                    <option value="Balatonfüred">Balatonfüred</option>
                    <option value="Balatonfűzfő">Balatonfűzfő</option>
                    <option value="Balatonkenese">Balatonkenese</option>
                    <option value="Balatonlelle">Balatonlelle</option>
                    <option value="Balkány">Balkány</option>
                    <option value="Balmazújváros">Balmazújváros</option>
                    <option value="Barcs">Barcs</option>
                    <option value="Bátaszék">Bátaszék</option>
                    <option value="Bátonyterenye">Bátonyterenye</option>
                    <option value="Battonya">Battonya</option>
                    <option value="Békés">Békés</option>
                    <option value="Bélapátfalva">Bélapátfalva</option>
                    <option value="Beled">Beled</option>
                    <option value="Berettyóújfalu">Berettyóújfalu</option>
                    <option value="Berhida">Berhida</option>
                    <option value="Biatorbágy">Biatorbágy</option>
                    <option value="Bicske">Bicske</option>
                    <option value="Biharkeresztes">Biharkeresztes</option>
                    <option value="Bodajk">Bodajk</option>
                    <option value="Bóly">Bóly</option>
                    <option value="Bonyhád">Bonyhád</option>
                    <option value="Borsodnádasd">Borsodnádasd</option>
                    <option value="Budakalász">Budakalász</option>
                    <option value="Budakeszi">Budakeszi</option>
                    <option value="Budaörs">Budaörs</option>
                    <option value="Bük">Bük</option>
                    <option value="Cegléd">Cegléd</option>
                    <option value="Celldömölk">Celldömölk</option>
                    <option value="Cigánd">Cigánd</option>
                    <option value="Csanádpalota">Csanádpalota</option>
                    <option value="Csenger">Csenger</option>
                    <option value="Csepreg">Csepreg</option>
                    <option value="Csongrád">Csongrád</option>
                    <option value="Csorna">Csorna</option>
                    <option value="Csorvás">Csorvás</option>
                    <option value="Csurgó">Csurgó</option>
                    <option value="Dabas">Dabas</option>
                    <option value="Demecser">Demecser</option>
                    <option value="Derecske">Derecske</option>
                    <option value="Dévaványa">Dévaványa</option>
                    <option value="Devecser">Devecser</option>
                    <option value="Dombóvár">Dombóvár</option>
                    <option value="Dombrád">Dombrád</option>
                    <option value="Dorog">Dorog</option>
                    <option value="Dunaföldvár">Dunaföldvár</option>
                    <option value="Dunaharaszti">Dunaharaszti</option>
                    <option value="Dunakeszi">Dunakeszi</option>
                    <option value="Dunavarsány">Dunavarsány</option>
                    <option value="Dunavecse">Dunavecse</option>
                    <option value="Edelény">Edelény</option>
                    <option value="Elek">Elek</option>
                    <option value="Emőd">Emőd</option>
                    <option value="Encs">Encs</option>
                    <option value="Enying">Enying</option>
                    <option value="Ercsi">Ercsi</option>
                    <option value="Esztergom">Esztergom</option>
                    <option value="Fehérgyarmat">Fehérgyarmat</option>
                    <option value="Felsőzsolca">Felsőzsolca</option>
                    <option value="Fertőd">Fertőd</option>
                    <option value="Fertőszentmiklós">Fertőszentmiklós</option>
                    <option value="Fonyód">Fonyód</option>
                    <option value="Fót">Fót</option>
                    <option value="Füzesabony">Füzesabony</option>
                    <option value="Füzesgyarmat">Füzesgyarmat</option>
                    <option value="Gárdony">Gárdony</option>
                    <option value="Göd">Göd</option>
                    <option value="Gödöllő">Gödöllő</option>
                    <option value="Gönc">Gönc</option>
                    <option value="Gyál">Gyál</option>
                    <option value="Gyomaendrőd">Gyomaendrőd</option>
                    <option value="Gyömrő">Gyömrő</option>
                    <option value="Gyöngyös">Gyöngyös</option>
                    <option value="Gyönk">Gyönk</option>
                    <option value="Gyula">Gyula</option>
                    <option value="Hajdúböszörmény">Hajdúböszörmény</option>
                    <option value="Hajdúdorog">Hajdúdorog</option>
                    <option value="Hajdúhadház">Hajdúhadház</option>
                    <option value="Hajdúnánás">Hajdúnánás</option>
                    <option value="Hajdúsámson">Hajdúsámson</option>
                    <option value="Hajdúszoboszló">Hajdúszoboszló</option>
                    <option value="Hajós">Hajós</option>
                    <option value="Halásztelek">Halásztelek</option>
                    <option value="Harkány">Harkány</option>
                    <option value="Hatvan">Hatvan</option>
                    <option value="Herend">Herend</option>
                    <option value="Heves">Heves</option>
                    <option value="Hévíz">Hévíz</option>
                    <option value="Ibrány">Ibrány</option>
                    <option value="Igal">Igal</option>
                    <option value="Isaszeg">Isaszeg</option>
                    <option value="Izsák">Izsák</option>
                    <option value="Jánoshalma">Jánoshalma</option>
                    <option value="Jánossomorja">Jánossomorja</option>
                    <option value="Jászapáti">Jászapáti</option>
                    <option value="Jászárokszállás">Jászárokszállás</option>
                    <option value="Jászberény">Jászberény</option>
                    <option value="Jászfényszaru">Jászfényszaru</option>
                    <option value="Jászkisér">Jászkisér</option>
                    <option value="Kaba">Kaba</option>
                    <option value="Kadarkút">Kadarkút</option>
                    <option value="Kalocsa">Kalocsa</option>
                    <option value="Kapuvár">Kapuvár</option>
                    <option value="Karcag">Karcag</option>
                    <option value="Kazincbarcika">Kazincbarcika</option>
                    <option value="Kecel">Kecel</option>
                    <option value="Kemecse">Kemecse</option>
                    <option value="Kenderes">Kenderes</option>
                    <option value="Kerekegyháza">Kerekegyháza</option>
                    <option value="Keszthely">Keszthely</option>
                    <option value="Kisbér">Kisbér</option>
                    <option value="Kisköre">Kisköre</option>
                    <option value="Kiskőrös">Kiskőrös</option>
                    <option value="Kiskunfélegyháza">Kiskunfélegyháza</option>
                    <option value="Kiskunhalas">Kiskunhalas</option>
                    <option value="Kiskunmajsa">Kiskunmajsa</option>
                    <option value="Kistelek">Kistelek</option>
                    <option value="Kisújszállás">Kisújszállás</option>
                    <option value="Kisvárda">Kisvárda</option>
                    <option value="Komádi">Komádi</option>
                    <option value="Komárom">Komárom</option>
                    <option value="Komló">Komló</option>
                    <option value="Körmend">Körmend</option>
                    <option value="Körösladány">Körösladány</option>
                    <option value="Kőszeg">Kőszeg</option>
                    <option value="Kozármisleny">Kozármisleny</option>
                    <option value="Kunhegyes">Kunhegyes</option>
                    <option value="Kunszentmárton">Kunszentmárton</option>
                    <option value="Kunszentmiklós">Kunszentmiklós</option>
                    <option value="Lábatlan">Lábatlan</option>
                    <option value="Lajosmizse">Lajosmizse</option>
                    <option value="Lengyeltóti">Lengyeltóti</option>
                    <option value="Lenti">Lenti</option>
                    <option value="Létavértes">Létavértes</option>
                    <option value="Letenye">Letenye</option>
                    <option value="Lőrinci">Lőrinci</option>
                    <option value="Maglód">Maglód</option>
                    <option value="Mágocs">Mágocs</option>
                    <option value="Makó">Makó</option>
                    <option value="Mándok">Mándok</option>
                    <option value="Marcali">Marcali</option>
                    <option value="Máriapócs">Máriapócs</option>
                    <option value="Martfű">Martfű</option>
                    <option value="Martonvásár">Martonvásár</option>
                    <option value="Mátészalka">Mátészalka</option>
                    <option value="Medgyesegyháza">Medgyesegyháza</option>
                    <option value="Mélykút">Mélykút</option>
                    <option value="Mezőberény">Mezőberény</option>
                    <option value="Mezőcsát">Mezőcsát</option>
                    <option value="Mezőhegyes">Mezőhegyes</option>
                    <option value="Mezőkeresztes">Mezőkeresztes</option>
                    <option value="Mezőkovácsháza">Mezőkovácsháza</option>
                    <option value="Mezőkövesd">Mezőkövesd</option>
                    <option value="Mezőtúr">Mezőtúr</option>
                    <option value="Mindszent">Mindszent</option>
                    <option value="Mohács">Mohács</option>
                    <option value="Monor">Monor</option>
                    <option value="Mór">Mór</option>
                    <option value="Mórahalom">Mórahalom</option>
                    <option value="Mosonmagyaróvár">Mosonmagyaróvár</option>
                    <option value="Nádudvar">Nádudvar</option>
                    <option value="Nagyatád">Nagyatád</option>
                    <option value="Nagybajom">Nagybajom</option>
                    <option value="Nagyecsed">Nagyecsed</option>
                    <option value="Nagyhalász">Nagyhalász</option>
                    <option value="Nagykálló">Nagykálló</option>
                    <option value="Nagykáta">Nagykáta</option>
                    <option value="Nagykőrös">Nagykőrös</option>
                    <option value="Nagymányok">Nagymányok</option>
                    <option value="Nagymaros">Nagymaros</option>
                    <option value="Nyékládháza">Nyékládháza</option>
                    <option value="Nyergesújfalu">Nyergesújfalu</option>
                    <option value="Nyíradony">Nyíradony</option>
                    <option value="Nyírbátor">Nyírbátor</option>
                    <option value="Nyírlugos">Nyírlugos</option>
                    <option value="Nyírmada">Nyírmada</option>
                    <option value="Nyírtelek">Nyírtelek</option>
                    <option value="Ócsa">Ócsa</option>
                    <option value="Őriszentpéter">Őriszentpéter</option>
                    <option value="Örkény">Örkény</option>
                    <option value="Orosháza">Orosháza</option>
                    <option value="Oroszlány">Oroszlány</option>
                    <option value="Ózd">Ózd</option>
                    <option value="Pacsa">Pacsa</option>
                    <option value="Paks">Paks</option>
                    <option value="Pálháza">Pálháza</option>
                    <option value="Pannonhalma">Pannonhalma</option>
                    <option value="Pápa">Pápa</option>
                    <option value="Pásztó">Pásztó</option>
                    <option value="Pécel">Pécel</option>
                    <option value="Pécsvárad">Pécsvárad</option>
                    <option value="Pétervására">Pétervására</option>
                    <option value="Pilis">Pilis</option>
                    <option value="Pilisvörösvár">Pilisvörösvár</option>
                    <option value="Polgár">Polgár</option>
                    <option value="Polgárdi">Polgárdi</option>
                    <option value="Pomáz">Pomáz</option>
                    <option value="Püspökladány">Püspökladány</option>
                    <option value="Pusztaszabolcs">Pusztaszabolcs</option>
                    <option value="Putnok">Putnok</option>
                    <option value="Rácalmás">Rácalmás</option>
                    <option value="Ráckeve">Ráckeve</option>
                    <option value="Rakamaz">Rakamaz</option>
                    <option value="Rákóczifalva">Rákóczifalva</option>
                    <option value="Répcelak">Répcelak</option>
                    <option value="Rétság">Rétság</option>
                    <option value="Rudabánya">Rudabánya</option>
                    <option value="Sajóbábony">Sajóbábony</option>
                    <option value="Sajószentpéter">Sajószentpéter</option>
                    <option value="Sándorfalva">Sándorfalva</option>
                    <option value="Sárbogárd">Sárbogárd</option>
                    <option value="Sarkad">Sarkad</option>
                    <option value="Sárospatak">Sárospatak</option>
                    <option value="Sárvár">Sárvár</option>
                    <option value="Sásd">Sásd</option>
                    <option value="Sátoraljaújhely">Sátoraljaújhely</option>
                    <option value="Sellye">Sellye</option>
                    <option value="Siklós">Siklós</option>
                    <option value="Simontornya">Simontornya</option>
                    <option value="Siófok">Siófok</option>
                    <option value="Solt">Solt</option>
                    <option value="Soltvadkert">Soltvadkert</option>
                    <option value="Sümeg">Sümeg</option>
                    <option value="Szabadszállás">Szabadszállás</option>
                    <option value="Szarvas">Szarvas</option>
                    <option value="Százhalombatta">Százhalombatta</option>
                    <option value="Szécsény">Szécsény</option>
                    <option value="Szendrő">Szendrő</option>
                    <option value="Szentendre">Szentendre</option>
                    <option value="Szentes">Szentes</option>
                    <option value="Szentgotthárd">Szentgotthárd</option>
                    <option value="Szentlőrinc">Szentlőrinc</option>
                    <option value="Szerencs">Szerencs</option>
                    <option value="Szigethalom">Szigethalom</option>
                    <option value="Szigetszentmiklós">Szigetszentmiklós</option>
                    <option value="Szigetvár">Szigetvár</option>
                    <option value="Szikszó">Szikszó</option>
                    <option value="Szob">Szob</option>
                    <option value="Tab">Tab</option>
                    <option value="Tamási">Tamási</option>
                    <option value="Tápiószele">Tápiószele</option>
                    <option value="Tapolca">Tapolca</option>
                    <option value="Tata">Tata</option>
                    <option value="Téglás">Téglás</option>
                    <option value="Tét">Tét</option>
                    <option value="Tiszacsege">Tiszacsege</option>
                    <option value="Tiszaföldvár">Tiszaföldvár</option>
                    <option value="Tiszafüred">Tiszafüred</option>
                    <option value="Tiszakécske">Tiszakécske</option>
                    <option value="Tiszalök">Tiszalök</option>
                    <option value="Tiszaújváros">Tiszaújváros</option>
                    <option value="Tiszavasvári">Tiszavasvári</option>
                    <option value="Tokaj">Tokaj</option>
                    <option value="Tököl">Tököl</option>
                    <option value="Tolna">Tolna</option>
                    <option value="Tompa">Tompa</option>
                    <option value="Törökbálint">Törökbálint</option>
                    <option value="Törökszentmiklós">Törökszentmiklós</option>
                    <option value="Tótkomlós">Tótkomlós</option>
                    <option value="Tura">Tura</option>
                    <option value="Túrkeve">Túrkeve</option>
                    <option value="Újfehértó">Újfehértó</option>
                    <option value="Újkígyós">Újkígyós</option>
                    <option value="Újszász">Újszász</option>
                    <option value="Üllő">Üllő</option>
                    <option value="Vác">Vác</option>
                    <option value="Vaja">Vaja</option>
                    <option value="Vámospércs">Vámospércs</option>
                    <option value="Várpalota">Várpalota</option>
                    <option value="Vásárosnamény">Vásárosnamény</option>
                    <option value="Vasvár">Vasvár</option>
                    <option value="Vecsés">Vecsés</option>
                    <option value="Velence">Velence</option>
                    <option value="Vép">Vép</option>
                    <option value="Veresegyház">Veresegyház</option>
                    <option value="Vésztő">Vésztő</option>
                    <option value="Villány">Villány</option>
                    <option value="Visegrád">Visegrád</option>
                    <option value="Záhony">Záhony</option>
                    <option value="Zalakaros">Zalakaros</option>
                    <option value="Zalalövő">Zalalövő</option>
                    <option value="Zalaszentgrót">Zalaszentgrót</option>
                    <option value="Zamárdi">Zamárdi</option>
                    <option value="Zirc">Zirc</option>
                    <option value="Zsámbék">Zsámbék</option>
                </select>



                <?php
            }elseif ($pays == "Inde"){
                ?>
                <select class="select" name="localisation">
                    <option value="Agartala">Agartala</option>
                    <option value="Agra">Agra</option>
                    <option value="Ahmadnagar">Ahmadnagar</option>
                    <option value="Ahmedabad">Ahmedabad</option>
                    <option value="Aizawl">Aizawl</option>
                    <option value="Ajmer">Ajmer</option>
                    <option value="Akola">Akola</option>
                    <option value="Aligarh">Aligarh</option>
                    <option value="Alwar">Alwar</option>
                    <option value="Ambattur">Ambattur</option>
                    <option value="Ambernath">Ambernath</option>
                    <option value="Amravati">Amravati</option>
                    <option value="Amritsar">Amritsar</option>
                    <option value="Anantapur">Anantapur</option>
                    <option value="Arrah">Arrah</option>
                    <option value="Asansol">Asansol</option>
                    <option value="Aurangabad">Aurangabad</option>
                    <option value="Avadi">Avadi</option>
                    <option value="Bally">Bally</option>
                    <option value="Baranagar">Baranagar</option>
                    <option value="Barasat">Barasat</option>
                    <option value="Bardhaman">Bardhaman</option>
                    <option value="Bareilly">Bareilly</option>
                    <option value="Bathinda">Bathinda</option>
                    <option value="Begusarai">Begusarai</option>
                    <option value="Belgaum">Belgaum</option>
                    <option value="Bellary">Bellary</option>
                    <option value="Bengaluru">Bengaluru</option>
                    <option value="Bhagalpur">Bhagalpur</option>
                    <option value="Bharatpur">Bharatpur</option>
                    <option value="Bhatpara">Bhatpara</option>
                    <option value="Bhavnagar">Bhavnagar</option>
                    <option value="Bhilai">Bhilai</option>
                    <option value="Bhilwara">Bhilwara</option>
                    <option value="Bhiwandi">Bhiwandi</option>
                    <option value="Bhopal">Bhopal</option>
                    <option value="Bhubaneswar">Bhubaneswar</option>
                    <option value="Bidar">Bidar</option>
                    <option value="Bidhan Nagar">Bidhan Nagar</option>
                    <option value="Bihar Sharif">Bihar Sharif</option>
                    <option value="Bijapur">Bijapur</option>
                    <option value="Bikaner">Bikaner</option>
                    <option value="Bilaspur">Bilaspur</option>
                    <option value="Bokaro">Bokaro</option>
                    <option value="Brahmapur">Brahmapur</option>
                    <option value="Bulandshahr">Bulandshahr</option>
                    <option value="Burhanpur">Burhanpur</option>
                    <option value="Chandigarh">Chandigarh</option>
                    <option value="Chandrapur">Chandrapur</option>
                    <option value="Chennai">Chennai</option>
                    <option value="Chhapra">Chhapra</option>
                    <option value="Coimbatore">Coimbatore</option>
                    <option value="Cuttack">Cuttack</option>
                    <option value="Darbhanga">Darbhanga</option>
                    <option value="Davangere">Davangere</option>
                    <option value="Dehradun">Dehradun</option>
                    <option value="Delhi">Delhi</option>
                    <option value="Deoghar">Deoghar</option>
                    <option value="Dewas">Dewas</option>
                    <option value="Dhanbad">Dhanbad</option>
                    <option value="Dhule">Dhule</option>
                    <option value="Dindigul">Dindigul</option>
                    <option value="Durg">Durg</option>
                    <option value="Durgapur">Durgapur</option>
                    <option value="Eluru">Eluru</option>
                    <option value="English Bazar">English Bazar</option>
                    <option value="Etawah">Etawah</option>
                    <option value="Faridabad">Faridabad</option>
                    <option value="Farrukhabad-cum-Fatehgarh">Farrukhabad-cum-Fatehgarh</option>
                    <option value="Firozabad">Firozabad</option>
                    <option value="Gandhidham">Gandhidham</option>
                    <option value="Gandhinagar">Gandhinagar</option>
                    <option value="Ganganagar">Ganganagar</option>
                    <option value="Gaya">Gaya</option>
                    <option value="Ghaziabad">Ghaziabad</option>
                    <option value="Gorakhpur">Gorakhpur</option>
                    <option value="Gulbarga">Gulbarga</option>
                    <option value="Guntur">Guntur</option>
                    <option value="Gurgaon">Gurgaon</option>
                    <option value="Guwahati">Guwahati</option>
                    <option value="Gwalior">Gwalior</option>
                    <option value="Haldia">Haldia</option>
                    <option value="Haora">Haora</option>
                    <option value="Hapur">Hapur</option>
                    <option value="Haridwar">Haridwar</option>
                    <option value="Hisar">Hisar</option>
                    <option value="Hospet">Hospet</option>
                    <option value="Hubli-Dharwad">Hubli-Dharwad</option>
                    <option value="Hyderabad">Hyderabad</option>
                    <option value="Ichalkaranji">Ichalkaranji</option>
                    <option value="Imphal">Imphal</option>
                    <option value="Indore">Indore</option>
                    <option value="Jabalpur">Jabalpur</option>
                    <option value="Jaipur">Jaipur</option>
                    <option value="Jalandhar">Jalandhar</option>
                    <option value="Jalgaon">Jalgaon</option>
                    <option value="Jalna">Jalna</option>
                    <option value="Jammu">Jammu</option>
                    <option value="Jamnagar">Jamnagar</option>
                    <option value="Jamshedpur">Jamshedpur</option>
                    <option value="Jhansi">Jhansi</option>
                    <option value="Jodhpur">Jodhpur</option>
                    <option value="Junagadh">Junagadh</option>
                    <option value="Kadapa">Kadapa</option>
                    <option value="Kakinada">Kakinada</option>
                    <option value="Kalyan-Dombivli">Kalyan-Dombivli</option>
                    <option value="Kamarhati">Kamarhati</option>
                    <option value="Kanpur">Kanpur</option>
                    <option value="Karawal Nagar">Karawal Nagar</option>
                    <option value="Karimnagar">Karimnagar</option>
                    <option value="Karnal">Karnal</option>
                    <option value="Katihar">Katihar</option>
                    <option value="Khandwa">Khandwa</option>
                    <option value="Kharagpur">Kharagpur</option>
                    <option value="Kirari Suleman Nagar">Kirari Suleman Nagar</option>
                    <option value="Kochi">Kochi</option>
                    <option value="Kolhapur">Kolhapur</option>
                    <option value="Kolkata">Kolkata</option>
                    <option value="Kollam">Kollam</option>
                    <option value="Korba">Korba</option>
                    <option value="Kota">Kota</option>
                    <option value="Kozhikode">Kozhikode</option>
                    <option value="Kulti">Kulti</option>
                    <option value="Kurnool">Kurnool</option>
                    <option value="Latur">Latur</option>
                    <option value="Loni">Loni</option>
                    <option value="Lucknow">Lucknow</option>
                    <option value="Ludhiana">Ludhiana</option>
                    <option value="Madurai">Madurai</option>
                    <option value="Maheshtala">Maheshtala</option>
                    <option value="Malegaon">Malegaon</option>
                    <option value="Mangalore">Mangalore</option>
                    <option value="Mango">Mango</option>
                    <option value="Mathura">Mathura</option>
                    <option value="Mau">Mau</option>
                    <option value="Meerut">Meerut</option>
                    <option value="Mira-Bhayandar">Mira-Bhayandar</option>
                    <option value="Mirzapur">Mirzapur</option>
                    <option value="Moradabad">Moradabad</option>
                    <option value="Morena">Morena</option>
                    <option value="Mumbai">Mumbai</option>
                    <option value="Munger">Munger</option>
                    <option value="Murwara">Murwara</option>
                    <option value="Muzaffarnagar">Muzaffarnagar</option>
                    <option value="Muzaffarpur">Muzaffarpur</option>
                    <option value="Mysore">Mysore</option>
                    <option value="Nadiad">Nadiad</option>
                    <option value="Nagercoil">Nagercoil</option>
                    <option value="Nagpur">Nagpur</option>
                    <option value="Naihati">Naihati</option>
                    <option value="Nanded">Nanded</option>
                    <option value="Nandyal">Nandyal</option>
                    <option value="Nangloi Jat">Nangloi Jat</option>
                    <option value="Nashik">Nashik</option>
                    <option value="Navi Mumbai">Navi Mumbai</option>
                    <option value="Nellore">Nellore</option>
                    <option value="New Delhi">New Delhi</option>
                    <option value="Nizamabad">Nizamabad</option>
                    <option value="Noida">Noida</option>
                    <option value="North Dum Dum">North Dum Dum</option>
                    <option value="Ongole">Ongole</option>
                    <option value="Ozhukarai">Ozhukarai</option>
                    <option value="Pali">Pali</option>
                    <option value="Pallavaram">Pallavaram</option>
                    <option value="Panchkula">Panchkula</option>
                    <option value="Panihati">Panihati</option>
                    <option value="Panipat">Panipat</option>
                    <option value="Parbhani">Parbhani</option>
                    <option value="Patiala">Patiala</option>
                    <option value="Patna">Patna</option>
                    <option value="Pimpri-Chinchwad">Pimpri-Chinchwad</option>
                    <option value="Pondichéry">Pondichéry</option>
                    <option value="Prayagraj">Prayagraj</option>
                    <option value="Pune">Pune</option>
                    <option value="Puri">Puri</option>
                    <option value="Purnia">Purnia</option>
                    <option value="Raichur">Raichur</option>
                    <option value="Raipur">Raipur</option>
                    <option value="Rajahmundry">Rajahmundry</option>
                    <option value="Rajarhat Gopalpur">Rajarhat Gopalpur</option>
                    <option value="Rajkot">Rajkot</option>
                    <option value="Rajpur Sonarpur">Rajpur Sonarpur</option>
                    <option value="Ramagundam">Ramagundam</option>
                    <option value="Rampur">Rampur</option>
                    <option value="Ranchi">Ranchi</option>
                    <option value="Ratlam">Ratlam</option>
                    <option value="Rewa">Rewa</option>
                    <option value="Rohtak">Rohtak</option>
                    <option value="Rourkela">Rourkela</option>
                    <option value="Rourkela Industrial Township">Rourkela Industrial Township</option>
                    <option value="Sagar">Sagar</option>
                    <option value="Saharanpur">Saharanpur</option>
                    <option value="Salem">Salem</option>
                    <option value="Sambhal">Sambhal</option>
                    <option value="Sangli-Miraj-Kupwad">Sangli-Miraj-Kupwad</option>
                    <option value="Satna">Satna</option>
                    <option value="Secunderabad">Secunderabad</option>
                    <option value="Shahjahanpur">Shahjahanpur</option>
                    <option value="Shimoga">Shimoga</option>
                    <option value="Sikar">Sikar</option>
                    <option value="Siliguri">Siliguri</option>
                    <option value="Singrauli">Singrauli</option>
                    <option value="Solapur">Solapur</option>
                    <option value="Sonipat">Sonipat</option>
                    <option value="South Dum Dum">South Dum Dum</option>
                    <option value="Srinagar">Srinagar</option>
                    <option value="Surate">Surate</option>
                    <option value="Thane">Thane</option>
                    <option value="Thanjavur">Thanjavur</option>
                    <option value="Thiruvananthapuram">Thiruvananthapuram</option>
                    <option value="Thoothukudi">Thoothukudi</option>
                    <option value="Thrissur">Thrissur</option>
                    <option value="Tiruchirappalli">Tiruchirappalli</option>
                    <option value="Tirunelveli">Tirunelveli</option>
                    <option value="Tirupati">Tirupati</option>
                    <option value="Tiruppur">Tiruppur</option>
                    <option value="Tiruvottiyur">Tiruvottiyur</option>
                    <option value="Tumkur">Tumkur</option>
                    <option value="Udaipur">Udaipur</option>
                    <option value="Ujjain">Ujjain</option>
                    <option value="Ulhasnagar">Ulhasnagar</option>
                    <option value="Ulubaria">Ulubaria</option>
                    <option value="Vadodara">Vadodara</option>
                    <option value="Varanasi">Varanasi</option>
                    <option value="Vasai-Virar">Vasai-Virar</option>
                    <option value="Vijayawada">Vijayawada</option>
                    <option value="Visakhapatnam">Visakhapatnam</option>
                    <option value="Vizianagaram">Vizianagaram</option>
                    <option value="Warangal">Warangal</option>
                    <option value="Yamunanagar">Yamunanagar</option>
                </select>

                <?php
            }elseif ($pays == "Indonesie"){
                ?>
                <select class="select" name="localisation">
                    <option value="Adiwerna">Adiwerna</option>
                    <option value="Ambon">Ambon</option>
                    <option value="Arjawinangun">Arjawinangun</option>
                    <option value="Astanajapura">Astanajapura</option>
                    <option value="Babakan">Babakan</option>
                    <option value="Balaraja">Balaraja</option>
                    <option value="Baleendah">Baleendah</option>
                    <option value="Balikpapan">Balikpapan</option>
                    <option value="Banda Aceh">Banda Aceh</option>
                    <option value="Bandar Lampung">Bandar Lampung</option>
                    <option value="Bandung">Bandung</option>
                    <option value="Banjar">Banjar</option>
                    <option value="Banjarmasin">Banjarmasin</option>
                    <option value="Banyuwangi">Banyuwangi</option>
                    <option value="Batam">Batam</option>
                    <option value="Batang">Batang</option>
                    <option value="Baturaja">Baturaja</option>
                    <option value="Bekasi">Bekasi</option>
                    <option value="Belawan">Belawan</option>
                    <option value="Bengkulu">Bengkulu</option>
                    <option value="Binjai">Binjai</option>
                    <option value="Bitung">Bitung</option>
                    <option value="Blitar">Blitar</option>
                    <option value="Bogor">Bogor</option>
                    <option value="Bojong Gede">Bojong Gede</option>
                    <option value="Bontang">Bontang</option>
                    <option value="Brebes">Brebes</option>
                    <option value="Bukittinggi">Bukittinggi</option>
                    <option value="Ciamis">Ciamis</option>
                    <option value="Ciampea">Ciampea</option>
                    <option value="Cianjur">Cianjur</option>
                    <option value="Cibadak">Cibadak</option>
                    <option value="Cibinong">Cibinong</option>
                    <option value="Cibitung">Cibitung</option>
                    <option value="Cibungbulang">Cibungbulang</option>
                    <option value="Cicalengka">Cicalengka</option>
                    <option value="Cikampek">Cikampek</option>
                    <option value="Cikarang">Cikarang</option>
                    <option value="Cikupa">Cikupa</option>
                    <option value="Cilacap">Cilacap</option>
                    <option value="Ciledug">Ciledug</option>
                    <option value="Cilegon">Cilegon</option>
                    <option value="Cileungsi">Cileungsi</option>
                    <option value="Cileunyi">Cileunyi</option>
                    <option value="Cimahi">Cimahi</option>
                    <option value="Ciomas">Ciomas</option>
                    <option value="Ciparay">Ciparay</option>
                    <option value="Ciputat">Ciputat</option>
                    <option value="Cirebon">Cirebon</option>
                    <option value="Cirebon Utara">Cirebon Utara</option>
                    <option value="Cisaat">Cisaat</option>
                    <option value="Cisarua">Cisarua</option>
                    <option value="Citeureup">Citeureup</option>
                    <option value="Curug">Curug</option>
                    <option value="Denpasar">Denpasar</option>
                    <option value="Depok">Depok</option>
                    <option value="Dukuhturi">Dukuhturi</option>
                    <option value="Dumai">Dumai</option>
                    <option value="Garut">Garut</option>
                    <option value="Gorontalo">Gorontalo</option>
                    <option value="Grogol">Grogol</option>
                    <option value="Gunung Putri">Gunung Putri</option>
                    <option value="Hamparan Perak">Hamparan Perak</option>
                    <option value="Indramayu">Indramayu</option>
                    <option value="Jakarta">Jakarta</option>
                    <option value="Jambi">Jambi</option>
                    <option value="Jayapura">Jayapura</option>
                    <option value="Jember">Jember</option>
                    <option value="Jombang">Jombang</option>
                    <option value="Karang Tengah">Karang Tengah</option>
                    <option value="Karawang">Karawang</option>
                    <option value="Kebumen">Kebumen</option>
                    <option value="Kediri">Kediri</option>
                    <option value="Kedungwuni">Kedungwuni</option>
                    <option value="Kemang">Kemang</option>
                    <option value="Kendari">Kendari</option>
                    <option value="Ketapang">Ketapang</option>
                    <option value="Kisaran">Kisaran</option>
                    <option value="Klaten">Klaten</option>
                    <option value="Kresek">Kresek</option>
                    <option value="Kupang">Kupang</option>
                    <option value="Lawang">Lawang</option>
                    <option value="Lembang">Lembang</option>
                    <option value="Leuwiliang">Leuwiliang</option>
                    <option value="Loa Janan">Loa Janan</option>
                    <option value="Lubuklinggau">Lubuklinggau</option>
                    <option value="Lumajang">Lumajang</option>
                    <option value="Madiun">Madiun</option>
                    <option value="Magelang">Magelang</option>
                    <option value="Majalaya">Majalaya</option>
                    <option value="Majalengka">Majalengka</option>
                    <option value="Makassar">Makassar</option>
                    <option value="Malang">Malang</option>
                    <option value="Manado">Manado</option>
                    <option value="Martapura">Martapura</option>
                    <option value="Mataram">Mataram</option>
                    <option value="Medan">Medan</option>
                    <option value="Metro">Metro</option>
                    <option value="Mojokerto">Mojokerto</option>
                    <option value="Ngamprah">Ngamprah</option>
                    <option value="Pacet">Pacet</option>
                    <option value="Padalarang">Padalarang</option>
                    <option value="Padang">Padang</option>
                    <option value="Padang Sidempuan">Padang Sidempuan</option>
                    <option value="Palangkaraya">Palangkaraya</option>
                    <option value="Palembang">Palembang</option>
                    <option value="Palu">Palu</option>
                    <option value="Pamanukan">Pamanukan</option>
                    <option value="Pamekasan">Pamekasan</option>
                    <option value="Pamulang">Pamulang</option>
                    <option value="Pandeglang">Pandeglang</option>
                    <option value="Pangkah">Pangkah</option>
                    <option value="Pangkalpinang">Pangkalpinang</option>
                    <option value="Pare-Pare">Pare-Pare</option>
                    <option value="Pariaman">Pariaman</option>
                    <option value="Parung">Parung</option>
                    <option value="Pasarkemis">Pasarkemis</option>
                    <option value="Paseh">Paseh</option>
                    <option value="Pasuruan">Pasuruan</option>
                    <option value="Pati">Pati</option>
                    <option value="Payakumbuh">Payakumbuh</option>
                    <option value="Pekalongan">Pekalongan</option>
                    <option value="Pekanbaru">Pekanbaru</option>
                    <option value="Pemalang">Pemalang</option>
                    <option value="Pematang Siantar">Pematang Siantar</option>
                    <option value="Perbaungan">Perbaungan</option>
                    <option value="Percut Sei Tuan">Percut Sei Tuan</option>
                    <option value="Plumbon">Plumbon</option>
                    <option value="Pondok Aren">Pondok Aren</option>
                    <option value="Pontianak">Pontianak</option>
                    <option value="Prabumulih">Prabumulih</option>
                    <option value="Pringsewu">Pringsewu</option>
                    <option value="Probolinggo">Probolinggo</option>
                    <option value="Purwakarta">Purwakarta</option>
                    <option value="Purwodadi">Purwodadi</option>
                    <option value="Purwokerto">Purwokerto</option>
                    <option value="Purworejo">Purworejo</option>
                    <option value="Rancaekek">Rancaekek</option>
                    <option value="Rangkasbitung">Rangkasbitung</option>
                    <option value="Rantauprapat">Rantauprapat</option>
                    <option value="Rengasdengklok">Rengasdengklok</option>
                    <option value="Salatiga">Salatiga</option>
                    <option value="Samarinda">Samarinda</option>
                    <option value="Sawangan">Sawangan</option>
                    <option value="Semarang">Semarang</option>
                    <option value="Sepatan">Sepatan</option>
                    <option value="Serang">Serang</option>
                    <option value="Sidoarjo">Sidoarjo</option>
                    <option value="Singaraja">Singaraja</option>
                    <option value="Singkawang">Singkawang</option>
                    <option value="Soreang">Soreang</option>
                    <option value="Sorong">Sorong</option>
                    <option value="Subang">Subang</option>
                    <option value="Sukabumi">Sukabumi</option>
                    <option value="Sukaraja">Sukaraja</option>
                    <option value="Sumber">Sumber</option>
                    <option value="Sumedang">Sumedang</option>
                    <option value="Sungai Penuh">Sungai Penuh</option>
                    <option value="Sunggal">Sunggal</option>
                    <option value="Surabaya">Surabaya</option>
                    <option value="Surakarta">Surakarta</option>
                    <option value="Talang">Talang</option>
                    <option value="Taman">Taman</option>
                    <option value="Tambun">Tambun</option>
                    <option value="Tanete">Tanete</option>
                    <option value="Tangerang">Tangerang</option>
                    <option value="Tanjung Balai-Meral">Tanjung Balai-Meral</option>
                    <option value="Tanjung Morawa">Tanjung Morawa</option>
                    <option value="Tanjung Pinang">Tanjung Pinang</option>
                    <option value="Tanjungbalai">Tanjungbalai</option>
                    <option value="Tarakan">Tarakan</option>
                    <option value="Tasikmalaya">Tasikmalaya</option>
                    <option value="Tebingtinggi">Tebingtinggi</option>
                    <option value="Tegal">Tegal</option>
                    <option value="Teluknaga">Teluknaga</option>
                    <option value="Tembilahan">Tembilahan</option>
                    <option value="Ternate">Ternate</option>
                    <option value="Ungaran">Ungaran</option>
                    <option value="Waru">Waru</option>
                    <option value="Weru">Weru</option>
                    <option value="Wonosobo">Wonosobo</option>
                    <option value="Yogyakarta">Yogyakarta</option>
                </select>

                <?php
            }elseif ($pays == "Iran"){
                ?>
                <select class="select" name="localisation">
                    <option value="Abadan">Abadan</option>
                    <option value="Ahvaz">Ahvaz</option>
                    <option value="Amol">Amol</option>
                    <option value="Andimechk">Andimechk</option>
                    <option value="Arak">Arak</option>
                    <option value="Ardabil">Ardabil</option>
                    <option value="Babol">Babol</option>
                    <option value="Bandar Abbas">Bandar Abbas</option>
                    <option value="Bandar Anzali">Bandar Anzali</option>
                    <option value="Bandar-e Mahchahr">Bandar-e Mahchahr</option>
                    <option value="Behbahan">Behbahan</option>
                    <option value="Birdjand">Birdjand</option>
                    <option value="Bodjnourd">Bodjnourd</option>
                    <option value="Boroudjerd">Boroudjerd</option>
                    <option value="Bouchehr">Bouchehr</option>
                    <option value="Boukan">Boukan</option>
                    <option value="Chahinchahr">Chahinchahr</option>
                    <option value="Chahr-e Kord">Chahr-e Kord</option>
                    <option value="Chahreza">Chahreza</option>
                    <option value="Chahriar">Chahriar</option>
                    <option value="Chahroud">Chahroud</option>
                    <option value="Chiraz">Chiraz</option>
                    <option value="Dezfoul">Dezfoul</option>
                    <option value="Djahrom">Djahrom</option>
                    <option value="Doroud">Doroud</option>
                    <option value="Eslamchahr">Eslamchahr</option>
                    <option value="Ghartchak">Ghartchak</option>
                    <option value="Ghods">Ghods</option>
                    <option value="Ghoutchan">Ghoutchan</option>
                    <option value="Golestan">Golestan</option>
                    <option value="Gonbad-e Qabous">Gonbad-e Qabous</option>
                    <option value="Gorgan">Gorgan</option>
                    <option value="Hamadan">Hamadan</option>
                    <option value="Ilam">Ilam</option>
                    <option value="Iranchahr">Iranchahr</option>
                    <option value="Ispahan">Ispahan</option>
                    <option value="Izeh">Izeh</option>
                    <option value="Kachan">Kachan</option>
                    <option value="Karadj">Karadj</option>
                    <option value="Kerman">Kerman</option>
                    <option value="Kermanchah">Kermanchah</option>
                    <option value="Khomeynichahr">Khomeynichahr</option>
                    <option value="Khorramabad">Khorramabad</option>
                    <option value="Khorramchahr">Khorramchahr</option>
                    <option value="Khoy">Khoy</option>
                    <option value="Mahabad">Mahabad</option>
                    <option value="Malard">Malard</option>
                    <option value="Malayer">Malayer</option>
                    <option value="Maragha">Maragha</option>
                    <option value="Marand">Marand</option>
                    <option value="Marvdacht">Marvdacht</option>
                    <option value="Masjed Soleiman">Masjed Soleiman</option>
                    <option value="Mechhed">Mechhed</option>
                    <option value="Miandoab">Miandoab</option>
                    <option value="Nadjafabad">Nadjafabad</option>
                    <option value="Nassimchahr">Nassimchahr</option>
                    <option value="Nichapur">Nichapur</option>
                    <option value="Ourmia">Ourmia</option>
                    <option value="Pakdacht">Pakdacht</option>
                    <option value="Qaem-Chahr">Qaem-Chahr</option>
                    <option value="Qazvin">Qazvin</option>
                    <option value="Qom">Qom</option>
                    <option value="Racht">Racht</option>
                    <option value="Rafsandjan">Rafsandjan</option>
                    <option value="Sabzevar">Sabzevar</option>
                    <option value="Sanandadj">Sanandadj</option>
                    <option value="Saqqez">Saqqez</option>
                    <option value="Sari">Sari</option>
                    <option value="Saveh">Saveh</option>
                    <option value="Semnan">Semnan</option>
                    <option value="Sirdjan">Sirdjan</option>
                    <option value="Tabriz">Tabriz</option>
                    <option value="Téhéran">Téhéran</option>
                    <option value="Torbat-e Djam">Torbat-e Djam</option>
                    <option value="Varamin">Varamin</option>
                    <option value="Yassoudj">Yassoudj</option>
                    <option value="Yazd">Yazd</option>
                    <option value="Zabol">Zabol</option>
                    <option value="Zahedan">Zahedan</option>
                    <option value="Zandjan">Zandjan</option>
                </select>

                <?php
            }elseif ($pays == "Iraq"){
                ?>
                <select class="select" name="localisation">
                    <option value="Al-Qurnah">Al-Qurnah</option>
                    <option value="Amara">Amara</option>
                    <option value="Arbil">Arbil</option>
                    <option value="Asch-Schamal">Asch-Schamal</option>
                    <option value="Bagdad">Bagdad</option>
                    <option value="Bakouba">Bakouba</option>
                    <option value="Bassorah">Bassorah</option>
                    <option value="Dahuk">Dahuk</option>
                    <option value="Diwaniya">Diwaniya</option>
                    <option value="Falloujah">Falloujah</option>
                    <option value="Fao">Fao</option>
                    <option value="Hartha">Hartha</option>
                    <option value="Hilla">Hilla</option>
                    <option value="Kerbela">Kerbela</option>
                    <option value="Kirkuk">Kirkuk</option>
                    <option value="Koufa">Koufa</option>
                    <option value="Kut">Kut</option>
                    <option value="Mossoul">Mossoul</option>
                    <option value="Nadjaf">Nadjaf</option>
                    <option value="Nassiriya">Nassiriya</option>
                    <option value="Ramadi">Ramadi</option>
                    <option value="Samarra">Samarra</option>
                    <option value="Samawa">Samawa</option>
                    <option value="Shatt al-Arab">Shatt al-Arab</option>
                    <option value="Soran">Soran</option>
                    <option value="Souleimaniye">Souleimaniye</option>
                    <option value="Suq asch-Schuyuch">Suq asch-Schuyuch</option>
                    <option value="Tall Afar">Tall Afar</option>
                    <option value="Umm Qasr">Umm Qasr</option>
                    <option value="Zaxo">Zaxo</option>
                    <option value="Zubair">Zubair</option>
                </select>

                <?php
            }elseif ($pays == "Irlande"){
                ?>
                <select class="select" name="localisation">
                    <option value="Ardee et environs">Ardee et environs</option>
                    <option value="Arklow et environs">Arklow et environs</option>
                    <option value="Ashbourne">Ashbourne</option>
                    <option value="Athenry">Athenry</option>
                    <option value="Athlone">Athlone</option>
                    <option value="Athy">Athy</option>
                    <option value="Balbriggan et environs">Balbriggan et environs</option>
                    <option value="Ballina">Ballina</option>
                    <option value="Ballinasloe et environs">Ballinasloe et environs</option>
                    <option value="Ballybofey-Stranorlar">Ballybofey-Stranorlar</option>
                    <option value="Bandon et environs">Bandon et environs</option>
                    <option value="Bantry">Bantry</option>
                    <option value="Birr et environs">Birr et environs</option>
                    <option value="Blessington">Blessington</option>
                    <option value="Bray et environs">Bray et environs</option>
                    <option value="Buncrana et environs">Buncrana et environs</option>
                    <option value="Cahir">Cahir</option>
                    <option value="Carlow et environs">Carlow et environs</option>
                    <option value="Carrickmacross">Carrickmacross</option>
                    <option value="Carrick-on-Shannon">Carrick-on-Shannon</option>
                    <option value="Carrick-on-Suir et environs">Carrick-on-Suir et environs</option>
                    <option value="Carrigaline">Carrigaline</option>
                    <option value="Castlebar et environs">Castlebar et environs</option>
                    <option value="Castleblayney">Castleblayney</option>
                    <option value="Cavan et environs">Cavan et environs</option>
                    <option value="Celbridge">Celbridge</option>
                    <option value="Clane">Clane</option>
                    <option value="Clara">Clara</option>
                    <option value="Clonakilty">Clonakilty</option>
                    <option value="Clonmel et environs">Clonmel et environs</option>
                    <option value="Cobh et environs">Cobh et environs</option>
                    <option value="Cork et banlieue">Cork et banlieue</option>
                    <option value="Donabate">Donabate</option>
                    <option value="Drogheda et environs">Drogheda et environs</option>
                    <option value="Dublin et banlieue">Dublin et banlieue</option>
                    <option value="Duleek">Duleek</option>
                    <option value="Dunboyne">Dunboyne</option>
                    <option value="Dundalk et banlieue">Dundalk et banlieue</option>
                    <option value="Dungarvan et environs">Dungarvan et environs</option>
                    <option value="Dunshaughlin">Dunshaughlin</option>
                    <option value="Edenderry et environs">Edenderry et environs</option>
                    <option value="Ennis et environs">Ennis et environs</option>
                    <option value="Enniscorthy et environs">Enniscorthy et environs</option>
                    <option value="Fermoy et environs">Fermoy et environs</option>
                    <option value="Galway et banlieue">Galway et banlieue</option>
                    <option value="Gorey et environs">Gorey et environs</option>
                    <option value="Greystones et environs">Greystones et environs</option>
                    <option value="Kells et environs">Kells et environs</option>
                    <option value="Kilcock">Kilcock</option>
                    <option value="Kilcoole">Kilcoole</option>
                    <option value="Kildare">Kildare</option>
                    <option value="Kilkenny et environs">Kilkenny et environs</option>
                    <option value="Killarney et environs">Killarney et environs</option>
                    <option value="Kinsale">Kinsale</option>
                    <option value="Kinsealy-Drinan">Kinsealy-Drinan</option>
                    <option value="Laytown-Bettystown-Mornington">Laytown-Bettystown-Mornington</option>
                    <option value="Leixlip">Leixlip</option>
                    <option value="Letterkenny et environs">Letterkenny et environs</option>
                    <option value="Limerick et banlieue">Limerick et banlieue</option>
                    <option value="Listowel">Listowel</option>
                    <option value="Longford et environs">Longford et environs</option>
                    <option value="Loughrea">Loughrea</option>
                    <option value="Lusk">Lusk</option>
                    <option value="Macroom et environs">Macroom et environs</option>
                    <option value="Malahide">Malahide</option>
                    <option value="Mallow et environs">Mallow et environs</option>
                    <option value="Maynooth">Maynooth</option>
                    <option value="Midleton et environs">Midleton et environs</option>
                    <option value="Mitchelstown">Mitchelstown</option>
                    <option value="Monaghan et environs">Monaghan et environs</option>
                    <option value="Monasterevin">Monasterevin</option>
                    <option value="Mountmellick et environs">Mountmellick et environs</option>
                    <option value="Mullingar et environs">Mullingar et environs</option>
                    <option value="Naas">Naas</option>
                    <option value="Navan et environs">Navan et environs</option>
                    <option value="Nenagh et environs">Nenagh et environs</option>
                    <option value="New Ross et environs">New Ross et environs</option>
                    <option value="Newbridge et environs">Newbridge et environs</option>
                    <option value="Newcastle West">Newcastle West</option>
                    <option value="Oranmore">Oranmore</option>
                    <option value="Passage West et environs">Passage West et environs</option>
                    <option value="Portarlington">Portarlington</option>
                    <option value="Portlaoise et environs">Portlaoise et environs</option>
                    <option value="Portmarnock">Portmarnock</option>
                    <option value="Ratoath">Ratoath</option>
                    <option value="Roscommon">Roscommon</option>
                    <option value="Roscrea">Roscrea</option>
                    <option value="Rush">Rush</option>
                    <option value="Sallins">Sallins</option>
                    <option value="Shannon et environs">Shannon et environs</option>
                    <option value="Skerries">Skerries</option>
                    <option value="Sligo et environs">Sligo et environs</option>
                    <option value="Swords">Swords</option>
                    <option value="Thurles et environs">Thurles et environs</option>
                    <option value="Tipperary et environs">Tipperary et environs</option>
                    <option value="Tower">Tower</option>
                    <option value="Tralee et environs">Tralee et environs</option>
                    <option value="Tramore et environs">Tramore et environs</option>
                    <option value="Trim et environs">Trim et environs</option>
                    <option value="Tuam et environs">Tuam et environs</option>
                    <option value="Tullamore et environs">Tullamore et environs</option>
                    <option value="Tullow">Tullow</option>
                    <option value="Waterford et banlieue">Waterford et banlieue</option>
                    <option value="Westport et environs">Westport et environs</option>
                    <option value="Wexford et environs">Wexford et environs</option>
                    <option value="Wicklow et environs">Wicklow et environs</option>
                    <option value="Youghal et environs">Youghal et environs</option>
                </select>

                <?php
            }elseif ($pays == "Islande"){
                ?>
                <select class="select" name="localisation">
                    <option value="Akranes">Akranes</option>
                    <option value="Akureyri">Akureyri</option>
                    <option value="Álftanes">Álftanes</option>
                    <option value="Árbæjarhverfi">Árbæjarhverfi</option>
                    <option value="Arnarstapi">Arnarstapi</option>
                    <option value="Bakkafjörður">Bakkafjörður</option>
                    <option value="Bakkagerði">Bakkagerði</option>
                    <option value="Bifröst">Bifröst</option>
                    <option value="Bíldudalur">Bíldudalur</option>
                    <option value="Bláskógar">Bláskógar</option>
                    <option value="Blönduós">Blönduós</option>
                    <option value="Bolungarvík">Bolungarvík</option>
                    <option value="Borðeyri">Borðeyri</option>
                    <option value="Borgarfjörður eystri">Borgarfjörður eystri</option>
                    <option value="Borgarnes">Borgarnes</option>
                    <option value="Breiðdalsvík">Breiðdalsvík</option>
                    <option value="Brúnastaðir">Brúnastaðir</option>
                    <option value="Búðardalur">Búðardalur</option>
                    <option value="Dalvík">Dalvík</option>
                    <option value="Djúpivogur">Djúpivogur</option>
                    <option value="Drangsnes">Drangsnes</option>
                    <option value="Egilsstaðir">Egilsstaðir</option>
                    <option value="Eiðar">Eiðar</option>
                    <option value="Eskifjörður">Eskifjörður</option>
                    <option value="Eyrarbakki">Eyrarbakki</option>
                    <option value="Fagurhólsmýri">Fagurhólsmýri</option>
                    <option value="Fáskrúðsfjörður">Fáskrúðsfjörður</option>
                    <option value="Fellabær">Fellabær</option>
                    <option value="Flateyri">Flateyri</option>
                    <option value="Fljótshlíð">Fljótshlíð</option>
                    <option value="Flúðir">Flúðir</option>
                    <option value="Garðabær">Garðabær</option>
                    <option value="Garður">Garður</option>
                    <option value="Grenivík">Grenivík</option>
                    <option value="Grímsey">Grímsey</option>
                    <option value="Grímsstaðir">Grímsstaðir</option>
                    <option value="Grindavík">Grindavík</option>
                    <option value="Grundarfjörður">Grundarfjörður</option>
                    <option value="Hafnarfjörður">Hafnarfjörður</option>
                    <option value="Hafnir">Hafnir</option>
                    <option value="Hallormsstaður">Hallormsstaður</option>
                    <option value="Hauganes">Hauganes</option>
                    <option value="Hella">Hella</option>
                    <option value="Hellissandur">Hellissandur</option>
                    <option value="Hjalteyri">Hjalteyri</option>
                    <option value="Hnífsdalur">Hnífsdalur</option>
                    <option value="Hoffell">Hoffell</option>
                    <option value="Höfn í Hornafirði">Höfn í Hornafirði</option>
                    <option value="Hofsós">Hofsós</option>
                    <option value="Hólar">Hólar</option>
                    <option value="Hólmavík">Hólmavík</option>
                    <option value="Hrafnagil">Hrafnagil</option>
                    <option value="Hrísey">Hrísey</option>
                    <option value="Húsafell">Húsafell</option>
                    <option value="Húsavík">Húsavík</option>
                    <option value="Hvammstangi">Hvammstangi</option>
                    <option value="Hvanneyri">Hvanneyri</option>
                    <option value="Hveragerði">Hveragerði</option>
                    <option value="Hvolsvöllur">Hvolsvöllur</option>
                    <option value="Ísafjörður">Ísafjörður</option>
                    <option value="Keflavík">Keflavík</option>
                    <option value="Kirkjubæjarklaustur">Kirkjubæjarklaustur</option>
                    <option value="Kleppjárnsreykir">Kleppjárnsreykir</option>
                    <option value="Kópasker">Kópasker</option>
                    <option value="Kópavogur">Kópavogur</option>
                    <option value="Kristnes">Kristnes</option>
                    <option value="Króksfjarðarnes">Króksfjarðarnes</option>
                    <option value="Krossholt">Krossholt</option>
                    <option value="Laugar">Laugar</option>
                    <option value="Laugarás">Laugarás</option>
                    <option value="Laugarbakki">Laugarbakki</option>
                    <option value="Laugardælir">Laugardælir</option>
                    <option value="Litli-Árskógssandur">Litli-Árskógssandur</option>
                    <option value="Mjóifjörður">Mjóifjörður</option>
                    <option value="Mosfellsbær">Mosfellsbær</option>
                    <option value="Neskaupstaður">Neskaupstaður</option>
                    <option value="Njarðvík">Njarðvík</option>
                    <option value="Oddi">Oddi</option>
                    <option value="Ólafsfjörður">Ólafsfjörður</option>
                    <option value="Ólafsvík">Ólafsvík</option>
                    <option value="Patreksfjörður">Patreksfjörður</option>
                    <option value="Raufarhöfn">Raufarhöfn</option>
                    <option value="Reyðarfjörður">Reyðarfjörður</option>
                    <option value="Reykhólar">Reykhólar</option>
                    <option value="Reykholt">Reykholt</option>
                    <option value="Reykjahlíð">Reykjahlíð</option>
                    <option value="Reykjavik">Reykjavik</option>
                    <option value="Rif">Rif</option>
                    <option value="Sandgerði">Sandgerði</option>
                    <option value="Sauðárkrókur">Sauðárkrókur</option>
                    <option value="Selfoss">Selfoss</option>
                    <option value="Seltjarnarnes">Seltjarnarnes</option>
                    <option value="Seyðisfjörður">Seyðisfjörður</option>
                    <option value="Siglufjörður">Siglufjörður</option>
                    <option value="Skagaströnd">Skagaströnd</option>
                    <option value="Skálholt">Skálholt</option>
                    <option value="Skógar">Skógar</option>
                    <option value="Stöðvarfjörður">Stöðvarfjörður</option>
                    <option value="Stokkseyri">Stokkseyri</option>
                    <option value="Stykkishólmur">Stykkishólmur</option>
                    <option value="Súðavík">Súðavík</option>
                    <option value="Suðureyri">Suðureyri</option>
                    <option value="Svalbarðseyri">Svalbarðseyri</option>
                    <option value="Tálknafjörður">Tálknafjörður</option>
                    <option value="Þingeyri">Þingeyri</option>
                    <option value="Þorlákshöfn">Þorlákshöfn</option>
                    <option value="Þórshöfn">Þórshöfn</option>
                    <option value="Vallanes">Vallanes</option>
                    <option value="Varmahlíð">Varmahlíð</option>
                    <option value="Vestmannaeyjar">Vestmannaeyjar</option>
                    <option value="Víðidalstunga">Víðidalstunga</option>
                    <option value="Vík í Mýrdal">Vík í Mýrdal</option>
                    <option value="Vogar">Vogar</option>
                    <option value="Vopnafjörður">Vopnafjörður</option>
                </select>

                <?php
            }elseif ($pays == "Israel"){
                ?>
                <select class="select" name="localisation">
                    <option value="Acre">Acre</option>
                    <option value="Afoula">Afoula</option>
                    <option value="Arad">Arad</option>
                    <option value="Ariel1">Ariel1</option>
                    <option value="Ashdod">Ashdod</option>
                    <option value="Ashkelon">Ashkelon</option>
                    <option value="Baka Jatt">Baka Jatt</option>
                    <option value="Bat Yam">Bat Yam</option>
                    <option value="Beer-Sheva">Beer-Sheva</option>
                    <option value="Beït Shéan">Beït Shéan</option>
                    <option value="Bet Shemesh">Bet Shemesh</option>
                    <option value="Betar Illit1">Betar Illit1</option>
                    <option value="Bnei Brak">Bnei Brak</option>
                    <option value="Dimona">Dimona</option>
                    <option value="Eilat">Eilat</option>
                    <option value="El'ad">El'ad</option>
                    <option value="Giv'at Shmuel">Giv'at Shmuel</option>
                    <option value="Givatayim">Givatayim</option>
                    <option value="Hadera">Hadera</option>
                    <option value="Haïfa">Haïfa</option>
                    <option value="Herzliya">Herzliya</option>
                    <option value="Hod Hasharon">Hod Hasharon</option>
                    <option value="Holon">Holon</option>
                    <option value="Jérusalem">Jérusalem</option>
                    <option value="Kafr Qasim">Kafr Qasim</option>
                    <option value="Karmiel">Karmiel</option>
                    <option value="Kfar Saba">Kfar Saba</option>
                    <option value="Kfar Yona">Kfar Yona</option>
                    <option value="Kiryat Gat">Kiryat Gat</option>
                    <option value="Kiryat Ono">Kiryat Ono</option>
                    <option value="Kiryat Shmona">Kiryat Shmona</option>
                    <option value="Kiryat-Ata">Kiryat-Ata</option>
                    <option value="Kiryat-Bialik">Kiryat-Bialik</option>
                    <option value="Kiryat-Malakhi">Kiryat-Malakhi</option>
                    <option value="Kiryat-Motzkin">Kiryat-Motzkin</option>
                    <option value="Kiryat-Yam">Kiryat-Yam</option>
                    <option value="Lod">Lod</option>
                    <option value="Ma'aleh Adumim1">Ma'aleh Adumim1</option>
                    <option value="Ma'alot-Tarshiha">Ma'alot-Tarshiha</option>
                    <option value="Migdal HaEmek">Migdal HaEmek</option>
                    <option value="Modiin Illit1">Modiin Illit1</option>
                    <option value="Modiin-Maccabim-Reout">Modiin-Maccabim-Reout</option>
                    <option value="Nahariya">Nahariya</option>
                    <option value="Nazareth">Nazareth</option>
                    <option value="Nazareth Illit">Nazareth Illit</option>
                    <option value="Nesher">Nesher</option>
                    <option value="Ness Ziona">Ness Ziona</option>
                    <option value="Netanya">Netanya</option>
                    <option value="Netivot">Netivot</option>
                    <option value="Ofaqim">Ofaqim</option>
                    <option value="Or Aqiva">Or Aqiva</option>
                    <option value="Or Yehuda">Or Yehuda</option>
                    <option value="Petah Tikva">Petah Tikva</option>
                    <option value="Qalansawe">Qalansawe</option>
                    <option value="Ra'anana">Ra'anana</option>
                    <option value="Rahat">Rahat</option>
                    <option value="Ramat Gan">Ramat Gan</option>
                    <option value="Ramat Ha-Sharon">Ramat Ha-Sharon</option>
                    <option value="Ramla">Ramla</option>
                    <option value="Rehovot">Rehovot</option>
                    <option value="Rishon LeZion">Rishon LeZion</option>
                    <option value="Rosh HaAyin">Rosh HaAyin</option>
                    <option value="Safed">Safed</option>
                    <option value="Sakhnin">Sakhnin</option>
                    <option value="Sdérot">Sdérot</option>
                    <option value="Shefa Amr">Shefa Amr</option>
                    <option value="Tamra">Tamra</option>
                    <option value="Tayibe">Tayibe</option>
                    <option value="Tel Aviv-Jaffa">Tel Aviv-Jaffa</option>
                    <option value="Tibériade">Tibériade</option>
                    <option value="Tira">Tira</option>
                    <option value="Tirat Carmel">Tirat Carmel</option>
                    <option value="Umm al-Fahm">Umm al-Fahm</option>
                    <option value="Yavné">Yavné</option>
                    <option value="Yehud-Monosson">Yehud-Monosson</option>
                    <option value="Yoqneam">Yoqneam</option>
                </select>

                <?php
            }elseif ($pays == "Italie"){
                ?>
                <select class="select" name="localisation">
                    <option value="Acerra">Acerra</option>
                    <option value="Acireale">Acireale</option>
                    <option value="Afragola">Afragola</option>
                    <option value="Agrigento">Agrigento</option>
                    <option value="Alexandrie">Alexandrie</option>
                    <option value="Altamura">Altamura</option>
                    <option value="Ancône">Ancône</option>
                    <option value="Andria">Andria</option>
                    <option value="Anzio">Anzio</option>
                    <option value="Aprilia">Aprilia</option>
                    <option value="Arezzo">Arezzo</option>
                    <option value="Asti">Asti</option>
                    <option value="Avellino">Avellino</option>
                    <option value="Aversa">Aversa</option>
                    <option value="Bagheria">Bagheria</option>
                    <option value="Bari">Bari</option>
                    <option value="Barletta">Barletta</option>
                    <option value="Battipaglia">Battipaglia</option>
                    <option value="Bénévent">Bénévent</option>
                    <option value="Bergame">Bergame</option>
                    <option value="Bisceglie">Bisceglie</option>
                    <option value="Bitonto">Bitonto</option>
                    <option value="Bologne">Bologne</option>
                    <option value="Bolzane">Bolzane</option>
                    <option value="Brescia">Brescia</option>
                    <option value="Brindisi">Brindisi</option>
                    <option value="Busto Arsizio">Busto Arsizio</option>
                    <option value="Cagliari">Cagliari</option>
                    <option value="Caltanissetta">Caltanissetta</option>
                    <option value="Carpi">Carpi</option>
                    <option value="Carrare">Carrare</option>
                    <option value="Caserte">Caserte</option>
                    <option value="Casoria">Casoria</option>
                    <option value="Castellammare di Stabia">Castellammare di Stabia</option>
                    <option value="Catane">Catane</option>
                    <option value="Catanzaro">Catanzaro</option>
                    <option value="Cava de' Tirreni">Cava de' Tirreni</option>
                    <option value="Cerignola">Cerignola</option>
                    <option value="Cesena">Cesena</option>
                    <option value="Cinisello Balsamo">Cinisello Balsamo</option>
                    <option value="Civitavecchia">Civitavecchia</option>
                    <option value="Côme">Côme</option>
                    <option value="Coni">Coni</option>
                    <option value="Corigliano-Rossano">Corigliano-Rossano</option>
                    <option value="Cosenza">Cosenza</option>
                    <option value="Crémone">Crémone</option>
                    <option value="Crotone">Crotone</option>
                    <option value="Ercolano">Ercolano</option>
                    <option value="Faenza">Faenza</option>
                    <option value="Fano">Fano</option>
                    <option value="Ferrare">Ferrare</option>
                    <option value="Fiumicino">Fiumicino</option>
                    <option value="Florence">Florence</option>
                    <option value="Foggia">Foggia</option>
                    <option value="Foligno">Foligno</option>
                    <option value="Forlì">Forlì</option>
                    <option value="Gallarate">Gallarate</option>
                    <option value="Gela">Gela</option>
                    <option value="Gênes">Gênes</option>
                    <option value="Giugliano in Campania">Giugliano in Campania</option>
                    <option value="Grosseto">Grosseto</option>
                    <option value="Guidonia Montecelio">Guidonia Montecelio</option>
                    <option value="Imola">Imola</option>
                    <option value="La Spezia">La Spezia</option>
                    <option value="Lamezia Terme">Lamezia Terme</option>
                    <option value="L'Aquila">L'Aquila</option>
                    <option value="Latina">Latina</option>
                    <option value="Lecce">Lecce</option>
                    <option value="Legnano">Legnano</option>
                    <option value="Livourne">Livourne</option>
                    <option value="Lucques">Lucques</option>
                    <option value="Manfredonia">Manfredonia</option>
                    <option value="Marano di Napoli">Marano di Napoli</option>
                    <option value="Marsala">Marsala</option>
                    <option value="Massa">Massa</option>
                    <option value="Matera">Matera</option>
                    <option value="Mazara del Vallo">Mazara del Vallo</option>
                    <option value="Messine">Messine</option>
                    <option value="Milan">Milan</option>
                    <option value="Modène">Modène</option>
                    <option value="Modica">Modica</option>
                    <option value="Molfetta">Molfetta</option>
                    <option value="Moncalieri">Moncalieri</option>
                    <option value="Montesilvano">Montesilvano</option>
                    <option value="Monza">Monza</option>
                    <option value="Naples">Naples</option>
                    <option value="Novare">Novare</option>
                    <option value="Olbia">Olbia</option>
                    <option value="Padoue">Padoue</option>
                    <option value="Palerme">Palerme</option>
                    <option value="Parme">Parme</option>
                    <option value="Pavie">Pavie</option>
                    <option value="Pérouse">Pérouse</option>
                    <option value="Pesaro">Pesaro</option>
                    <option value="Pescara">Pescara</option>
                    <option value="Pise">Pise</option>
                    <option value="Pistoia">Pistoia</option>
                    <option value="Plaisance">Plaisance</option>
                    <option value="Pomezia">Pomezia</option>
                    <option value="Pordenone">Pordenone</option>
                    <option value="Portici">Portici</option>
                    <option value="Potenza">Potenza</option>
                    <option value="Pouzzoles">Pouzzoles</option>
                    <option value="Prato">Prato</option>
                    <option value="Quartu Sant'Elena">Quartu Sant'Elena</option>
                    <option value="Raguse">Raguse</option>
                    <option value="Ravenne">Ravenne</option>
                    <option value="Reggio de Calabre">Reggio de Calabre</option>
                    <option value="Reggio d'Émilie">Reggio d'Émilie</option>
                    <option value="Rimini">Rimini</option>
                    <option value="Rome">Rome</option>
                    <option value="Salerne">Salerne</option>
                    <option value="Savone">Savone</option>
                    <option value="Scandicci">Scandicci</option>
                    <option value="Sesto San Giovanni">Sesto San Giovanni</option>
                    <option value="Sienne">Sienne</option>
                    <option value="Syracuse">Syracuse</option>
                    <option value="Tarente">Tarente</option>
                    <option value="Teramo">Teramo</option>
                    <option value="Terni">Terni</option>
                    <option value="Tivoli">Tivoli</option>
                    <option value="Torre del Greco">Torre del Greco</option>
                    <option value="Trani">Trani</option>
                    <option value="Trapani">Trapani</option>
                    <option value="Trente">Trente</option>
                    <option value="Trévise">Trévise</option>
                    <option value="Trieste">Trieste</option>
                    <option value="Turin">Turin</option>
                    <option value="Udine">Udine</option>
                    <option value="Varèse">Varèse</option>
                    <option value="Velletri">Velletri</option>
                    <option value="Venise">Venise</option>
                    <option value="Vérone">Vérone</option>
                    <option value="Viareggio">Viareggio</option>
                    <option value="Vicence">Vicence</option>
                    <option value="Vigevano">Vigevano</option>
                    <option value="Viterbe">Viterbe</option>
                    <option value="Vittoria">Vittoria</option>
                </select>

                <?php
            }elseif ($pays == "Jamaique"){
                ?>
                <select class="select" name="localisation">
                    <option value="Anotto Bay">Anotto Bay</option>
                    <option value="Bog Walk">Bog Walk</option>
                    <option value="Brown's Town">Brown's Town</option>
                    <option value="Bull Savanna">Bull Savanna</option>
                    <option value="Christiana">Christiana</option>
                    <option value="Constant Spring">Constant Spring</option>
                    <option value="Ewarton">Ewarton</option>
                    <option value="Falmouth">Falmouth</option>
                    <option value="Grange Hill">Grange Hill</option>
                    <option value="Half Way Tree">Half Way Tree</option>
                    <option value="Hayes">Hayes</option>
                    <option value="Highgate">Highgate</option>
                    <option value="Kingston">Kingston</option>
                    <option value="Linstead">Linstead</option>
                    <option value="Lionel Town">Lionel Town</option>
                    <option value="Lucea">Lucea</option>
                    <option value="Mandeville">Mandeville</option>
                    <option value="May Pen">May Pen</option>
                    <option value="Montego Bay">Montego Bay</option>
                    <option value="Morant Bay">Morant Bay</option>
                    <option value="Ocho Rios">Ocho Rios</option>
                    <option value="Old Harbour">Old Harbour</option>
                    <option value="Old Harbour Bay">Old Harbour Bay</option>
                    <option value="Point Hill">Point Hill</option>
                    <option value="Port Antonio">Port Antonio</option>
                    <option value="Port Maria">Port Maria</option>
                    <option value="Portmore">Portmore</option>
                    <option value="Porus">Porus</option>
                    <option value="Runaway Bay">Runaway Bay</option>
                    <option value="Saint Ann's Bay">Saint Ann's Bay</option>
                    <option value="Santa Cruz">Santa Cruz</option>
                    <option value="Savanna-la-Mar">Savanna-la-Mar</option>
                    <option value="Spanish Town">Spanish Town</option>
                    <option value="Stony Hill">Stony Hill</option>
                    <option value="Yallahs">Yallahs</option>
                </select>

                <?php
            }elseif ($pays == "Japon"){
                ?>
                <select class="select" name="localisation">
                    <option value="Aichi">Aichi</option>
                    <option value="Akita">Akita</option>
                    <option value="Aomori">Aomori</option>
                    <option value="Chiba">Chiba</option>
                    <option value="Ehime">Ehime</option>
                    <option value="Fukui">Fukui</option>
                    <option value="Fukuoka">Fukuoka</option>
                    <option value="Fukushima">Fukushima</option>
                    <option value="Gifu">Gifu</option>
                    <option value="Gunma">Gunma</option>
                    <option value="Hiroshima">Hiroshima</option>
                    <option value="Hokkaidō">Hokkaidō</option>
                    <option value="Hyōgo">Hyōgo</option>
                    <option value="Ibaraki">Ibaraki</option>
                    <option value="Ishikawa">Ishikawa</option>
                    <option value="Iwate">Iwate</option>
                    <option value="Kagawa">Kagawa</option>
                    <option value="Kagoshima">Kagoshima</option>
                    <option value="Kanagawa">Kanagawa</option>
                    <option value="Kōchi">Kōchi</option>
                    <option value="Kumamoto">Kumamoto</option>
                    <option value="Kyoto">Kyoto</option>
                    <option value="Mie">Mie</option>
                    <option value="Miyagi">Miyagi</option>
                    <option value="Miyazaki">Miyazaki</option>
                    <option value="Nagano">Nagano</option>
                    <option value="Nagasaki">Nagasaki</option>
                    <option value="Nara">Nara</option>
                    <option value="Niigata">Niigata</option>
                    <option value="Ōita">Ōita</option>
                    <option value="Okayama">Okayama</option>
                    <option value="Okinawa">Okinawa</option>
                    <option value="Osaka">Osaka</option>
                    <option value="Saga">Saga</option>
                    <option value="Saitama">Saitama</option>
                    <option value="Shiga">Shiga</option>
                    <option value="Shimane">Shimane</option>
                    <option value="Shizuoka">Shizuoka</option>
                    <option value="Tochigi">Tochigi</option>
                    <option value="Tokushima">Tokushima</option>
                    <option value="Tokyo">Tokyo</option>
                    <option value="Tottori">Tottori</option>
                    <option value="Toyama">Toyama</option>
                    <option value="Wakayama">Wakayama</option>
                    <option value="Yamagata">Yamagata</option>
                    <option value="Yamaguchi">Yamaguchi</option>
                    <option value="Yamanashi">Yamanashi</option>
                    </select>
                <?php
            }elseif ($pays == "Jordanie"){
                ?>
                <select class="select" name="localisation">
                    <option value="Ain Basha">Ain Basha</option>
                    <option value="Al-Karak">Al-Karak</option>
                    <option value="Amman">Amman</option>
                    <option value="Aqaba">Aqaba</option>
                    <option value="Askan Abu Nusair">Askan Abu Nusair</option>
                    <option value="Dulail">Dulail</option>
                    <option value="Hasimiya">Hasimiya</option>
                    <option value="Husun">Husun</option>
                    <option value="Irbid">Irbid</option>
                    <option value="Jerash">Jerash</option>
                    <option value="Jubaiha">Jubaiha</option>
                    <option value="Khuraibat as-Suq">Khuraibat as-Suq</option>
                    <option value="Kufrinja">Kufrinja</option>
                    <option value="Ma'an">Ma'an</option>
                    <option value="Madaba">Madaba</option>
                    <option value="Mafraq">Mafraq</option>
                    <option value="Marj Hamam">Marj Hamam</option>
                    <option value="Mukhayyam Baq'a">Mukhayyam Baq'a</option>
                    <option value="Mukhayyam Hetten">Mukhayyam Hetten</option>
                    <option value="Quwaisima">Quwaisima</option>
                    <option value="Ramtha">Ramtha</option>
                    <option value="Rusaifa">Rusaifa</option>
                    <option value="Sahab">Sahab</option>
                    <option value="Salt">Salt</option>
                    <option value="Suwailih">Suwailih</option>
                    <option value="Tafila">Tafila</option>
                    <option value="Tila al-Ali">Tila al-Ali</option>
                    <option value="Umm Qusair">Umm Qusair</option>
                    <option value="Wadi as-Sir">Wadi as-Sir</option>
                    <option value="Zarqa">Zarqa</option>
                    </select>
                <?php
            }elseif ($pays == "Kenya"){
                ?>
                <select class="select" name="localisation">
                    <option value="Bungoma">Bungoma</option>
                    <option value="Busia">Busia</option>
                    <option value="Eldoret">Eldoret</option>
                    <option value="Embu">Embu</option>
                    <option value="Garissa">Garissa</option>
                    <option value="Homa Bay">Homa Bay</option>
                    <option value="Isiolo">Isiolo</option>
                    <option value="Kakamega">Kakamega</option>
                    <option value="Kericho">Kericho</option>
                    <option value="Kilifi">Kilifi</option>
                    <option value="Kisii">Kisii</option>
                    <option value="Kisumu">Kisumu</option>
                    <option value="Kitale">Kitale</option>
                    <option value="Machakos">Machakos</option>
                    <option value="Malindi">Malindi</option>
                    <option value="Mandera">Mandera</option>
                    <option value="Maragua">Maragua</option>
                    <option value="Meru">Meru</option>
                    <option value="Migori">Migori</option>
                    <option value="Mombasa">Mombasa</option>
                    <option value="Mumias">Mumias</option>
                    <option value="Nairobi">Nairobi</option>
                    <option value="Naivasha">Naivasha</option>
                    <option value="Nakuru">Nakuru</option>
                    <option value="Nanyuki">Nanyuki</option>
                    <option value="Narok">Narok</option>
                    <option value="Ngong">Ngong</option>
                    <option value="Nyahururu">Nyahururu</option>
                    <option value="Nyeri">Nyeri</option>
                    <option value="Rongai">Rongai</option>
                    <option value="Ruiru">Ruiru</option>
                    <option value="Thika">Thika</option>
                    <option value="Wajir">Wajir</option>
                    <option value="Webuye">Webuye</option>
                    </select>
                <?php
            }elseif ($pays == "Koweit"){
                ?>
                <select class="select" name="localisation">
                    <option value="Al Ahmadi">Al Ahmadi</option>
                    <option value="Al Farwaniyah">Al Farwaniyah</option>
                    <option value="Al Jahra">Al Jahra</option>
                    <option value="Al-Kabeer">Al-Kabeer</option>
                    <option value="Al-Kuwait">Al-Kuwait</option>
                    <option value="Hawalli">Hawalli</option>
                    <option value="Khaitan">Khaitan</option>
                    <option value="Mubarak">Mubarak</option>
                </select>
                <?php
            }elseif ($pays == "Laos"){
                ?>
                <select class="select" name="localisation">
                <option value="Huay Xay">Huay Xay</option>
                <option value="Laksao">Laksao</option>
                <option value="Luang Namtha">Luang Namtha</option>
                <option value="Luang Prabang">Luang Prabang</option>
                <option value="Muang Xay">Muang Xay</option>
                <option value="Nambak">Nambak</option>
                <option value="Paklay">Paklay</option>
                <option value="Paksé">Paksé</option>
                <option value="Pakxan">Pakxan</option>
                <option value="Phiang">Phiang</option>
                <option value="Phonhong">Phonhong</option>
                <option value="Phonsavan">Phonsavan</option>
                <option value="Phonthong">Phonthong</option>
                <option value="Savannakhet">Savannakhet</option>
                <option value="Sayaboury">Sayaboury</option>
                <option value="Sekong">Sekong</option>
                <option value="Thakhek">Thakhek</option>
                <option value="Vang Vieng">Vang Vieng</option>
                <option value="Vientiane">Vientiane</option>
                <option value="Xeno">Xeno</option>
                </select>
                <?php
            }elseif ($pays == "Lesotho"){
                ?>
                <select class="select" name="localisation">
                <option value="Butha-Buthe">Butha-Buthe</option>
                <option value="Hlotse">Hlotse</option>
                <option value="Mafeteng">Mafeteng</option>
                <option value="Maputsoe">Maputsoe</option>
                <option value="Maseru">Maseru</option>
                <option value="Mohale's Hoek">Mohale's Hoek</option>
                <option value="Mokhotlong">Mokhotlong</option>
                <option value="Peka">Peka</option>
                <option value="Qacha's Nek">Qacha's Nek</option>
                <option value="Quthing">Quthing</option>
                <option value="Roma">Roma</option>
                <option value="Teyateyaneng">Teyateyaneng</option>
                <option value="Thaba-Tseka">Thaba-Tseka</option>
                </select>
                <?php
            }elseif ($pays == "Lettonie"){
                ?>
                <select class="select" name="localisation">
                    <option value="Ainaži">Ainaži</option>
                    <option value="Aizkraukle">Aizkraukle</option>
                    <option value="Aizpute">Aizpute</option>
                    <option value="Aknīste">Aknīste</option>
                    <option value="Aloja">Aloja</option>
                    <option value="Alūksne">Alūksne</option>
                    <option value="Ape">Ape</option>
                    <option value="Auce">Auce</option>
                    <option value="Baldone">Baldone</option>
                    <option value="Baloži">Baloži</option>
                    <option value="Balvi">Balvi</option>
                    <option value="Bauska">Bauska</option>
                    <option value="Brocēni">Brocēni</option>
                    <option value="Cēsis">Cēsis</option>
                    <option value="Cesvaine">Cesvaine</option>
                    <option value="Dagda">Dagda</option>
                    <option value="Daugavpils">Daugavpils</option>
                    <option value="Dobele">Dobele</option>
                    <option value="Durbe">Durbe</option>
                    <option value="Grobiņa">Grobiņa</option>
                    <option value="Gulbene">Gulbene</option>
                    <option value="Ikšķile">Ikšķile</option>
                    <option value="Ilūkste">Ilūkste</option>
                    <option value="Jaunjelgava">Jaunjelgava</option>
                    <option value="Jēkabpils">Jēkabpils</option>
                    <option value="Jelgava">Jelgava</option>
                    <option value="Jūrmala">Jūrmala</option>
                    <option value="Kandava">Kandava</option>
                    <option value="Kārsava">Kārsava</option>
                    <option value="Ķegums">Ķegums</option>
                    <option value="Krāslava">Krāslava</option>
                    <option value="Kuldīga">Kuldīga</option>
                    <option value="Lielvārde">Lielvārde</option>
                    <option value="Liepāja">Liepāja</option>
                    <option value="Līgatne">Līgatne</option>
                    <option value="Limbaži">Limbaži</option>
                    <option value="Līvāni">Līvāni</option>
                    <option value="Lubāna">Lubāna</option>
                    <option value="Ludza">Ludza</option>
                    <option value="Madona">Madona</option>
                    <option value="Mazsalaca">Mazsalaca</option>
                    <option value="Ogre">Ogre</option>
                    <option value="Olaine">Olaine</option>
                    <option value="Pāvilosta">Pāvilosta</option>
                    <option value="Piltene">Piltene</option>
                    <option value="Pļaviņas">Pļaviņas</option>
                    <option value="Preiļi">Preiļi</option>
                    <option value="Priekule">Priekule</option>
                    <option value="Rēzekne">Rēzekne</option>
                    <option value="Riga">Riga</option>
                    <option value="Rūjiena">Rūjiena</option>
                    <option value="Sabile">Sabile</option>
                    <option value="Salacgrīva">Salacgrīva</option>
                    <option value="Salaspils">Salaspils</option>
                    <option value="Saldus">Saldus</option>
                    <option value="Saulkrasti">Saulkrasti</option>
                    <option value="Seda">Seda</option>
                    <option value="Sigulda">Sigulda</option>
                    <option value="Skrunda">Skrunda</option>
                    <option value="Smiltene">Smiltene</option>
                    <option value="Staicele">Staicele</option>
                    <option value="Stende">Stende</option>
                    <option value="Strenči">Strenči</option>
                    <option value="Subate">Subate</option>
                    <option value="Talsi">Talsi</option>
                    <option value="Tukums">Tukums</option>
                    <option value="Valdemārpils">Valdemārpils</option>
                    <option value="Valka">Valka</option>
                    <option value="Valmiera">Valmiera</option>
                    <option value="Vangaži">Vangaži</option>
                    <option value="Varakļāni">Varakļāni</option>
                    <option value="Ventspils">Ventspils</option>
                    <option value="Viesīte">Viesīte</option>
                    <option value="Viļaka">Viļaka</option>
                    <option value="Viļāni">Viļāni</option>
                    <option value="Zilupe">Zilupe</option>
                </select>

                <?php
            }elseif ($pays == "Liban"){
                ?>
                <select class="select" name="localisation">
                    <option value="Antoura">Antoura</option>
                    <option value="Ainata">Ainata</option>
                    <option value="Ain Ebel">Ain Ebel</option>
                    <option value="Ain Saadeh">Ain Saadeh</option>
                    <option value="Aitaroun">Aitaroun</option>
                    <option value="Aley">Aley</option>
                    <option value="Amchit">Amchit</option>
                    <option value="Amioun">Amioun</option>
                    <option value="Anjar">Anjar</option>
                    <option value="Antélias">Antélias</option>
                    <option value="Araya">Araya</option>
                    <option value="Arbanieh">Arbanieh</option>
                    <option value="Ardeh">Ardeh</option>
                    <option value="Arqa">Arqa</option>
                    <option value="Ayta ash-Shab">Ayta ash-Shab</option>
                    <option value="Baabda">Baabda</option>
                    <option value="Baakline">Baakline</option>
                    <option value="Baalbek">Baalbek</option>
                    <option value="Baraachit">Baraachit</option>
                    <option value="Batroun">Batroun</option>
                    <option value="Baskinta">Baskinta</option>
                    <option value="Bécharré">Bécharré</option>
                    <option value="Béchouate">Béchouate</option>
                    <option value="Bentael">Bentael</option>
                    <option value="Beit-Mery">Beit-Mery</option>
                    <option value="Beiteddine">Beiteddine</option>
                    <option value="Bejjeh">Bejjeh</option>
                    <option value="Beyno">Beyno</option>
                    <option value="Beyrouth">Beyrouth</option>
                    <option value="Bikfaya">Bikfaya</option>
                    <option value="Bint-Jbeil">Bint-Jbeil</option>
                    <option value="Bkerké">Bkerké</option>
                    <option value="Bretel">Bretel</option>
                    <option value="Bteghrine">Bteghrine</option>
                    <option value="Byblos">Byblos</option>
                    <option value="Canaa">Canaa</option>
                    <option value="Chaqra">Chaqra</option>
                    <option value="Chartoun">Chartoun</option>
                    <option value="Chekka">Chekka</option>
                    <option value="Chmestar">Chmestar</option>
                    <option value="Damour">Damour</option>
                    <option value="Daroun">Daroun</option>
                    <option value="Debel">Debel</option>
                    <option value="Deir-el-Qamar">Deir-el-Qamar</option>
                    <option value="Dour Choueir">Dour Choueir</option>
                    <option value="Ehden">Ehden</option>
                    <option value="Fanar">Fanar</option>
                    <option value="Fiké">Fiké</option>
                    <option value="Ghadir">Ghadir</option>
                    <option value="Ghazir">Ghazir</option>
                    <option value="Ghazlyé">Ghazlyé</option>
                    <option value="Ghosta">Ghosta</option>
                    <option value="Hadeth">Hadeth</option>
                    <option value="Halba">Halba</option>
                    <option value="Harf">Harf</option>
                    <option value="Harissa">Harissa</option>
                    <option value="Hasbaya">Hasbaya</option>
                    <option value="Hermel">Hermel</option>
                    <option value="Houla">Houla</option>
                    <option value="Ibl el Saqi">Ibl el Saqi</option>
                    <option value="Jdeideh">Jdeideh</option>
                    <option value="Joub Jenin">Joub Jenin</option>
                    <option value="Jebrayel">Jebrayel</option>
                    <option value="Jezzine">Jezzine</option>
                    <option value="Jmeijme">Jmeijme</option>
                    <option value="Jounieh">Jounieh</option>
                    <option value="Jwaya">Jwaya</option>
                    <option value="Kfar Kela">Kfar Kela</option>
                    <option value="Kfarchouba">Kfarchouba</option>
                    <option value="Kfaremen">Kfaremen</option>
                    <option value="Kfarsghab">Kfarsghab</option>
                    <option value="Kfarmelki">Kfarmelki</option>
                    <option value="Kfarzabad">Kfarzabad</option>
                    <option value="Khartoum">Khartoum</option>
                    <option value="Khenchara">Khenchara</option>
                    <option value="Khiam">Khiam</option>
                    <option value="Labbouné">Labbouné</option>
                    <option value="Maaser Beit El Dine">Maaser Beit El Dine</option>
                    <option value="Machghara">Machghara</option>
                    <option value="Maghdouché">Maghdouché</option>
                    <option value="Mariatta">Mariatta</option>
                    <option value="Marwahin">Marwahin</option>
                    <option value="Mazraat el Chouf">Mazraat el Chouf</option>
                    <option value="Menjez">Menjez</option>
                    <option value="Miniara">Miniara</option>
                    <option value="Minieh">Minieh</option>
                    <option value="Marjayoun">Marjayoun</option>
                    <option value="Maroun al-Ras">Maroun al-Ras</option>
                    <option value="Mokhtara">Mokhtara</option>
                    <option value="Mtein">Mtein</option>
                    <option value="Nabay">Nabay</option>
                    <option value="Nabatieh">Nabatieh</option>
                    <option value="Nabi Osman">Nabi Osman</option>
                    <option value="Naqoura">Naqoura</option>
                    <option value="Qaa">Qaa</option>
                    <option value="Qobaiyat">Qobaiyat</option>
                    <option value="Qozhaya">Qozhaya</option>
                    <option value="Rabieh">Rabieh</option>
                    <option value="Rachaya">Rachaya</option>
                    <option value="Rahbe">Rahbe</option>
                    <option value="Rayak">Rayak</option>
                    <option value="Roumieh">Roumieh</option>
                    <option value="Saghbine">Saghbine</option>
                    <option value="Shabbaniah">Shabbaniah</option>
                    <option value="Sheilé">Sheilé</option>
                    <option value="Sidon">Sidon</option>
                    <option value="Syr Denieh">Syr Denieh</option>
                    <option value="Tibnin">Tibnin</option>
                    <option value="Tikrit">Tikrit</option>
                    <option value="Tripoli">Tripoli</option>
                    <option value="Tyr">Tyr</option>
                    <option value="Yammouné">Yammouné</option>
                    <option value="Zahlé">Zahlé</option>
                    <option value="Zghorta">Zghorta</option>
                </select>

                <?php
            }elseif ($pays == "Liberia"){
                ?>
                <select class="select" name="localisation">
                    <option value="Barclayville">Barclayville</option>
                    <option value="Bensonville">Bensonville</option>
                    <option value="Bopolu">Bopolu</option>
                    <option value="Buchanan">Buchanan</option>
                    <option value="Cesstos City">Cesstos City</option>
                    <option value="Fish Town">Fish Town</option>
                    <option value="Foya">Foya</option>
                    <option value="Ganta">Ganta</option>
                    <option value="Gbarnga">Gbarnga</option>
                    <option value="Greenville">Greenville</option>
                    <option value="Harbel">Harbel</option>
                    <option value="Harper">Harper</option>
                    <option value="Kakata">Kakata</option>
                    <option value="Karnplay">Karnplay</option>
                    <option value="Monrovia">Monrovia</option>
                    <option value="Pleebo">Pleebo</option>
                    <option value="River Gbeh">River Gbeh</option>
                    <option value="Robertsport">Robertsport</option>
                    <option value="Sagleipie">Sagleipie</option>
                    <option value="Sanniquellie">Sanniquellie</option>
                    <option value="Tubmanburg">Tubmanburg</option>
                    <option value="Voinjama">Voinjama</option>
                    <option value="Zorzor">Zorzor</option>
                    <option value="Zwedru">Zwedru</option>
                </select>

                <?php
            }elseif ($pays == "Libye"){
                ?>
                <select class="select" name="localisation">
                    <option value="Ajdabiya">Ajdabiya</option>
                    <option value="Al Abyar">Al Abyar</option>
                    <option value="Al Jaouf">Al Jaouf</option>
                    <option value="Al Marj">Al Marj</option>
                    <option value="Al Qubba">Al Qubba</option>
                    <option value="Awbari">Awbari</option>
                    <option value="Az Zuwaitina">Az Zuwaitina</option>
                    <option value="Bani Walid">Bani Walid</option>
                    <option value="Benghazi">Benghazi</option>
                    <option value="Birak">Birak</option>
                    <option value="Derna">Derna</option>
                    <option value="El Azizia">El Azizia</option>
                    <option value="El Beïda">El Beïda</option>
                    <option value="Gharyan">Gharyan</option>
                    <option value="Ghat">Ghat</option>
                    <option value="Houn">Houn</option>
                    <option value="Khoms">Khoms</option>
                    <option value="Misrata">Misrata</option>
                    <option value="Mizda">Mizda</option>
                    <option value="Mourzouq">Mourzouq</option>
                    <option value="Msallata">Msallata</option>
                    <option value="Nalout">Nalout</option>
                    <option value="Sabratha">Sabratha</option>
                    <option value="Sebha">Sebha</option>
                    <option value="Shahhat">Shahhat</option>
                    <option value="Surman">Surman</option>
                    <option value="Syrte">Syrte</option>
                    <option value="Tarhounah">Tarhounah</option>
                    <option value="Tobrouk">Tobrouk</option>
                    <option value="Tripoli">Tripoli</option>
                    <option value="Tukra">Tukra</option>
                    <option value="Waddan">Waddan</option>
                    <option value="Yefren">Yefren</option>
                    <option value="Zaouïa">Zaouïa</option>
                    <option value="Zliten">Zliten</option>
                    <option value="Zouara">Zouara</option>
                </select>

                <?php
            }elseif ($pays == "Lituanie"){
                ?>
                <select class="select" name="localisation">
                    <option value="Akmenė">Akmenė</option>
                    <option value="Alytus">Alytus</option>
                    <option value="Anykščiai">Anykščiai</option>
                    <option value="Ariogala">Ariogala</option>
                    <option value="Baltoji Vokė">Baltoji Vokė</option>
                    <option value="Birštonas">Birštonas</option>
                    <option value="Biržai">Biržai</option>
                    <option value="Daugai">Daugai</option>
                    <option value="Druskininkai">Druskininkai</option>
                    <option value="Dūkštas">Dūkštas</option>
                    <option value="Dusetos">Dusetos</option>
                    <option value="Eišiškės">Eišiškės</option>
                    <option value="Elektrėnai">Elektrėnai</option>
                    <option value="Ežerėlis">Ežerėlis</option>
                    <option value="Gargždai">Gargždai</option>
                    <option value="Garliava">Garliava</option>
                    <option value="Gelgaudiškis">Gelgaudiškis</option>
                    <option value="Grigiškės">Grigiškės</option>
                    <option value="Ignalina">Ignalina</option>
                    <option value="Jieznas">Jieznas</option>
                    <option value="Jonava">Jonava</option>
                    <option value="Joniškėlis">Joniškėlis</option>
                    <option value="Joniškis">Joniškis</option>
                    <option value="Jurbarkas">Jurbarkas</option>
                    <option value="Kaišiadorys">Kaišiadorys</option>
                    <option value="Kalvarija">Kalvarija</option>
                    <option value="Kaunas">Kaunas</option>
                    <option value="Kavarskas">Kavarskas</option>
                    <option value="Kazlų Rūda">Kazlų Rūda</option>
                    <option value="Kėdainiai">Kėdainiai</option>
                    <option value="Kelmė">Kelmė</option>
                    <option value="Klaipėda">Klaipėda</option>
                    <option value="Kretinga">Kretinga</option>
                    <option value="Kudirkos Naumiestis">Kudirkos Naumiestis</option>
                    <option value="Kupiškis">Kupiškis</option>
                    <option value="Kuršėnai">Kuršėnai</option>
                    <option value="Kybartai">Kybartai</option>
                    <option value="Lazdijai">Lazdijai</option>
                    <option value="Lentvaris">Lentvaris</option>
                    <option value="Linkuva">Linkuva</option>
                    <option value="Marijampolė">Marijampolė</option>
                    <option value="Mažeikiai">Mažeikiai</option>
                    <option value="Molėtai">Molėtai</option>
                    <option value="Naujoji Akmenė">Naujoji Akmenė</option>
                    <option value="Nemenčinė">Nemenčinė</option>
                    <option value="Neringa2">Neringa2</option>
                    <option value="Obeliai">Obeliai</option>
                    <option value="Pabradė">Pabradė</option>
                    <option value="Pagėgiai">Pagėgiai</option>
                    <option value="Pakruojis">Pakruojis</option>
                    <option value="Palanga">Palanga</option>
                    <option value="Pandėlys">Pandėlys</option>
                    <option value="Panemunė">Panemunė</option>
                    <option value="Panevėžys">Panevėžys</option>
                    <option value="Pasvalys">Pasvalys</option>
                    <option value="Plungė">Plungė</option>
                    <option value="Priekulė">Priekulė</option>
                    <option value="Prienai">Prienai</option>
                    <option value="Radviliškis">Radviliškis</option>
                    <option value="Ramygala">Ramygala</option>
                    <option value="Raseiniai">Raseiniai</option>
                    <option value="Rietavas">Rietavas</option>
                    <option value="Rokiškis">Rokiškis</option>
                    <option value="Rūdiškės">Rūdiškės</option>
                    <option value="Šakiai">Šakiai</option>
                    <option value="Salantai">Salantai</option>
                    <option value="Šalčininkai">Šalčininkai</option>
                    <option value="Seda">Seda</option>
                    <option value="Šeduva">Šeduva</option>
                    <option value="Šiauliai">Šiauliai</option>
                    <option value="Šilalė">Šilalė</option>
                    <option value="Šilutė">Šilutė</option>
                    <option value="Simnas">Simnas</option>
                    <option value="Širvintos">Širvintos</option>
                    <option value="Skaudvilė">Skaudvilė</option>
                    <option value="Skuodas">Skuodas</option>
                    <option value="Smalininkai">Smalininkai</option>
                    <option value="Subačius">Subačius</option>
                    <option value="Švenčionėliai">Švenčionėliai</option>
                    <option value="Švenčionys">Švenčionys</option>
                    <option value="Tauragė">Tauragė</option>
                    <option value="Telšiai">Telšiai</option>
                    <option value="Trakai">Trakai</option>
                    <option value="Troškūnai">Troškūnai</option>
                    <option value="Tytuvėnai">Tytuvėnai</option>
                    <option value="Ukmergė">Ukmergė</option>
                    <option value="Utena">Utena</option>
                    <option value="Užventis">Užventis</option>
                    <option value="Vabalninkas">Vabalninkas</option>
                    <option value="Varėna">Varėna</option>
                    <option value="Varniai">Varniai</option>
                    <option value="Veisiejai">Veisiejai</option>
                    <option value="Venta">Venta</option>
                    <option value="Viekšniai">Viekšniai</option>
                    <option value="Vievis">Vievis</option>
                    <option value="Vilkaviškis">Vilkaviškis</option>
                    <option value="Vilkija">Vilkija</option>
                    <option value="Vilnius">Vilnius</option>
                    <option value="Virbalis">Virbalis</option>
                    <option value="Visaginas">Visaginas</option>
                    <option value="Žagarė">Žagarė</option>
                    <option value="Zarasai">Zarasai</option>
                    <option value="Žiežmariai">Žiežmariai</option>
                </select>

                <?php
            }elseif ($pays == "Luxembourg"){
                ?>
                <select class="select" name="localisation">
                    <option value="Diekirch">Diekirch</option>
                    <option value="Differdange">Differdange</option>
                    <option value="Dudelange">Dudelange</option>
                    <option value="Echternach">Echternach</option>
                    <option value="Esch-sur-Alzette">Esch-sur-Alzette</option>
                    <option value="Ettelbruck">Ettelbruck</option>
                    <option value="Grevenmacher">Grevenmacher</option>
                    <option value="Luxembourg">Luxembourg</option>
                    <option value="Remich">Remich</option>
                    <option value="Rumelange">Rumelange</option>
                    <option value="Vianden">Vianden</option>
                    <option value="Wiltz">Wiltz</option>
                </select>

                <?php
            }elseif ($pays == "Madagascar"){
                ?>
                <select class="select" name="localisation">
                    <option value="Ambanja">Ambanja</option>
                    <option value="Ambatondrazaka">Ambatondrazaka</option>
                    <option value="Amboasary">Amboasary</option>
                    <option value="Ambositra">Ambositra</option>
                    <option value="Ambovombe">Ambovombe</option>
                    <option value="Amparafaravola">Amparafaravola</option>
                    <option value="Antalaha">Antalaha</option>
                    <option value="Antanifotsy">Antanifotsy</option>
                    <option value="Antsirabé">Antsirabé</option>
                    <option value="Betioky">Betioky</option>
                    <option value="Diego-Suarez">Diego-Suarez</option>
                    <option value="Fandriana">Fandriana</option>
                    <option value="Faratsiho">Faratsiho</option>
                    <option value="Fianarantsoa">Fianarantsoa</option>
                    <option value="Ikongo">Ikongo</option>
                    <option value="Mahanoro">Mahanoro</option>
                    <option value="Majunga">Majunga</option>
                    <option value="Manakara">Manakara</option>
                    <option value="Mananara Nord">Mananara Nord</option>
                    <option value="Manjakandriana">Manjakandriana</option>
                    <option value="Marovoay">Marovoay</option>
                    <option value="Morondava">Morondava</option>
                    <option value="Nosy Varika">Nosy Varika</option>
                    <option value="Sambava">Sambava</option>
                    <option value="Soanierana Ivongo">Soanierana Ivongo</option>
                    <option value="Soavinandriana">Soavinandriana</option>
                    <option value="Tamatave">Tamatave</option>
                    <option value="Tananarive">Tananarive</option>
                    <option value="Tôlanaro">Tôlanaro</option>
                    <option value="Tuléar">Tuléar</option>
                    <option value="Vavatenina">Vavatenina</option>
                </select>

                <?php
            }elseif ($pays == "Malawi"){
                ?>
                <select class="select" name="localisation">
                    <option value="Balaka">Balaka</option>
                    <option value="Blantyre">Blantyre</option>
                    <option value="Dedza">Dedza</option>
                    <option value="Karonga">Karonga</option>
                    <option value="Kasungu">Kasungu</option>
                    <option value="Lilongwe">Lilongwe</option>
                    <option value="Liwonde">Liwonde</option>
                    <option value="Luchenza">Luchenza</option>
                    <option value="Mangochi">Mangochi</option>
                    <option value="Mchinji">Mchinji</option>
                    <option value="Monkey Bay">Monkey Bay</option>
                    <option value="Mponela">Mponela</option>
                    <option value="Mulanje">Mulanje</option>
                    <option value="Mwanza">Mwanza</option>
                    <option value="Mzimba">Mzimba</option>
                    <option value="Mzuzu">Mzuzu</option>
                    <option value="Nkhata Bay">Nkhata Bay</option>
                    <option value="Nkhotakota">Nkhotakota</option>
                    <option value="Nsanje">Nsanje</option>
                    <option value="Ntcheu">Ntcheu</option>
                    <option value="Rumphi">Rumphi</option>
                    <option value="Salima">Salima</option>
                    <option value="Zomba">Zomba</option>
                </select>

                <?php
            }elseif ($pays == "Maldives"){
                ?>
                <select class="select" name="localisation">
                    <option value="Dhidhdhoo">Dhidhdhoo</option>
                    <option value="Eydhafushi">Eydhafushi</option>
                    <option value="Farukolhufunadhoo">Farukolhufunadhoo</option>
                    <option value="Felidhoo">Felidhoo</option>
                    <option value="Funadhoo">Funadhoo</option>
                    <option value="Fuvammulah">Fuvammulah</option>
                    <option value="Gan">Gan</option>
                    <option value="Hithadhoo">Hithadhoo</option>
                    <option value="Hulhumalé">Hulhumalé</option>
                    <option value="Kudahuvadhoo">Kudahuvadhoo</option>
                    <option value="Kulhudhuffushi">Kulhudhuffushi</option>
                    <option value="Magoodhoo">Magoodhoo</option>
                    <option value="Mahibadhoo">Mahibadhoo</option>
                    <option value="Malé">Malé</option>
                    <option value="Manadhoo">Manadhoo</option>
                    <option value="Midu">Midu</option>
                    <option value="Mula">Mula</option>
                    <option value="Naifaru">Naifaru</option>
                    <option value="Nolhivaranfaru">Nolhivaranfaru</option>
                    <option value="Thinadhoo">Thinadhoo</option>
                    <option value="U'ngoofaaru">U'ngoofaaru</option>
                    <option value="Ugoofaaru">Ugoofaaru</option>
                    <option value="Veymandhoo">Veymandhoo</option>
                    <option value="Veymandoo">Veymandoo</option>
                    <option value="Viligili">Viligili</option>
                    <option value="Villingili">Villingili</option>
                </select>

                <?php
            }elseif ($pays == "Mali"){
                ?>
                <select class="select" name="localisation">
                    <option value="Araouane">Araouane</option>
                    <option value="Bafoulabé">Bafoulabé</option>
                    <option value="Bamako">Bamako</option>
                    <option value="Banamba">Banamba</option>
                    <option value="Bandiagara">Bandiagara</option>
                    <option value="Bougouni">Bougouni</option>
                    <option value="Diré">Diré</option>
                    <option value="Djenné">Djenné</option>
                    <option value="Douentza">Douentza</option>
                    <option value="Gao">Gao</option>
                    <option value="Goundam">Goundam</option>
                    <option value="Kangaba">Kangaba</option>
                    <option value="Kati">Kati</option>
                    <option value="Kayes">Kayes</option>
                    <option value="Kidal">Kidal</option>
                    <option value="Kimparana">Kimparana</option>
                    <option value="Kita">Kita</option>
                    <option value="Kolokani">Kolokani</option>
                    <option value="Kolondiéba">Kolondiéba</option>
                    <option value="Koulikoro">Koulikoro</option>
                    <option value="Koutiala">Koutiala</option>
                    <option value="Macina">Macina</option>
                    <option value="Markala">Markala</option>
                    <option value="Ménaka">Ménaka</option>
                    <option value="Mopti">Mopti</option>
                    <option value="Nara">Nara</option>
                    <option value="Niafunké">Niafunké</option>
                    <option value="Niono">Niono</option>
                    <option value="Nioro du Sahel">Nioro du Sahel</option>
                    <option value="San">San</option>
                    <option value="Ségou">Ségou</option>
                    <option value="Sikasso">Sikasso</option>
                    <option value="Sokolo">Sokolo</option>
                    <option value="Taoudeni">Taoudeni</option>
                    <option value="Ténenkou">Ténenkou</option>
                    <option value="Tessalit">Tessalit</option>
                    <option value="Tombouctou">Tombouctou</option>
                    <option value="Yorosso">Yorosso</option>
                </select>

                <?php
            }elseif ($pays == "Malte"){
                ?>
                <select class="select" name="localisation">
                    <option value="Attard">Attard</option>
                    <option value="Birkirkara">Birkirkara</option>
                    <option value="Birżebbuġa">Birżebbuġa</option>
                    <option value="Bormla">Bormla</option>
                    <option value="Ħal Luqa">Ħal Luqa</option>
                    <option value="Ħal Qormi">Ħal Qormi</option>
                    <option value="Ħal Tarxien">Ħal Tarxien</option>
                    <option value="Ħaż-Żabbar">Ħaż-Żabbar</option>
                    <option value="Ħaż-Żebbuġ">Ħaż-Żebbuġ</option>
                    <option value="Il-Fgura">Il-Fgura</option>
                    <option value="Il-Gżira">Il-Gżira</option>
                    <option value="Il-Ħamrun">Il-Ħamrun</option>
                    <option value="Il-Marsa">Il-Marsa</option>
                    <option value="Il-Mellieħa">Il-Mellieħa</option>
                    <option value="Il-Mosta">Il-Mosta</option>
                    <option value="In-Naxxar">In-Naxxar</option>
                    <option value="Ir-Rabat">Ir-Rabat</option>
                    <option value="Is-Siġġiewi">Is-Siġġiewi</option>
                    <option value="Is-Swieqi">Is-Swieqi</option>
                    <option value="Iż-Żejtun">Iż-Żejtun</option>
                    <option value="Iż-Żurrieq">Iż-Żurrieq</option>
                    <option value="La Valette">La Valette</option>
                    <option value="L-Imdina">L-Imdina</option>
                    <option value="L-Imsida">L-Imsida</option>
                    <option value="Marsaskala">Marsaskala</option>
                    <option value="Paola">Paola</option>
                    <option value="San Ġiljan">San Ġiljan</option>
                    <option value="San Ġwann">San Ġwann</option>
                    <option value="San Pawl il-Baħar">San Pawl il-Baħar</option>
                    <option value="Santa Venera">Santa Venera</option>
                    <option value="Tas-Sliema">Tas-Sliema</option>
                </select>

                <?php
            }elseif ($pays == "Maroc"){
                ?>
                <select class="select" name="localisation">
                    <option value="Agadir">Agadir</option>
                    <option value="Béni Mellal">Béni Mellal</option>
                    <option value="Berkane">Berkane</option>
                    <option value="Casablanca">Casablanca</option>
                    <option value="El Jadida">El Jadida</option>
                    <option value="Fès">Fès</option>
                    <option value="kénitra">kénitra</option>
                    <option value="Khémisset">Khémisset</option>
                    <option value="Khouribga">Khouribga</option>
                    <option value="Laayoune">Laayoune</option>
                    <option value="Marrakech">Marrakech</option>
                    <option value="Meknès">Meknès</option>
                    <option value="Mohammédia">Mohammédia</option>
                    <option value="Nador">Nador</option>
                    <option value="Oujda">Oujda</option>
                    <option value="Rabat">Rabat</option>
                    <option value="Tanger">Tanger</option>
                    <option value="Taza">Taza</option>
                    <option value="Tétouan">Tétouan</option>
                </select>

                <?php
            }elseif ($pays == "Maurice"){
                ?>
                <select class="select" name="localisation">
                    <option value="Baie du Tombeau">Baie du Tombeau</option>
                    <option value="Bambous">Bambous</option>
                    <option value="Beau-Bassin Rose-Hill">Beau-Bassin Rose-Hill</option>
                    <option value="Bel Air">Bel Air</option>
                    <option value="Centre de Flacq">Centre de Flacq</option>
                    <option value="Chemin Grenier">Chemin Grenier</option>
                    <option value="Curepipe">Curepipe</option>
                    <option value="Goodlands">Goodlands</option>
                    <option value="Grand Baie">Grand Baie</option>
                    <option value="Lalmatie">Lalmatie</option>
                    <option value="Le Hochet">Le Hochet</option>
                    <option value="L'Escalier">L'Escalier</option>
                    <option value="Mahébourg">Mahébourg</option>
                    <option value="Moka">Moka</option>
                    <option value="Montagne Blanche">Montagne Blanche</option>
                    <option value="New Grove">New Grove</option>
                    <option value="Pailles">Pailles</option>
                    <option value="Pamplemousses">Pamplemousses</option>
                    <option value="Petit Raffray">Petit Raffray</option>
                    <option value="Plaine Magnien">Plaine Magnien</option>
                    <option value="Port Louis">Port Louis</option>
                    <option value="Quatre Bornes">Quatre Bornes</option>
                    <option value="Rivière des Anguilles">Rivière des Anguilles</option>
                    <option value="Rivière du Rempart">Rivière du Rempart</option>
                    <option value="Rose-Belle">Rose-Belle</option>
                    <option value="Saint-Pierre">Saint-Pierre</option>
                    <option value="Surinam">Surinam</option>
                    <option value="Terre Rouge">Terre Rouge</option>
                    <option value="Trou-aux-Biches">Trou-aux-Biches</option>
                    <option value="Vacoas-Phœnix">Vacoas-Phœnix</option>
                </select>

                <?php
            }elseif ($pays == "Mauritanie"){
                ?>
                <select class="select" name="localisation">
                    <option value="Adel Bagrou">Adel Bagrou</option>
                    <option value="Atar">Atar</option>
                    <option value="Bareina">Bareina</option>
                    <option value="Boghé">Boghé</option>
                    <option value="Boû Gâdoûm">Boû Gâdoûm</option>
                    <option value="Boutilimit">Boutilimit</option>
                    <option value="Gouraye">Gouraye</option>
                    <option value="Kaédi">Kaédi</option>
                    <option value="Kiffa">Kiffa</option>
                    <option value="Mâl">Mâl</option>
                    <option value="Nouâdhibou">Nouâdhibou</option>
                    <option value="Nouakchott">Nouakchott</option>
                    <option value="Rosso">Rosso</option>
                    <option value="Zouerate">Zouerate</option>
                </select>

                <?php
            }elseif ($pays == "Mexique"){
                ?>
                <select class="select" name="localisation">
                    <option value="Acapulco">Acapulco</option>
                    <option value="Aguascalientes">Aguascalientes</option>
                    <option value="Apodaca">Apodaca</option>
                    <option value="Campeche">Campeche</option>
                    <option value="Cancún">Cancún</option>
                    <option value="Celaya">Celaya</option>
                    <option value="Chihuahua">Chihuahua</option>
                    <option value="Chimalhuacan">Chimalhuacan</option>
                    <option value="Ciudad López Mateos">Ciudad López Mateos</option>
                    <option value="Ciudad Obregón">Ciudad Obregón</option>
                    <option value="Ciudad Victoria">Ciudad Victoria</option>
                    <option value="Coatzacoalcos">Coatzacoalcos</option>
                    <option value="Cuautitlán Izcalli">Cuautitlán Izcalli</option>
                    <option value="Cuernavaca">Cuernavaca</option>
                    <option value="Culiacán">Culiacán</option>
                    <option value="Durango">Durango</option>
                    <option value="Ecatepec">Ecatepec</option>
                    <option value="Ensenada">Ensenada</option>
                    <option value="General Escobedo">General Escobedo</option>
                    <option value="Gómez Palacio">Gómez Palacio</option>
                    <option value="Guadalajara">Guadalajara</option>
                    <option value="Guadalupe">Guadalupe</option>
                    <option value="Hermosillo">Hermosillo</option>
                    <option value="Irapuato">Irapuato</option>
                    <option value="Ixtapaluca">Ixtapaluca</option>
                    <option value="Juárez">Juárez</option>
                    <option value="León">León</option>
                    <option value="Los Mochis">Los Mochis</option>
                    <option value="Los Reyes la Paz">Los Reyes la Paz</option>
                    <option value="Matamoros">Matamoros</option>
                    <option value="Mazatlán">Mazatlán</option>
                    <option value="Mérida">Mérida</option>
                    <option value="Mexicali">Mexicali</option>
                    <option value="Mexico">Mexico</option>
                    <option value="Monterrey">Monterrey</option>
                    <option value="Morelia">Morelia</option>
                    <option value="Naucalpan">Naucalpan</option>
                    <option value="Nezahualcóyotl">Nezahualcóyotl</option>
                    <option value="Nuevo Laredo">Nuevo Laredo</option>
                    <option value="Oaxaca de Juárez">Oaxaca de Juárez</option>
                    <option value="Pachuca">Pachuca</option>
                    <option value="Puebla">Puebla</option>
                    <option value="Querétaro">Querétaro</option>
                    <option value="Reynosa">Reynosa</option>
                    <option value="Saltillo">Saltillo</option>
                    <option value="San Francisco Coacalco">San Francisco Coacalco</option>
                    <option value="San Luis Potosí">San Luis Potosí</option>
                    <option value="San Nicolás de los Garza">San Nicolás de los Garza</option>
                    <option value="Santa Catarina">Santa Catarina</option>
                    <option value="Soledad Díez Gutiérrez">Soledad Díez Gutiérrez</option>
                    <option value="Tampico">Tampico</option>
                    <option value="Tehuacán">Tehuacán</option>
                    <option value="Tepic">Tepic</option>
                    <option value="Tijuana">Tijuana</option>
                    <option value="Tlalnepantla">Tlalnepantla</option>
                    <option value="Tlaquepaque">Tlaquepaque</option>
                    <option value="Toluca">Toluca</option>
                    <option value="Tonalá">Tonalá</option>
                    <option value="Torreón">Torreón</option>
                    <option value="Tuxtla">Tuxtla</option>
                    <option value="Uruapan">Uruapan</option>
                    <option value="Veracruz">Veracruz</option>
                    <option value="Villa Nicolás Romero">Villa Nicolás Romero</option>
                    <option value="Villahermosa">Villahermosa</option>
                    <option value="Xalapa">Xalapa</option>
                    <option value="Xico">Xico</option>
                    <option value="Zapopan">Zapopan</option>
                </select>

                <?php
            }elseif ($pays == "Moldavie"){
                ?>
                <select class="select" name="localisation">
                    <option value="Bălți">Bălți</option>
                    <option value="Basarabeasca">Basarabeasca</option>
                    <option value="Briceni">Briceni</option>
                    <option value="Cahul">Cahul</option>
                    <option value="Călărași">Călărași</option>
                    <option value="Camenca">Camenca</option>
                    <option value="Căușeni">Căușeni</option>
                    <option value="Chișinău">Chișinău</option>
                    <option value="Ciadîr Lunga">Ciadîr Lunga</option>
                    <option value="Cimișlia">Cimișlia</option>
                    <option value="Codru">Codru</option>
                    <option value="Comrat">Comrat</option>
                    <option value="Dnestrovsc">Dnestrovsc</option>
                    <option value="Drochia">Drochia</option>
                    <option value="Dubăsari">Dubăsari</option>
                    <option value="Durlești">Durlești</option>
                    <option value="Edineț">Edineț</option>
                    <option value="Fălești">Fălești</option>
                    <option value="Florești">Florești</option>
                    <option value="Glodeni">Glodeni</option>
                    <option value="Grigoriopol">Grigoriopol</option>
                    <option value="Hîncești">Hîncești</option>
                    <option value="Ialoveni">Ialoveni</option>
                    <option value="Leova">Leova</option>
                    <option value="Nisporeni">Nisporeni</option>
                    <option value="Ocnița">Ocnița</option>
                    <option value="Orhei">Orhei</option>
                    <option value="Rezina">Rezina</option>
                    <option value="Rîbnița">Rîbnița</option>
                    <option value="Rîșcani">Rîșcani</option>
                    <option value="Sîngerei">Sîngerei</option>
                    <option value="Slobozia">Slobozia</option>
                    <option value="Soroca">Soroca</option>
                    <option value="Strășeni">Strășeni</option>
                    <option value="Taraclia">Taraclia</option>
                    <option value="Tighina">Tighina</option>
                    <option value="Tiraspol">Tiraspol</option>
                    <option value="Ungheni">Ungheni</option>
                    <option value="Vulcănești">Vulcănești</option>
                </select>

                <?php
            }elseif ($pays == "Monaco"){
                ?>
                <select class="select" name="localisation">
                    <option value="Fontvieille">Fontvieille</option>
                    <option value="Jardin exotique">Jardin exotique</option>
                    <option value="La Condamine">La Condamine</option>
                    <option value="La Rousse">La Rousse</option>
                    <option value="Larvotto">Larvotto</option>
                    <option value="Les Moneghetti">Les Moneghetti</option>
                    <option value="Monaco-Ville">Monaco-Ville</option>
                    <option value="Monte-Carlo">Monte-Carlo</option>
                    <option value="Ravin de Sainte-Dévote">Ravin de Sainte-Dévote</option>
                </select>

                <?php
            }elseif ($pays == "Mongolie"){
                ?>
                <select class="select" name="localisation">
                    <option value="Altay">Altay</option>
                    <option value="Arvayheer">Arvayheer</option>
                    <option value="Baganuur">Baganuur</option>
                    <option value="Baruun-Urt">Baruun-Urt</option>
                    <option value="Bayanhongor">Bayanhongor</option>
                    <option value="Bor-Öndör">Bor-Öndör</option>
                    <option value="Bulgan">Bulgan</option>
                    <option value="Choybalsan">Choybalsan</option>
                    <option value="Choyr">Choyr</option>
                    <option value="Dalanzadgad">Dalanzadgad</option>
                    <option value="Darkhan">Darkhan</option>
                    <option value="Erdenet">Erdenet</option>
                    <option value="Hovd">Hovd</option>
                    <option value="Kharkhorin">Kharkhorin</option>
                    <option value="Mandalgovĭ">Mandalgovĭ</option>
                    <option value="Mörön">Mörön</option>
                    <option value="Nalayh">Nalayh</option>
                    <option value="Ölgiy">Ölgiy</option>
                    <option value="Öndörhaan">Öndörhaan</option>
                    <option value="Oulan-Bator">Oulan-Bator</option>
                    <option value="Saynshand">Saynshand</option>
                    <option value="Sharyngol">Sharyngol</option>
                    <option value="Sükhbaatar">Sükhbaatar</option>
                    <option value="Tosontsengel">Tosontsengel</option>
                    <option value="Tsetserleg">Tsetserleg</option>
                    <option value="Ulaangom">Ulaangom</option>
                    <option value="Uliastay">Uliastay</option>
                    <option value="Zamyn-Üüd">Zamyn-Üüd</option>
                    <option value="Züünharaa">Züünharaa</option>
                    <option value="Zuunmod">Zuunmod</option>
                </select>

                <?php
            }elseif ($pays == "Mozambique"){
                ?>
                <select class="select" name="localisation">
                    <option value="Angoche">Angoche</option>
                    <option value="Beira">Beira</option>
                    <option value="Bilene Macia">Bilene Macia</option>
                    <option value="Catandica">Catandica</option>
                    <option value="Chibuto">Chibuto</option>
                    <option value="Chimoio">Chimoio</option>
                    <option value="Chokwé">Chokwé</option>
                    <option value="Cuamba">Cuamba</option>
                    <option value="Dondo">Dondo</option>
                    <option value="Gondola">Gondola</option>
                    <option value="Gurué">Gurué</option>
                    <option value="Ilha de Moçambique">Ilha de Moçambique</option>
                    <option value="Inhambane">Inhambane</option>
                    <option value="Lichinga">Lichinga</option>
                    <option value="Mandlacaze">Mandlacaze</option>
                    <option value="Manica">Manica</option>
                    <option value="Maputo">Maputo</option>
                    <option value="Matola">Matola</option>
                    <option value="Maxixe">Maxixe</option>
                    <option value="Moatize">Moatize</option>
                    <option value="Mocímboa da Praia">Mocímboa da Praia</option>
                    <option value="Mocuba">Mocuba</option>
                    <option value="Monapo">Monapo</option>
                    <option value="Montepuez">Montepuez</option>
                    <option value="Mutuáli">Mutuáli</option>
                    <option value="Nacala">Nacala</option>
                    <option value="Namialo">Namialo</option>
                    <option value="Nampula">Nampula</option>
                    <option value="Pemba">Pemba</option>
                    <option value="Quelimane">Quelimane</option>
                    <option value="Tete">Tete</option>
                    <option value="Ulongwe">Ulongwe</option>
                    <option value="Vilanculos">Vilanculos</option>
                    <option value="Xai-Xai">Xai-Xai</option>
                </select>

                <?php
            }elseif ($pays == "Namibie"){
                ?>
                <select class="select" name="localisation">
                    <option value="Gobabis">Gobabis</option>
                    <option value="Grootfontein">Grootfontein</option>
                    <option value="Henties Bay">Henties Bay</option>
                    <option value="Karasburg">Karasburg</option>
                    <option value="Katima Mulilo">Katima Mulilo</option>
                    <option value="Keetmanshoop">Keetmanshoop</option>
                    <option value="Lüderitz">Lüderitz</option>
                    <option value="Mariental">Mariental</option>
                    <option value="Okahandja">Okahandja</option>
                    <option value="Ondangwa">Ondangwa</option>
                    <option value="Oshakati">Oshakati</option>
                    <option value="Otjiwarongo">Otjiwarongo</option>
                    <option value="Outjo">Outjo</option>
                    <option value="Rundu">Rundu</option>
                    <option value="Solitaire">Solitaire</option>
                    <option value="Swakopmund">Swakopmund</option>
                    <option value="Tsumeb">Tsumeb</option>
                    <option value="Walvis Bay">Walvis Bay</option>
                    <option value="Windhoek">Windhoek</option>
                </select>

                <?php
            }elseif ($pays == "Nepal"){
                ?>
                <select class="select" name="localisation">
                    <option value="Bhaktapur">Bhaktapur</option>
                    <option value="Bharatpur">Bharatpur</option>
                    <option value="Bhimdatta1">Bhimdatta1</option>
                    <option value="Biratnagar">Biratnagar</option>
                    <option value="Birganj">Birganj</option>
                    <option value="Butwal">Butwal</option>
                    <option value="Damak">Damak</option>
                    <option value="Dhangadhi">Dhangadhi</option>
                    <option value="Dharan">Dharan</option>
                    <option value="Ghorahi">Ghorahi</option>
                    <option value="Gularia">Gularia</option>
                    <option value="Hetauda">Hetauda</option>
                    <option value="Itahari">Itahari</option>
                    <option value="Janakpur">Janakpur</option>
                    <option value="Katmandou">Katmandou</option>
                    <option value="Kirtipur">Kirtipur</option>
                    <option value="Lalitpur">Lalitpur</option>
                    <option value="Leknath">Leknath</option>
                    <option value="Madhyapur Thimi">Madhyapur Thimi</option>
                    <option value="Mechinagar">Mechinagar</option>
                    <option value="Nepalganj">Nepalganj</option>
                    <option value="Pokhara">Pokhara</option>
                    <option value="Siddharthanagar">Siddharthanagar</option>
                    <option value="Tikapur">Tikapur</option>
                    <option value="Triyuga">Triyuga</option>
                    <option value="Tulsipur">Tulsipur</option>
                </select>

                <?php
            }elseif ($pays == "Nicaragua"){
                ?>
                <select class="select" name="localisation">
                    <option value="Bluefields">Bluefields</option>
                    <option value="Boaco">Boaco</option>
                    <option value="Camoapa">Camoapa</option>
                    <option value="Chichigalpa">Chichigalpa</option>
                    <option value="Chinandega">Chinandega</option>
                    <option value="Ciudad Darío">Ciudad Darío</option>
                    <option value="Ciudad Sandino">Ciudad Sandino</option>
                    <option value="Condega">Condega</option>
                    <option value="Corinto">Corinto</option>
                    <option value="Diriamba">Diriamba</option>
                    <option value="El Rama">El Rama</option>
                    <option value="El Viejo">El Viejo</option>
                    <option value="Estelí">Estelí</option>
                    <option value="Granada">Granada</option>
                    <option value="Jalapa">Jalapa</option>
                    <option value="Jinotega">Jinotega</option>
                    <option value="Jinotepe">Jinotepe</option>
                    <option value="Juigalpa">Juigalpa</option>
                    <option value="La Concepción">La Concepción</option>
                    <option value="La Paz Centro">La Paz Centro</option>
                    <option value="La Trinidad">La Trinidad</option>
                    <option value="Larreynaga">Larreynaga</option>
                    <option value="León">León</option>
                    <option value="Managua">Managua</option>
                    <option value="Masatepe">Masatepe</option>
                    <option value="Masaya">Masaya</option>
                    <option value="Matagalpa">Matagalpa</option>
                    <option value="Mateare">Mateare</option>
                    <option value="Nagarote">Nagarote</option>
                    <option value="Nandaime">Nandaime</option>
                    <option value="Nindirí">Nindirí</option>
                    <option value="Nueva Guinea">Nueva Guinea</option>
                    <option value="Ocotal">Ocotal</option>
                    <option value="Puerto Cabezas">Puerto Cabezas</option>
                    <option value="Río Blanco">Río Blanco</option>
                    <option value="Rivas">Rivas</option>
                    <option value="San Carlos">San Carlos</option>
                    <option value="San Marcos">San Marcos</option>
                    <option value="San Rafael del Sur">San Rafael del Sur</option>
                    <option value="Santo Tomás">Santo Tomás</option>
                    <option value="Sébaco">Sébaco</option>
                    <option value="Siuna">Siuna</option>
                    <option value="Somotillo">Somotillo</option>
                    <option value="Somoto">Somoto</option>
                    <option value="Ticuantepe">Ticuantepe</option>
                    <option value="Tipitapa">Tipitapa</option>
                </select>

                <?php
            }elseif ($pays == "Niger"){
                ?>
                <select class="select" name="localisation">
                    <option value="Abalak">Abalak</option>
                    <option value="Agadez">Agadez</option>
                    <option value="Aguié">Aguié</option>
                    <option value="Arlit">Arlit</option>
                    <option value="Bilma">Bilma</option>
                    <option value="Birni N'Gaouré">Birni N'Gaouré</option>
                    <option value="Birni N'Konni">Birni N'Konni</option>
                    <option value="Bouza">Bouza</option>
                    <option value="Dakoro">Dakoro</option>
                    <option value="Diffa">Diffa</option>
                    <option value="Dogondoutchi">Dogondoutchi</option>
                    <option value="Dosso">Dosso</option>
                    <option value="Filingué">Filingué</option>
                    <option value="Gaya">Gaya</option>
                    <option value="Gouré">Gouré</option>
                    <option value="Guidan-Roumdji">Guidan-Roumdji</option>
                    <option value="Illéla">Illéla</option>
                    <option value="Kéita">Kéita</option>
                    <option value="Kollo">Kollo</option>
                    <option value="Loga">Loga</option>
                    <option value="Madaoua">Madaoua</option>
                    <option value="Madarounfa">Madarounfa</option>
                    <option value="Magaria">Magaria</option>
                    <option value="Maïné-Soroa">Maïné-Soroa</option>
                    <option value="Maradi">Maradi</option>
                    <option value="Matamèye">Matamèye</option>
                    <option value="Mayahi">Mayahi</option>
                    <option value="Mirriah">Mirriah</option>
                    <option value="N'Guigmi">N'Guigmi</option>
                    <option value="Niamey">Niamey</option>
                    <option value="Ouallam">Ouallam</option>
                    <option value="Say">Say</option>
                    <option value="Tahoua">Tahoua</option>
                    <option value="Tanout">Tanout</option>
                    <option value="Tchintabaraden">Tchintabaraden</option>
                    <option value="Tchirozérine">Tchirozérine</option>
                    <option value="Téra">Téra</option>
                    <option value="Tessaoua">Tessaoua</option>
                    <option value="Tibiri">Tibiri</option>
                    <option value="Tillabéri">Tillabéri</option>
                    <option value="Zinder">Zinder</option>
                </select>

                <?php
            }elseif ($pays == "Nigeria"){
                ?>
                <select class="select" name="localisation">
                    <option value="Aba">Aba</option>
                    <option value="Abeokuta">Abeokuta</option>
                    <option value="Ado Ekiti">Ado Ekiti</option>
                    <option value="Akure">Akure</option>
                    <option value="Bauchi">Bauchi</option>
                    <option value="Benin City">Benin City</option>
                    <option value="Calabar">Calabar</option>
                    <option value="Damaturu">Damaturu</option>
                    <option value="Ede">Ede</option>
                    <option value="Efon Alaaye">Efon Alaaye</option>
                    <option value="Enugu">Enugu</option>
                    <option value="Gboko">Gboko</option>
                    <option value="Gombe">Gombe</option>
                    <option value="Gusau">Gusau</option>
                    <option value="Ibadan">Ibadan</option>
                    <option value="Ife">Ife</option>
                    <option value="Ijebu Ode">Ijebu Ode</option>
                    <option value="Ikire">Ikire</option>
                    <option value="Ikorodu">Ikorodu</option>
                    <option value="Ikot Ekpene">Ikot Ekpene</option>
                    <option value="Ilesha">Ilesha</option>
                    <option value="Ilorin">Ilorin</option>
                    <option value="Ise">Ise</option>
                    <option value="Iseyin">Iseyin</option>
                    <option value="Iwo">Iwo</option>
                    <option value="Jimeta">Jimeta</option>
                    <option value="Jos">Jos</option>
                    <option value="Kaduna">Kaduna</option>
                    <option value="Kano">Kano</option>
                    <option value="Katsina">Katsina</option>
                    <option value="Lagos">Lagos</option>
                    <option value="Maiduguri">Maiduguri</option>
                    <option value="Makurdi">Makurdi</option>
                    <option value="Minna">Minna</option>
                    <option value="Mubi">Mubi</option>
                    <option value="Nnewi">Nnewi</option>
                    <option value="Ogbomosho">Ogbomosho</option>
                    <option value="Okene">Okene</option>
                    <option value="Ondo">Ondo</option>
                    <option value="Onitsha">Onitsha</option>
                    <option value="Oshogbo">Oshogbo</option>
                    <option value="Owerri">Owerri</option>
                    <option value="Owo">Owo</option>
                    <option value="Oyo">Oyo</option>
                    <option value="Port Harcourt">Port Harcourt</option>
                    <option value="Shagamu">Shagamu</option>
                    <option value="Sokoto">Sokoto</option>
                    <option value="Ugep">Ugep</option>
                    <option value="Umuahia">Umuahia</option>
                    <option value="Warri">Warri</option>
                    <option value="Zaria">Zaria</option>
                </select>

                <?php
            }elseif ($pays == "Norvege"){
                ?>
                <select class="select" name="localisation">
                    <option value="Åkrehamn">Åkrehamn</option>
                    <option value="Ålesund">Ålesund</option>
                    <option value="Alta">Alta</option>
                    <option value="Åndalsnes">Åndalsnes</option>
                    <option value="Arendal">Arendal</option>
                    <option value="Askim">Askim</option>
                    <option value="Bergen">Bergen</option>
                    <option value="Bodø">Bodø</option>
                    <option value="Brekstad">Brekstad</option>
                    <option value="Brevik">Brevik</option>
                    <option value="Brønnøysund">Brønnøysund</option>
                    <option value="Bryne">Bryne</option>
                    <option value="Drammen">Drammen</option>
                    <option value="Drøbak">Drøbak</option>
                    <option value="Egersund">Egersund</option>
                    <option value="Elverum">Elverum</option>
                    <option value="Fagernes">Fagernes</option>
                    <option value="Farsund">Farsund</option>
                    <option value="Fauske">Fauske</option>
                    <option value="Finnsnes">Finnsnes</option>
                    <option value="Flekkefjord">Flekkefjord</option>
                    <option value="Florø">Florø</option>
                    <option value="Førde">Førde</option>
                    <option value="Fosnavåg">Fosnavåg</option>
                    <option value="Fredrikstad">Fredrikstad</option>
                    <option value="Gjøvik">Gjøvik</option>
                    <option value="Grimstad">Grimstad</option>
                    <option value="Halden">Halden</option>
                    <option value="Hamar">Hamar</option>
                    <option value="Hammerfest">Hammerfest</option>
                    <option value="Harstad">Harstad</option>
                    <option value="Haugesund">Haugesund</option>
                    <option value="Hokksund">Hokksund</option>
                    <option value="Holmestrand">Holmestrand</option>
                    <option value="Hønefoss">Hønefoss</option>
                    <option value="Honningsvåg">Honningsvåg</option>
                    <option value="Horten">Horten</option>
                    <option value="Jørpeland">Jørpeland</option>
                    <option value="Kirkenes">Kirkenes</option>
                    <option value="Kolvereid">Kolvereid</option>
                    <option value="Kongsberg">Kongsberg</option>
                    <option value="Kongsvinger">Kongsvinger</option>
                    <option value="Kopervik">Kopervik</option>
                    <option value="Kragerø">Kragerø</option>
                    <option value="Kristiansand">Kristiansand</option>
                    <option value="Kristiansund">Kristiansund</option>
                    <option value="Langesund">Langesund</option>
                    <option value="Larvik">Larvik</option>
                    <option value="Leirvik">Leirvik</option>
                    <option value="Leknes">Leknes</option>
                    <option value="Levanger">Levanger</option>
                    <option value="Lillehammer">Lillehammer</option>
                    <option value="Lillesand">Lillesand</option>
                    <option value="Lillestrøm">Lillestrøm</option>
                    <option value="Lyngdal">Lyngdal</option>
                    <option value="Måløy">Måløy</option>
                    <option value="Mandal">Mandal</option>
                    <option value="Mo i Rana">Mo i Rana</option>
                    <option value="Molde">Molde</option>
                    <option value="Mosjøen">Mosjøen</option>
                    <option value="Moss">Moss</option>
                    <option value="Mysen">Mysen</option>
                    <option value="Namsos">Namsos</option>
                    <option value="Narvik">Narvik</option>
                    <option value="Notodden">Notodden</option>
                    <option value="Odda">Odda</option>
                    <option value="Oslo">Oslo</option>
                    <option value="Otta">Otta</option>
                    <option value="Porsgrunn">Porsgrunn</option>
                    <option value="Risør">Risør</option>
                    <option value="Rjukan">Rjukan</option>
                    <option value="Sandefjord">Sandefjord</option>
                    <option value="Sandnes">Sandnes</option>
                    <option value="Sandnessjøen">Sandnessjøen</option>
                    <option value="Sandvika">Sandvika</option>
                    <option value="Sarpsborg">Sarpsborg</option>
                    <option value="Sauda">Sauda</option>
                    <option value="Ski">Ski</option>
                    <option value="Skien">Skien</option>
                    <option value="Skudeneshavn">Skudeneshavn</option>
                    <option value="Sortland">Sortland</option>
                    <option value="Stathelle">Stathelle</option>
                    <option value="Stavanger">Stavanger</option>
                    <option value="Stavern">Stavern</option>
                    <option value="Steinkjer">Steinkjer</option>
                    <option value="Tønsberg">Tønsberg</option>
                    <option value="Tromsø">Tromsø</option>
                    <option value="Trondheim">Trondheim</option>
                    <option value="Ulsteinvik">Ulsteinvik</option>
                    <option value="Vadsø">Vadsø</option>
                    <option value="Vardø">Vardø</option>
                    <option value="Verdalsøra">Verdalsøra</option>
                </select>

                <?php
            }elseif ($pays == "Senegal"){
                ?>
                <select class="select" name="localisation">
                    <option value="Bakel">Bakel</option>
                    <option value="Bambey">Bambey</option>
                    <option value="Bargny">Bargny</option>
                    <option value="Bignona">Bignona</option>
                    <option value="Dagana">Dagana</option>
                    <option value="Dahra">Dahra</option>
                    <option value="Dakar">Dakar</option>
                    <option value="Diamniadio">Diamniadio</option>
                    <option value="Diawara">Diawara</option>
                    <option value="Diourbel">Diourbel</option>
                    <option value="Fatick">Fatick</option>
                    <option value="Gandiaye">Gandiaye</option>
                    <option value="Gossas">Gossas</option>
                    <option value="Goudomp">Goudomp</option>
                    <option value="Guédiawaye">Guédiawaye</option>
                    <option value="Guinguinéo">Guinguinéo</option>
                    <option value="Joal-Fadiouth">Joal-Fadiouth</option>
                    <option value="Kaffrine">Kaffrine</option>
                    <option value="Kanel">Kanel</option>
                    <option value="Kaolack">Kaolack</option>
                    <option value="Kayar">Kayar</option>
                    <option value="Kébémer">Kébémer</option>
                    <option value="Kédougou">Kédougou</option>
                    <option value="Khombole">Khombole</option>
                    <option value="Kolda">Kolda</option>
                    <option value="Koungheul">Koungheul</option>
                    <option value="Linguère">Linguère</option>
                    <option value="Louga">Louga</option>
                    <option value="Matam">Matam</option>
                    <option value="Mbacké">Mbacké</option>
                    <option value="Mboro">Mboro</option>
                    <option value="Mbour">Mbour</option>
                    <option value="Meckhe">Meckhe</option>
                    <option value="Ndioum">Ndioum</option>
                    <option value="Ndoffane">Ndoffane</option>
                    <option value="Nguékhokh">Nguékhokh</option>
                    <option value="Nioro du Rip">Nioro du Rip</option>
                    <option value="Ourossogui">Ourossogui</option>
                    <option value="Pikine">Pikine</option>
                    <option value="Podor">Podor</option>
                    <option value="Pout">Pout</option>
                    <option value="Richard-Toll">Richard-Toll</option>
                    <option value="Rosso">Rosso</option>
                    <option value="Rufisque">Rufisque</option>
                    <option value="Saint-Louis">Saint-Louis</option>
                    <option value="Sébikhotane">Sébikhotane</option>
                    <option value="Sédhiou">Sédhiou</option>
                    <option value="Sokone">Sokone</option>
                    <option value="Tambacounda">Tambacounda</option>
                    <option value="Thiadiaye">Thiadiaye</option>
                    <option value="Thiès">Thiès</option>
                    <option value="Tivaouane">Tivaouane</option>
                    <option value="Touba">Touba</option>
                    <option value="Vélingara">Vélingara</option>
                    <option value="Ziguinchor">Ziguinchor</option>
                </select>
                <?php
            }elseif ($pays == "Togo"){
                ?>
                <select class="select" name="localisation">
                    <option value="Amlamé">Amlamé</option>
                    <option value="Aného">Aného</option>
                    <option value="Atakpamé">Atakpamé</option>
                    <option value="Badou">Badou</option>
                    <option value="Bafilo">Bafilo</option>
                    <option value="Bassar">Bassar</option>
                    <option value="Biankouri">Biankouri</option>
                    <option value="Dapaong">Dapaong</option>
                    <option value="Galangachi">Galangachi</option>
                    <option value="Kandé">Kandé</option>
                    <option value="Kara">Kara</option>
                    <option value="Kpagouda">Kpagouda</option>
                    <option value="Kpalimé">Kpalimé</option>
                    <option value="Lomé">Lomé</option>
                    <option value="Mango">Mango</option>
                    <option value="Niamtougou">Niamtougou</option>
                    <option value="Notsé">Notsé</option>
                    <option value="Sokodé">Sokodé</option>
                    <option value="Sotouboua">Sotouboua</option>
                    <option value="Tabligbo">Tabligbo</option>
                    <option value="Tchamba">Tchamba</option>
                    <option value="Tsévié">Tsévié</option>
                    <option value="Vogan">Vogan</option>
                </select>

                <?php
            }elseif($pays == "Tchad"){
                ?>
                <select class="select" name="localisation">
                    <option value="Arusha">Arusha</option>
                    <option value="Bagamoyo">Bagamoyo</option>
                    <option value="Bukoba">Bukoba</option>
                    <option value="Bunda">Bunda</option>
                    <option value="Buseresere">Buseresere</option>
                    <option value="Dar es Salaam">Dar es Salaam</option>
                    <option value="Dodoma">Dodoma</option>
                    <option value="Ifakara">Ifakara</option>
                    <option value="Iringa">Iringa</option>
                    <option value="Kalangalala">Kalangalala</option>
                    <option value="Katoro">Katoro</option>
                    <option value="Katumba">Katumba</option>
                    <option value="Kigoma">Kigoma</option>
                    <option value="Kilosa">Kilosa</option>
                    <option value="Kiranyi">Kiranyi</option>
                    <option value="Lindi">Lindi</option>
                    <option value="Makambako">Makambako</option>
                    <option value="Mbeya">Mbeya</option>
                    <option value="Mererani">Mererani</option>
                    <option value="Mishoma">Mishoma</option>
                    <option value="Morogoro">Morogoro</option>
                    <option value="Moshi">Moshi</option>
                    <option value="Mpanda">Mpanda</option>
                    <option value="Mtwara">Mtwara</option>
                    <option value="Musoma">Musoma</option>
                    <option value="Mwanza">Mwanza</option>
                    <option value="Nguruka">Nguruka</option>
                    <option value="Njombe">Njombe</option>
                    <option value="Nkololo">Nkololo</option>
                    <option value="Nkome">Nkome</option>
                    <option value="Sengerama">Sengerama</option>
                    <option value="Shinyanga">Shinyanga</option>
                    <option value="Siha Kati">Siha Kati</option>
                    <option value="Singida">Singida</option>
                    <option value="Songea">Songea</option>
                    <option value="Sumbawanga">Sumbawanga</option>
                    <option value="Tabora">Tabora</option>
                    <option value="Tanga">Tanga</option>
                    <option value="Ushirombo">Ushirombo</option>
                    <option value="Utengule Usongwe">Utengule Usongwe</option>
                    <option value="Uyovu">Uyovu</option>
                    <option value="Vwawa">Vwawa</option>
                    <option value="Zanzibar">Zanzibar</option>
                </select>

                <?php
            }

        ?>
        </div>
        </div>
        <h5 class="fw-bold my-4">Photos</h5>
        <div class="col-lg-12">
        <div class="form-group">
        <div class="property-upload-wrapper">
        <div class="property-img-upload">
        <span><i class="far fa-images"></i> Sélectionner vos photos</span>
        </div>
        <input type="file" class="property-img-file" name="photos">
        </div>
        </div>
        </div>
        <h5 class="fw-bold my-4">Information détaillée</h5>
        <div class="col-lg-12">
        <div class="form-group">
        <label>Description</label>
        <textarea class="form-control" name="description" placeholder="Description" cols="30" rows="5"></textarea>
        </div>
        </div>
        <div class="col-lg-12 my-4">
        <button type="submit" name="submit" class="theme-btn">Publier l'annonce</button>
        </div>
        </div>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>

</main>

<?php
    require("includes/footer.php");
?>