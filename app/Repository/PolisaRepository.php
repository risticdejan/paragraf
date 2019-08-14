<?php 

namespace App\Repository;

use Core\Database\Connaction as Connaction;
use App\Model\Polisa as Polisa;
use App\Model\Osiguranik as Osiguranik;

class PolisaRepository{

    protected static $model = Polisa::class;
    protected static $table = 'polise';

    public function __construct(){
    }

    public function getAll() {
        try {
            $conn = Connaction::getInstance();

            $query = "SELECT 
                        p.id as polisa_id,
                        o.id AS nosioc_id,
                        o.puno_ime AS puno_ime,
                        DATE_FORMAT(o.datum_rodjenja, '%d/%m/%Y')  AS datum_rodjenja,
                        o.broj_pasosa AS broj_pasosa,
                        o.telefon AS telefon,
                        o.email AS email,
                        DATE_FORMAT(p.datum_polaska, '%d/%m/%Y') AS datum_polaska,
                        DATE_FORMAT(p.datum_dolaska, '%d/%m/%Y') AS datum_dolaska,
                        DATEDIFF(p.datum_dolaska, p.datum_polaska) AS broj_dana,
                        DATE_FORMAT(p.datum_unosa, '%d/%m/%Y %H:%i:%s') AS datum_unosa,
                        IF(p.tip_polise <> '2','individualno', 'grupno') AS tip_polise
                    FROM
                        polise AS p
                            INNER JOIN
                        osiguranici AS o ON p.nosioc_id = o.id
                    ORDER BY datum_unosa DESC";

            $stmt = $conn->prepare($query);

            $stmt->execute();

            $polise = [];

            while ($row = $stmt->fetch(\PDO::FETCH_OBJ)) {
                $nosioc = new Osiguranik();
                $nosioc->id = $row->nosioc_id;
                $nosioc->puno_ime = $row->puno_ime;
                $nosioc->datum_rodjenja = $row->datum_rodjenja;
                $nosioc->broj_pasosa = $row->broj_pasosa;
                $nosioc->email = $row->email;
                $nosioc->telefon = $row->telefon;

                $polisa = new Polisa();
                $polisa->nosioc = $nosioc;
                $polisa->id = $row->polisa_id;
                $polisa->datum_polaska = $row->datum_polaska;
                $polisa->datum_dolaska = $row->datum_dolaska;
                $polisa->tip_polise = $row->tip_polise;
                $polisa->setBrojDana($row->broj_dana);
                $polisa->datum_unosa = $row->datum_unosa;

                $polise[] = $polisa;
            }
            $stmt = null;

            return $polise;
        } catch(\PDOException $e) {
            if(DEBUG) { 
                exit("Connection and/or Query failed: " . $e->getMessage());
            }

            return null;      
        }
    }

    public function create(Polisa $polisa){
        try {
            $conn = Connaction::getInstance();
            try {
                $query = "INSERT INTO  ".self::$table." "
                    ."(datum_polaska, datum_dolaska, tip_polise, nosioc_id) "
                    ."VALUES(:datum_polaska, :datum_dolaska, :tip_polise, :nosioc_id)";

                $stmt = $conn->prepare($query);

                $stmt->bindParam(':nosioc_id', $polisa->nosioc->id);
                $stmt->bindParam(':datum_polaska', $polisa->datum_polaska);
                $stmt->bindParam(':datum_dolaska', $polisa->datum_dolaska);
                $stmt->bindParam(':tip_polise', $polisa->tip_polise);
                
                $conn->beginTransaction();

                $stmt->execute();
                $polisa->id = $conn->lastInsertId();

                $conn->commit();


                $stmt = null;

                return $polisa;
            }catch(\PDOException $e) {
                $conn->rollback();
                if(DEBUG) { 
                    exit("Query failed: " . $e->getMessage());
                }
                return null;
            }

        } catch(\PDOException $e) {
            if(DEBUG) { 
                exit("Connection failed: " . $e->getMessage());
            }   
            return null;   
        }
    }
}