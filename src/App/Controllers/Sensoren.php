<?php

declare(strict_types=1);

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Repositories\SensorRepository;

class sensoren{
public function __construct(private SensorRepository $repository)
{
    
}
public function showAllSensoren(Request $request, Response $response): Response {

    $data = $this->repository->getAllSensoren();

    $body = json_encode($data);

    $response->getBody()->write($body);

    return $response->withHeader('Content-Type', 'application/json');
}
    public function addSensor(Request $request, Response $response): Response
    {
        $body = $request->getParsedBody();
        $id = $this->repository->addSensor($body);

        $body = json_encode([
                'message' => 'Sensor toegevoegd',
                'id'=> $id
        ]);

        $response->getBody()->write($body);

        return $response->withHeader('Content-Type','application/json')->withStatus(201);
    }
}