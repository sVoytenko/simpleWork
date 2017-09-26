<?php

namespace App\Controllers;

/**
 * Description of IndexController
 *
 * @author home
 */
class IndexController extends \Core\BaseController
{
    protected $sorte;
    protected $page;
    protected $search;
    protected $gateaway;


    public function __construct($routeParams)
    {
        parent::__construct($routeParams);
        $this->sorte = $this->routeParams['sorte'];
        $this->page = $this->routeParams['page'];
        $this->search = $this->routeParams['subject'];;
        $this->search = $this->routeParams['subject'];
        
        $this->gateaway = new \App\Models\StudentsGateaway();
    }
    
    public function indexAction()
    {
        $order = 'name';
        
        $students = $this->gateaway->getAllStudents($order);
        var_dump($students);
    }
    
    public function searchAction()
    {
        echo "Страница поиска по параметрам {$this->search}";
    }
}
