<?php

declare(strict_types=1);

namespace App\Application\Actions\Image;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;

class UpImageAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $params = $this->request->getParsedBody();

        $uploadedImages = $this->request->getUploadedFiles()['image'];

        $result = "";

        $directory = $this->settings->get('uploadDir');

        foreach ($uploadedImages as $key => $uploadedImage) {

            if ($uploadedImage->getError() === UPLOAD_ERR_OK) {
                $filename = $this->moveUploadedFile($directory, $uploadedImage);
                $result .= "uploaded ($key) $filename successfully";
            } else {
                $result .= "uploaded ($key) " . $uploadedImage->getClientFilename() . " failed: " . var_dump($uploadedImage->getError());
            }
        }


        return $this->respondWithData($result, 200);
    }


    protected function moveUploadedFile($dir, $uploadedFile)
    {
        $originName = $uploadedFile->getClientFilename();
        $basename = bin2hex(random_bytes(8));
        $filename = $basename . "-" . $originName;

        $uploadedFile->moveTo($dir . DIRECTORY_SEPARATOR . $filename);

        return $filename;
    }
}
