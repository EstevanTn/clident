<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGatewayInterface;
use Application\Model\Entity\Enviroment;
use Zend\Mvc\Application;
use Application\Model\Entity\Persona;

class UsuarioTable extends BaseTable{
    
    var $tableGatewayPersona;
    
    public function __construct(TableGatewayInterface $tableGateway){
        $this->tableGateway = $tableGateway;
        $resultSetPrototype = new \Zend\Db\ResultSet\ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new \Application\Model\Entity\Persona());
        $this->tableGatewayPersona = new \Zend\Db\TableGateway\TableGateway('persona', $this->tableGateway->getAdapter(), null, $resultSetPrototype);
    }
    
    public function save($userId, $data)
    {
        
    }
    
    public function autenticate($usr, $pwd){
        $resultSet = $this->Join('persona', 
            'usuario.ID_PERSONA=persona.ID_PERSONA', 
            Persona::getVarNames(), array(
                'usuario.ACTIVE' => true,
                'usuario.USERNAME' => $usr,
                'usuario.PASSWORD'  => sha1($pwd)
            ));
        $entry = $resultSet->current();
        if(!$entry){
            return array(
                'IsSuccess' => false,
                'Message' => 'No se ha encontrado el usuario.'
            );
        }else{
            $entry = get_object_vars($entry);
            $path = '/';
            $_SESSION[Enviroment::NAME_SESSION] = $entry['USERNAME'];
            setcookie(Enviroment::NAME_COOKIE, json_encode($entry), time()*3600, $path);
            return array(
                'IsSuccess' => true,
                'Message' => 'Bienvenido al sistema.'
            );
        }
    }

    
}