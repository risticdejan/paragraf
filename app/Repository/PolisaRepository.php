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
            
            $query = "INSERT INTO  ".self::$table." "
                ."(nosioc_id, email, datum_polaska, datum_dolaska, tip_polise) "
                ."VALUES(:nosioc_id, :email, :datum_polaska, :datum_dolaska, :tip_polise)";

            $stmt = $conn->prepare($query);

            $stmt->bindParam(':nosioc_id', $polisa->nosioc->id);
            $stmt->bindParam(':email', $polisa->email);
            $stmt->bindParam(':datum_polaska', $polisa->datum_polaska);
            $stmt->bindParam(':datum_dolaska', $polisa->datum_dolaska);
            $stmt->bindParam(':tip_polise', $polisa->tip_polise);
            $stmt->execute();

            $id = $conn->lastInsertId();

            $stmt = null;

            return $id;

        } catch(\PDOException $e) {
            if(DEBUG) { 
                exit("Connection and/or Query failed: " . $e->getMessage());
            }   
            return 0;   
        }
    }
}