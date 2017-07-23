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

namespace Application\Model\Entity;


class MenuRol extends IEntity
{
    var $ID_MENU_ROL;
    var $ID_MENU;
    var $ID_ROL;

    public function exchangeArray(array $data)
    {
        $this->ID_MENU_ROL = isset($data['ID_MENU_ROL']) ? $data['ID_MENU_ROL'] : null;
        $this->ID_MENU = isset($data['ID_MENU']) ? $data['ID_MENU'] : null;
        $this->ID_ROL = isset($data['ID_ROL']) ? $data['ID_ROL'] : null;
    }

    public static function getColumnNames()
    {
        return [
            'ID_MENU_ROL',
            'ID_MENU',
            'ID_ROL'
        ];
    }
}