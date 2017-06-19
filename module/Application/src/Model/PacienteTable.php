<?php
namespace Application\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;
use Application\Model\BaseTable;
use Zend\Db\Sql\Select;
use Application\Model\Entity\Paciente;
use Application\Model\Entity\Persona;
use Application\Model\Entity\Enviroment;

class PacienteTable extends BaseTable{
    var $tableGatewayPersona;
    public function __construct(TableGatewayInterface $tableGatewayInterface){
        $this->tableGateway = $tableGatewayInterface;
        $resultSetPrototype = new \Zend\Db\ResultSet\ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new \Application\Model\Entity\Persona());
        $this->tableGatewayPersona = new \Zend\Db\TableGateway\TableGateway('persona', $this->tableGateway->getAdapter(), null, $resultSetPrototype);
    }

    public function save($userId, $data){
        $data['ID_PERSONA'] = (int) $data['ID_PERSONA'];
        $data['ID_PACIENTE'] = (int) $data['ID_PACIENTE'];
        $data['TIPO_DOCUMENTO'] = (int) $data['TIPO_DOCUMENTO'];
        $persona = [
            'ID_PERSONA'    =>  $data['ID_PERSONA'],
            'TIPO_DOCUMENTO'  => $data['TIPO_DOCUMENTO'],
            'NUMERO_DOCUMENTO'  => $data['NUMERO_DOCUMENTO'],
            'ACTIVE'    =>  true,
            'NOMBRE'    =>  $data['NOMBRE'],
            'TELEFONO'    =>  $data['TELEFONO'],
            'CELULAR'    =>  $data['CELULAR'],
            'APELLIDOS'    =>  $data['APELLIDOS'],
            'DIRECCION'    =>  $data['DIRECCION'],
            'EMAIL'    =>  $data['EMAIL'],
            'FECHA_NACIMIENTO'    =>  $data['FECHA_NACIMIENTO'],
            'CELULAR'    =>  $data['CELULAR'],
            'TELEFONO'    =>  $data['TELEFONO'],
        ];
        
        if($data['ID_PACIENTE']===0){
            $persona['USUARIO_CREACION'] = $userId;
            $persona['FECHA_CREACION'] = Enviroment::GetDate();
            $result1 = $this->tableGatewayPersona->insert($persona);
            $idpersona = $this->tableGatewayPersona->getLastInsertValue();
            $paciente = [
                'ID_PERSONA'    =>  $idpersona,
                'ID_PACIENTE'    =>  $data['ID_PACIENTE'],
                'ACTIVE'    =>  true,
                'USUARIO_CREACION' => $userId,
                'FECHA_CREACION' => Enviroment::GetDate(),
            ];
            $result = $this->tableGateway->insert($paciente);
            return [
                'success'   =>  true,
                'message'   =>  Enviroment::MSG_SAVE,
                'id'      =>  $this->tableGateway->getLastInsertValue()
            ];
        }else{
            $id = $data['ID_PACIENTE'];
            $idpersona = $data['ID_PERSONA'];
            $row = $this->getX( $id);
            $paciente = [
                'ID_PERSONA'    =>  $data['ID_PERSONA'],
                'ID_PACIENTE'    =>  $id,
                'ACTIVE'    =>  true,
                'USUARIO_MODIFICACION'  =>  $userId,
                'FECHA_MODIFICACION' => Enviroment::GetDate()
            ];
            $persona['USUARIO_MODIFICACION'] = $userId;
            $persona['FECHA_MODIFICACION'] = Enviroment::GetDate();
            $result = $this->tableGateway->update($paciente, ['ID_PACIENTE'=>$id]);
            $result1= $this->tableGatewayPersona->update($persona, ['ID_PERSONA'=>$idpersona] );
            return[
                'success'   =>  true,
                'message'   =>  Enviroment::MSG_UPDATE
            ];
        }
    }

    public function getX($id){
        $id = (int) $id;
        $resultSet = $this->Join(
            'persona', 
            'paciente.ID_PERSONA=persona.ID_PERSONA', 
            Persona::getVarNames(), 
            ['paciente.ACTIVE'=>true, 'paciente.ID_PACIENTE'=>$id]
           )->current();
        if(!$resultSet){
            throw new \Exception(Enviroment::NOT_FIND);
        }
        return get_object_vars($resultSet);
    }

    public function fetchAll(){
       return $this->Join(
            'persona', 
            'paciente.ID_PERSONA=persona.ID_PERSONA', 
            Persona::getVarNames(), 
            ['paciente.ACTIVE'=>true], 
            true
           );
        
    }

    public function searchQuery($nombre){
        return $this->Join(
            'persona', 
            'paciente.ID_PERSONA=persona.ID_PERSONA', 
            Persona::getVarNames(), 
            'paciente.ACTIVE = true AND NOMBRE LIKE \'%'.$nombre.'%\' OR APELLIDOS LIKE \'%'.$nombre.'%\'', 
            true
           );
    }
}