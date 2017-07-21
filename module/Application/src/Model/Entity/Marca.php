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

namespace Application\Model\Entity;


class Marca extends IEntity
{
    var $ID_MARCA;
    var $NOMBRE_MARCA;
    var $ACTIVE;
    var $FECHA_CREACION;
    var $USUARIO_CREACION;
    var $FECHA_MODIFICACION;
    var $USUARIO_MODIFICACION;

    public function exchangeArray(array $data)
    {
        $this->ID_MARCA = !empty($data['ID_MARCA']) ? $data['ID_MARCA'] : null;
        $this->NOMBRE_MARCA = !empty($data['NOMBRE_MARCA']) ? $data['NOMBRE_MARCA'] : null;
        $this->ACTIVE = !empty($data['ACTIVE']) ? $data['ACTIVE'] : null;
        $this->FECHA_CREACION = !empty($data['FECHA_CREACION']) ? $data['FECHA_CREACION'] : null;
        $this->USUARIO_CREACION = !empty($data['USUARIO_CREACION']) ? $data['USUARIO_CREACION'] : null;
        $this->USUARIO_MODIFICACION = !empty($data['USUARIO_MODIFICACION']) ? $data['USUARIO_MODIFICACION'] : null;
        $this->FECHA_MODIFICACION = !empty($data['FECHA_MODIFICACION']) ? $data['FECHA_MODIFICACION'] : null;
    }

    public static function getColumnNames()
    {
        return [
            'ID_MARCA',
            'NOMBRE_MARCA'
        ];
    }
}