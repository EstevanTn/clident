<?php
namespace Application\Model;

use Application\Model\Entity\Enviroment;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;

abstract class BaseTable {

    public $tableGateway = null;

    abstract public function save($userId, $data);

    public function fetchAll($where=['ACTIVE'=>true]){
        $resultSet = $this->tableGateway->select($where);
        return $this->toEntries($resultSet);
    }

    public function get($nameKey, $id){
        $id  = (int) $id;
        $rowset = $this->tableGateway->select([ $nameKey => $id ]);
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception(Enviroment::NOT_FIND);
        }
        return get_object_vars($row);
    }

    public function delete($userId, $nameKey, $id){
        try{
            $id = (int) $id;
            $row = array();
            $row['ACTIVE'] = false;
            $row['FECHA_MODIFICACION'] = Enviroment::GetDate();
            $row['USUARIO_MODIFICACION'] = $userId;
            $this->tableGateway->update($row, [ $nameKey => $id ]);
            return [
                'success'   =>  true,
                'message'   =>  Enviroment::MSG_DELETE,
            ];
        }catch (\Exception $ex){
            return [
                'success' => false,
                'message' => Enviroment::MSG_ERROR.': '.$ex->getMessage()
            ];
        }
    }

    public function Join($table, $condition, $columns, $where, $typeEntries=false){
        return $this->JoinBase($this->tableGateway, $table, $condition, $columns, $where, $typeEntries);
    }
    
    public function JoinBase(TableGateway $tableGateway, $table, $condition, $columns, $where, $typeEntries=false){
        $actualTable = $tableGateway->getTable();
        $select = new Select($actualTable);
        $select->join(
            $table,
            $condition,
            $columns,
            Select::JOIN_INNER
        )->where($where);
        $resultSet = $tableGateway->selectWith($select);
        if($typeEntries){
            $entries = array();
            foreach ($resultSet as $row) {
                $entries[] = get_object_vars($row);
            }
            return $entries;
        }
        return $resultSet;
    }

    public function toEntries($resultSet){
        $entries = array();
        foreach ($resultSet as $row) {
            $entries[] = get_object_vars($row);
        }
        return $entries;
    }
}
