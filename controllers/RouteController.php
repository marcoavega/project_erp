<?php

class RouteController{

    public function loadPage($url){
        
        $viewsDirectory = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'pages' . DIRECTORY_SEPARATOR;
        
        $url = trim($url, "/ ");

        $file = $viewsDirectory . $url . '.php';

        if (file_exists($file)) {
            include $file;
        } else {
            include $viewsDirectory . '404.php';
        }
    }

}
?>