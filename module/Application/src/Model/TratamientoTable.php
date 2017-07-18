<?php
namespace Application\Model;

use Application\Model\Entity\Enviroment;
use Zend\Db\TableGateway\TableGatewayInterface;

class TratamientoTable extends BaseTable{

    public function __construct(TableGatewayInterface $tableGatewayInterface) {
        $this->tableGateway = $tableGatewayInterface;
    }

    public function save($userId, $data) {
        $id = (int) $data['ID_TRATAMIENTO'];
        if($id===0){
            $dataInsert = [
                'NOMBRE' => $data['NOMBRE'],
                'DESCRIPCION' => $data['DESCRIPCION'],
                'APLICA_CARA' => $data['APLICA_CARA'],
                'APLICA_DIENTE' => $data['APLICA_DIENTE'],
                'PRECIO' => $data['PRECIO'],
                'ACTIVE' => true,
                'FECHA_CREACION' => Enviroment::GetDate(),
                'USUARIO_CREACION' => $userId
            ];
            $this->tableGateway->insert($dataInsert);
            return [
              'success' => true,
                'message' => Enviroment::MSG_SAVE,
            ];
        }else{
            $dataUpdate = [
                'NOMBRE' => $data['NOMBRE'],
                'DESCRIPCION' => $data['DESCRIPCION'],
                'APLICA_CARA' => (bool) $data['APLICA_CARA'],
                'APLICA_DIENTE' => (bool) $data['APLICA_DIENTE'],
                'PRECIO' => $data['PRECIO'],
                'USUARIO_MODIFICACION' => $userId,
                'FECHA_MODIFICACION' => Enviroment::GetDate(),
            ];
            $this->tableGateway->update($dataUpdate, [
                'ID_TRATAMIENTO' => $id
            ]);
            return [
                'success' => true,
                'message' => Enviroment::MSG_UPDATE,
                'data' => $dataUpdate
            ];
        }
    }
}