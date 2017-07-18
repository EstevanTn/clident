<?php
namespace Application\Model;

use Application\Model\Entity\DetalleOdontograma;
use RuntimeException;
use const true;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\TableGatewayInterface;
use Application\Model\BaseTable;
use Zend\Db\Sql\Select;

class OdontogramaTable extends BaseTable{
    
    var $tableGatewayTratamiento;
    var $tableGatewayDetalle;
    
    public function __construct(TableGatewayInterface $tableGatewayInterface){
        $this->tableGateway = $tableGatewayInterface;
        
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new DetalleOdontograma());
        $this->tableGatewayTratamiento = new TableGateway('tratamiento',
            $this->tableGateway->getAdapter(), null, $resultSetPrototype);
    
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new DetalleOdontograma());
        $this->tableGatewayDetalle = new TableGateway('detalle_odontograma',
            $this->tableGateway->getAdapter(), null, $resultSetPrototype);
    }

    public function save($userId, $data){
        
    }
    
    public function fetchAll($where = ['detalle_odontograma.ACTIVE' => true])
    {
        return $this->JoinBase($this->tableGatewayDetalle, 'tratamiento',
            'detalle_odontograma.ID_TRATAMIENTO=tratamiento.ID_TRATAMIENTO',
            ['NOMBRE'], $where, true);
    }
}