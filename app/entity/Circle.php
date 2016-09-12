<?php
/**
 * Created by PhpStorm.
 * User: huzhihao
 * Date: 16/8/26
 * Time: 11:04
 */
namespace App\Entity;

class Circle extends Vector{
    public $radius;

    public function __construct($x = 0, $y = 0, $radius = 0){
        $this->x = $x;
        $this->y = $y;
        $this->radius = $radius;
    }

    public function toPointArray(){
        return array(
            'x' => $this->x,
            'y' => $this->y,
            'radius' => $this->radius
        );
    }
}