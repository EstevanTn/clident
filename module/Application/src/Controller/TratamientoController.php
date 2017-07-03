<?php
namespace Application\Controller;

class TratamientoController extends \Zend\Mvc\Controller\AbstractActionController {

    var $table;

    public function __construct(\Application\Model\TratamientoTable $table){
        $this->table = $table;
    }

    public function indexAction()
    {
        return new \Zend\View\Model\ViewModel();
    }

    public function getAllAction(){
        $response = \Application\Model\Entity\Enviroment::AJAX_TABLE;
        if($this->getRequest()->isPost() && $this->getRequest()->isXmlHttpRequest()){
            $response = [
                'data'  => $this->table->fetchAll(),
            ];
        }
        return new \Zend\View\Model\JsonModel($response);
    }

    public function guardarAction(){
        return new \Zend\View\Model\JsonModel();
    }

    public function getAction(){
        return new \Zend\View\Model\JsonModel();
    }

    public function eliminarAction(){
        return new \Zend\View\Model\JsonModel();
    }
    
}