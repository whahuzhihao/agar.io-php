<?php
/**
 * Created by PhpStorm.
 * User: huzhihao
 * Date: 16/8/26
 * Time: 11:04
 */
namespace App\Entity;

class Vector {
    protected $x;
    protected $y;
    public function __construct($x = 0, $y = 0){
        $this->x = $x;
        $this->y = $y;
    }

    public function __set($name,$value){
        $this->$name = $value;
    }

    public function __get($name){
        return $this->$name;
    }

}