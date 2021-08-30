<?php

declare(strict_types=1);

namespace App\Application\Actions\Image;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Psr7\Stream;

class DownImageAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        if ($_SESSION && array_key_exists("admin", $_SESSION) && $_SESSION["admin"] === 1) {
            $directory = $this->settings->get('uploadDir');
            $path = $directory . '/5371108c027eadca.csv';

            $fh = fopen($path, 'rb');
            $file_stream = new Stream($fh);

            return $this->response->withBody($file_stream)
                ->withHeader('Content-Disposition', 'attachment; filename=file.csv;')
                ->withHeader('Content-Type', mime_content_type($path))
                ->withHeader('Content-Length', filesize($path));
        } else {
            return $this->respondWithData("You do not have permission to download", 200);
        }
    }
}
