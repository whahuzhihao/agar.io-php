<?php
/**
 * Created by PhpStorm.
 * User: huzhihao
 * Date: 16/8/26
 * Time: 11:04
 */
namespace App\Entity;

class MassFood extends Circle{
    public $id;
    public $hue;
    public $masa;
    public $target;
    public $speed;

    public function __construct($id, $num, $x = 0, $y = 0, $radius = 0, $mass = 0, $hue = 0, $target = null, $speed = 0){
        $this->id = $id;
        $this->num = $num;
        $this->hue = $hue;
        $this->masa = $mass;
        $this->target = $target;
        $this->speed = $speed;
        $this->num = $num;
        parent::__construct($x,$y,$radius);
    }
}