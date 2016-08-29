<?php
/**
 * Created by PhpStorm.
 * User: huzhihao
 * Date: 16/8/26
 * Time: 11:04
 */
namespace App\Entity;

class Food extends Circle{
    protected $id;
    protected $hue;

    public function __construct($id, $x = 0, $y = 0, $radius = 0, $mass = 0, $hue = 0){
        $this->id = $id;
        $this->hue = $hue;
        parent::__construct($x,$y,$radius,$mass);
    }
}