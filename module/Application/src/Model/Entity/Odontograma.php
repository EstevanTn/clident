<?php
namespace Application\Model\Entity;

class Odontograma {
    public function exchangeArray($data) {

    }

    public function getArrayCopy(){
        return get_object_vars($this);
    }
}