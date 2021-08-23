<?php

declare(strict_types=1);

namespace App\Application\Actions\Posts;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;

class GetAllPostAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $statement = $this->db->prepare("SELECT * FROM posts");
        $statement->execute();

        $posts = $statement->fetchAll();

        $previousItem = $_SESSION['detail'] ?? $_SESSION['detail'] ?? 0;

        $_SESSION['admin'] = 1;

        if ($previousItem == 0) {
            $message = "You have see not see details of any items";
        } else {
            $message = "You have see details of item $previousItem";
        }

        return $this->respondWithData(compact("message", "posts"));
    }
}
