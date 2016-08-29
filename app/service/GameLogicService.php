<?php
namespace App\Service;
use App\Entity\User;
use App\Entity\Food;
use App\Entity\Virus;
use App\Entity\Circle;

class GameLogicService
{
    private $ifRun;

    private $moveloopId;
    private $gameloopId;
    private $sendUpdatesId;

    private $userList;
    private $food;
    private $virus;


    private $leaderBoard;
    private $leaderBoardChanged;

    public function __construct(){
        $this->userList = array();
        $this->food = array();
        $this->virus = array();

        $this->leaderBoard = array();
        $this->leaderBoardChanged = false;

        $this->ifRun = false;
    }

    public function run(){
        $this->moveloopId = \swoole_timer_tick(1000 / 60, function(){$this->moveloop();});
        $this->gameloopId = \swoole_timer_tick(1000, function(){$this->gameloop();});
        $this->sendUpdatesId = \swoole_timer_tick(1000 / getConf('networkUpdateFactor'), function(){$this->sendUpdates();});

        $this->ifRun = true;
    }


    private function addFood($toAdd) {
        $radius = massToRadius(getConf('foodMass'));
        while ($toAdd--) {
            $position = getConf('foodUniformDisposition') ? uniformPosition($this->food, $radius) : randomPosition($radius);
            //TODO uniqid ((new Date()).getTime() + '' + food.length) >>> 0,
            $id = 0;
            $mass = random01Float() + 2;
            $this->food[]= new Food($id, $position['x'], $position['y'], $radius, $mass,round(random01Float(0,1) * 360));
        }
    }

    private function addVirus($toAdd) {
        while ($toAdd--) {
            $mass = randomInRange(getConf('virus')['defaultMass']['from'], getConf('virus')['defaultMass']['to']);
            $radius = massToRadius($mass);
            $position = getConf('virusUniformDisposition') ? uniformPosition($this->virus, $radius) : randomPosition($radius);
            //TODO
            $id = 0;
            $fill = getConf('virus')['fill'];
            $stroke = getConf('virus')['stroke'];
            $strokeWidth = getConf('virus')['strokeWidth'];
            $this->virus[] = new Virus($id, $position['x'], $position['y'], $radius, $mass, $fill, $stroke, $strokeWidth);
        }
    }

    private function removeFood($toRem) {
        while ($toRem--) {
            array_pop($this->food);
        }
    }

    private function balanceMass(){
        $foodMass = count($this->food) * getConf('foodMass');
        $userMass = array_reduce(array_map(function($v){return $v->mass;}, $this->userList),function($a,$b){return $a+$b;},0);
        $totalMass = $foodMass + $userMass;
        $massDiff = getConf('gameMass') - $totalMass;
        $maxFoodDiff = getConf('maxFood') - count($this->food);
        $foodDiff = floor($massDiff/ getConf('foodMass')) - $maxFoodDiff;
        $foodToAdd = min($foodDiff, $maxFoodDiff);
        $foodToRemove = -max($foodDiff, $maxFoodDiff);
        if ($foodToAdd > 0) {
            //console.log('[DEBUG] Adding ' + foodToAdd + ' food to level!');
            $this->addFood($foodToAdd);
            //console.log('[DEBUG] Mass rebalanced!');
        } elseif ($foodToRemove > 0) {
            //console.log('[DEBUG] Removing ' + foodToRemove + ' food from level!');
            $this->removeFood(foodToRemove);
            //console.log('[DEBUG] Mass rebalanced!');
        }

        $virusToAdd = getConf('maxVirus') - count($this->virus);

        if ($virusToAdd > 0) {
            $this->addVirus($virusToAdd);
        }
    }


    private function moveloop(){

    }

    private function gameloop(){
        if (count($this->userList) > 0){
            //按质量降序
            usort($this->userList, function(User $a, User $b){
                return $b->mass - $a->mass;
            });

            //更新排行榜
            $topUsers = array();
            $userLen = count($this->userList);
            for($i = 0; $i < min(10, $userLen); $i++){
                if($this->userList[$i]->type == User::TYPE_PLAYER){
                    $topUsers[] = array(
                        "id" => $this->userList[$i]->id,
                        "name" => $this->userList[$i]->name,
                    );
                }
            }
            if(empty($this->leaderBoard) || count($this->leaderBoard) != count($topUsers)){
                $this->leaderBoardChanged = true;
                $this->leaderBoard = $topUsers;
            }else {
                $leaderLen = count($this->leaderBoard);
                for ($i = 0; $i < $leaderLen; $i++) {
                    if ($this->leaderBoard[$i]["id"] != $topUsers[$i]["id"]) {
                        $this->leaderBoard = $topUsers;
                        $this->leaderBoardChanged = true;
                        break;
                    }
                }
            }
            //质量流失
            for ($i = 0; $i < $userLen; $i++) {
                $cellLen = count($this->userList[$i]->cells);
                for($z=0; $z < $cellLen; $z++) {
                    if ($this->userList[$i]->cells[$z]->mass * (1 - (getConf('massLossRate') / 1000)) > getConf('defaultPlayerMass') && $this->userList[$i]->mass > getConf('minMassLoss')) {
                        $massLoss = $this->userList[$i]->cells[$z]->mass * (1 - (getConf('massLossRate') / 1000));
                        $this->userList[$i]->mass -= $this->userList[$i]->cells[$z]->mass - $massLoss;
                        $this->userList[$i]->cells[$z]->mass = $massLoss;
                    }
                }
            }
        }
        $this->balanceMass();
    }

    private function sendUpdates(){

    }


    public function isRunning(){
        return $this->ifRun;
    }
}