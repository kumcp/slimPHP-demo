<?php

declare(strict_types=1);

namespace App\Application\Actions\Category;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;

class AddCategoryAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $body = $this->request->getParsedBody();

        $name = $body['name'];

        $statement = $this->db->prepare("INSERT INTO categories (name) VALUES (?)");
        $statement->execute([$name]);

        return $this->respondWithData("You have added a new category.", 200);
    }
}
