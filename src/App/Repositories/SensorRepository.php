<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Database;
use PDO;

class SensorRepository
{
    public function __construct(private Database $database){
        
    }
    public function getAllSensoren():array {
        $pdo = $this->database->getConnection();
        $stmt = $pdo->query('SELECT * FROM sensor');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }
    public function getSensorById(int $id) : array | bool 
    {

        $sql = 'select * from sensor where sensorID = :id';
        $pdo = $this ->database->getConnection();

        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':id', $id, pdo::PARAM_INT);

        $stmt->execute();

        return $stmt->fetch(pdo::FETCH_ASSOC);
    }

    public function addSensor(array $data): string
    {
        $sql = 'INSERT INTO sensor (Type, LocatieBeschrijving, Diepte)
                VALUES (:type, :locatie, :diepte)';
        
        $pdo = $this->database->getConnection();

        $stmt = $pdo->prepare($sql);

        if(empty($data['Type']))
        {
            $stmt->bindValue(':type', null, PDO::PARAM_NULL);
        } else{
            $stmt->bindValue(':type', $data['Type'], PDO::PARAM_STR);
        }

        
        if(empty($data['LocatieBeschrijving']))
        {
            $stmt->bindValue(':locatie', null, PDO::PARAM_NULL);
        } else{
            $stmt->bindValue(':locatie', $data['LocatieBeschrijving'], PDO::PARAM_STR);
        }
        //dit is gemaakt door finn

        if(empty($data['Diepte']))
        {
            $stmt->bindValue(':diepte', null, PDO::PARAM_NULL);
        } else{
            $stmt->bindValue(':diepte', $data['Diepte'], PDO::PARAM_STR);
        }

        $stmt->execute();

        return $pdo->lastInsertId();

    }
}