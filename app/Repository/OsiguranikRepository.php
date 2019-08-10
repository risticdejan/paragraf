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
            
            $query = "INSERT INTO  ".self::$table." "
                ."(puno_ime, datum_rodjenja, broj_pasosa, telefon) "
                ."VALUES(:puno_ime, :datum_rodjenja, :broj_pasosa, :telefon)";

            $stmt = $conn->prepare($query);

            $stmt->bindParam(':puno_ime', $osiguranik->puno_ime);
            $stmt->bindParam(':datum_rodjenja', $osiguranik->datum_rodjenja);
            $stmt->bindParam(':broj_pasosa', $osiguranik->broj_pasosa);
            $stmt->bindParam(':telefon', $osiguranik->telefon);

            $stmt->execute();

            $osiguranik->id = $conn->lastInsertId();

            $stmt = null;

            return $osiguranik;

        } catch(\PDOException $e) {
            if(DEBUG) { 
                exit("Connection and/or Query failed: " . $e->getMessage());
            }   
            return null;   
        }
    }


}