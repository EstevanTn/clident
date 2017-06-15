<?php
namespace Application\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;
use Application\Model\Entity\Area;
use Application\Model\Entity\Enviroment;

class AreaTable{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway){
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll(){
        $resultSet = $this->tableGateway->select();
        $entries = array();
        foreach ($resultSet as $row) {
            $entities[] = get_object_vars($row);
        }
        return $entities;
    }

    public function get($id){
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('ID_AREA' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception(Enviroment::NOT_FIND);
        }
        return $row;
    }

    public function save($userId, $arrData){
        try {
            $result = 0;
            $date = getdate();
            $arrData['ID_PARENT_AREA'] = ((int)$arrData['ID_PARENT_AREA']) == 0? null : ((int)$arrData['ID_PARENT_AREA']);
            if (((int)$arrData['ID_AREA'])==0) {
                $arrData['FECHA_CREACION'] = sprintf('%s-%s-%s', $date['year'], $date['mon'], $date['mday']);
                $arrData['USUARIO_CREACION'] = $userId;
                $arrData['ACTIVE'] = true;
                $arrData['ESTADO'] = 1;
                $result = $this->tableGateway->insert($arrData);
                return [
                    'success'   =>  true,
                    'message'   =>  Enviroment::MSG_SAVE,
                    'id'    =>  $this->tableGateway->getLastInsertValue()
                ];
            }else{
                if ($this->get($arrData['ID_AREA'])) {
                    $arrData['FECHA_MODIFICACION'] = sprintf('%s-%s-%s', $date['year'], $date['mon'], $date['mday']);
                    $arrData['USUARIO_MODIFICACION'] = $userId;
                    $result = $this->tableGateway->update($arrData, ['ID_AREA'=> $arrData['ID_AREA']]);
                    return [
                        'success'   =>  true,
                        'message'   =>  Enviroment::MSG_UPDATE
                    ];
                }else{
                    return [
                        'success'   =>  'custom',
                        'message'   =>  Enviroment::NOT_FIND
                    ];
                }
            }
        } catch (\Exception $e) {
            return [
                'success'   =>  false,
                'message'   =>  htmlspecialchars($e->getMessage())
            ];
        }
    }
}