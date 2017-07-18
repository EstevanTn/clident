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
use Zend\Mvc\Controller\AbstractActionController;
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
}