<?php

class App {

  public $git;
  public $sanitize;

  function __construct(){
    $this->git = new Git();
    $this->sanitize = new Sanitize();
  }

  function run(){
    // Check if is installed
    if(file_exists($this->sanitize->path('INSTALLED'))) { // Installed
    } else { // Run Installation 
        $installer = new Install();
        $installer->run();
    }
  }
}
