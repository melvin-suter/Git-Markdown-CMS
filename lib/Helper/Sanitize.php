<?php

class Sanitize {

  public function path($path){
    GLOBAL $CONFIG;

    if(substr($path,0,1) == '/'){ // Path is absolute
      return realpath($path));
    } else { // Relative path
      return realpath( $this->path($CONFIG['base_dir']) .'/'. $path);
    }
  }

}
