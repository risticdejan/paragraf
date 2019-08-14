<!doctype html>
<html lang="en">
    <head>
        <?php include_once VIEW_PATH.'/layout/head.php';?>
    </head>
    <body>
        <div class="container">
            <h1 class="mb-3">Putno osiguranje</h1>
            <div class="mb-3">
                <p>
                    <div><b>datup polaska: </b><?php echo out($polisa->datum_polaska);?> </div>
                    <div><b>datum dolaska: </b><?php echo out($polisa->datum_dolaska);?> </div>
                    <div><b>broj dana: </b><?php echo out($polisa->getBrojDana());?> </div>
                    <div><b>datum unosa: </b><?php echo out($polisa->datum_unosa);?> </div>
                    <div><b>tip: </b><?php echo out($polisa->tip_polise);?> </div>
                </p>
            </div>
            <div class="mb-3">
                <h5>Nosioc putnog osiguranja: </h5>
                <p>
                    <div><b>ime i prezime: </b><?php echo out($polisa->nosioc->puno_ime);?> </div>
                    <div><b>datum rodjenja: </b><?php echo out($polisa->nosioc->datum_rodjenja);?> </div>
                    <div><b>broj pasoša: </b><?php echo out($polisa->nosioc->broj_pasosa);?> </div>
                    <div><b>email: </b><?php echo out($polisa->nosioc->email);?> </div>
                    <div><b>telefon: </b><?php echo out($polisa->nosioc->telefon);?> </div>
                </p>
            </div>
            <?php if(has($polisa->nosioc->getOsiguranici())){ ?>
            <div class="mb-3">
                <h5>Dodatno osigurana lica: </h5>
                <?php foreach($polisa->nosioc->getOsiguranici() as $osiguranik) { ?>
                <p class="mb-2">
                    <div><b>ime i prezime: </b><?php echo out($osiguranik->puno_ime);?> </div>
                    <div><b>datum rodjenja: </b><?php echo out($osiguranik->datum_rodjenja);?> </div>
                    <div><b>broj pasoša: </b><?php echo out($osiguranik->broj_pasosa);?> </div>
                </p>
                <?php } ?>
            </div>
            <?php } ?>
             
        </div>
        <?php include_once VIEW_PATH.'/layout/footer.php';?>
    </body>
</html>

