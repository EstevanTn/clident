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
 * Date: 18/07/2017 - 14:32
 **/

namespace Application\Model\Entity;


class Cita extends IEntity
{
    var $ID_CITA;
    var $ID_PACIENTE;
    var $ID_DENTISTA;
    var $TIPO_CITA;
    var $FECHA_CITA;
    var $HORA_INICIO;
    var $HORA_FIN;
    var $ESTADO;
    var $NOTA;
    var $ACTIVE;
    var $FECHA_CREACION;
    var $USUARIO_CREACION;
    var $FECHA_MODIFICACION;
    var $USUARIO_MODIFICACION;
    
    public function exchangeArray(array $data)
    {
        $this->ID_CITA = !empty($data['ID_CITA']) ? $data['ID_CITA'] : null;
        $this->ID_PACIENTE = !empty($data['ID_PACIENTE']) ? $data['ID_PACIENTE'] : null;
        $this->ID_DENTISTA = !empty($data['ID_DENTISTA']) ? $data['ID_DENTISTA'] : null;
        $this->TIPO_CITA = !empty($data['TIPO_CITA']) ? $data['TIPO_CITA'] : null;
        $this->FECHA_CITA = !empty($data['FECHA_CITA']) ? $data['FECHA_CITA'] : null;
        $this->HORA_INICIO = !empty($data['HORA_INICIO']) ? $data['HORA_INICIO'] : null;
        $this->HORA_FIN = !empty($data['HORA_FIN']) ? $data['HORA_FIN'] : null;
        $this->ESTADO = !empty($data['ESTADO']) ? $data['ESTADO'] : null;
        $this->NOTA = !empty($data['NOTA']) ? $data['NOTA'] : null;
        $this->ACTIVE = !empty($data['ACTIVE']) ? $data['ACTIVE'] : null;
        $this->FECHA_CREACION = !empty($data['FECHA_CREACION']) ? $data['FECHA_CREACION'] : null;
        $this->USUARIO_CREACION = !empty($data['USUARIO_CREACION']) ? $data['USUARIO_CREACION'] : null;
        $this->FECHA_MODIFICACION = !empty($data['FECHA_MODIFICACION']) ? $data['FECHA_MODIFICACION'] : null;
        $this->USUARIO_MODIFICACION = !empty($data['USUARIO_MODIFICACION']) ? $data['USUARIO_MODIFICACION'] : null;
    }
    
    public static function getColumnNames()
    {
        return [
        
        ];
    }
}