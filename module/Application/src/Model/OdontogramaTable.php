<?php
namespace Application\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;
use Application\Model\BaseTable;
use Zend\Db\Sql\Select;

class OdontogramaTable extends BaseTable{
    
    public function __construct(TableGatewayInterface $tableGatewayInterface){
        $this->tableGateway = $tableGatewayInterface;
    }

    public function save($userId, $data){
        
    }
}