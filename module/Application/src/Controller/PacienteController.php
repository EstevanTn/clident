<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class PacienteController extends AbstractActionController
{

    public function indexAction()
    {
        return new ViewModel();
    }
    public function guardarAction(){
    	if ($this->getRequest()->isPost() && $this->getRequest()->isXmlHttpRequest()) {
    		return new JsonModel([
    			'success'	=>	true,
    			'root'	=>	[
                    'dni'   => $dni
    				// 'nombres'	=>	$this->request->getPost('nombres', null),
    				// 'qString'	=> $this->getRequest()->getContent()
    			]
    		]);
    	}else{
    		return new JsonModel([
    			'success'	=>	false,
    			'message'	=>	'No disponible.'
    		]);
    	}    	
    }

    public function getAll(){
    	if ($this->getRequest()->isGet()) {
    		# code...
    	}else{
    		return new JsonModel(null);
    	}
    }
}
