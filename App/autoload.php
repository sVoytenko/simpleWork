<?php
/* обычная автозагрузка */
spl_autoload_register(function($class){
    $root = dirname(__DIR__);
    $file = $root . '/' . str_replace('\\', '/', $class . '.php');
    if(file_exists($file)){
        require $root . '/' . str_replace('\\', '//', $class) . '.php';
    }
});