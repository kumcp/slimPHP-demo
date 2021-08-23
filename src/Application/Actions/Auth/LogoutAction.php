<?php

declare(strict_types=1);

namespace App\Application\Actions\Auth;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;

class LogoutAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        session_destroy();

        return $this->respondWithData("You have been logged out", 200);
    }
}
