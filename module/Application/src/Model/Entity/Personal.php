<?php
namespace Application\Model\Entity;

use Application\Model\Entity\Persona;

class Personal extends Persona {
    var $ID_PERSONAL;
    var $ID_AREA;
    var $TIPO_PERSONAL;
    var $FECHA_INGRESO;
    var $FECHA_CONTRATO_INICIO;
    var $FECHA_CONTRATO_FIN;
    var $ESPECIALIDAD;
    var $CARGO;

    public function exchangeArray($data){
        parent::exchangeArray($data);
        $this->ID_PERSONAL = !empty($data['ID_PERSONAL']) ? $data['ID_PERSONAL'] : 0;
        $this->ID_AREA = !empty($data['ID_AREA']) ? $data['ID_AREA'] : 0;
        $this->TIPO_PERSONAL = !empty($data['TIPO_PERSONAL']) ? $data['TIPO_PERSONAL'] : null;
        $this->FECHA_INGRESO = !empty($data['FECHA_INGRESO']) ? $data['FECHA_INGRESO'] : \Application\Model\Entity\Enviroment::GetDate();
        $this->FECHA_CONTRATO_INICIO = !empty($data['FECHA_CONTRATO_INICIO']) ? $data['FECHA_CONTRATO_INICIO'] : null;
        $this->FECHA_CONTRATO_FIN = !empty($data['FECHA_CONTRATO_FIN']) ? $data['FECHA_CONTRATO_FIN'] : null;
        $this->ESPECIALIDAD = !empty($data['ESPECIALIDAD']) ? $data['ESPECIALIDAD'] : null;
        $this->CARGO = !empty($data['CARGO']) ? $data['CARGO'] : '';
    }

    public function getArrayCopy(){
        return get_object_vars($this);
    }
}
