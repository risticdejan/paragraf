<!doctype html>
<html lang="en">
    <head>
        <?php include_once VIEW_PATH.'/layout/head.php';?>
    </head>
    <body>
        <div class="container">
            <h2>Prijava putnog osiguranje</h2>
            <p>
                Hvala <?php echo out(strtolower($polisa->nosioc->puno_ime));?>, što ste nam ukazali poverenje. 
                Želimo vam ugodno putovanje.
            </p>
            <p>
                Vaš primerak putnog osiguranja možete videti u prilogu ovog mejla.
            </p>
            <p>
                S poštovanjem,<br/>
                Pargraf lex
            </p>
        </div>
    </body>
</html>

