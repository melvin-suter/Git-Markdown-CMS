<?php

class Git {

  public function clone(){
    GLOBAL $app;
    exec($app->config->git_bin.' clone -c http.sslVerify=false '.$app->config->git_repo.' '.$app->config->repo_dir);
  }

  public function pull(){
    GLOBAL $app;
    exec($app->config->git_bin.' -c http.sslVerify=false --git-dir='.$app->config->repo_dir.'/.git --work-tree='.$app->config->repo_dir.' pull origin master');
  }

}
