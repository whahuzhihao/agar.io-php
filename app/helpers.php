<?php
if (!function_exists("getConf")){
    function getConf($key = null){
        static $conf;
        if(!isset($conf)){
            $conf = \Noodlehaus\Config::load(APP_PATH.'/config.json');
        }
        if(is_null($key)){
            return $conf;
        }
        return $conf[$key];
    }
}

if (!function_exists("random01Float")) {
    function random01Float(){
        return mt_rand(1,mt_getrandmax()-1)/mt_getrandmax();
    }
}

if (!function_exists('massToRadius')){
    function massToRadius($mass) {
        return 4 + sqrt($mass) * 6;
    };
}

if (!function_exists('getDistance')) {
    function getDistance($p1, $p2) {
        return sqrt(pow($p2['x'] - $p1['x'], 2) + pow($p2['y'] - $p1['y'], 2)) - $p1['radius'] - $p2['radius'];
    };
}

//[$from, $to)
if (!function_exists('randomInRange')){
    function randomInRange($from, $to) {
        return $from + floor(mt_rand(0, mt_getrandmax()-1) / mt_getrandmax() * ($to - $from));
    };
}


if (!function_exists('uniformPosition')) {
    function uniformPosition($points, $radius){
        $bestCandidate = 0;
        $maxDistance = 0;
        $numberOfCandidates = 10;

        $lenPoints = count($points);
        if ($lenPoints === 0) {
            return randomPosition($radius);
        }

        //找到离所有人最远的一个点
        for ($ci = 0; $ci < $numberOfCandidates; $ci++) {
            $minDistance = INF;
            $candidate = randomPosition($radius);
            $candidate['radius'] = $radius;

            for ($pi = 0; $pi < $lenPoints; $pi++) {
                if(is_object($points[$pi]) && method_exists($points[$pi],'toPointArray')){
                    $distance = getDistance($candidate, $points[$pi]->toPointArray());
                }else{
                    $distance = getDistance($candidate, $points[$pi]);
                }
                if ($distance < $minDistance) {
                    $minDistance = $distance;
                }
            }

            if ($minDistance > $maxDistance) {
                $bestCandidate = $candidate;
                $maxDistance = $minDistance;
            } else {
                return randomPosition($radius);
            }
        }

        return $bestCandidate;
    }
}


if (!function_exists('randomPosition')) {
    function randomPosition($radius){
        $gameWidth = getConf('gameWidth');
        $gameHeight = getConf('gameHeight');

        return array(
            'x'=>randomInRange($radius, $gameWidth - $radius),
            'y'=>randomInRange($radius, $gameHeight - $radius)
        );
    }
}

if (!function_exists('findIndex')){
    function findIndex($arr, $id) {
        foreach($arr as $k => &$row){
            if($row->id == $id){
                return $k;
            }
        }
        return -1;
    };

}

if (!function_exists('object_to_array')){
    function object_to_array($obj){
        $_arr = is_object($obj)? get_object_vars($obj) :$obj;
        $arr = array();
        foreach ($_arr as $key => $val){
            $val=(is_array($val)) || is_object($val) ? object_to_array($val) :$val;
            $arr[$key] = $val;
        }
        return $arr;
    }
}