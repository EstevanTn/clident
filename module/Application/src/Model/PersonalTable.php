<?php
namespace Application\Model;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\TableGatewayInterface;
use Application\Model\Entity\Persona;
use Application\Model\Entity\Enviroment;

class PersonalTable extends BaseTable {
    var $tableGatewayPersona;

    public function __construct(TableGatewayInterface $tableGatewayInterface){
        $this->tableGateway = $tableGatewayInterface;
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Persona());
        $this->tableGatewayPersona = new TableGateway('persona', $this->tableGateway->getAdapter(), null, $resultSetPrototype);
    }

    public function save($userId, $data){
      $id = (int) $data['ID_PERSONAL'];
      $idpersona = (int) $data['ID_PERSONA'];
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
      $personal = [
        'ACTIVE'  =>  true,
        'CARGO'   =>  $data['CARGO'],
        'ESPECIALIDAD'  =>  $data['ESPECIALIDAD'],
        'ID_AREA' =>  $data['ID_AREA'],
        'TIPO_PERSONAL' =>  $data['TIPO_PERSONAL'],
        'ACTIVE'  => true,
        'FECHA_INGRESO' =>  $data['FECHA_INGRESO'],
        'FECHA_CONTRATO_INICIO' => $data['FECHA_CONTRATO_INICIO'],
        'FECHA_CONTRATO_FIN'  =>  $data['FECHA_CONTRATO_FIN']
      ];
      try {
        if($id===0){
          $persona['USUARIO_CREACION']  = $userId;
          $persona['FECHA_CREACION']  = Enviroment::GetDate();
          $personal['USUARIO_CREACION']  = $userId;
          $personal['FECHA_CREACION']  = Enviroment::GetDate();
          $this->tableGatewayPersona->insert($persona);
          $idpersona = $this->tableGatewayPersona->getLastInsertValue();
          $personal['ID_PERSONA'] = $idpersona;
          $this->tableGateway->insert($personal);
          return [
            'success'   =>  true,
            'message'   =>  Enviroment::MSG_SAVE,
            'id'        =>  $this->tableGateway->getLastInsertValue(),
          ];
        }else{
          $persona['USUARIO_MODIFICACION']  = $userId;
          $persona['FECHA_MODIFICACION']  = Enviroment::GetDate();
          $personal['USUARIO_MODIFICACION']  = $userId;
          $personal['FECHA_MODIFICACION']  = Enviroment::GetDate();
          $personal['ID_PERSONA'] = $idpersona;
          $this->tableGatewayPersona->update($persona, [ 'ID_PERSONA' => $idpersona ]);
          $this->tableGateway->update($personal, ['ID_PERSONAL', $id]);
          return [
            'success'   =>  true,
            'message'   =>  Enviroment::MSG_UPDATE
          ];
        }
      } catch (\Exception $e) {
        return [
          'success' =>  false,
          'message' =>  htmlspecialchars($e->getMessage())
        ];
      }
    }

    public function fetchAll($where=['personal.ACTIVE'=>true]){
       return $this->Join(
            'persona',
            'personal.ID_PERSONA=persona.ID_PERSONA',
            Persona::getVarNames(),
            $where,
            true
           );
    }

    public function get($key, $id){
        $result = $this->Join(
            'persona',
            'personal.ID_PERSONA=persona.ID_PERSONA',
            Persona::getVarNames(),
            ['personal.ACTIVE'=>true, 'personal.ID_PERSONAL'  =>  $id]);
        $entity = $result->current();
        return get_object_vars($entity);
    }

}
