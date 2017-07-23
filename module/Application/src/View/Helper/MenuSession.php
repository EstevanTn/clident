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

namespace Application\View\Helper;

use Application\Model\Entity\Enviroment;
use Application\Model\UsuarioTable;

class MenuSession
{
    var $table;
    var $arrMenu;
    public function __construct(UsuarioTable $usuarioTable)
    {
        $this->table = $usuarioTable;
        $this->arrMenu = $this->table->buildMenu();
    }
    public function __invoke()
    {
        return $this->arrMenu;
    }
}