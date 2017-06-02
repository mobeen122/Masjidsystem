<?php
use Phalcon\Mvc\View;
use Phalcon\Crypt;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\Model\Metadata\Files as MetaDataAdapter;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Flash\Direct as Flash;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Logger\Adapter\File as FileLogger;
use Phalcon\Logger\Formatter\Line as FormatterLine;
use App\Auth\Auth;
use App\Acl\Acl;
use App\Mail\Mail;
use App\AssetsManager;
use Phalcon\Mvc\View\Engine\Php;
use Phalcon\Cache\Frontend\Output as OutputFrontend;
use Phalcon\Cache\Backend\Memcache as MemcacheBackend;
use Phalcon\Flash\Session;
use MongoDB\Driver\Manager;

use Phalcon\Mvc\Collection\Manager as MongoCollection;
use Phalcon\Db\Adapter\MongoDB\Client as MongoClient;
use Phalcon\Security;



/**
 * Register the global configuration as config
 */
$di->setShared('config', function () {
    $config = include APP_PATH . '/config/config.php';
    
    if (is_readable(APP_PATH . '/config/config.dev.php')) {
        $override = include APP_PATH . '/config/config.dev.php';
        $config->merge($override);
    }
    
    return $config;
});

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->setShared('url', function () {
    $config = $this->getConfig();

    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);
    return $url;
});

/**
 * Setting up the view component
 */
$di->set('view', function () {
    $config = $this->getConfig();

    $view = new View();
    
    //$view->setLayoutsDir($config->application->layoutDir);
    $view->setViewsDir($config->application->viewsDir);

    $view->registerEngines([
       '.volt' => function ($view) {
            $config = $this->getConfig();

            $volt = new VoltEngine($view, $this);

            $volt->setOptions([
                'compiledPath' => $config->application->cacheDir . 'volt/',
                'compiledSeparator' => '_'
            ]);

            return $volt;
        },
        '.php'  => function ($view) {
            $config = $this->getConfig();

            $engine = new Php($view, $this);
            return $engine;
        },
        '.phtml'  => function ($view) {
            $config = $this->getConfig();

            $engine = new Php($view, $this);
            return $engine;
        },
    ]);

    return $view;
}, true);

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->set('db', function () {
    $config = $this->getConfig();
    return new DbAdapter([
        'host' => $config->database->host,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'dbname' => $config->database->dbname
    ]);
});

    // Initialise the mongo DB connection.
$di->setShared('mongo', function () {
    /** @var \Phalcon\DiInterface $this */
    $config = $this->getConfig();
    
    if (!$config->database->mongo->username || !$config->database->mongo->password) 
    {
            $dsn = 'mongodb://' . $config->database->mongo->hostname.':'.$config->database->mongo->port;
    } 
    else 
    {
        $dsn = sprintf('mongodb://%s:%s@%s'.$config->database->mongo->username,
            $config->database->mongo->password,
            $config->database->mongo->hostname.':'.$config->database->mongo->port
        );
    }
    $mongo = new MongoClient($dsn);
        return $mongo->selectDatabase($config->database->mongo->database);
});

    // Collection Manager is required for MongoDB
$di->setShared('collectionManager', function () {
   return new MongoCollection();
});

/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->set('modelsMetadata', function () {
    $config = $this->getConfig();
    return new MetaDataAdapter([
        'metaDataDir' => $config->application->cacheDir . 'metaData/'
    ]);
});

/**
 * Start the session the first time some component request the session service
 */
$di->set('session', function () {
    $session = new SessionAdapter();
    $session->start();
    return $session;
});

/**
 * Crypt service
 */
$di->set('crypt', function () {
    $config = $this->getConfig();

    $crypt = new Crypt();
    $crypt->setKey($config->application->cryptSalt);
    return $crypt;
});

/**
 * Dispatcher use a default namespace
 */
$di->set('dispatcher', function () {
    $dispatcher = new Dispatcher();
    
    $eventsManager = new EventsManager;
    $eventsManager->attach("dispatch:beforeException", function($event, $dispatcher, $exception) {
    
        //Handle 404 exceptions
        if ($exception instanceof \Phalcon\Mvc\Dispatcher\Exception) {
            $dispatcher->forward(array(
                'controller' => 'error',
                'action' => 'show404'
            ));
            return false;
        }
    
        //Handle other exceptions
        $dispatcher->forward(array(
            'controller' => 'error',
            'action' => 'show503'
        ));
    
        return false;
    });
    
    
    $dispatcher->setEventsManager($eventsManager);
    $dispatcher->setDefaultNamespace('App\Controllers');
    return $dispatcher;
});

/**
 * Loading routes from the routes.php file
 */
$di->set('router', function () {
    return require APP_PATH . '/config/routes.php';
});

/**
 * Flash service with custom CSS classes
 */
$di->set('flash', function () {
    return new Flash([
        'error' => 'alert alert-danger',
        'success' => 'alert alert-success',
        'notice' => 'alert alert-info',
        'warning' => 'alert alert-warning'
    ]);
     
});

/**
 * Custom authentication component
 */
$di->set('auth', function () {
    return new Auth();
});

/**
 * Mail service uses AmazonSES
 */
$di->set('mail', function () {
    return new Mail();
});


$di->set("viewCache", function () {
    // Cache data for one day by default
    $frontCache = new OutputFrontend(
        [
            "lifetime" => 86400,
        ]
    );

    // Memcached connection settings
    $cache = new MemcacheBackend(
        $frontCache,
        [
            "host" => "localhost",
            "port" => "11211",
        ]
    );

    return $cache;
});

/**
 * Access Control List
 */
$di->set('acl', function () {
    return new Acl();
});

/**
 * Assets Manager
 */
$di->setShared('assets',function(){
    $assetManager = new AssetsManager();
    return $assetManager;
});

/**
 * Set Security
 */
$di->set("security", function () 
{
    $security = new Security();
            
    // Set the password hashing factor to 12 rounds
    $security->setWorkFactor(12);
            
    return $security;
}, true );
/**
 * Logger service
 */
$di->set('logger', function ($filename = null, $format = null) {
    $config = $this->getConfig();

    $format   = $format ?: $config->get('logger')->format;
    $filename = trim($filename ?: $config->get('logger')->filename, '\\/');
    $path     = rtrim($config->get('logger')->path, '\\/') . DIRECTORY_SEPARATOR;

    $formatter = new FormatterLine($format, $config->get('logger')->date);
    $logger    = new FileLogger($path . $filename);

    $logger->setFormatter($formatter);
    $logger->setLogLevel($config->get('logger')->logLevel);

    return $logger;
});
