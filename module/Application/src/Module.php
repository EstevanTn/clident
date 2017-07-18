<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Application\Controller\AuthController;
use Application\Controller\SiteController;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\EventManager\EventInterface as Event;
//
use Application\Model\Entity\Enviroment;
use Zend\ServiceManager\Factory\InvokableFactory;

//use Application\Service\AuthAdapter;
//use Zend\Authentication\Storage\Session;
//use Zend\Authentication\AuthenticationService;

class Module implements ConfigProviderInterface
{
    const VERSION = '3.0.3-dev';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    
    public function getServiceConfig(){
        return [
            'factories' => [
                Model\AreaTable::class => function($container){
                    $tableGateway = $container->get(Model\AreaTableGateway::class);
                    return new Model\AreaTable($tableGateway);
                },
                Model\AreaTableGateway::class => function($container){
                    $dbAdapter = $container->get(\Zend\Db\Adapter\AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Entity\Area());
                    return new TableGateway('area', $dbAdapter, null, $resultSetPrototype);
                },
                Model\PacienteTable::class => function($container){
                    $tableGateway = $container->get(Model\PacienteTableGateway::class);
                    return new Model\PacienteTable($tableGateway);
                },
                Model\PacienteTableGateway::class => function($container){
                    $dbAdapter = $container->get(\Zend\Db\Adapter\AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Entity\Paciente());
                    return new TableGateway('paciente', $dbAdapter, null, $resultSetPrototype);
                },
                Model\TipoTable::class => function($container){
                    $tableGateway = $container->get(Model\TipoTableGateway::class);
                    return new Model\TipoTable($tableGateway);
                },
                Model\TipoTableGateway::class => function($container){
                    $dbAdapter = $container->get(\Zend\Db\Adapter\AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Entity\Tipo());
                    return new TableGateway('tipo', $dbAdapter, null, $resultSetPrototype);
                },
                Model\OdontogramaTable::class => function($container){
                    $tableGateway = $container->get(Model\OdontogramaTableGateway::class);
                    return new Model\OdontogramaTable($tableGateway);
                },
                Model\OdontogramaTableGateway::class => function($container){
                    $dbAdapter = $container->get(\Zend\Db\Adapter\AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Entity\Odontograma());
                    return new TableGateway('odontograma', $dbAdapter, null, $resultSetPrototype);
                },
                Model\PersonalTable::class => function($container){
                    $tableGateway = $container->get(Model\PersonalTableGateway::class);
                    return new Model\PersonalTable($tableGateway);
                },
                Model\PersonalTableGateway::class => function($container){
                    $dbAdapter = $container->get(\Zend\Db\Adapter\AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Entity\Personal());
                    return new TableGateway('personal', $dbAdapter, null, $resultSetPrototype);
                },
                Model\TratamientoTable::class => function($container){
                    $tableGateway = $container->get(Model\TratamientoTableGateway::class);
                    return new Model\TratamientoTable($tableGateway);
                },
                Model\TratamientoTableGateway::class => function($container){
                    $dbAdapter = $container->get(\Zend\Db\Adapter\AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Entity\Tratamiento());
                    return new TableGateway('tratamiento', $dbAdapter, null, $resultSetPrototype);
                },
                Model\UsuarioTableGateway::class => function($container){
                    $dbAdapter = $container->get(\Zend\Db\Adapter\AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Entity\Usuario());
                    return new TableGateway('usuario', $dbAdapter, null, $resultSetPrototype);
                },
                Model\UsuarioTable::class => function($container){
                    $tableGateway = $container->get(Model\UsuarioTableGateway::class);
                    return new Model\UsuarioTable($tableGateway);
                },
                Model\CitaTableGateway::class => function($container){
                    $dbAdapter = $container->get(\Zend\Db\Adapter\AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Entity\Cita());
                    return new TableGateway('cita', $dbAdapter, null, $resultSetPrototype);
                },
                Model\CitaTable::class => function($container){
                    $tableGateway = $container->get(Model\CitaTableGateway::class);
                    return new Model\CitaTable($tableGateway);
                },
                
            ]
        ];
    }
    
    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\IndexController::class => function($container) {
                    return new Controller\IndexController();
                },
                Controller\AreaController::class => function($container) {
                    return new Controller\AreaController(
                        $container->get(Model\AreaTable::class)
                    );
                },
                Controller\PacienteController::class => function($container) {
                    return new Controller\PacienteController(
                        $container->get(Model\PacienteTable::class)
                    );
                },
                Controller\TipoController::class => function($container) {
                    return new Controller\TipoController(
                        $container->get(Model\TipoTable::class)
                    );
                },
                Controller\OdontogramaController::class => function($container) {
                    return new Controller\OdontogramaController(
                        $container->get(Model\OdontogramaTable::class)
                    );
                },
                Controller\PersonalController::class => function($container) {
                    return new Controller\PersonalController(
                        $container->get(Model\PersonalTable::class)
                    );
                },
                Controller\TratamientoController::class => function($container) {
                    return new Controller\TratamientoController(
                        $container->get(Model\TratamientoTable::class)
                    );
                },
                Controller\AuthController::class => function($container){
                    return new Controller\AuthController(
                        $container->get(Model\UsuarioTable::class)
                    );
                },
                Controller\CitaController::class => function($container){
                  return new Controller\CitaController(
                      $container->get(Model\CitaTable::class)
                  );
                },
                Controller\SiteController::class => InvokableFactory::class,
            ],
        ];
    }
    
    public function onBootstrap(Event $e)
    {
        session_start();
        $em = $e->getApplication()->getEventManager();
        $em->attach('route', array($this, 'verificateSession'));
        //$em->attach('route', array($this, 'checkSession'));
    }
    
    public function verificateSession(Event $e){
        $sm = $e->getApplication()->getServiceManager();
        if(!isset($_COOKIE[Enviroment::NAME_COOKIE])){
            $controller = $e->getRouteMatch()->getParam('controller');
            if ($controller != SiteController::class && $controller != AuthController::class) {
                return $e->getTarget()->getEventManager()->getSharedManager()->attach('Zend\Mvc\Controller\AbstractActionController', 'dispatch', function($e)  {
                    $controller = $e->getTarget();
                    $controller->redirect()->toRoute('site');
                }, -11);
            }
        }else{
            $controller = $e->getRouteMatch()->getParam('controller');
            if($controller == SiteController::class || $controller == AuthController::class){
                return $e->getTarget()->getEventManager()->getSharedManager()->attach('Zend\Mvc\Controller\AbstractActionController', 'dispatch', function($e)  {
                    $controller = $e->getTarget();
                    $controller->redirect()->toRoute('home');
                }, -11);
            }
        }
    }
        
    public function checkSession(Event $e)
    {
        $sm = $e->getApplication()->getServiceManager();
        $nameService = 'AuthService';
        if ( ! $sm->get($nameService)->getStorage()->getSessionManager()
            ->getSaveHandler()
            ->read($sm->get($nameService)->getStorage()->getSessionId())) {
                $controller = $e->getRouteMatch()->getParam('controller');
                if ($controller != 'Auth') {
                    return $e->getTarget()->getEventManager()->getSharedManager()->attach('Zend\Mvc\Controller\AbstractActionController', 'dispatch', function($e)  {
                        $controller = $e->getTarget();
                        $controller->redirect()->toRoute('auth');
                    }, -11);
                }
            }
    }
    
    public function getViewHelperConfig()
    {
       return [
            'factories' => [
                'ControllerName' => function ($sm) {
                    $match = $sm->get('application')->getMvcEvent()->getRouteMatch();
                    return new \Application\View\Helper\ControllerName($match);
                },
            ],
       ];
    }
}
