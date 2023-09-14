<?php

    require("includes/header.php");

    $reqAnnonces = $database->prepare("SELECT * FROM annoncescolocations");
    $reqAnnonces->execute();

    $countAnnonces = $reqAnnonces->rowCount();

?>
    



    <div class="container-fluid">
        <div class="row">


            <?php

                if ($countAnnonces != 0){
                    while ($dataAnnonces = $reqAnnonces->fetch()){
                        
                        $username = $dataAnnonces['username'];
                        $dateAnnonce = $dataAnnonces['date'];
                        $prix = $dataAnnonces['prix'];
                        $categorie = $dataAnnonces['categorie'];
                        $pays = $dataAnnonces['pays'];
                        $description = $dataAnnonces['description'];

                        $reqUserAnnonce = $database->prepare("SELECT * FROM collocusers WHERE username=:username");
                        $reqUserAnnonce->bindvalue(":username", $dataAnnonces['username']);
                        $reqUserAnnonce->execute();

                        $dataUserAnnonce = $reqUserAnnonce->fetch();

                        ?>
                        <div class="col-md-6">
                            <div class="p-4 rounded-2 bg-light mb-3">
                                <div class="d-flex align-items-center gap-3">
                                    <img src="../assets/img/account/user-1.jpg" alt="" class="rounded-circle" width="33" height="33">
                                    <h6 class="fw-semibold mb-0 fs-4"><?=$username?></h6>
                                    <span class="fs-2"><span class="p-1 bg-muted rounded-circle d-inline-block"></span> <?=$dateAnnonce?></span>
                                    </div>
                                    <p class="my-3"><?=nl2br($description)?>
                                    </p>
                                    <p class="my-3">Prix : <?=$prix?> FCFA</p>
                                    <p class="my-3">Catégorie : <?=$categorie?></p>
                                    <div class="d-flex align-items-center">
                                        <a id="sendWhatsApp" data-phone-number="<?=$dataUserAnnonce['whatsapp']?>" class="theme-btn">Interessé</a>

                                        <script>
                                            document.getElementById("sendWhatsApp").addEventListener("click", function() {
                                                var phoneNumber = this.getAttribute("data-phone-number"); // Récupérer le numéro de téléphone
                                               
                                                var whatsappMessage = "Je suis intéressé par votre annonce de colocation sur Conforthouse";

                                                var whatsappURL = "https://api.whatsapp.com/send?phone=" + phoneNumber + "&text=" + encodeURIComponent(whatsappMessage);

                                                window.open(whatsappURL, "_blank");
                                            });
                                        </script>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }else{
                    ?>
                    <div class="text-center">
                        <p class="btn btn-danger">Aucun service disponible actuellement</p>
                    </div>
                    <?php
                }

            ?>

        </div>
    </div>



<?php
    require("includes/footer.php");
?>