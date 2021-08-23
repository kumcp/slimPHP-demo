<?php

declare(strict_types=1);

namespace App\Application\Actions\Posts;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;

class GetDetailPostAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $postId = $this->args['postId'];
        $statement = $this->db->prepare("SELECT * FROM posts WHERE id=?");
        $statement->execute([$postId]);

        $post = $statement->fetchAll();
        $_SESSION['detail'] = $postId;
        return $this->respondWithData($post);
    }
}
