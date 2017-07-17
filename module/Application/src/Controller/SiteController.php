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
 * Date: 17/07/2017 - 7:45
 **/

namespace Application\Controller;


use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class SiteController extends AbstractActionController
{
    public function indexAction()
    {
        $this->layout('layout/public');
        return new ViewModel();
    }
    
    public function aboutAction(){
        $this->layout('layout/public');
        return new ViewModel();
    }
    
    public function servicesAction(){
        $this->layout('layout/public');
        return new ViewModel();
    }
    
    public function galleryAction(){
        $this->layout('layout/public');
        return new ViewModel();
    }
    
    public function contactAction(){
        $this->layout('layout/public');
        return new ViewModel();
    }
    
    public function reservationAction(){
        $this->layout('layout/public');
        return new ViewModel();
    }
}