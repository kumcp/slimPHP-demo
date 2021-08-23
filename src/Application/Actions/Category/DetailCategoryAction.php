<?php

declare(strict_types=1);

namespace App\Application\Actions\Category;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;

class DetailCategoryAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $catId = $this->args['catId'];
        $statement = $this->db->prepare("SELECT * FROM categories WHERE id=?");
        $statement->execute([$catId]);

        $category = $statement->fetchAll();

        return $this->respondWithData($category, 401);
    }
}
