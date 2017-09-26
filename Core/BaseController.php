<?php
namespace Core;

/**
 * Description of BaseController
 *
 * @author home
 */
abstract class BaseController
{
    protected $routeParams = [];
    
    public function __construct(array $routeParams)
    {
        $this->routeParams = $routeParams;
    }
    
    public function __call($name, $arguments)
    {
        $method = $name . 'Action';
        $this->$method();
    }
    
    protected function beforeAction()
    {
        return TRUE;
    }
}
