<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Helper\ViewModel;

class OdontogramaController extends AbstractActionController {

    var $table;

    public function __construct(\Application\Model\OdontogramaTable $table){
        $this->table = $table;
    }
}