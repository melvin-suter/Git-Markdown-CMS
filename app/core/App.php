<?php

class App {

  public $git;
  public $sanitize;
  public $config;
  private $defaultconfig;

  function __construct(){
    GLOBAL $CONFIG;

    // Create defaultconfig
    $this->defaultconfig  = [
        'git_repo' => '',
        'repo_dir' => __DIR__.'/../../data/',
        'git_bin'  => '/bin/git',
        'base_dir' => __DIR__.'/../../',
        'app_dir' => __DIR__.'/..',
        'base_url' => 'https://'.$_SERVER['HTTP_HOST'],
    ];

    // Assign Properties
    $this->git = new Git();
    $this->sanitize = new Sanitize();
    $this->viewer = new Viewer();
    $this->config = (object)array_merge($this->defaultconfig,$CONFIG);

    // Sanitize Paths
    $this->config->repo_dir = $this->sanitize->path($this->config->repo_dir);
    $this->config->git_bin = $this->sanitize->path($this->config->git_bin);
    $this->config->base_dir = $this->sanitize->path($this->config->base_dir);
    $this->config->app_dir = $this->sanitize->path($this->config->app_dir);
  }

  function run(){
    // Check if is installed
    if(file_exists($this->config->app_dir.'/INSTALLED')) { // Installed
        $route = isset($_GET['p']) ? $_GET['p'] : 'index'; // Get Route
        $route = strlen(trim($route)) > 0 ? $route : 'index'; // If empty or whitespace return to default
        $this->viewer->view($route);
    } else { // Run Installation 
        $installer = new Install();
        $installer->run();
    }
  }
}
