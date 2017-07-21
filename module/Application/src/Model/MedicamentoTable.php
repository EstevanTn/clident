<?php
/**
 * Apps TunaquiSoft (http://apps-tnqsoft.azurewebsites.net/)
 * -------------------------------------------------------------------------------
 * This file is part of the clident project.
 *
 * @autor @EstevanTn
 * @email tunaqui@outlook.es
 * @copyright Copyright © 2017 - TunaquiSoft
 * @website http://apps-tnqsoft.azurewebsites.net/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 20/07/2017
 **/

namespace Application\Model;


use Application\Model\Entity\UnidadMedida;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\TableGatewayInterface;

class MedicamentoTable extends BaseTable
{
    var $tableGatewayUnidad;
    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;

        $resultSet = new ResultSet();
        $resultSet->setArrayObjectPrototype(new UnidadMedida());
        $this->tableGatewayUnidad = new TableGateway('unidad_medida',
            $this->tableGateway->getAdapter(), null, $resultSet);
    }

    public function save($userId, $data)
    {
        // TODO: Implement save() method.
    }

    public function fetchAllUnidades($where=['ACTIVE'=>true]){
        $result = $this->tableGatewayUnidad->select($where);
        return $this->toEntries($result);
    }
}