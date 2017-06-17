<?php
namespace Application\Model\Entity;

class TipoGrupo {
    var $ID_GRUPO;
    var $NOMBRE;
    var $DESCRIPCION;
    public function exchangeArray(array $data) {
        $this->ID_GRUPO = !empty($data['ID_GRUPO'])?$data['ID_GRUPO']:0;
        $this->NOMBRE_GRUPO = !empty($data['NOMBRE_GRUPO'])?$data['NOMBRE_GRUPO']:'';
        $this->DESCRIPCION_GRUPO = !empty($data['DESCRIPCION_GRUPO'])?$data['DESCRIPCION_GRUPO']:'';
    }

    public function getArrayCopy(){
        return get_object_vars($this);
    }

    public static function getVarNames(){
        return [
            'ID_GRUPO',
            'NOMBRE_GRUPO', 
            'DESCRIPCION_GRUPO', 
            ];
    }
}