<?php

declare(strict_types=1);

namespace App\Application\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response as Psr7Response;

class AdminMiddleware implements Middleware
{
    /**
     * {@inheritdoc}
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        if (isset($_SESSION) && ($_SESSION['admin'] !== null)) {
            return $handler->handle($request);
        }

        $response = new Psr7Response();
        $response->getBody()->write(json_encode(["test" => 'a'], JSON_PRETTY_PRINT));
        return $response;
    }
}
