<?php
/**
 * Created by PhpStorm.
 * User: huzhihao
 * Date: 16/8/26
 * Time: 11:04
 */
namespace App\Entity;

class TreePoint extends \QuadTrees\QuadTreeXYPoint{
    public $user;

    public function __construct($x = 0.0, $y = 0.0, User &$user = null){
        $this->user = $user;
        parent::__construct($x,$y);
    }
}