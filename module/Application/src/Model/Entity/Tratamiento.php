<?php
namespace Application\Model\Entity;

class Tratamiento {
    var $ID_TRATAMIENTO;
    var $NOMBRE;
    var $DESCRIPCION;
    var $APLICA_CARA;
    var $APLICA_DIENTE;
    var $PRECIO;
    var $ACTIVE;
    var $FECHA_CREACION;
    var $FECHA_MODIFICACION;
    var $USUARIO_CREACION;
    var $USUARIO_MODIFICACION;
    
    public function exchangeArray($data){
        $this->ID_TRATAMIENTO = isset($data['ID_TRATAMIENTO']) ? $data['ID_TRATAMIENTO'] : 0 ;
        $this->NOMBRE = isset($data['NOMBRE']) ? $data['NOMBRE'] : '';
        $this->DESCRIPCION = isset($data['DESCRIPCION']) ? $data['DESCRIPCION']: '';
        $this->APLICA_CARA = isset($data['APLICA_CARA']) ? $data['APLICA_CARA']: false;
        $this->APLICA_DIENTE = isset($data['APLICA_DIENTE']) ? $data['APLICA_DIENTE']: false;
        $this->ACTIVE = isset($data['ACTIVE']) ? $data['ACTIVE']: true;
        $this->PRECIO = isset($data['PRECIO']) ? $data['PRECIO']: '';
        $this->FECHA_CREACION = isset($data['FECHA_CREACION']) ? $data['FECHA_CREACION']: Enviroment::GetDate();
        $this->FECHA_MODIFICACION = isset($data['FECHA_MODIFICACION']) ? $data['FECHA_MODIFICACION']: null;
        $this->USUARIO_CREACION = isset($data['USUARIO_CREACION']) ? $data['USUARIO_CREACION']: null;
        $this->USUARIO_MODIFICACION = isset($data['USUARIO_MODIFICACION']) ? $data['USUARIO_MODIFICACION']: null;
    }

    public function getArrayCopy(){
        return get_object_vars($this);
    }

}