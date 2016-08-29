<?php
namespace App\Service;

class WSocketService
{
    private $logicService;

    public function __construct(){
        $this->logicService = new GameLogicService();
    }

    public function run(){
        $server = new \swoole_websocket_server("0.0.0.0", getConf('ws_port'));

        $server->set(array(
            'worker_num' => 1,   //工作进程数量
        ));

        $server->on('open', function (\swoole_websocket_server $server, $request) {
//            echo "server: handshake success with fd{$request->fd}\n";
        });

        $server->on('message', function (\swoole_websocket_server $server, $frame) {
//            echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
            $data = json_decode($frame->data, true);
            if($data && $data['action'] && $this->logicService->isRunning()){
                $result = $this->logicService->deal($data['action'], $data['data']);
                if($result){
                    $server->push($frame->fd, json_encode($result));
                }
            }
        });

        $server->on('close', function ($ser, $fd) {
            echo "client {$fd} closed\n";
        });

        $server->on('workerStart', function (\swoole_server $server,  $worker_id){
            $this->logicService->run();
        });

        $server->start();
    }

}