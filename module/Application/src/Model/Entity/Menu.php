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


class Menu extends MenuRol
{
    var $ID_MENU;
    var $ID_PARENT_MENU;
    var $ICONO;
    var $NOMBRE;
    var $DESCRIPCION;
    var $URL;

    public function exchangeArray(array $data)
    {
        parent::exchangeArray($data);
        $this->ID_MENU = isset($data['ID_MENU']) ? $data['ID_MENU'] : null;
        $this->ID_PARENT_MENU = isset($data['ID_PARENT_MENU']) ? $data['ID_PARENT_MENU'] : null;
        $this->ICONO = isset($data['ICONO']) ? $data['ICONO'] : '';
        $this->NOMBRE = isset($data['NOMBRE']) ? $data['NOMBRE'] : '';
        $this->DESCRIPCION = isset($data['DESCRIPCION']) ? $data['DESCRIPCION'] : '';
        $this->URL = isset($data['URL']) ? $data['URL'] : '#';
    }

    public static function getColumnNames()
    {
        return [
            'ID_MENU',
            'ID_PARENT_MENU',
            'ICONO',
            'NOMBRE',
            'DESCRIPCION',
            'URL',
        ];
    }
}