<?php

class Sanitize {

  public function path($path){
    GLOBAL $app;
   
    // Add base_dir if relative
    $path = substr($path,0,1) == '/' ? $path : $app->config->base_dir .'/'. $path;

    return array_reduce(explode('/', $path), create_function('$a, $b', '
        if($a === 0)
            $a = "/";

        if($b === "" || $b === ".")
            return $a;

        if($b === "..")
            return dirname($a);

        return preg_replace("/\/+/", "/", "$a/$b");
    '), 0);
  }

  public function url($url){
    GLOBAL $app;
    $url = strtolower($url);

    if(substr($url,0,7) == 'http://' || substr($url,0,8) == 'https://'){
      return $url;
    } else {
      return $app->config->base_url.(substr($url,0,1) == '/' ? $url : '/'.$url);
    }
  }

}
