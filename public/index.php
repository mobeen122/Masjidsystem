<?php

use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\Application;


error_reporting(E_ALL);

/**
 * Define some useful constants
 */
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
define('PUB_PATH', __DIR__);

try {

    /**
     * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
     */
    $di = new FactoryDefault();

    /**
     * Read services
     */
    include APP_PATH . "/config/services.php";

    /**
     * Get config service for use in inline setup below
     */
    $config = $di->getConfig();

    /**
     * Include Autoloader
     */
    include APP_PATH . '/config/loader.php';

    /**
    * Handle the request
    */
    $application = new Application($di);
   /*  $application->registerModules([
        'customers' => [
            'className' => 'App\Customers',
            'path'      => '../App/Modules/Customers/Module.php'
        ],
    ]); */
    
    echo preg_replace("/\s+/", " ", $application->handle()->getContent());
    
        
} catch (Exception $e) {
	echo $e->getMessage(). '<br>';
	echo nl2br(htmlentities($e->getTraceAsString()));
}



