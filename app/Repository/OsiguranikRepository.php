<?php 

namespace App\Repository;

use Core\Database\Connaction as Connaction;
use App\Model\Osiguranik as Osiguranik;

class OsiguranikRepository{

    protected static $model = Osiguranik::class;
    protected static $table = 'osiguranici';

    public function __construct(){
    }

    public function create(Osiguranik $osiguranik){
        try {
            $conn = Connaction::getInstance();
            
            try {
                $query = "INSERT INTO  ".self::$table." "
                    ."(puno_ime, datum_rodjenja, broj_pasosa, email, telefon) "
                    ."VALUES(:puno_ime, :datum_rodjenja, :broj_pasosa, :email, :telefon)";
    
                $stmt = $conn->prepare($query);
    
                $stmt->bindParam(':puno_ime', $osiguranik->puno_ime);
                $stmt->bindParam(':datum_rodjenja', $osiguranik->datum_rodjenja);
                $stmt->bindParam(':broj_pasosa', $osiguranik->broj_pasosa);
                $stmt->bindParam(':email',$osiguranik->email);
                $stmt->bindParam(':telefon', $osiguranik->telefon);
    
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

    public function getNosioca($id) {
        try {
            $conn = Connaction::getInstance();

            $query = "SELECT 
                    o.id as id,
                    o.puno_ime AS puno_ime,
                    DATE_FORMAT(o.datum_rodjenja, '%d/%m/%Y')  AS datum_rodjenja,
                    o.broj_pasosa AS broj_pasosa,
                    o.telefon AS telefon,
                    o.email AS email 
                    FROM " . self::$table . " as o
                    WHERE id=:id AND nosioc_id IS NULL";

            $stmt = $conn->prepare($query);

            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);

            $stmt->execute();
            
            $row = $stmt->fetch(\PDO::FETCH_OBJ);

            if($row){
                $osiguranik = new Osiguranik();
    
                $osiguranik->id = $row->id;
                $osiguranik->puno_ime = $row->puno_ime;
                $osiguranik->datum_rodjenja = $row->datum_rodjenja;
                $osiguranik->broj_pasosa = $row->broj_pasosa;
                $osiguranik->email = $row->email;
                $osiguranik->telefon = $row->telefon;
            } else {
                $osiguranik = null;
            }

            $stmt = null;

            return $osiguranik;
        } catch(\PDOException $e) {
            if(DEBUG) { 
                exit("Connection and/or Query failed: " . $e->getMessage());
            }

            return null;      
        }
    }

    public function getOsiguranike($id) {
        try {
            $conn = Connaction::getInstance();

            $query = "SELECT 
                    o1.id as id,
                    o1.puno_ime AS puno_ime,
                    DATE_FORMAT(o1.datum_rodjenja, '%d/%m/%Y')  AS datum_rodjenja,
                    o1.broj_pasosa AS broj_pasosa,
                    o1.telefon AS telefon,
                    o1.email AS email,
                    o2.puno_ime as osiguranik_puno_ime,
                    DATE_FORMAT(o2.datum_rodjenja, '%d/%m/%Y')  AS osiguranik_datum_rodjenja,
                    o2.broj_pasosa as osiguranik_broj_pasosa
                FROM 
                    " . self::$table . "  AS o1 
                INNER JOIN 
                    " . self::$table . "  AS o2  
                ON o1.id = o2.nosioc_id
                WHERE o1.id=:id";

            $stmt = $conn->prepare($query);

            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);

            $stmt->execute();

            $res = [];
            $nosioc = new Osiguranik();
            while ($row = $stmt->fetch(\PDO::FETCH_OBJ)) {
                $nosioc->id = $row->id;
                $nosioc->puno_ime = $row->puno_ime;
                $nosioc->datum_rodjenja = $row->datum_rodjenja;
                $nosioc->broj_pasosa = $row->broj_pasosa;
                $nosioc->email = $row->email;
                $nosioc->telefon = $row->telefon;
                $osiguranik = new Osiguranik();
                $osiguranik->puno_ime = $row->osiguranik_puno_ime;
                $osiguranik->datum_rodjenja = $row->osiguranik_datum_rodjenja;
                $osiguranik->broj_pasosa = $row->osiguranik_broj_pasosa;
                $nosioc->addOsiguranika($osiguranik);
            }

            $stmt = null;

            if($nosioc->id == null) $nosioc = null;
            
            return $nosioc;
        } catch(\PDOException $e) {
            if(DEBUG) { 
                exit("Connection and/or Query failed: " . $e->getMessage());
            }

            return null;      
        }
    }
}