<?php

declare(strict_types=1);

namespace App\Application\Actions\Posts;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;

class DeletePostAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $postId = $this->args['postId'];

        $body = $this->request->getParsedBody();

        try {
            $db = $this->db;
            $statement = $db->prepare("DELETE FROM posts WHERE id=?");
            $statement->execute([$postId]);
        } catch (\Throwable $th) {
            return $this->respondWithData($th->getMessage());
        }

        return $this->respondWithData("Data has been deleted successfully");
    }
}
