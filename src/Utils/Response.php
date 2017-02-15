<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace  DevTics\LaravelHelpers\Utils;
use \Illuminate\Support\Facades\File;
/**
 * Description of SocketIOClient
 *
 * @author jdiaz
 */
class Response {
   public static function cacheHeaders() {
        header('Pragma: public');
        header('Cache-Control: max-age=86400');
        header('Last-Modified: '.gmdate('r', time()));
        header('Expires: '.gmdate('r', time() + 1800));  
    }
    public static function dataWithCacheHeaders($data, $mime){
        self::cacheHeaders();
        header('Content-Type: '. $mime);
        echo $data;
        die();
    }
    public static function fileContentWithCacheHeaders($file) {
        self::cacheHeaders();
        header('Content-Type: '. File::mimeType($file));
        echo File::get($file);
        die();
    }
    
}
