<?php
namespace App\Service;

class HTTPService
{
    public function run(){
        $http = new \swoole_http_server("0.0.0.0", getConf("http_port"));
        $http->set(array(
            'worker_num' => 1,   //工作进程数量
        ));
        $http->on('request', function ($request, $response) {
            if($request->server['request_uri'] == "/"){
                $response->end(file_get_contents(STATIC_PATH."/index.html"));
            }elseif(file_exists(STATIC_PATH.$request->server['request_uri'])){
                switch(pathinfo(STATIC_PATH.$request->server['request_uri'], PATHINFO_EXTENSION)){
                    case "html":
                        $response->header("Content-Type","text/html;charset=utf-8");
                        break;
                    case "js":
                        $response->header("Content-Type","application/x-javascript");
                        break;
                    case "mp3":
                        $response->header("Content-Type","audio/mpeg");
                        break;
                    case "css":
                        $response->header("Content-Type","text/css");
                        break;
                    case "png":
                        $response->header("Content-Type","image/png");
                        break;
                }
                $response->end(file_get_contents(STATIC_PATH.$request->server['request_uri']));
            }else{
//                $response->header("", "");
//                $response->end("<h1>NOT FOUND</h1>");
            }
        });
        $http->start();
    }

}