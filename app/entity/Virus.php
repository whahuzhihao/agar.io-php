<?php
/**
 * Created by PhpStorm.
 * User: huzhihao
 * Date: 16/8/26
 * Time: 11:04
 */
namespace App\Entity;

class Virus extends Circle{
    protected $id;
    protected $fill;
    protected $stroke;
    protected $strokeWidth;

    public function __construct($id, $x = 0, $y = 0, $radius = 0, $mass = 0, $fill = 0, $stroke = 0, $strokeWidth = 0){
        $this->id = $id;
        $this->fill = $fill;
        $this->stroke = $stroke;
        $this->strokeWidth = $strokeWidth;
        parent::__construct($x,$y,$radius,$mass);
    }
}