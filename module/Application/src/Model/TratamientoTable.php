<?php
namespace Application\Model;

class TratamientoTable extends BaseTable{

    public function __construct(\Zend\Db\TableGateway\TableGatewayInterface $tableGatewayInterface) {
        $this->tableGateway = $tableGatewayInterface;
    }

    public function save($userId, $data) {

    }
}