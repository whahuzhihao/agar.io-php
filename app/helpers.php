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
    function uniformPosition($poitns, $radius){
        //TODO
        return randomPosition($radius);

        $bestCandidate = 0;
        $maxDistance = 0;
        $numberOfCandidates = 10;

        if (count($points) === 0) {
            return randomPosition($radius);
        }

//        for ($ci = 0; $ci < $numberOfCandidates; $ci++) {
//                $minDistance = Infinity;
//                $candidate = exports.randomPosition(radius);
//                candidate.radius = radius;
//
//                for ($pi = 0; pi < points.length; pi++) {
//                    $distance = exports.getDistance(candidate, points[pi]);
//                if (distance < minDistance) {
//                    minDistance = distance;
//                }
//            }
//
//            if (minDistance > maxDistance) {
//                bestCandidate = candidate;
//                maxDistance = minDistance;
//            } else {
//                return exports.randomPosition(radius);
//            }
//        }
//
//        return bestCandidate;
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
