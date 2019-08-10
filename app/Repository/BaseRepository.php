<?php 

namespace App\Repository;

abstract class BaseRepository {

    public function getAll() {
        try {
            $conn = Connaction::getInstance();

            $query = "SELECT * FROM " . static::$table();

            $stmt = $conn->prepare($query);

            $stmt->execute();
            
            $stmt->setFetchMode(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, get_class(static::$model));

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

    public function get(int $id){
        try {
            $conn = Connaction::getInstance();

            $query = "SELECT * FROM " . static::$table() . " WHERE id=:id";

            $stmt = $conn->prepare($query);

            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);

            $stmt->execute();
            
            $stmt->setFetchMode(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, static::$model);
            
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