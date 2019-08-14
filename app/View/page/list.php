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
                        <tr id='sort-heading' data-sort-url="<?php echo url('/pregled');?>">
                            <th data-sort-col="datum_unosa">
                                datum unosa 
                                <?php if($col == 'datum_unosa'){?>
                                <span data-sort-val="<?php echo $order;?>" class="float-right <?php echo $order;?>">&#60;</span>
                                <?php }?>
                            </th>
                            <th data-sort-col="puno_ime">
                                ime i prezime 
                                <?php if($col == 'puno_ime'){?>
                                <span data-sort-val="<?php echo $order;?>" class="float-right <?php echo $order;?>">&#60;</span>
                                <?php }?>
                            <th data-sort-col="datum_rodjenja">
                                datum rodjenja
                                <?php if($col == 'datum_rodjenja'){?>
                                <span data-sort-val="<?php echo $order;?>" class="float-right <?php echo $order;?>">&#60;</span>
                                <?php }?>
                            </th>
                            <th data-sort-col="broj_pasosa">
                                broj pasoša
                                <?php if($col == 'broj_pasosa'){?>
                                <span data-sort-val="<?php echo $order;?>" class="float-right <?php echo $order;?>">&#60;</span>
                                <?php }?>
                            </th>
                            <th data-sort-col="email">
                                email
                                <?php if($col == 'email'){?>
                                <span data-sort-val="<?php echo $order;?>" class="float-right <?php echo $order;?>">&#60;</span>
                                <?php }?>
                            </th>
                            <th data-sort-col="datum_polaska">
                                datum polaska
                                <?php if($col == 'datum_polaska'){?>
                                <span data-sort-val="<?php echo $order;?>" class="float-right <?php echo $order;?>">&#60;</span>
                                <?php }?>
                            </th>
                            <th data-sort-col="datum_dolaska">
                                datum dolaska
                                <?php if($col == 'datum_dolaska'){?>
                                <span data-sort-val="<?php echo $order;?>" class="float-right <?php echo $order;?>">&#60;</span>
                                <?php }?>
                            </th>
                            <th data-sort-col="broj_dana">
                                broj dana
                                <?php if($col == 'broj_dana'){?>
                                <span data-sort-val="<?php echo $order;?>" class="float-right <?php echo $order;?>">&#60;</span>
                                <?php }?>
                            </th>
                            <th data-sort-col="tip_polise">
                                tip polise
                                <?php if($col == 'tip_polise'){?>
                                <span data-sort-val="<?php echo $order;?>" class="float-right <?php echo $order;?>">&#60;</span>
                                <?php }?>
                            </th>
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

        <script>
            Lista.init();
        </script>
    </body>
</html>

