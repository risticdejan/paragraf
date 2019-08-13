<?php 

namespace App\Repository;

use Core\Database\Connaction as Connaction;
use App\Model\Polisa as Polisa;

class PolisaRepository  extends BaseRepository{

    private static $model = Polisa::class;
    private static $table = 'polise';

    public function __construct(){
    }

    public function create(Polisa $polisa){
        try {
            $conn = Connaction::getInstance();
            try {
                $query = "INSERT INTO  ".self::$table." "
                    ."(telefon, email, datum_polaska, datum_dolaska, tip_polise, nosioc_id) "
                    ."VALUES(:telefon, :email, :datum_polaska, :datum_dolaska, :tip_polise, :nosioc_id)";

                $stmt = $conn->prepare($query);

                $stmt->bindParam(':nosioc_id', $polisa->nosioc->id);
                $stmt->bindParam(':email', $polisa->email);
                $stmt->bindParam(':telefon', $polisa->telefon);
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