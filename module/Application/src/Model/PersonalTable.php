<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGatewayInterface;
use Application\Model\BaseTable;
use Application\Model\Entity\Persona;
use Application\Model\Entity\Enviroment;

class PersonalTable extends BaseTable {

    public function __construct(TableGatewayInterface $tableGatewayInterface){
        $this->tableGateway = $tableGatewayInterface;
    }

    public function save($userId, $data){
      $id = (int) $data['ID_PERSONAL'];
      $personal = [

      ];
      try {
        if($id===0){

          return [
            'success'   =>  true,
            'message'   =>  Enviroment::MSG_SAVE
          ];
        }else{
          
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

    public function fetchAll(){
       return $this->Join(
            'persona',
            'personal.ID_PERSONA=persona.ID_PERSONA',
            Persona::getVarNames(),
            ['personal.ACTIVE'=>true],
            true
           );
    }

}
