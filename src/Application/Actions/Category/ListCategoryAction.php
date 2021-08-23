<?php

declare(strict_types=1);

namespace App\Application\Actions\Category;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;

class ListCategoryAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $statement = $this->db->prepare("SELECT * FROM categories");
        $statement->execute();

        $categories = $statement->fetchAll();
        return $this->respondWithData($categories, 200);
    }
}
