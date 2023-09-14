<?php

    require("includes/header.php");

    if (isset($_POST['register'])){

        if (!empty($_POST['username']) && !empty($_POST['pays']) && !empty($_POST['sexe']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['cpassword']) && !empty($_POST['whatsapp'])){

            $username = htmlspecialchars(ucwords($_POST['username']), ENT_QUOTES, 'UTF-8');
            $pays = htmlspecialchars($_POST['pays'], ENT_QUOTES, 'UTF-8');
            $sexe = htmlspecialchars($_POST['sexe'], ENT_QUOTES, 'UTF-8');
            $whatsapp = htmlspecialchars($_POST['whatsapp'], ENT_QUOTES, 'UTF-8');
            $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
            $password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');
            $cpassword = htmlspecialchars($_POST['cpassword'], ENT_QUOTES, 'UTF-8');

            if ($_POST['password'] === $_POST['cpassword']){

                $reqExistUser = $database->prepare("SELECT * FROM collocusers WHERE email=:email OR whatsapp=:whatsapp");
                $reqExistUser->bindvalue(":email", $email);
                $reqExistUser->bindvalue(":whatsapp", $whatsapp);
                $reqExistUser->execute();

                $countExistUser = $reqExistUser->rowCount();

                if ($countExistUser){
                    ?>
                    <script>
                        swal("Oups", "Un utilisateur est déjà inscrit avec le numéro ou l'email", "error")
                    </script>
                    <?php
                }else{

                    $insertUser = $database->prepare("INSERT INTO collocusers(username, email, pays, whatsapp, sexe, mdp) VALUES(:username, :email, :pays, :whatsapp, :sexe, :mdp)");
                    $insertUser->bindvalue(":username", $username);
                    $insertUser->bindvalue(":email", $_POST['pays']);
                    $insertUser->bindvalue(":pays", $email);
                    $insertUser->bindvalue(":whatsapp", $whatsapp);
                    $insertUser->bindvalue(":sexe", $sexe);
                    $insertUser->bindvalue(":mdp", sha1($password));
                    $insertUser->execute();

                    ?>
                    <script>
                        swal("Succès", "Compte crée avec succès", "success")
                    </script>
                    <?php

                }

            }else{
                ?>
                <script>
                    swal("Oups", "Mot de passe non identique", "error")
                </script>
                <?php
            }

        }

    }

?>

<main class="main">

<div class="site-breadcrumb" style="background: url(../assets/img/breadcrumb/01.jpg)">
<div class="container">
<h2 class="breadcrumb-title">Inscription colocation</h2>
<ul class="breadcrumb-menu">
<li><a href="index.php">Accueil</a></li>
<li class="active">Inscription colocation</li>
</ul>
</div>
</div>

<div class="login-area py-120">
<div class="container">
<div class="col-md-5 mx-auto">
<div class="login-form">
<div class="login-header">
ConfortHouse
<p>Rejoignez notre communauté en vous inscrivant dès maintenant ! </p>
</div>
<form  method="post">
    <div class="form-group">
        <label for="username">Username <span class="text-danger">*</span></label>
        <input type="text" id="username" class="form-control" name="username" placeholder="Votre username">
        <i class="far fa-user"></i>
    </div>

    <div class="form-group">
        <label for="pays">Pays <span class="text-danger">*</span></label>
        <select name="pays" id="pays" class="form-control">
            <option value="">Sélectionner votre pays</option>
            <option value="Afghanistan">Afghanistan </option>
            <option value="Afrique Centrale">Afrique Centrale </option>
            <option value="Afrique du sud">Afrique du Sud </option>
            <option value="Albanie">Albanie </option>
            <option value="Algerie">Algerie </option>
            <option value="Allemagne">Allemagne </option>
            <option value="Andorre">Andorre </option>
            <option value="Angola">Angola </option>
            <option value="Anguilla">Anguilla </option>
            <option value="Arabie Saoudite">Arabie Saoudite </option>
            <option value="Argentine">Argentine </option>
            <option value="Armenie">Armenie </option>
            <option value="Australie">Australie </option>
            <option value="Autriche">Autriche </option>
            <option value="Azerbaidjan">Azerbaidjan </option>
            <option value="Bahamas">Bahamas </option>
            <option value="Bangladesh">Bangladesh </option>
            <option value="Barbade">Barbade </option>
            <option value="Bahrein">Bahrein </option>
            <option value="Belgique">Belgique </option>
            <option value="Belize">Belize </option>
            <option value="Benin" selected="selected">Benin </option>
            <option value="Bermudes">Bermudes </option>
            <option value="Bielorussie">Bielorussie </option>
            <option value="Bolivie">Bolivie </option>
            <option value="Botswana">Botswana </option>
            <option value="Bhoutan">Bhoutan </option>
            <option value="Boznie-Herzegovine">Boznie-Herzegovine </option>
            <option value="Bresil">Bresil </option>
            <option value="Brunei">Brunei </option>
            <option value="Bulgarie">Bulgarie </option>
            <option value="Burkina Faso">Burkina Faso </option>
            <option value="Burundi">Burundi </option>
            <option value="Caiman">Caiman </option>
            <option value="Cambodge">Cambodge </option>
            <option value="Cameroun">Cameroun </option>
            <option value="Canada">Canada </option>
            <option value="Canaries">Canaries </option>
            <option value="Cap-vert">Cap-Vert </option>
            <option value="Chili">Chili </option>
            <option value="Chine">Chine </option>
            <option value="Chypre">Chypre </option>
            <option value="Colombie">Colombie </option>
            <option value="Comores">Colombie </option>
            <option value="Congo">Congo </option>
            <option value="Congo democratique">Congo democratique </option>
            <option value="Cook">Cook </option>
            <option value="Coree du Nord">Coree du Nord </option>
            <option value="Coree du Sud">Coree du Sud </option>
            <option value="Costa Rica">Costa Rica </option>
            <option value="Côte d'Ivoire">Côte d'Ivoire </option>
            <option value="Croatie">Croatie </option>
            <option value="Cuba">Cuba </option>
            <option value="Danemark">Danemark </option>
            <option value="Djibouti">Djibouti </option>
            <option value="Dominique">Dominique </option>
            <option value="Egypte">Egypte </option>
            <option value="Emirats Arabes Unis">Emirats Arabes Unis </option>
            <option value="Equateur">Equateur </option>
            <option value="Erythree">Erythree </option>
            <option value="Espagne">Espagne </option>
            <option value="Estonie">Estonie </option>
            <option value="Etats-Unis">Etats-Unis </option>
            <option value="Ethiopie">Ethiopie </option>
            <option value="Falkland">Falkland </option>
            <option value="Feroe">Feroe </option>
            <option value="Fidji">Fidji </option>
            <option value="Finlande">Finlande </option>
            <option value="France">France </option>
            <option value="Gabon">Gabon </option>
            <option value="Gambie">Gambie </option>
            <option value="Georgie">Georgie </option>
            <option value="Ghana">Ghana </option>
            <option value="Gibraltar">Gibraltar </option>
            <option value="Grece">Grece </option>
            <option value="Grenade">Grenade </option>
            <option value="Groenland">Groenland </option>
            <option value="Guadeloupe">Guadeloupe </option>
            <option value="Guam">Guam </option>
            <option value="Guatemala">Guatemala</option>
            <option value="Guernesey">Guernesey </option>
            <option value="Guinee">Guinee </option>
            <option value="Guinee-Bissau">Guinee-Bissau </option>
            <option value="Guinee equatoriale">Guinee Equatoriale </option>
            <option value="Guyana">Guyana </option>
            <option value="Guyane">Guyane </option>
            <option value="Haïti">Haïti </option>
            <option value="Hawaii">Hawaii </option>
            <option value="Honduras">Honduras </option>
            <option value="Hongrie">Hongrie </option>
            <option value="Inde">Inde </option>
            <option value="Indonesie">Indonesie </option>
            <option value="Iran">Iran </option>
            <option value="Iraq">Iraq </option>
            <option value="Irlande">Irlande </option>
            <option value="Islande">Islande </option>
            <option value="Israel">Israel </option>
            <option value="Italie">italie </option>
            <option value="Jamaique">Jamaique </option>
            <option value="Jan Mayen">Jan Mayen </option>
            <option value="Japon">Japon </option>
            <option value="Jersey">Jersey </option>
            <option value="Jordanie">Jordanie </option>
            <option value="Kazakhstan">Kazakhstan </option>
            <option value="Kenya">Kenya </option>
            <option value="Kirghizstan">Kirghizistan </option>
            <option value="Kiribati">Kiribati </option>
            <option value="Koweit">Koweit </option>
            <option value="Laos">Laos </option>
            <option value="Lesotho">Lesotho </option>
            <option value="Lettonie">Lettonie </option>
            <option value="Liban">Liban </option>
            <option value="Liberia">Liberia </option>
            <option value="Liechtenstein">Liechtenstein </option>
            <option value="Lituanie">Lituanie </option>
            <option value="Luxembourg">Luxembourg </option>
            <option value="Lybie">Lybie </option>
            <option value="Macao">Macao </option>
            <option value="Macedoine">Macedoine </option>
            <option value="Madagascar">Madagascar </option>
            <option value="Madère">Madère </option>
            <option value="Malaisie">Malaisie </option>
            <option value="Malawi">Malawi </option>
            <option value="Maldives">Maldives </option>
            <option value="Mali">Mali </option>
            <option value="Malte">Malte </option>
            <option value="Man">Man </option>
            <option value="Mariannes du Nord">Mariannes du Nord </option>
            <option value="Maroc">Maroc </option>
            <option value="Marshall">Marshall </option>
            <option value="Martinique">Martinique </option>
            <option value="Maurice">Maurice </option>
            <option value="Mauritanie">Mauritanie </option>
            <option value="Mayotte">Mayotte </option>
            <option value="Mexique">Mexique </option>
            <option value="Micronesie">Micronesie </option>
            <option value="Midway">Midway </option>
            <option value="Moldavie">Moldavie </option>
            <option value="Monaco">Monaco </option>
            <option value="Mongolie">Mongolie </option>
            <option value="Montserrat">Montserrat </option>
            <option value="Mozambique">Mozambique </option>
            <option value="Namibie">Namibie </option>
            <option value="Nauru">Nauru </option>
            <option value="Nepal">Nepal </option>
            <option value="Nicaragua">Nicaragua </option>
            <option value="Niger">Niger </option>
            <option value="Nigeria">Nigeria </option>
            <option value="Niue">Niue </option>
            <option value="Norfolk">Norfolk </option>
            <option value="Norvege">Norvege </option>
            <option value="Nouvelle-Zelande">Nouvelle-Zelande </option>
            <option value="Oman">Oman </option>
            <option value="Ouganda">Ouganda </option>
            <option value="Ouzbekistan">Ouzbekistan </option>
            <option value="Pakistan">Pakistan </option>
            <option value="Palau">Palau </option>
            <option value="Palestine">Palestine </option>
            <option value="Panama">Panama </option>
            <option value="Papouasie-Nouvelle-Guinee">Papouasie-Nouvelle-Guinee </option>
            <option value="Paraguay">Paraguay </option>
            <option value="Pays-Bas">Pays-Bas </option>
            <option value="Perou">Perou </option>
            <option value="Philippines">Philippines </option>
            <option value="Pologne">Pologne </option>
            <option value="Polynesie">Polynesie </option>
            <option value="Porto Rico">Porto Rico </option>
            <option value="Portugal">Portugal </option>
            <option value="Qatar">Qatar </option>
            <option value="Republique Dominicaine">Republique Dominicaine </option>
            <option value="Republique Tcheque">Republique Tcheque </option>
            <option value="Reunion">Reunion </option>
            <option value="Roumanie">Roumanie </option>
            <option value="Royaume Uni">Royaume Uni </option>
            <option value="Russie">Russie </option>
            <option value="Rwanda">Rwanda </option>
            <option value="Sahara Occidental">Sahara Occidental </option>
            <option value="Sainte Lucie">Sainte Lucie </option>
            <option value="Saint Marin">Saint Marin </option>
            <option value="Salomon">Salomon </option>
            <option value="Salvador">Salvador </option>
            <option value="Samoa Occidentales">Samoa Occidentales</option>
            <option value="Samoa Americaine">Samoa Americaine </option>
            <option value="Sao Tome et Principe">Sao Tome et Principe </option>
            <option value="Senegal">Senegal </option>
            <option value="Seychelles">Seychelles </option>
            <option value="Sierra Leone">Sierra Leone </option>
            <option value="Singapour">Singapour </option>
            <option value="Slovaquie">Slovaquie </option>
            <option value="Slovenie">Slovenie</option>
            <option value="Somalie">Somalie </option>
            <option value="Soudan">Soudan </option>
            <option value="Sri Lanka">Sri Lanka </option>
            <option value="Suede">Suede </option>
            <option value="Suisse">Suisse </option>
            <option value="Surinam">Surinam </option>
            <option value="Swaziland">Swaziland </option>
            <option value="Syrie">Syrie </option>
            <option value="Tadjikistan">Tadjikistan </option>
            <option value="Taiwan">Taiwan </option>
            <option value="Tonga">Tonga </option>
            <option value="Tanzanie">Tanzanie </option>
            <option value="Tchad">Tchad </option>
            <option value="Thailande">Thailande </option>
            <option value="Tibet">Tibet </option>
            <option value="Timo Oriental">Timor Oriental </option>
            <option value="Togo">Togo </option>
            <option value="Trinite et Tobago">Trinite et Tobago </option>
            <option value="Tristan da cunha">Tristan de cuncha </option>
            <option value="Tunisie">Tunisie </option>
            <option value="Turkmenistan">Turmenistan </option>
            <option value="Turquie">Turquie </option>
            <option value="Ukraine">Ukraine </option>
            <option value="Uruguay">Uruguay </option>
            <option value="Vanuatu">Vanuatu </option>
            <option value="Vatican">Vatican </option>
            <option value="Venezuela">Venezuela </option>
            <option value="Vierges Americaines">Vierges Americaines </option>
            <option value="Vierges Britanniques">Vierges Britanniques </option>
            <option value="Vietnam">Vietnam </option>
            <option value="Wake">Wake </option>
            <option value="Walllis et Futuma">Wallis et Futuma </option>
            <option value="Yemen">Yemen </option>
            <option value="Yougoslavie">Yougoslavie </option>
            <option value="Zambie">Zambie </option>
            <option value="Zimbabwe">Zimbabwe </option>
        </select>
    </div>

    <div class="form-group">
        <label for="sexe">Sexe <span class="text-danger">*</span></label>
        <select name="sexe" id="sexe" class="form-control">
            <option value="">Choisir votre sexe</option>
            <option value="Homme">Homme</option>
            <option value="Femme">Femme</option>
            <option value="Autre">Autre</option>
        </select>
        <i class="far fa-user"></i>
    </div>

    <div class="form-group">
        <label for="whatsapp">Numéro Whatsapp (avec indicatif du pays)<span class="text-danger">*</span></label>
        <input type="tel" id="whatsapp" class="form-control" name="whatsapp" placeholder="Votre numéro whatsapp">
        <i class="far fa-user"></i>
    </div>

    <div class="form-group">
        <label for="email"> Adresse email <span class="text-danger">*</span></label>
        <input type="email" class="form-control" name="email" id="email" placeholder="Votre adresse email">
        <i class="far fa-envelope"></i>
    </div>
    <div class="form-group">
        <label for="password">Mot de passe <span class="text-danger">*</span></label>
        <input type="password" class="form-control" id="password" name="password" placeholder="********** ">
        <i class="far fa-lock"></i>
    </div>

    <div class="form-group">
        <label for="cpassword">Confirmation du mot de passe <span class="text-danger">*</span></label>
        <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="********** ">
        <i class="far fa-lock"></i>
    </div>

    
    <div class="d-flex align-items-center">
    <button type="submit" class="theme-btn" name="register"><i class="far fa-paper-plane"></i> S'inscrire</button>
    </div>

    <p style="margin-top:20px;">
        En soumettant ce formulaire, vous acceptez notre <a href="../privacy.php" style="color:blue;">Politique de confidentialité</a> et les <a href="../terms.php" style="color:blue;">Conditions générales d'utilisations</a>.
    </p>
</form>

<div class="login-footer">
<!-- <div class="login-divider"><span>Or</span></div>
<div class="social-login">
<a href="#" class="btn-fb"><i class="fab fa-facebook"></i> Login With Facebook</a>
<a href="#" class="btn-gl"><i class="fab fa-google"></i> Login With Google</a>
</div> -->
<p>Vous avez un compte ? <a href="login.php">Se connecter</a></p>
</div>

</div>
</div>
</div>
</div>

</main>

<?php

    require("includes/footer.php");

?>