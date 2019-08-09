<?php 

namespace App\Repository\DB;

use Core\Database\Connaction as Connaction;
use App\Model\Osiguranik as Osiguranik;
use App\Repository\OsiguranikRepository as OsiguranikRepository;

class DBOsiguranikRepository implements OsiguranikRepository {

    private $model;

    public function __construct(){
        $this->model = new Osiguranik();
    }

    public function getAll(): array {
        try {
            $conn = Connaction::getInstance();

            $query = "SELECT * FROM " . $this->model->getTable();

            $stmt = $conn->prepare($query);

            $stmt->execute();
            
            $stmt->setFetchMode(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, get_class($this->model));

            $res = $stmt->fetchAll();

            $stmt = null;

            return $res;
        } catch(\PDOException $e) {
            if(DEBUG) { 
                exit("Connection and/or Query failed: " . $e->getMessage());
            }

            return [];      
        }
    }

    public function get(int $id): Osiguranik{
        try {
            $conn = Connaction::getInstance();

            $query = "SELECT * FROM " . $this->model->getTable() . " WHERE id=:id";

            $stmt = $conn->prepare($query);

            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);

            $stmt->execute();
            
            $stmt->setFetchMode(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, get_class($this->model));
            
            $res = $stmt->fetch();

            $stmt = null;

            return $res;
        } catch(\PDOException $e) {
            if(DEBUG) { 
                exit("Connection and/or Query failed: " . $e->getMessage());
            }

            return null;      
        }
    }
}