<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Application\Model\PersonalTable;
use Application\Model\Entity\Enviroment;

class PersonalController extends AbstractActionController {
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

    public function searchAction(){
      $response = Enviroment::AJAX_TABLE;
      if ($this->getRequest()->isPost() && $this->getRequest()->isXmlHttpRequest()) {
        $query = $this->getRequest()->getPost('nombre','');
        $idarea = (int) $this->getRequest()->getPost('idarea',0);
        $tipopersonal = (int) $this->getRequest()->getPost('tipopersonal',0);
        $where = 'personal.ACTIVE=1 AND CONCAT(persona.NOMBRE,\' \',persona.APELLIDOS) like \'%'.$query.'%\'';
        if ($idarea!==0) {
          $where .= ' AND personal.ID_AREA = \''.$idarea.'\'';
        }
        if ($tipopersonal!==0) {
          $where .= ' AND personal.TIPO_PERSONAL = \''.$tipopersonal.'\'';
        }
        $response = [
          'data' => $this->table->fetchAll($where),
          'q' =>  $where
        ];
      }
      return new JsonModel($response);
    }

    public function guardarAction(){
      $response = Enviroment::AJAX_RESPONSE;
      if ($this->getRequest()->isPost() && $this->getRequest()->isXmlHttpRequest()) {
        $data = [
          'ID_PERSONAL' =>  $this->getRequest()->getPost('id',0),
          'ID_PERSONA' =>  $this->getRequest()->getPost('idpersona',0),
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

    public function eliminarAction(){
      $response = Enviroment::AJAX_RESPONSE;
      if ($this->getRequest()->isPost() && $this->getRequest()->isXmlHttpRequest()) {
        $response = $this->table->delete(1, 'ID_PERSONAL', $this->getRequest()->getPost('id',0));
      }
      return new JsonModel($response);
    }

    public function getAction(){
      $response = Enviroment::AJAX_RESPONSE;
      if ($this->getRequest()->isPost() && $this->getRequest()->isXmlHttpRequest()) {
        $response = $this->table->get('ID_PERSONAL', $this->getRequest()->getPost('id',0));
      }
      return new JsonModel($response);
    }
}
