<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return [
    'service_manager'    =>  [
        'factories' =>  [
            Zend\Db\Adapter\Adapter::class   =>  Zend\Db\Adapter\AdapterServiceFactory::class,
        ]
    ],
    'db'    =>  [
        'username'  =>  'root',
        'password'  =>  '',
        'driver'    =>  'Pdo',
<<<<<<< HEAD
        'dsn'       =>  'mysql:dbname=db_clident;host=localhost',
=======
        'dsn'       =>  'mysql:dbname=clident;host=127.0.0.1',
>>>>>>> af9e969501b99e3a379514d0bc20eb86cd3c9a8f
        'driver_options'    =>  [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'utf8\''
        ]
    ]
];
