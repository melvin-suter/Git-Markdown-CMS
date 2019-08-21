<?php

class Install {

    public function run(){
      GLOBAL $app; 

      echo "<h1>Install</h1>";

      // Git Setup
      echo "Setup Git<br>";
      $app->git->clone();

      // Finish Installation
      echo "Finish Installation<br>";
      file_put_contents($app->sanitize->path('INSTALLED'),'INSTALLED');
      
      echo "<b>Please reload page</b>";
    }

}
