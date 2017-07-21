<?php
namespace Application\Model;

use Application\Model\Entity\DetalleOdontograma;
use Application\Model\Entity\Enviroment;
use Application\Model\Entity\Marca;
use Application\Model\Entity\Medicacion;
use Application\Model\Entity\Medicamento;
use Application\Model\Entity\Tratamiento;
use RuntimeException;
use const true;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\TableGatewayInterface;

class OdontogramaTable extends BaseTable{
    
    var $tableGatewayTratamiento;
    var $tableGatewayDetalle;
    var $tableGatewayMedicacion;
    
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

        $resultSetPrototype3 = new ResultSet();
        $resultSetPrototype3->setArrayObjectPrototype(new Medicacion());
        $this->tableGatewayMedicacion = new TableGateway('medicacion',
            $this->tableGateway->getAdapter(), null, $resultSetPrototype3);
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
                'message' => Enviroment::MSG_ERROR
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
                'message' => Enviroment::MSG_ERROR
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

    public function getAllMedicacionItemDetalle($where){
        $select = new Select('medicacion');
        $select->join('medicamento',
            'medicacion.ID_MEDICAMENTO=medicamento.ID_MEDICAMENTO',
            Medicamento::getColumnNames())
            ->join('marca',
                'medicamento.ID_MARCA=marca.ID_MARCA',
                Marca::getColumnNames())
            ->where($where);
        $resultSet = $this->tableGatewayMedicacion->selectWith($select);
        return $this->toEntries($resultSet);
    }

    public function saveMedicacion($data){
        $userId = Enviroment::GetCookieValue('ID_USUARIO');
        try{
            $id = (int) $data['ID_MEDICACION'];
            $dataX = [
                'ID_DETALLE_ODONTOGRAMA' => $data['ID_DETALLE_ODONTOGRAMA'],
                'ID_MEDICAMENTO' => $data['ID_MEDICAMENTO'],
                'ID_UNIDAD_MEDIDA' => $data['ID_UNIDAD_MEDIDA'],
                'CANTIDAD' => $data['CANTIDAD'],
                'DESCRIPCION_MEDICACION' => $data['DESCRIPCION_MEDICACION']
            ];
            if($id===0){
                $dataX['ACTIVE'] = true;
                $dataX['USUARIO_CREACION'] = $userId;
                $dataX['FECHA_CREACION'] = Enviroment::GetDate();
                $this->tableGatewayMedicacion->insert($dataX);
                return [
                    'success' => true,
                    'message' => Enviroment::MSG_SAVE
                ];
            }else{
                $dataX['FECHA_MODIFICACION'] = Enviroment::GetDate();
                $dataX['USUARIO_MODIFICACION'] = $userId;
                $this->tableGatewayMedicacion->update($dataX, [ 'ID_MEDICACION' => $id ] );
                return [
                    'success' => true,
                    'message' => Enviroment::MSG_UPDATE
                ];
            }
        }catch (\Exception $ex){
            return [
                'success' => false,
                'message' => Enviroment::MSG_ERROR
            ];
        }
    }

    public function deleteMedicacion($id_medicacion){
        try{
            $id_medicacion = (int) $id_medicacion;
            $dataX = array();
            $dataX['ACTIVE'] = false;
            $dataX['FECHA_MODIFICACION'] = Enviroment::GetDate();
            $dataX['USUARIO_MODIFICACION'] = Enviroment::GetCookieValue('ID_USUARIO');
            $this->tableGatewayMedicacion->update($dataX, [ 'ID_MEDICACION' => $id_medicacion ] );
            return [
                'success' => true,
                'message' => Enviroment::MSG_DELETE
            ];
        }catch (\Exception $ex){
            return [
                'success' => false,
                'message' => Enviroment::MSG_ERROR
            ];
        }
    }

    public function getMedicacion($id_medicacion){
        $select = new Select('medicacion');
        $select->join('medicamento',
            'medicacion.ID_MEDICAMENTO=medicamento.ID_MEDICAMENTO',
            Medicamento::getColumnNames())
            ->join('marca',
                'medicamento.ID_MARCA=marca.ID_MARCA',
                Marca::getColumnNames())
            ->where(['medicacion.ID_MEDICACION' => $id_medicacion]);
        $resultSet = $this->tableGatewayMedicacion->selectWith($select);
        return $this->toEntries($resultSet)[0];
    }

}