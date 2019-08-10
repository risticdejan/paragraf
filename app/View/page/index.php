<!doctype html>
<html lang="en">
    <head>
        <?php include_once VIEW_PATH.'/layout/head.php';?>
    </head>
    <body>
        <?php include_once VIEW_PATH.'/layout/navbar.php';?>

        <div class="container">
            <h3 class="font-weight-normal">Prijava putnog osiguranja</h3>
            <form method="post" action="<?php echo BASE_URL.'/prijavi';?>">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="puno_ime">Ime i prezime: </label>
                        <input type="text" class="form-control" id="puno_ime" name="puno_ime">
                    </div>
                    <div class="form-group">
                        <label for="datum_rodjenja">Datum rodjenja: </label>
                        <input type="date" class="form-control" id="datum_rodjenja" name="datum_rodjenja">
                    </div>
                    <div class="form-group">
                        <label for="broj_pasosa">Broj pasoša: </label>
                        <input type="text" class="form-control" id="broj_pasosa" name="broj_pasosa">
                    </div>
                    <div class="form-group">
                        <label for="telefon">Telefon: </label>
                        <input type="text" class="form-control" id="telefon" name="telefon">
                    </div>
                    <div class="form-group">
                        <label for="email">Email: </label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                    <div class="form-group">
                        <label for="datum_polaska">Datum polaska: </label>
                        <input type="date" class="form-control" id="datum_polaska" name="datum_polaska">
                    </div>
                    <div class="form-group">
                        <label for="datum_dolaska">Datum dolaska: </label>
                        <input type="date" class="form-control" id="datum_dolaska" name="datum_dolaska">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Tip putnog osiguranja: </label><br/>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="tip_polise" id="individualno" value="1" checked>
                            <label class="form-check-label" for="individualno">individualno</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="tip_polise" id="grupno" value="2">
                            <label class="form-check-label" for="grupno">grupno</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
            <div class="col-sm-6">
                <button type="submit" class="btn btn-primary btn-block btn-lg">Prijavi</button>
            </div> 
            </div> 
            </form>
        </div>
        <?php include_once VIEW_PATH.'/layout/footer.php';?>
    </body>
</html>

