<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Application\Model\PacienteTable as PacienteTable;

class PacienteController extends AbstractActionController
{
	var $table = null;

    public function __construct(PacienteTable $table){
      $this->table = $table;
    }

    public function indexAction()
    {
        return new ViewModel();
    }
    public function guardarAction(){
        $response = \Application\Model\Entity\Enviroment::AJAX_RESPONSE;
    	if ($this->getRequest()->isPost() && $this->getRequest()->isXmlHttpRequest()) {
            $data = [
                'ID_PERSONA'    =>  $this->getRequest()->getPost('ID_PERSONA', 0),
                'ID_PACIENTE'    =>  $this->getRequest()->getPost('ID_PACIENTE', 0),
                'NOMBRE'    =>  $this->getRequest()->getPost('NOMBRE', ''),
                'APELLIDOS'    =>  $this->getRequest()->getPost('APELLIDOS', ''),
                'EMAIL'    =>  $this->getRequest()->getPost('EMAIL', ''),
                'FECHA_NACIMIENTO'    =>  $this->getRequest()->getPost('FECHA_NACIMIENTO', null),
                'DIRECCION'    =>  $this->getRequest()->getPost('DIRECCION', ''),
                'NUMERO_DOCUMENTO'    =>  $this->getRequest()->getPost('NUMERO_DOCUMENTO', ''),
                'TIPO_DOCUMENTO'    =>  $this->getRequest()->getPost('TIPO_DOCUMENTO', 1),
                'CELULAR'    =>  $this->getRequest()->getPost('CELULAR', null),
                'TELEFONO'    =>  $this->getRequest()->getPost('TELEFONO', null),
            ];
    		$response = $this->table->save(1, $data);
    	}
        return new JsonModel($response);
    }

    public function getAction(){
        $response = null;
        if($this->getRequest()->isPost() && $this->getRequest()->isXmlHttpRequest()){
            return new JsonModel($this->table->getX($this->getRequest()->getPost('Id', 0)));
        }        
        return new JsonModel($response);
    }

    public function getAllAction(){
    	$response = null;        
        if ($this->getRequest()->isPost() && $this->getRequest()->isXmlHttpRequest()) {
          $response = [
            'data'  => $this->table->fetchAll(),
          ];
        }
        return new JsonModel($response);
    }

    public function deleteAction(){
    	$response = null;        
        if ($this->getRequest()->isPost() && $this->getRequest()->isXmlHttpRequest()) {
          $response = $this->table->delete(1,'ID_PACIENTE', $this->getRequest()->getPost('Id',0));
        }
        return new JsonModel($response);
    }

    public function searchAction(){
        $response = null;        
        if ($this->getRequest()->isPost() && $this->getRequest()->isXmlHttpRequest()) {
          $response = [
            'data'  => $this->table->searchQuery($this->getRequest()->getPost('q','')),
          ];
        }
        return new JsonModel($response);
    }
}
