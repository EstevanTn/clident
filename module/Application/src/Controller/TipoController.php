<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Application\Model\TipoTable;
//use Application\Model\AreaTable as AreaTable;
//use Application\Model\Entity\Area as Area;

class TipoController extends AbstractActionController {
    var $table = null;

    public function __construct(TipoTable $table){
        $this->table = $table;
    }

    public function indexAction(){
        return new ViewModel();
    }

    public function getAllNombreGrupoAction(){
        $response = null;
        if($this->getRequest()->isPost() && $this->getRequest()->isXmlHttpRequest()){
            $nombre = $this->getRequest()->getPost('nombre','');
            $response = [
                'data' => $this->table->fetchAll(['tipo_grupo.NOMBRE_GRUPO'=>$nombre, 'tipo.ACTIVE'=>true])
            ];
        }
        return new JsonModel($response);
    }

    public function getAllGrupoAction(){
        $response = null;
        if($this->getRequest()->isPost() && $this->getRequest()->isXmlHttpRequest()){
            $response = [
                'data' => $this->table->fetchAllGrupo($this->getRequest()->getPost('nombre',''))
            ];
        }
        return new JsonModel($response);
    }

    public function getAllKeyGrupoAction(){
        $response = null;
        if($this->getRequest()->isPost() && $this->getRequest()->isXmlHttpRequest()){
            $id = $this->getRequest()->getPost('id','');
            $id = (int) $id;
            $response = [
                'data' => $this->table->fetchAll(['tipo.ID_GRUPO'=>$id, 'tipo.ACTIVE'=>true])
            ];
        }
        return new JsonModel($response);
    }

    public function guardarGrupoAction(){
        $response = null;
        if($this->getRequest()->isPost() && $this->getRequest()->isXmlHttpRequest()){
            $data = [
                'ID_GRUPO'  => $this->getRequest()->getPost('id',''),
                'NOMBRE'  =>  $this->getRequest()->getPost('nombre',''),
                'DESCRIPCION'  =>  $this->getRequest()->getPost('descripcion',''),
            ];
            $response = $this->table->saveGrupo(1, $data);
        }
        return new JsonModel($response);
    }

    public function guardarTipoAction(){
        $response = null;
        if($this->getRequest()->isPost() && $this->getRequest()->isXmlHttpRequest()){
            $data = [
                'ID_TIPO'  => $this->getRequest()->getPost('id',''),
                'ID_GRUPO'  => $this->getRequest()->getPost('idgrupo',''),
                'NOMBRE'  =>  $this->getRequest()->getPost('nombre',''),
                'VALOR'  =>  $this->getRequest()->getPost('valor',''),
                'SIGLA'  =>  $this->getRequest()->getPost('sigla',''),
            ];
            $response = $this->table->save(1, $data);
        }
        return new JsonModel($response);
    }

    public function eliminarAction(){
        $response = \Application\Model\Entity\Enviroment::AJAX_RESPONSE;
        if($this->getRequest()->isPost() && $this->getRequest()->isXmlHttpRequest()){
            $response = $this->table->delete(1, 'ID_TIPO', $this->getRequest()->getPost('id',''));
        }
        return new JsonModel($response);
    }

    public function getTipoAction(){
        $response = \Application\Model\Entity\Enviroment::AJAX_RESPONSE;
        if($this->getRequest()->isPost() && $this->getRequest()->isXmlHttpRequest()){
            $response = $this->table->get('ID_TIPO', $this->getRequest()->getPost('id',''));
        }
        return new JsonModel($response);
    }

}