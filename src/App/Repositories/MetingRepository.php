<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Database;
use PDO;

class MetingRepository
{
    public function __construct(private Database $database){}
    
    public function getAllMeting():array {
        $pdo = $this->database->getConnection();
        $stmt = $pdo->query('SELECT * FROM meting');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }
    public function getMetingById(int $id) : array | bool 
    {

        $sql = 'select * from Meting where MetingID = :id';
        $pdo = $this ->database->getConnection();

        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':id', $id, pdo::PARAM_INT);

        $stmt->execute();

        return $stmt->fetch(pdo::FETCH_ASSOC);
}
}