<?php
namespace Application\Model\Entity;

class Persona {
    var $ID_PERSONA;
    var $NUMERO_DOCUMENTO;
    var $TIPO_DOCUMENTO;
    var $NOMBRE;
    var $APELLIDOS;
    var $DIRECCION;
    var $EMAIL;
    var $CELULAR;
    var $TELEFONO;
    var $FECHA_NACIMIENTO;
    var $ACTIVE;
    var $FECHA_CREACION;
    var $USUARIO_CREACION;
    var $FECHA_MODIFICACION;
    var $USUARIO_MODIFICACION;

    public function exchangeArray(array $data){
        $this->ID_PERSONA = !empty($data['ID_PERSONA'])?$data['ID_PERSONA']:0;
        $this->NUMERO_DOCUMENTO = !empty($data['NUMERO_DOCUMENTO'])?$data['NUMERO_DOCUMENTO']:'';
        $this->TIPO_DOCUMENTO = !empty($data['TIPO_DOCUMENTO'])?$data['TIPO_DOCUMENTO']:1;
        $this->NOMBRE = !empty($data['NOMBRE'])?$data['NOMBRE']:'';
        $this->APELLIDOS = !empty($data['APELLIDOS'])?$data['APELLIDOS']:'';
        $this->DIRECCION = !empty($data['DIRECCION'])?$data['DIRECCION']:'';
        $this->EMAIL = !empty($data['EMAIL'])?$data['EMAIL']:'';
        $this->CELULAR = !empty($data['CELULAR'])?$data['CELULAR']:'';
        $this->TELEFONO = !empty($data['TELEFONO'])?$data['TELEFONO']:'';
        $this->FECHA_NACIMIENTO = !empty($data['FECHA_NACIMIENTO'])?$data['FECHA_NACIMIENTO']:'';
        $this->ACTIVE = !empty($data['ACTIVE'])?$data['ACTIVE']:true;
        $this->FECHA_CREACION = !empty($data['FECHA_CREACION'])?$data['FECHA_CREACION']:Enviroment::GetDate();
        $this->USUARIO_CREACION = !empty($data['USUARIO_CREACION'])?$data['USUARIO_CREACION']:null;
        $this->FECHA_MODIFICACION = !empty($data['FECHA_MODIFICACION'])?$data['FECHA_MODIFICACION']:null;
        $this->USUARIO_MODIFICACION = !empty($data['USUARIO_MODIFICACION'])?$data['USUARIO_MODIFICACION']:null;
    }

    public function getArrayCopy(){
        return get_object_vars($this);
    }

    public static function getVarNames(){
        return [
            'ID_PERSONA',
            'NUMERO_DOCUMENTO', 
            'TIPO_DOCUMENTO', 
            'NOMBRE',
            'APELLIDOS',
            'DIRECCION',
            'EMAIL',
            'CELULAR',
            'TELEFONO',
            'FECHA_NACIMIENTO'
            ];
    }
}