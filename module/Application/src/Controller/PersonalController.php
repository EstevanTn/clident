<?php
namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Application\Model\PersonalTable;
use Application\Model\Entity\Enviroment;

class PersonalController extends \Zend\Mvc\Controller\AbstractActionController {
    var $table = null;
    public function __construct(PersonalTable $table){
        $this->table = $table;
    }
    public function indexAction(){
        return new ViewModel();
    }
    public function getAllAction(){
      $response = Enviroment::AJAX_TABLE;
      if ($this->getRequest()->isPost() && $this->getRequest()->isXmlHttpRequest()) {
        $response = [
          'data' => $this->table->fetchAll()
        ];
      }
      return new JsonModel($response);
    }
    public function guardarAction(){
      $response = Enviroment::AJAX_RESPONSE;
      if ($this->getRequest()->isPost() && $this->getRequest()->isXmlHttpRequest()) {
        $data = [
          'ID_PERSONAL' =>  $this->getRequest()->getPost('id',0),
          'TIPO_DOCUMENTO' =>  $this->getRequest()->getPost('tipodocumento', null),
          'NUMERO_DOCUMENTO' =>  $this->getRequest()->getPost('numerodocumento',''),
          'NOMBRE' =>  $this->getRequest()->getPost('nombre',''),
          'APELLIDOS' =>  $this->getRequest()->getPost('apellidos',''),
          'DIRECCION' =>  $this->getRequest()->getPost('direccion',''),
          'EMAIL' =>  $this->getRequest()->getPost('email',''),
          'CELULAR' =>  $this->getRequest()->getPost('celular',''),
          'TELEFONO' =>  $this->getRequest()->getPost('telefono',''),
          'FECHA_NACIMIENTO' =>  $this->getRequest()->getPost('fechanacimiento',''),
          'TIPO_PERSONAL' =>  $this->getRequest()->getPost('tipoperonal', null),
          'CARGO' =>  $this->getRequest()->getPost('cargo', ''),
          'ESPECIALIDAD' =>  $this->getRequest()->getPost('especialidad', ''),
          'ID_AREA' =>  $this->getRequest()->getPost('idarea', null),
          'FECHA_INGRESO' =>  $this->getRequest()->getPost('fechaingreso', Enviroment::GetDate()),
          'FECHA_CONTRATO_INICIO' =>  $this->getRequest()->getPost('fechacontrato_inicio', null),
          'FECHA_CONTRATO_FIN' =>  $this->getRequest()->getPost('fechacontrato_fin', null),
        ];
        $response = $this->table->save(1, $data);
      }
      return new JsonModel($response);
    }
}
