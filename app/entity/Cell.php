<?php
/**
 * Created by PhpStorm.
 * User: huzhihao
 * Date: 16/8/26
 * Time: 11:04
 */
namespace App\Entity;

class Cell extends Circle{
    public $mass;
    public $speed;

    public function __construct($x = 0, $y = 0, $radius = 0, $mass = 0, $speed = null){
        $this->mass = $mass;
        $this->speed = is_null($speed)? 25 : $speed;
        parent::__construct($x, $y, $radius);
    }
}