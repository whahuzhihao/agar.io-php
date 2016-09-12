<?php
/**
 * Created by PhpStorm.
 * User: huzhihao
 * Date: 16/8/26
 * Time: 11:04
 */
namespace App\Entity;

class User extends Circle
{
    const TYPE_PLAYER = "player";
    const TYPE_SPECTATE = "spectate";

    public $id;//socketId
    public $w;
    public $h;
    public $cells;
    public $hue;
    public $type;
    public $lastHeartBeat;
    public $target;
    public $lastSplit;
    public $massTotal;

    public $screenWidth;
    public $screenHeight;
    public $name;
    public $admin;

    public function __construct($type = self::TYPE_PLAYER, $socketId = null, $name = "", $userPointList = array())
    {
        $this->id = $socketId;
        $this->cells = array();
        $this->lastHeartBeat = time();
        $this->lastSplit = 0;
        $this->target = new Vector(0, 0);
        $this->type = $type;
        $this->name = $name;
        $this->admin = false;

        $this->w = getConf('defaultPlayerMass');
        $this->h = getConf('defaultPlayerMass');
        $this->hue = round(random01Float() * 360);
        $radius = massToRadius(getConf("defaultPlayerMass"));
        $mass = 0;
        if($this->type === self::TYPE_PLAYER) {
            $position = getConf("newPlayerInitialPosition") == 'farthest' ? uniformPosition($userPointList, $radius) : randomPosition($radius);
            $mass = getConf("defaultPlayerMass");
            $this->cells[] =new Cell($position['x'], $position['y'], $radius, $mass);
        }else{
            $position['x'] = null;
            $position['y'] = null;
        }
        $this->massTotal= $mass;
        parent::__construct($position['x'], $position['y']);
    }
}