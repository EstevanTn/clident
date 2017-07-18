<?php
namespace Application\Controller;

use Application\Model\Entity\Enviroment;
use Application\Model\TratamientoTable;
use const false;
use Zend\View\Model\JsonModel;

class TratamientoController extends \Zend\Mvc\Controller\AbstractActionController {

    var $table;

    public function __construct(TratamientoTable $table){
        $this->table = $table;
    }

    public function indexAction()
    {
        return new \Zend\View\Model\ViewModel();
    }

    public function getAllAction(){
        $response = Enviroment::AJAX_TABLE;
        if($this->getRequest()->isPost() && $this->getRequest()->isXmlHttpRequest()){
            $response = [
                'data'  => $this->table->fetchAll(),
            ];
        }
        return new JsonModel($response);
    }

    public function guardarAction(){
        $response = Enviroment::AJAX_RESPONSE;
        if($this->getRequest()->isPost() && $this->getRequest()->isXmlHttpRequest()){
            $data = [
                'ID_TRATAMIENTO' => $this->getRequest()->getPost('id', 0),
                'NOMBRE' => $this->getRequest()->getPost('nombre',''),
                'DESCRIPCION' => $this->getRequest()->getPost('descripcion',''),
                'APLICA_CARA' => $this->getRequest()->getPost('aplicaCara', 0),
                'APLICA_DIENTE' => $this->getRequest()->getPost('aplicaDiente', 0),
                'PRECIO' => $this->getRequest()->getPost('precio', 0)
            ];
            $response = $this->table->save(Enviroment::GetCookieValue('ID_USUARIO'), $data);
        }
        return new JsonModel($response);
    }

    public function getAction(){
        $response = Enviroment::AJAX_RESPONSE;
        if($this->getRequest()->isPost() && $this->getRequest()->isXmlHttpRequest()){
            $response = $this->table->get('ID_TRATAMIENTO', $this->getRequest()->getPost('id', 0));
        }
        return new JsonModel($response);
    }

    public function eliminarAction(){
        $response = Enviroment::AJAX_RESPONSE;
        if($this->getRequest()->isPost() && $this->getRequest()->isXmlHttpRequest()){
            $response = $this->table->delete(Enviroment::GetCookieValue('ID_USUARIO'), 'ID_TRATAMIENTO', $this->getRequest()->getPost('id', 0));
        }
        return new JsonModel($response);
    }
    
}