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
 * Date: 20/07/2017
 **/

namespace Application\Controller;


use Application\Model\MedicamentoTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class MedicamentoController extends AbstractActionController
{
    var $table ;
    public function __construct(MedicamentoTable $table)
    {
        $this->table = $table;
    }

    public function indexAction()
    {
        return new ViewModel();
    }
}