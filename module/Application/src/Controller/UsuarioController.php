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
 * Date: 22/07/2017
 **/

namespace Application\Controller;


use Application\Model\Entity\Enviroment;
use Application\Model\UsuarioTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class UsuarioController extends AbstractActionController
{
    var $table;
    public function __construct(UsuarioTable $usuarioTable)
    {
        $this->table = $usuarioTable;
    }
    public function indexAction(){

        return new ViewModel();
    }
    public function guardarAction(){

    }
    public function eliminarAction(){

    }
    public function getAllAction(){
        $response = Enviroment::AJAX_TABLE;
        if($this->getRequest()->isPost() && $this->getRequest()->isXmlHttpRequest()){
            $response = [
                'data' => $this->table->fetchAll()
            ];
        }
        return new JsonModel($response);
    }
}