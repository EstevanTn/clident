<?php
namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;

class ControllerName extends AbstractHelper
{

    protected $routeMatch;

    public function __construct($routeMatch)
    {
        $this->routeMatch = $routeMatch;
    }
    
    public function __invoke()
    {
        if ($this->routeMatch) {
            $controller = $this->routeMatch->getParam('controller', 'index');
            return strtolower(substr($controller, 23, -10));
        }
    }
}