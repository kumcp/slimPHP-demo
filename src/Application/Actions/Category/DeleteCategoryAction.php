<?php

declare(strict_types=1);

namespace App\Application\Actions\Category;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;

class DeleteCategoryAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $catId = $this->args['catId'];
        $statement = $this->db->prepare("DELETE FROM categories WHERE id=?");
        $statement->execute([$catId]);

        return $this->respondWithData("You have been deleted category successfully", 200);
    }
}
