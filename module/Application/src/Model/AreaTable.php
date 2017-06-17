<?php
namespace Application\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;
use Application\Model\Entity\Area;
use Application\Model\Entity\Enviroment;
use Application\Model\BaseTable;

class AreaTable extends BaseTable{

    public function __construct(TableGatewayInterface $tableGateway){
        $this->tableGateway = $tableGateway;
    }

    public function save($userId, $arrData){
        try {
            $result = 0;
            $arrData['ID_AREA'] = (int) $arrData['ID_AREA'];
            $arrData['ID_PARENT_AREA'] = ((int)$arrData['ID_PARENT_AREA']) == 0? null : ((int)$arrData['ID_PARENT_AREA']);
            if (((int)$arrData['ID_AREA'])===0) {
                $arrData['FECHA_CREACION'] = Enviroment::GetDate();
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
                    $arrData['FECHA_MODIFICACION'] = Enviroment::GetDate();
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