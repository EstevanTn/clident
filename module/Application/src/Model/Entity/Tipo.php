<?php
namespace Application\Model\Entity;

class Tipo extends TipoGrupo {
    var $ID_TIPO;
    var $ID_GRUPO;
    var $NOMBRE;
    var $VALOR;
    var $SIGLA;
    var $ACTIVE;
    var $FECHA_CREACION;
    var $USUARIO_CREACION;
    var $FECHA_MODIFICACION;
    var $USUARIO_MODIFICACION;
    
    public function exchangeArray(array $data) {
        parent::exchangeArray($data);
        $this->ID_TIPO = !empty($data['ID_TIPO'])?$data['ID_TIPO']:0;
        $this->NOMBRE = !empty($data['NOMBRE'])?$data['NOMBRE']:'';
        $this->ID_GRUPO = !empty($data['ID_GRUPO'])?$data['ID_GRUPO']:0;
        $this->VALOR = !empty($data['VALOR'])?$data['VALOR']:'';
        $this->SIGLA = !empty($data['SIGLA'])?$data['SIGLA']:'';
        $this->ACTIVE = !empty($data['ACTIVE'])?$data['ACTIVE']:true;
        $this->FECHA_CREACION = !empty($data['FECHA_CREACION'])?$data['FECHA_CREACION']:Enviroment::GetDate();
        $this->USUARIO_CREACION = !empty($data['USUARIO_CREACION'])?$data['USUARIO_CREACION']:1;
        $this->FECHA_MODIFICACION = !empty($data['FECHA_MODIFICACION'])?$data['FECHA_MODIFICACION']:null;
        $this->USUARIO_MODIFICACION = !empty($data['USUARIO_MODIFICACION'])?$data['USUARIO_MODIFICACION']:null;
    }

    public function getArrayCopy(){
        return get_object_vars($this);
    }

    public static function getVarNames(){
        return [
            'ID_TIPO',
            'NOMBRE', 
            'ID_GRUPO', 
            'NOMBRE',
            'VALOR',
            'SIGLA',
            'ACTIVE',
            'FECHA_CREACION',
            'USUARIO_CREACION',
            'FECHA_MODIFICACION',
            'USUARIO_MODIFICACION'
            ];
    }
}