<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class OdontogramaController extends AbstractActionController {

    var $table;

    public function __construct(\Application\Model\OdontogramaTable $table){
        $this->table = $table;
    }

    public function indexAction(){
        return new ViewModel();
    }
}