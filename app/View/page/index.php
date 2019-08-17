<!doctype html>
<html lang="en">
    <head>
        <?php include_once VIEW_PATH.'/layout/head.php';?>
    </head>
    <body>
        <?php include_once VIEW_PATH.'/layout/spinner.php';?>
        
        <?php include_once VIEW_PATH.'/layout/navbar.php';?>

        <div class="container">
            <h3 class="font-weight-normal">Prijava putnog osiguranja</h3>
            <form autocomplete="off" method="post" id="prijava-forma" action="<?php echo url('/prijavi');?>">
            <input type="hidden" name="token" value="<?php echo \Core\Session::get('token');?>">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="puno_ime">Ime i prezime: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="puno_ime" name="puno_ime">                   
                    </div>
                    <div class="form-group">
                        <label for="datum_rodjenja">Datum rodjenja: <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="datum_rodjenja" name="datum_rodjenja">
                    </div>
                    <div class="form-group">
                        <label for="broj_pasosa">Broj pasoša: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="broj_pasosa" name="broj_pasosa">          
                    </div>
                    <div class="form-group">
                        <label for="telefon">Telefon: </label>
                        <input type="text" class="form-control" id="telefon" name="telefon">                   
                    </div>
                    <div class="form-group">
                        <label for="email">Email: <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email">                
                    </div>
                    <div class="form-group">
                        <label for="datum_polaska">Datum polaska: <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="datum_polaska" name="datum_polaska">               
                    </div>
                    <div class="form-group">
                        <label for="datum_dolaska">Datum dolaska: <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="datum_dolaska" name="datum_dolaska">                    
                    </div>
                    <p class="date-info"></p>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Tip putnog osiguranja: </label><br/>
                        <div class="form-check form-check-inline ind-opt mr-5">
                            <input class="form-check-input radio" type="radio" name="tip_polise" id="individualno" value="1" checked>
                            <label class="form-check-label radio" for="individualno">individualno</label>
                        </div>
                        <div class="form-check form-check-inline gru-opt">
                            <input class="form-check-input radio" type="radio" name="tip_polise" id="grupno" value="2">
                            <label class="form-check-label radio" for="grupno">grupno</label>
                        </div>
                    </div>
                    <div id="addition"></div>
                    <a  href="#" id="addition-button" class="btn btn-danger">
                        Dodaj Osiguranika
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <p><span class="text-danger">*</span> Ova polja su obavezna.</p>
                    <button type="submit" class="btn btn-primary btn-block btn-lg">Prijavi</button>
                </div> 
            </div> 
            </form>
        </div>
        <?php include_once VIEW_PATH.'/layout/footer.php';?>

        <script>
            Prijava.init();
        </script>
    </body>
</html>

