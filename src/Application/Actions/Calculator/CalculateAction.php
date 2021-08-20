<?php

declare(strict_types=1);

namespace App\Application\Actions\Calculator;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;

class CalculateAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        // $this->logger->info();
        $method = $this->request->getMethod();
        $uri = $this->request->getUri();
        $host = $uri->getHost();            // localhost
        $userInfo = $uri->getPath();        // \/test
        $port = $uri->getPort();            // :8080
        $query = $uri->getQuery();          // Query of param1=value1&param2=value2

        $formData = $this->request->getParsedBody();
        // $formData = $this->getFormData();

        return $this->respondWithData($formData, 401);
    }
}
