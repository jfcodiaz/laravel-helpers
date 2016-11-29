<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace DevTics\Libs\Helpers;

use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version1X;
/**
 * Description of SocketIOClient
 *
 * @author jdiaz
 */
class SocketIOClientVX1 {
    private $elephanIo = null;
    
    public function __construct($url=false) {
        $this->elephanIo = self::getElephantIO($url);
    }
    
    public function emmit($event, $data, $close=true){
        $r = $client->emit($event, $data);
        if($close) {
            $client->close();
        }
        return $r;
    }
    
    public static function staticEmmit($event, $data, $returnClient=false, $url = false) {
        die("---");
        $obj = new DevTics\Libs\Helpers\SocketIOClientVX1($url);
        $r = $obj->emmit($event, $data, !$returnClient);
        if($returnClient){
            return $obj;
        }
        return $r;
    }
    
    public static function getElephantIO($url=false){
        if(!$url) {
            $url = env("SOCKETIO_SERVER");   
        }
        $cient = new Client(new Version1X($url));
        $client->initialize();
        return $client;
        
    }
    
}
