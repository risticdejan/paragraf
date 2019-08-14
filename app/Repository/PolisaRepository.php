<?php 

namespace App\Repository;

use Core\Database\Connaction as Connaction;
use App\Model\Polisa as Polisa;

class PolisaRepository{

    protected static $model = Polisa::class;
    protected static $table = 'polise';

    public function __construct(){
    }

    public function getAll() {
        try {
            $conn = Connaction::getInstance();

            $query = "SELECT 
                        p.nosioc_id AS nosioc_id,
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
            
            $stmt->setFetchMode(\PDO::FETCH_OBJ);

            $res = $stmt->fetchAll();

            $stmt = null;

            return $res;
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