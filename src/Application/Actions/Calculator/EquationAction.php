<?php

declare(strict_types=1);

namespace App\Application\Actions\Calculator;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;

class EquationAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        // Get param
        $body = $this->request->getParsedBody();

        $a = $body['a'];
        $b = $body['b'];
        $c = $body['c'];

        // Calculate x
        $result = $this->calculateEquation($a, $b, $c);

        // Write result into response
        return $this->respondWithData("$result");
    }

    protected function calculateEquation($a, $b, $c)
    {
        $delta = $b * $b - 4 * $a * $c;

        if ($delta > 0) {
            $x1 = (-$b + sqrt($delta)) / (2 * $a);
            $x2 = (-$b - sqrt($delta)) / (2 * $a);

            return "PT co 2 nghiem phan biet: x1 = $x1, x2 = $x2";
        }

        if ($delta === 0) {
            $x = floatval(-$b) / (2 * $a);
            return "PT co nghiem duy nhat: x = $x";
        }

        return "PT vo nghiem";
    }
}
