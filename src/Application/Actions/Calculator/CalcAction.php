<?php

declare(strict_types=1);

namespace App\Application\Actions\Calculator;

// use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;

class CalcAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $body = $this->request->getParsedBody();

        $num1 = $body['num1'];
        $num2 = $body['num2'];
        $operator = $body['operator'];

        $result = $this->actionWith2Number($num1, $num2, $operator);

        // $body = $this->getFormData();
        return $this->respondWithData("$num1 $operator $num2 = $result");
    }


    protected function actionWith2Number($number1, $number2, $operator)
    {
        switch ($operator) {
            case 'cong':
                $result = $number1 + $number2;
                break;
            default:
                $result = "?";
        }

        return $result;
    }
}
