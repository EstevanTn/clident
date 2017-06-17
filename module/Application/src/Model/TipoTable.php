<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGatewayInterface;
use Application\Model\BaseTable;
use Application\Model\Entity\Tipo;
use Application\Model\Entity\TipoGrupo;
use Application\Model\Entity\Enviroment;

class TipoTable extends BaseTable {

    var $tableGatewayTipoGrupo = null;

    public function __construct(TableGatewayInterface $tableGateway){
        $this->tableGateway = $tableGateway;
        $resultSetPrototype = new \Zend\Db\ResultSet\ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new \Application\Model\Entity\TipoGrupo());
        $this->tableGatewayTipoGrupo = new \Zend\Db\TableGateway\TableGateway('tipo_grupo', $this->tableGateway->getAdapter(), null, $resultSetPrototype);
    }

    public function saveGrupo($userId, $data){
        $id = (int) $data['ID_GRUPO'];
        if($id===0){
            $this->tableGatewayTipoGrupo->insert([
                'NOMBRE_GRUPO'  =>  $data['NOMBRE'],
                'DESCRIPCION_GRUPO' => $data['DESCRIPCION']
            ]);
            return [
                'success' => true,
                'message'   =>  Enviroment::MSG_SAVE
            ];
        }else{
            $this->tableGatewayTipoGrupo->update([
                'NOMBRE_GRUPO'  =>  $data['NOMBRE'],
                'DESCRIPCION_GRUPO' => $data['DESCRIPCION']
            ], ['ID_GRUPO'=>$id]);
            return [
                'success' => true,
                'message'   =>  Enviroment::MSG_UPDATE
            ];
        }
    }

    public function save($userId, $data){
        $id = (int) $data['ID_TIPO'];
        $obj = array();
        $obj['ID_GRUPO'] = $data['ID_GRUPO'];
        $obj['NOMBRE'] = $data['NOMBRE'];
        $obj['VALOR'] = $data['VALOR'];
        $obj['SIGLA'] = $data['SIGLA'];
        if($id===0){
            $obj['FECHA_CREACION'] = Enviroment::GetDate();
            $obj['USUARIO_CREACION'] = $userId;
            $obj['ACTIVE'] = true;
            $this->tableGateway->insert($obj);
            return[
                'success'   => true,
                'message'   => Enviroment::MSG_SAVE
            ];
        }else{
            $obj['FECHA_MODIFICACION'] = Enviroment::GetDate();
            $obj['USUARIO_MODIFICACION'] = $userId;
            $this->tableGateway->update($obj, [ 'ID_TIPO' => $id ]);
            return[
                'success'   => true,
                'message'   => Enviroment::MSG_UPDATE
            ];
        }
    }

    public function fetchAll($where){
        return $this->Join(
            'tipo_grupo', 
            'tipo.ID_GRUPO=tipo_grupo.ID_GRUPO',
            TipoGrupo::getVarNames(), 
            $where, 
            true);
    }

    public function fetchAllGrupo($nombre){
        $resultSet = $this->tableGatewayTipoGrupo->select();
        $entries = array();
        foreach($resultSet as $row){
            $entries[] = get_object_vars($row);
        }
        return $entries;
    }
}