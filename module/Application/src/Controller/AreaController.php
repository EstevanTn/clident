<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Application\Model\AreaTable as AreaTable;
use Application\Model\Entity\Area as Area;


class AreaController extends AbstractActionController
{
    var $table = null;
    public function __construct(AreaTable $table){
      $this->table = $table;
    }
    
    public function indexAction(){
        return new ViewModel([
            'items' => $this->table->fetchAll()
          ]);
    }
    
    public function guardarAction(){
      $response = [
        'success' =>  false,
        'message' => 'No disponible.'
      ];
      if ($this->getRequest()->isPost() && $this->getRequest()->isXmlHttpRequest()) {
        $params = [
            'ID_AREA' =>  $this->getRequest()->getPost('ID_AREA',0),
            'ID_PARENT_AREA'  =>  $this->getRequest()->getPost('ID_PARENT_AREA', null),
            'NOMBRE'  => $this->getRequest()->getPost('NOMBRE', null),
            'DESCRIPCION' =>  $this->getRequest()->getPost('DESCRIPCION', null)
          ];
        $response = $this->table->save(1, $params);
      }
      return new JsonModel($response);
    }

    public function getAllAction()
    {
        $response = null;        
        if ($this->getRequest()->isPost()) {
          $response = [
            'data'  => $this->table->fetchAll(),
          ];
        }
        return new JsonModel($response);
    }

    public function testAction(){
      return new JsonModel([
          'data'  =>  $this->table->fetchAll(),
        ]);
    }

}