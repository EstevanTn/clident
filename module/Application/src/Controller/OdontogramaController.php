<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class OdontogramaController extends AbstractActionController {

    var $table;

    public function __construct(\Application\Model\OdontogramaTable $table){
        $this->table = $table;
    }

    public function indexAction(){
        return new ViewModel();
    }

    public function getAction(){
        $response = \Application\Model\Entity\Enviroment::AJAX_RESPONSE;
        if($this->getRequest()->isPost() && $this->getRequest()->isXmlHttpRequest()){
            $response = $this->table->get('ID_PACIENTE', $this->getRequest()->getPost('id', 0));
        }
        return new JsonModel($response);
    }

}