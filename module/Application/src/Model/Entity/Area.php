<?php

namespace Application\Model\Entity;

use Zend\View\Helper\AbstractHelper;

class Area {
    var $ID_AREA;
    var $ID_PARENT_AREA;
    var $NOMBRE;
    var $DESCRIPCION;
    var $ESTADO;
    var $ACTIVE;
    var $FECHA_CREACION;
    var $FECHA_MODIFICACION;
    var $USUARIO_CREACION;
    var $USUARIO_MODIFICACION;
    
    public function exchangeArray(array $data){
        $date = getdate();
        $strdate = sprintf('%s-%s-%s', $date['year'], $date['mon'], $date['mday']);
        $this->ID_AREA = !empty($data['ID_AREA']) ? $data['ID_AREA'] : 0;
        $this->ID_PARENT_AREA = !empty($data['ID_PARENT_AREA']) ? $data['ID_PARENT_AREA'] : 0;
        $this->NOMBRE = !empty($data['NOMBRE']) ? $data['NOMBRE'] : '';
        $this->DESCRIPCION = !empty($data['DESCRIPCION']) ? $data['DESCRIPCION'] : '';
        $this->ESTADO = !empty($data['ESTADO']) ? $data['ESTADO'] : 1;
        $this->ACTIVE = !empty($data['ACTIVE']) ? $data['ACTIVE'] : true;
        $this->FECHA_CREACION = !empty($data['FECHA_CREACION']) ? $data['FECHA_CREACION'] : $strdate;
        $this->FECHA_MODIFICACION = !empty($data['FECHA_MODIFICACION']) ? $data['FECHA_MODIFICACION'] : null;
        $this->USUARIO_CREACION = !empty($data['USUARIO_CREACION']) ? $data['USUARIO_CREACION'] : null;
        $this->USUARIO_MODIFICACION = !empty($data['USUARIO_MODIFICACION']) ? $data['USUARIO_MODIFICACION'] : null;
    }

    public function getArrayCopy(){
        return get_object_vars($this);
    }

}