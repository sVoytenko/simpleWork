<?php

namespace Core;

class Router
{
    public $routes = [];
    protected $params = [];
    protected $queryParams = [];

    public function addRoute(string $route, string $controller, string $action, string $namespace = 'Controllers')
    {
        //экранируем слеши внутри
        $route = preg_replace('/\//', '\\/', $route); 
        //оборачиваем параметры в фигурных скобах элементами регулярки
        $route = preg_replace('/\{([\w\d-]+)\}/', '(?P<\1>[\w\d-]+)', $route);
        //оформляем необходимые для регулярки элементы
        $route = '/^' . $route . '$/';
        
        $this->routes[] = ['route' => $route, 'controller' => $controller, 'action' => $action, 'namespace' => $namespace];
    }
    
    //местод сопоставляет входящий uri с роутами, хранящямися в массиве $routes
    protected function matchUri($uri)
    {
        foreach ($this->routes as $route) {
            if (preg_match($route['route'], $uri, $matches)) {
                $this->params['route'] = $route['route'];
                $this->params['controller'] = $route['controller'];
                $this->params['action'] = $route['action'];
                $this->params['namespace'] = $route['namespace'];
                //цикл необходим, т.к. совпадения как и с цифровы индексом, так и с ассоциативным
                foreach ($matches as $param => $value) {
                    if (is_string($param)) $this->queryParams[$param] = $value;
                }
                return TRUE;
            }

        }
        return false;
    }
    
    //запус приложения - поиск необходимого контроллера, его создание и вызо экшена
    public function run()
    {
        $uri = $this->removeQueryStringVariables($_SERVER['QUERY_STRING']);
        
        if(!$this->matchUri($uri)){
            echo 'Нет совпадающего роута!';
            return FALSE;
        } 
        
        $namespace = $this->params['namespace'];
        $controller = 'App\\' . $namespace . '\\' . ucfirst(strtolower($this->params['controller'])) . 'Controller';
        $action = strtolower($this->params['action']);
        
        if(class_exists($controller)){
            $controller = new $controller($this->queryParams);
        } else {
            echo "Контроллер {$controller} для роута {$this->queryParams['route']} не найден!";
            return false;
        }
        call_user_func_array([$controller, $action], $this->queryParams);
        return TRUE;
    }
    
    //метод очищает ури от переменных get строки
    protected function removeQueryStringVariables(string $url)
    {
        if($url != ''){
            $parts = explode('&', $url, 2);
            if(strpos($parts[0], '=') === false){
                $url = $parts[0];
            } else {
                $url = '';
            }
        }
        return $url;
    }
    

}
