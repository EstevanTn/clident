<?php
namespace Application\Model;

use Application\Model\Entity\Menu;
use Application\Model\Entity\MenuRol;
use Application\Model\Entity\Personal;
use Application\Model\Entity\Settings;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\TableGatewayInterface;
use Application\Model\Entity\Enviroment;
use Application\Model\Entity\Persona;

class UsuarioTable extends BaseTable{
    
    var $tableGatewayPersona;
    var $tableGatewaySettings;
    var $tableGatewayMenu;

    public function __construct(TableGatewayInterface $tableGateway){
        $this->tableGateway = $tableGateway;
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Persona());
        $this->tableGatewayPersona = new TableGateway('persona', $this->tableGateway->getAdapter(), null, $resultSetPrototype);

        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Settings());
        $this->tableGatewaySettings = new TableGateway('ajustes',
            $this->tableGateway->getAdapter() , null , $resultSetPrototype);

        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Menu());
        $this->tableGatewayMenu = new TableGateway('menu',
            $this->tableGateway->getAdapter(), null, $resultSetPrototype);
    }
    
    public function save($userId, $data)
    {
        
    }
    
    public function autenticate($usr, $pwd){
        $select = new Select('usuario');
        $select->join('persona',
            'usuario.ID_PERSONA=persona.ID_PERSONA',
            Persona::getVarNames())
            ->join('personal',
                'persona.ID_PERSONA=personal.ID_PERSONA',
                    Personal::getVarNames())
            ->where([
                'usuario.ACTIVE' => true,
                'usuario.USERNAME' => $usr,
                'usuario.PASSWORD'  => sha1($pwd)
            ]);
        $resultSet = $this->tableGateway->selectWith($select);

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
            $this->getAppSettings();
            return array(
                'IsSuccess' => true,
                'Message' => 'Bienvenido al sistema.'
            );
        }
    }

    public function getAppSettings(){
        $resultSet = $this->tableGatewaySettings->select();
        $entries = $this->toEntries($resultSet);
        define(KEY_PERSONAL_DENTISTA, (int) $entries[0]['VALOR']);
        define(KEY_PRE_CITA, (int) $entries[1]['VALOR']);
        define(KEY_CITA, (int) $entries[2]['VALOR']);
        //define(KEY_PERSONAL_DENTISTA, $entries[0]['VALOR']);
    }

    public function buildMenu(){
        $id_rol = Enviroment::GetCookieValue('ID_ROL');
        $select = new Select('menu');
        $select->join('menu_rol',
            'menu.ID_MENU=menu_rol.ID_MENU',
            MenuRol::getColumnNames())
        ->where([ 'ID_ROL' => $id_rol ]);

        $resultSet = $this->tableGatewayMenu->selectWith($select);
        $menu_principal = $this->toEntries($resultSet);

        $select = new Select('menu');
        $resultSet = $this->tableGatewayMenu->selectWith($select);
        $sub_menus = $this->toEntries($resultSet);

        $menu = array();
        $i = 0;
        foreach($menu_principal as $m){
            $id_menu = (int) $m['ID_MENU'];
            $menu[$i] = array();
            $menu[$i]['label'] = $m['NOMBRE'];
            $menu[$i]['title'] = $m['DESCRIPCION'];
            $menu[$i]['icon'] = $m['ICONO'];
            $menu[$i]['href'] = $m['URL'];
            $menu[$i]['pages'] = array();
            $contollers = '';
            $x = 0;
            foreach ($sub_menus as $sbm){
                $id_pmenu = (int) $sbm['ID_PARENT_MENU'];
                if($id_menu==$id_pmenu){
                    $menu[$i]['pages'][$x] = array();
                    $menu[$i]['pages'][$x]['label'] = $sbm['NOMBRE'];
                    $menu[$i]['pages'][$x]['title'] = $sbm['DESCRIPCION'];
                    $menu[$i]['pages'][$x]['icon'] = $sbm['ICONO'];
                    $menu[$i]['pages'][$x]['href'] = $sbm['URL'];
                    $contollers.=$sbm['URL'].',';
                    $x++;
                }
            }
            $contollers = substr($contollers,0,(strlen($contollers)-1));
            $menu[$i]['controllers'] = $contollers;
            $i++;
        }
        return $menu;
    }
    
}