<?php


class Car
{
    public $name;
    public $model;
    public $color;

    public function __construct($name, $model, $color)
    {
        $this->name = $name;
        $this->model = $model;
        $this->color = $color;
    }

    public function rename($newName)
    {
        $this->name = $newName;
    }

    public function changeColor($newColor)
    {
        $this->color = $newColor;
    }

    const DEVICE_MATERIAL = 'iron';

    public static function getMaterial()
    {
        return self::DEVICE_MATERIAL;
    }

    public static function countCarAmount($nguoiBan)
    {
        return $nguoiBan['doanhThu'];
    }
}

class Car2Banh extends Car
{
    public function __construct($name, $model, $color, $weight)
    {
        parent::__construct($name, $model, $color);
        $this->weight = $weight;
    }
}

$carX = new Car("Family car", "Toyota", "blue");

// $carX->rename("Business car")->changeColor("red");

$$carX->changeColor("red");
$carX->rename("Business car");
