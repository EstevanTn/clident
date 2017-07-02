<?php
namespace Application\Model\Entity;

class Usuario extends Persona {
    var $ID_USUARIO;
    var $ID_PERSONA;
    var $ID_ROL;
    var $USERNAME;
    var $PASSWORD;
    var $ESTADO;
    
    public function exchangeArray($data){
        parent::exchangeArray($data);
        $this->ID_USUARIO = isset($data['ID_USUARIO']) ? $data['ID_USUARIO'] : 0;
        $this->ID_PERSONA = isset($data['ID_USUARIO']) ? $data['ID_USUARIO'] : 0;
        $this->USERNAME = isset($data['USERNAME']) ? $data['USERNAME'] : '';
        $this->PASSWORD = isset($data['PASSWORD']) ? $data['PASSWORD'] : '';
    }
    public function getArrayCopy(){
        return get_object_vars($this);
    }
}