<?php
/**
 * Apps TunaquiSoft (http://apps-tnqsoft.azurewebsites.net/)
 * -------------------------------------------------------------------------------
 * This file is part of the clident project.
 *
 * @autor @EstevanTn
 * @email tunaqui@outlook.es
 * @copyright Copyright © 2017 - TunaquiSoft
 * @website http://apps-tnqsoft.azurewebsites.net/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 18/07/2017 - 14:29
 **/

namespace Application\Controller;

use Application\Model\CitaTable;
use Application\Model\Entity\Enviroment;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class CitaController extends AbstractActionController
{
    var $table;
    
    public function __construct(CitaTable $citaTable)
    {
        $this->table = $citaTable;
    }
    
    public function indexAction()
    {
        return new ViewModel();
    }

    public function getAllTodayAction(){
        $response = Enviroment::AJAX_TABLE;
        if($this->getRequest()->isPost() && $this->getRequest()->isXmlHttpRequest()){
            $response = [
                'data' => $this->table->fetchAll(
                    'cita.ACTIVE=1 AND DATE(cita.FECHA_CITA) = DATE(\''.Enviroment::GetDate().'\') AND cita.ID_DENTISTA='.Enviroment::GetDentista()
                )
            ];
        }
        return new JsonModel($response);
    }

    public function getAllAction(){
        $response = Enviroment::AJAX_TABLE;
        if($this->getRequest()->isPost() && $this->getRequest()->isXmlHttpRequest()){
            $response = [
                'data' => $this->table->fetchAll(
                    'cita.ACTIVE=1 AND cita.ID_DENTISTA='.Enviroment::GetDentista()
                )
            ];
        }
        return new JsonModel($response);
    }

    public function guardarCitaAction(){
        $response = Enviroment::AJAX_RESPONSE;
        if($this->getRequest()->isPost() && $this->getRequest()->isXmlHttpRequest()){
            $data = [
                'ID_CITA' => $this->getRequest()->getPost('id', null),
                'ID_PACIENTE' => $this->getRequest()->getPost('idpaciente', null),
                'ID_DENTISTA' => Enviroment::GetDentista(),
                'TIPO_CITA' => $this->getRequest()->getPost('tipo_cita', 2),
                'FECHA_CITA' => $this->getRequest()->getPost('fecha', null),
                'HORA_INICIO' => $this->getRequest()->getPost('hora_inicio', null),
                'HORA_FIN' => $this->getRequest()->getPost('hora_fin', null),
                'ESTADO' => $this->getRequest()->getPost('estado', 1),
                'NOTA' => $this->getRequest()->getPost('nota', ''),
            ];
            $response = $this->table->save(Enviroment::GetCookieValue('ID_USUARIO'), $data);
        }
        return new JsonModel($response);
    }

    public function eliminarCitaAction(){
        $response = Enviroment::AJAX_RESPONSE;
        if($this->getRequest()->isPost() && $this->getRequest()->isXmlHttpRequest()){
            $response = $this->table->delete(
                Enviroment::GetCookieValue('ID_USUARIO'),
                'ID_CITA',
                $this->getRequest()->getPost('id', null));
        }
        return new JsonModel($response);
    }

}