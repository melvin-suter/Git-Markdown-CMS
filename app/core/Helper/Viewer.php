<?php

use Pagerange\Markdown\MetaParsedown;

class Viewer {

    public function view($route) {
      GLOBAL $app;
      
      // Parse Data
      $parsedData = $this->route($route);

      // Create Data Array
      $data = [];
      $data['title'] = '';
      $data['url'] = $app->sanitize->url($route);
      $data['content'] = $parsedData[0];
      $data['meta'] = $parsedData[1];
      $data['menu'] = $this->generateMenu();
        
      $page = (object)$data;
      if(isset($page->meta['layout']) && file_exists($app->config->app_dir.'/template/'.$page->meta['layout'].'.php')) {
          require($app->config->app_dir.'/template/'.$page->meta['layout'].'.php');
      } else {
          require($app->config->app_dir.'/template/default.php');
      }
    }

    public function route($route,$pulled = false){
        GLOBAL $app;

        // Check if file exists
        if(file_exists($app->config->repo_dir.'/'.$route)){
            return $this->parseFile($app->config->repo_dir.'/'.$route);
        }

        // Check if file.md exists
        if(file_exists($app->config->repo_dir.'/'.$route.'.md')){
            return $this->parseFile($app->config->repo_dir.'/'.$route.'.md');
        }

        if($pulled == false){
          $app->git->pull();
          $this->route($route,true);
        }else{
            if($route != '404'){
                return "<h1>404</h1>";
            } else {
                $this->route('404');
            }
        }

        return "";
    }



    public function parseFile($file){
        $Parsedown = new MetaParsedown();
        return [$Parsedown->text(file_get_contents($file)), $Parsedown->meta(file_get_contents($file))];
    }

    public function generateMenu($dir = null){
        GLOBAL $app;

        // Catch Default 
        $dir = $dir == null? $app->config->repo_dir : $dir;

        $menu = [];
        foreach(scandir($dir) as $item){
          // Hidden or system-dir
          if(substr($item,0,1) == '.')
            continue;
          
          // Array index = relative path
          $index = substr($dir.'/'.$item,strlen($app->config->repo_dir) + 1);

          // If file add item to array, if dir recurse function
          if(is_file($dir.'/'.$item)){
            // Get data
            $meta = $this->parseMeta($dir.'/'.$item);
            if(isset($meta['inmenu']) && ($meta['inmenu'] == 'yes' || $meta['inmenu'] == true)) {
                $shortIndex = (substr($index,-3) == '.md' ? substr($index,0,-3) : $index);
                $filename = basename($shortIndex);

                // Create Data
                $menu[$index] = [
                    'name' =>  isset($meta['menu']) ? $meta['menu'] : (isset($meta['title']) ? $meta['title'] : $filename),
                    'meta' => $meta, 
                    'url' => $app->sanitize->url( $shortIndex ),
                ]; 
            }
          } else {
            $generatedMenu = $this->generateMenu($dir.'/'.$item);
            if(count($generatedMenu) > 0){ // Check if has children
                $menu[$index] = $generatedMenu;
            }
          }
        }
        return $menu;
    }

    public function parseMeta($file){
        $Parsedown = new MetaParsedown();
        return $Parsedown->meta(file_get_contents($file));
    }

    // generates a ul-li menu from menu-array
    public function generateMenuList($menu){
        $html = '<ul>';

        foreach($menu as $key => $item){
            if(isset($item['name'])) { // page
                $html .= '<li><a href="'.$item['url'].'">'.$item['name'].'</a></li>';
            } else { // submenu
                $html .= '<li>'.$key;
                $html .= $this->generateMenuList($item);
                $html .= '</li>';
            }
        }

        $html .= '</ul>';

        return $html;
    }
}
