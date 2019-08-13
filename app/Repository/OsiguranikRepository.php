<?php 

namespace App\Repository;

use Core\Database\Connaction as Connaction;
use App\Model\Osiguranik as Osiguranik;

class OsiguranikRepository extends BaseRepository{

    private static $model = Osiguranik::class;
    private static $table = 'osiguranici';

    public function __construct(){
    }

    public function create(Osiguranik $osiguranik){
        try {
            $conn = Connaction::getInstance();
            
            try {
                $query = "INSERT INTO  ".self::$table." "
                    ."(puno_ime, datum_rodjenja, broj_pasosa) "
                    ."VALUES(:puno_ime, :datum_rodjenja, :broj_pasosa)";
    
                $stmt = $conn->prepare($query);
    
                $stmt->bindParam(':puno_ime', $osiguranik->puno_ime);
                $stmt->bindParam(':datum_rodjenja', $osiguranik->datum_rodjenja);
                $stmt->bindParam(':broj_pasosa', $osiguranik->broj_pasosa);
    
                $conn->beginTransaction();

                $stmt->execute();
                $osiguranik->id = $conn->lastInsertId();

                $conn->commit();

                $stmt = null;
    
                return $osiguranik;
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

    public function createGrupnoOsiguraje($nosioc, $osiguranici) {
        try {
            $conn = Connaction::getInstance();
            
            try {
                $query = "INSERT INTO  ".self::$table." "
                    ."(puno_ime, datum_rodjenja, broj_pasosa, nosioc_id) "
                    ."VALUES(:puno_ime, :datum_rodjenja, :broj_pasosa, :nosioc_id)";
    
                $stmt = $conn->prepare($query);
             
                $stmt->bindParam(':puno_ime', $puno_ime);
                $stmt->bindParam(':datum_rodjenja', $datum_rodjenja);
                $stmt->bindParam(':broj_pasosa', $broj_pasosa);
                $stmt->bindParam(':nosioc_id', $nosioc_id);

                $conn->beginTransaction();

                $res = [];
                foreach($osiguranici as &$osiguranik) {
                    $puno_ime = $osiguranik['puno_ime'];
                    $datum_rodjenja = $osiguranik['datum_rodjenja'];
                    $broj_pasosa = $osiguranik['broj_pasosa'];
                    $nosioc_id = $nosioc->id;

                    $stmt->execute();

                    $newOsiguranik = new Osiguranik($puno_ime, $datum_rodjenja, $broj_pasosa);
                    $newOsiguranik->id = $conn->lastInsertId();

                    $res[] = $newOsiguranik;
                }
                $conn->commit();  
    
                $stmt = null;
    
                return $res;
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