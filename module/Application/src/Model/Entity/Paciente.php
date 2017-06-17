<?php
namespace Application\Model\Entity;

use Application\Model\Entity\Persona;

class Paciente extends Persona {
    var $ID_PACIENTE;

    public function exchangeArray(array $data){
        parent::exchangeArray($data);
        $this->ID_PACIENTE = !empty($data['ID_PACIENTE'])?$data['ID_PACIENTE']:0;
    }
    public function getArrayCopy(){
        return get_object_vars($this);
    }
}