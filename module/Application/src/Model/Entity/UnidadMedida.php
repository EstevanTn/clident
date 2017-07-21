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
 * Date: 21/07/2017
 **/

namespace Application\Model\Entity;


class UnidadMedida extends IEntity
{

    var $ID_UNIDAD_MEDIDA;
    var $NOMBRE;
    var $SIGLAS_UNIDAD;
    var $ACTIVE;
    var $USUARIO_REGISTRO;
    var $FECHA_REGISTRO;
    var $USUARIO_MODIFICACION;
    var $FECHA_MODIFICACION;

    public function exchangeArray(array $data)
    {
        $this->ID_UNIDAD_MEDIDA = !empty($data['ID_UNIDAD_MEDIDA']) ? $data['ID_UNIDAD_MEDIDA'] : null;
        $this->NOMBRE = !empty($data['NOMBRE']) ? $data['NOMBRE'] : '';
        $this->SIGLAS_UNIDAD = !empty($data['SIGLAS_UNIDAD']) ? $data['SIGLAS_UNIDAD'] : '';
        $this->ACTIVE = !empty($data['ACTIVE']) ? $data['ACTIVE'] : true;
        $this->FECHA_REGISTRO = !empty($data['FECHA_REGISTRO']) ? $data['FECHA_REGISTRO'] : Enviroment::GetDate();
        $this->USUARIO_REGISTRO = !empty($data['USUARIO_REGISTRO']) ? $data['USUARIO_REGISTRO'] : Enviroment::GetCookieValue('ID_USUARIO');
        $this->USUARIO_MODIFICACION = !empty($data['USUARIO_MODIFICACION']) ? $data['USUARIO_MODIFICACION'] : null;
        $this->FECHA_MODIFICACION= !empty($data['FECHA_MODIFICACION']) ? $data['FECHA_MODIFICACION'] : null;
    }

    public static function getColumnNames()
    {
        return [
            'ID_UNIDAD_MEDIDA',
            'NOMBRE',
            'SIGLAS_UNIDAD'
        ];
    }
}