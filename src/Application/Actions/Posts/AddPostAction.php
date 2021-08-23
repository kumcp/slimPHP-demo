<?php

declare(strict_types=1);

namespace App\Application\Actions\Posts;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;

class AddPostAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $body = $this->request->getParsedBody();

        $title = $body['title'];
        $content = $body['content'];
        $categoryId = $body['category_id'];
        try {
            $db = $this->db;
            $statement = $db->prepare("INSERT INTO posts (title, content, category_id) VALUES (?, ?, ?)");
            $statement->execute([$title, $content, $categoryId]);
        } catch (\Throwable $th) {
            return $this->respondWithData($th->getMessage());
        }

        return $this->respondWithData("Data has been saved successfully");
    }
}
