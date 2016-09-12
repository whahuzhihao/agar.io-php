<?php
namespace App\Service;

class WSocketService
{
    private $logicService;

    public function __construct(){

    }

    public function run(){
        $server = new \swoole_websocket_server("0.0.0.0", getConf('ws_port'));
        $this->logicService = new GameLogicService($server);

        $server->set(array(
            'worker_num' => 1,   //工作进程数量
        ));

        $server->on('open', function (\swoole_websocket_server $server, $request) {
//            echo "server: handshake success with fd{$request->fd}\n";
        });

        $server->on('message', function (\swoole_websocket_server $server, $frame) {
//            echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
            $data = json_decode($frame->data, true);
            if($data && !is_null($data['action']) && $this->logicService->isRunning()){
                $this->logicService->deal($data['action'], $data['data'] ? $data['data'] : null, $frame->fd);
            }
        });

        $server->on('close', function ($ser, $fd) {
            $this->logicService->deal("disconnect", null ,$fd);
            echo "client {$fd} closed\n";
        });

        $server->on('workerStart', function (\swoole_server $server,  $worker_id){
            $this->logicService->run();
        });

        $server->start();
    }

}