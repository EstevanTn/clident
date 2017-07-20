<?php
namespace Application\Controller;

use Application\Model\Entity\Enviroment;
use Application\Model\OdontogramaTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class OdontogramaController extends AbstractActionController {

    var $table;

    public function __construct(OdontogramaTable $table){
        $this->table = $table;
    }

    public function indexAction(){
        return new ViewModel();
    }

    public function getAction(){
        $response = Enviroment::AJAX_RESPONSE;
        if($this->getRequest()->isPost() && $this->getRequest()->isXmlHttpRequest()){
            $response = $this->table->get('ID_PACIENTE', $this->getRequest()->getPost('id', 0));
        }
        return new JsonModel($response);
    }

    public function getAllAction(){
        $response = Enviroment::AJAX_TABLE;
        if($this->getRequest()->isPost() && $this->getRequest()->isXmlHttpRequest()){
            $response = [
                'data' => $this->table->fetchAll([
                    'detalle_odontograma.ACTIVE' => true,
                    'detalle_odontograma.ID_ODONTOGRAMA' => $this->getRequest()->getPost('id', 0)
                ])
            ];
        }
        return new JsonModel($response);
    }

    public function guardarDetalleAction(){
        $response = Enviroment::AJAX_RESPONSE;
        if($this->getRequest()->isPost() && $this->getRequest()->isXmlHttpRequest()){
            $data = [
                'ID_DETALLE_ODONTOGRAMA' => $this->getRequest()->getPost('id', null),
                'ID_ODONTOGRAMA' => $this->getRequest()->getPost('id_odontograma', null),
                'NUMERO_DIENTE' => $this->getRequest()->getPost('numero_diente', null),
                'CARA_DIENTE' => $this->getRequest()->getPost('cara_diente', null),
                'ID_TRATAMIENTO' => $this->getRequest()->getPost('id_tratamiento', null),
                'ID_DENTISTA' => 1,
                'DESCRIPCION' => $this->getRequest()->getPost('descripcion', null),
                'ESTADO' => $this->getRequest()->getPost('estado', null),
                'FECHA_APLICACION' => Enviroment::GetDate(),
            ];
            $response = $this->table->save(Enviroment::GetCookieValue('ID_USUARIO'), $data);
        }
        return new JsonModel($response);
    }

    public function fetchAllAction(){
        $response = [
            'data' => $this->table->fetchAll([
                'detalle_odontograma.ACTIVE' => true,
                'detalle_odontograma.ID_ODONTOGRAMA' => $_GET['id']
            ])
        ];
        return new JsonModel($response);
    }
}