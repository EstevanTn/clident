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
 * Date: 18/07/2017 - 12:28
 **/

namespace Application\Model\Entity;


class DetalleOdontograma extends Tratamiento
{
    var $ID_DETALLE_ODONTOGRAMA;
    var $ID_ODONTOGRAMA;
    var $ID_TRATAMIENTO;
    var $ID_DENTISTA;
    var $NUMERO_DIENTE;
    var $CARA_DIENTE;
    var $DESCRIPCION;
    var $FECHA_APLICACION;
    var $ESTADO;
    var $ACTIVE;
    var $FECHA_CREACION;
    var $FECHA_MODIFICACION;
    var $USUARIO_CREACION;
    var $USUARIO_MODIFICACION;
    
    
    public function exchangeArray(array $data)
    {
        parent::exchangeArray($data);
        $this->ID_DETALLE_ODONTOGRAMA = !empty($data['ID_DETALLE_ODONTOGRAMA']) ? $data['ID_DETALLE_ODONTOGRAMA'] : null;
        $this->ID_ODONTOGRAMA = !empty($data['ID_ODONTOGRAMA']) ? $data['ID_ODONTOGRAMA'] : null;
        $this->ID_TRATAMIENTO = !empty($data['ID_TRATAMIENTO']) ? $data['ID_TRATAMIENTO'] : null;
        $this->ID_DENTISTA = !empty($data['ID_DENTISTA']) ? $data['ID_DENTISTA'] : null;
        $this->NUMERO_DIENTE = !empty($data['NUMERO_DIENTE']) ? $data['NUMERO_DIENTE'] : null;
        $this->CARA_DIENTE = !empty($data['CARA_DIENTE']) ? $data['CARA_DIENTE'] : null;
        $this->DESCRIPCION = !empty($data['DESCRIPCION']) ? $data['DESCRIPCION'] : '';
        $this->FECHA_APLICACION = !empty($data['FECHA_APLICACION']) ? $data['FECHA_APLICACION'] : null;
        $this->ESTADO = !empty($data['ESTADO']) ? $data['ESTADO'] : null;
        $this->ACTIVE = !empty($data['ACTIVE']) ? $data['ACTIVE'] : true;
        $this->FECHA_CREACION = isset($data['FECHA_CREACION']) ? $data['FECHA_CREACION'] :  Enviroment::GetDate();
        $this->FECHA_MODIFICACION = isset($data['FECHA_MODIFICACION']) ? $data['FECHA_MODIFICACION'] : null;
        $this->USUARIO_CREACION = isset($data['USUARIO_CREACION']) ? $data['USUARIO_CREACION'] : Enviroment::GetCookieValue('ID_USUARIO');
        $this->USUARIO_MODIFICACION = isset($data['USUARION_MODIFICACION']) ? $data['USUARION_MODIFICACION'] : null;
    }
    
    public static function getColumnNames()
    {
        return [
            'ID_DETALLE_ODONTOGRAMA',
            'ID_ODONTOGRAMA',
            'ID_TRATAMIENTO',
            'ID_DENTISTA',
            'NUMERO_DIENTE',
            'CARA_DIENTE',
            'DESCRIPCION',
            'FECHA_APLICACION',
            'ESTADO',
        ];
    }
}