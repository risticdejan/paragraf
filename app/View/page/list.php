<?php 
// print_r($polise);
?>
<!doctype html>
<html lang="en">
    <head>
        <?php include_once VIEW_PATH.'/layout/head.php';?>
    </head>
    <body>
        <?php include_once VIEW_PATH.'/layout/navbar.php';?>

        <div class="container">
            <h3 class="font-weight-normal">Pregled putnih osiguranja</h3>
            <?php if(has($polise)) {;?>
            <div class="table-responsive">
                <table class="table table-hover table-sm">
                    <thead class="thead-light">
                        <tr>
                            <th>datum unosa</th>
                            <th>ime i prezime</th>
                            <th>datum rodjenja</th>
                            <th>broj pasoša</th>
                            <th>email</th>
                            <th>datum polaska</th>
                            <th>datum dolaska</th>
                            <th>broj dana</th>
                            <th>tip</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($polise as $polisa) {?>
                        <tr>
                            <td><?php echo out($polisa->datum_unosa);?></td>
                            <td>
                                <a href="<?php echo url('/nosioc/'.$polisa->nosioc->id) ;?>">
                                <?php echo out($polisa->nosioc->puno_ime);?>
                                </a>
                            </td>
                            <td><?php echo out($polisa->nosioc->datum_rodjenja)?></td>
                            <td><?php echo out($polisa->nosioc->broj_pasosa);?></td>
                            <td><?php echo out($polisa->nosioc->email);?></td>
                            <td><?php echo out($polisa->datum_polaska);?></td>
                            <td><?php echo out($polisa->datum_dolaska);?></td>
                            <td><?php echo out($polisa->getBrojDana());?></td>
                            <td>
                            <?php if($polisa->tip_polise == 'grupno'){?>
                                <a href="<?php echo url('/grupno/'.$polisa->nosioc->id) ;?>">
                                <?php echo out($polisa->tip_polise);?>
                                </a>
                            <?php
                            } else {
                                echo out($polisa->tip_polise);
                            }
                            ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php } else { ?>
            <p>Ne postoje prijavljena putna osiguranja</p>
            <?php } ?>
        </div>
        <?php include_once VIEW_PATH.'/layout/footer.php';?>
    </body>
</html>

