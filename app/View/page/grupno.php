<?php 
// print_r($nosioc);
?>
<!doctype html>
<html lang="en">
    <head>
        <?php include_once VIEW_PATH.'/layout/head.php';?>
    </head>
    <body>
        <?php include_once VIEW_PATH.'/layout/navbar.php';?>

        <div class="container">
            <h3 class="font-weight-normal">Grupno putno osiguranje</h3>
            <?php if(has($nosioc)) {;?>
                <div class="card mb-4">
                    <div class="card-body">
                        <h4 class="card-title">Nosioc puntog osiguranja:</h4>
                        <h5 class="card-title"><?php echo out($nosioc->puno_ime);?></h5>
                        <p class="card-text">
                            <div><b>datum rodjenja: </b><?php echo out($nosioc->datum_rodjenja);?> </div>
                            <div><b>broj pasoša: </b><?php echo out($nosioc->broj_pasosa);?> </div>
                            <div><b>email: </b><?php echo out($nosioc->email);?> </div>
                            <div><b>telefon: </b><?php echo out($nosioc->telefon);?> </div>
                        </p>
                        <a href="<?php echo backUrl();?>" class="btn btn-primary">nazad</a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Dodatna osigurana lica:</h4>
                        <?php if(has($nosioc->getOsiguranici())) {
                            foreach($nosioc->getOsiguranici() as $osiguranik) {?>
                        <p class="card-text mb-2">
                            <div><b>ime i prezime: </b><?php echo out($osiguranik->puno_ime);?> </div>
                            <div><b>datum rodjenja: </b><?php echo out($osiguranik->datum_rodjenja);?> </div>
                            <div><b>broj pasoša: </b><?php echo out($osiguranik->broj_pasosa);?> </div>
                        </p>
                        <?php }
                        } else {?>
                        <p class"card-text">Nema dodatno osiguranih lica.</p>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            <?php } else { ?>
            <p>Ne postoje takav osiguranik.</p>
            <?php } ?>
        </div>
        <?php include_once VIEW_PATH.'/layout/footer.php';?>
    </body>
</html>

