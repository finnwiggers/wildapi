<?php

declare(strict_types=1);

namespace App\Middelware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class ApiKeyMiddelware
{
    private $apiKey = "konijn";

    public function __invoke(Request $request, RequestHandler $handler): Response 
    {
        $apiHeader = $request->getHeaderLine('Authorization');
    
        if ($apiHeader !== $this->apiKey){

            $response = new \Slim\Psr7\Response();

            $error = ['message' => '401 Unauthorized',
            'exeption' =>[['type' => get_class($this),
            'code' => 401,
            'message' => 'geen toegang',
            'file' => __FILE__,
            'line' => __LINE__]]];
            
        $response->getBody()->write(json_encode($error));
        return $response->withHeader('Content-Type', 'application\json')->withStatus(401);
        }
        
        return $handler->handle($request);
    }
}