<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\EventManager\EventInterface as Event;

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
            ],
        ];
    }
    
    public function onBootstrap(Event $e)
    {
//        $e->getApplication()->getServiceManager()->get('translator');
//        $e->getApplication()->getServiceManager()->get('viewhelpermanager')->setFactory('controllerName', function($sm) use ($e) {
//            $viewHelper = new View\Helper\ControllerName($e->getRouteMatch());
//            return $viewHelper;
//        });
//
//        $eventManager        = $e->getApplication()->getEventManager();
//        $moduleRouteListener = new ModuleRouteListener();
//        $moduleRouteListener->attach($eventManager);
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
