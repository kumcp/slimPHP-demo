<?php

declare(strict_types=1);

namespace App\Application\Actions\Category;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;

class UpdateCategoryAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $body = $this->request->getParsedBody();
        $name = $body['name'];

        $catId = $this->args['catId'];
        $statement = $this->db->prepare("UPDATE categories SET name=? WHERE id=?");
        $statement->execute([$name, $catId]);

        // $category = $statement->fetchAll();

        return $this->respondWithData("You have been updated successfully", 200);
    }
}
