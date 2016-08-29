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

    private $socket;
    private $w;
    private $h;
    private $cells;
    private $hue;
    private $type;
    private $lastHeartBeat;
    private $target;

    private $name;
    private $id;

    public function __construct($type = self::TYPE_PLAYER, $socket = null, $userPointList = array())
    {
        $this->socket = $socket;
        $this->cells = array();
        $this->lastHeartBeat = time();
        $this->target = new Vector(0, 0);
        $this->type = $type;

        $this->hue = round(random01Float() * 360);
        $radius = massToRadius(getConf("defaultPlayerMass"));
        $position = getConf("newPlayerInitialPosition") == 'farthest' ? uniformPosition($userPointList, $radius) : randomPosition($radius);

        $mass = 0;
        if($this->type === self::TYPE_PLAYER) {
            $this->cells = array(new Circle($position['x'], $position['y'], $radius, $mass));
            $mass = getConf("defaultPlayerMass");
        }
        parent::__construct($position['x'], $position['y'], $radius, $mass);
    }

    public function toPointArray(){
        return array(
            $this->x,
            $this->y
        );
    }
}