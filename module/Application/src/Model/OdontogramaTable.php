<?php
namespace Application\Model;

use Application\Model\Entity\DetalleOdontograma;
use Application\Model\Entity\Enviroment;
use Application\Model\Entity\Tratamiento;
use RuntimeException;
use const true;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\TableGatewayInterface;

class OdontogramaTable extends BaseTable{
    
    var $tableGatewayTratamiento;
    var $tableGatewayDetalle;
    
    public function __construct(TableGatewayInterface $tableGatewayInterface){
        $this->tableGateway = $tableGatewayInterface;

        $resultSetPrototype1 = new ResultSet();
        $resultSetPrototype1->setArrayObjectPrototype(new DetalleOdontograma());
        $this->tableGatewayDetalle = new TableGateway('detalle_odontograma',
            $this->tableGateway->getAdapter(), null, $resultSetPrototype1);
        
        $resultSetPrototype2 = new ResultSet();
        $resultSetPrototype2->setArrayObjectPrototype(new Tratamiento());
        $this->tableGatewayTratamiento = new TableGateway('tratamiento',
            $this->tableGateway->getAdapter(), null, $resultSetPrototype2);
    }

    public function save($userId, $data){
        $id = (int) $data['ID_DETALLE_ODONTOGRAMA'];
        $dataQuery = [
            'ID_ODONTOGRAMA' => $data['ID_ODONTOGRAMA'],
            'ID_TRATAMIENTO' => $data['ID_TRATAMIENTO'],
            'NUMERO_DIENTE' => $data['NUMERO_DIENTE'],
            'CARA_DIENTE' => $data['CARA_DIENTE'],
            'ID_DENTISTA' => $data['ID_DENTISTA'],
            'DESCRIPCION' => $data['DESCRIPCION'],
            'ESTADO' => $data['ESTADO'],
            'FECHA_APLICACION' => $data['FECHA_APLICACION']
        ];
        try{
            if($id===0){
                $dataQuery['USUARIO_CREACION'] = $userId;
                $dataQuery['FECHA_CREACION'] = Enviroment::GetDate();
                $dataQuery['ACTIVE'] = true;
                $this->tableGatewayDetalle->insert($dataQuery);
                return [
                    'success' => true,
                    'message' => Enviroment::MSG_SAVE,
                    'id' => $this->tableGatewayDetalle->getLastInsertValue()
                ];
            }else{
                $dataQuery['USUARIO_MODIFICACION'] = $userId;
                $dataQuery['FECHA_MODIFICACION'] = Enviroment::GetDate();
                $this->tableGatewayDetalle->update($dataQuery, ['ID_DETALLE_ODONTOGRAMA' => $id]);
                return [
                    'success' => true,
                    'message' => Enviroment::MSG_UPDATE
                ];
            }
        }catch (\Exception $ex){
            return [
                'success'  => false,
                'message' => Enviroment::MSG_ERROR.': '.$ex->getMessage()
            ];
        }
    }
    
    public function fetchAll($where = ['detalle_odontograma.ACTIVE' => true])
    {
        return $this->JoinBase($this->tableGatewayDetalle, 'tratamiento',
            'detalle_odontograma.ID_TRATAMIENTO=tratamiento.ID_TRATAMIENTO',
            Tratamiento::getColumnNames(), $where, true);
    }

    public function delete($userId, $nameKey, $id)
    {
        try{
            $id = (int) $id;
            $row = array();
            $row['ACTIVE'] = false;
            $row['FECHA_MODIFICACION'] = Enviroment::GetDate();
            $row['USUARIO_MODIFICACION'] = $userId;
            $this->tableGatewayDetalle->update($row, [ $nameKey => $id ]);
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

    public function getDetalle($id){
        try{
            $id  = (int) $id;
            $rowset = $this->tableGatewayDetalle->select([ 'ID_DETALLE_ODONTOGRAMA' => $id ]);
            $row = $rowset->current();
            if (!$row) {
                throw new \Exception(Enviroment::NOT_FIND);
            }
            return get_object_vars($row);
        }catch (\Exception $ex){
            return null;
        }
    }

}