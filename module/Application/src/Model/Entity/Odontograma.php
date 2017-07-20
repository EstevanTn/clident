<?php
namespace Application\Model\Entity;

class Odontograma extends IEntity {

    var $ID_PACIENTE;
    var $ID_ODONTOGRAMA;
    var $FECHA_CREACION;
    var $FECHA_MODIFICACION;
    var $USUARIO_CREACION;
    var $USUARIO_MODIFICACION;

    public function exchangeArray(array $data) {
        $this->ID_ODONTOGRAMA = isset($data['ID_ODONTOGRAMA']) ? $data['ID_ODONTOGRAMA'] : 0;
        $this->ID_PACIENTE = isset($data['ID_PACIENTE']) ? $data['ID_PACIENTE'] : 0;
        $this->FECHA_CREACION = isset($data['FECHA_CREACION']) ? $data['FECHA_CREACION'] :  Enviroment::GetDate();
        $this->FECHA_MODIFICACION = isset($data['FECHA_MODIFICACION']) ? $data['FECHA_MODIFICACION'] : null;
        $this->USUARIO_CREACION = isset($data['USUARIO_CREACION']) ? $data['USUARIO_CREACION'] : 1;
        $this->USUARIO_MODIFICACION = isset($data['USUARION_MODIFICACION']) ? $data['USUARION_MODIFICACION'] : null;
    }

    public function getArrayCopy(){
        return get_object_vars($this);
    }
    
    public static function getColumnNames()
    {
        return [
          'ID_ODONTOGRAMA',
            'ID_PACIENTE',
        ];
    }
}