<?php

declare(strict_types=1);

namespace App\Application\Actions\Posts;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;

class UpdatePostAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $parsedBody = $this->request->getParsedBody();




        return $this->respondWithData($name);
    }
}
