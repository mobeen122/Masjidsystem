<?php
use Phalcon\Mvc\Router;
use Phalcon\Mvc\View;
use Phalcon\Crypt;
use Phalcon\Flash\Direct;

if (PHP_VERSION_ID < 50600) {
    iconv_set_encoding('internal_encoding', 'UTF-8');
}

$parameters     = include_once __DIR__ . '/parameters.php';
$configuration  = include_once __DIR__. '/config.php';
return [
    'parameters' => &$parameters,
    
    'services' => [
        'db'        => [
            'class' => '\Phalcon\Db\Adapter\Pdo\Mysql',
            '__construct' => array(
                $parameters['db']
            )
        ],
        'config'    => [
            'class' => $configuration,
        ],
        'logger'    => [
            'class' => '\Phalcon\Logger\Adapter\File',
            '__construct' => array(
                APPLICATION_PATH . '/logs/' . APPLICATION_ENV . '.log'
            )
        ],
        'url'       => [
            'class' => '\Phalcon\Mvc\Url',
            'shared' => true,
            'parameters' => $parameters['url']
        ],
        'tag'       => [
            'class' => '\App\Tag'
        ],
        'modelsMetadata' => [
            'class' => function () {
                $metaData = new \Phalcon\Mvc\Model\MetaData\Memory();
                $metaData->setStrategy(new \Engine\Db\Model\Annotations\Metadata());
                return $metaData;
            }
        ],
        'crypt'      => [
            'class'    => function () {                
                $crypt = new Crypt();
                return $crypt;
            },
            'setKey' => $parameters['cryptSalt']
        ],
        'flash'      => [
            'class'    => function () {
                return new Direct([
                    'error' => 'alert alert-danger',
                    'success' => 'alert alert-success',
                    'notice' => 'alert alert-info',
                    'warning' => 'alert alert-warning'
                ]);
            }
        ],
        'dispatcher' => [
            'class' => function ($application) {
                $evManager = $application->getDI()->getShared('eventsManager');
                
                $evManager->attach('dispatch:beforeException', function ($event, $dispatcher, $exception) use (&$application) {
                    
                    if (! class_exists('Frontend\Module')) {
                        include_once APPLICATION_PATH . '/modules/frontend/Module.php';
                        $module = new Frontend\Module();
                        $module->registerServices($application->getDI());
                        $module->registerAutoloaders($application->getDI());
                    }
                    
                    /**
                     *
                     * @var $dispatcher \Phalcon\Mvc\Dispatcher
                     */
                    $dispatcher->setModuleName('frontend');
                    
                    $dispatcher->setParam('error', $exception);
                    $dispatcher->forward(array(
                        'namespace' => 'Frontend\Controller',
                        'module' => 'frontend',
                        'controller' => 'error',
                        'action' => 'index'
                    ));
                    return false;
                });
                
                $dispatcher = new \Phalcon\Mvc\Dispatcher();
                $dispatcher->setEventsManager($evManager);
                return $dispatcher;
            }
        ],
        'modelsManager' => [
            'class' => function ($application) {
                $eventsManager = $application->getDI()->get('eventsManager');
                
                $modelsManager = new \Phalcon\Mvc\Model\Manager();
                $modelsManager->setEventsManager($eventsManager);
                
                $eventsManager->attach('modelsManager', new \Engine\Db\Model\Annotations\Initializer());
                
                return $modelsManager;
            }
        ],
        'router' => [
            'class' => function ($application) {
                $router = new Router(false);
                
                $router->add('/', [
                    'module' => 'frontend',
                    'controller' => 'index',
                    'action' => 'index'
                ])->setName('default');
                
                foreach ($application->getModules() as $key => $module) {
                    $router->add('/' . $key . '/:params', [
                        'module' => $key,
                        'controller' => 'index',
                        'action' => 'index',
                        'params' => 1
                    ])->setName($key);
                    
                    $router->add('/' . $key . '/:controller/:params', [
                        'module' => $key,
                        'controller' => 1,
                        'action' => 'index',
                        'params' => 2
                    ]);
                    
                    $router->add('/' . $key . '/:controller/:action/:params', [
                        'module' => $key,
                        'controller' => 1,
                        'action' => 2,
                        'params' => 3
                    ]);
                }
                $router->add('/oauth/login/{id:([a-z]{1,20})}/:params', [
                    'module' => 'oauth',
                    'controller' => 'index',
                    'action' => 'index'
                ])->setName('oauth-index-index');
                
                $router->add('/api/users/{id:([0-9]{1,32})}/:params', [
                    'module' => 'api',
                    'controller' => 'users',
                    'action' => 'get'
                ]);
                
                $router->add('/user/{id:([0-9]{1,32})}/:params', [
                    'module' => 'user',
                    'controller' => 'index',
                    'action' => 'view'
                ])->setName('user-index-view');
                
                $router->notFound([
                    'module' => 'frontend',
                    'namespace' => 'Frontend\Controller',
                    'controller' => 'index',
                    'action' => 'index'
                ]);
                
                return $router;
            },
            'parameters' => [
                'uriSource' => Router::URI_SOURCE_SERVER_REQUEST_URI
            ]
        ],
        'view' => [
            'class' => function () {
                $class = new View();
                $class->registerEngines(array(
                    '.phtml'    => 'Phalcon\Mvc\View\Engine\Php',
                    '.volt'     => 'Phalcon\Mvc\View\Engine\Volt',
                    '.php'      => 'Phalcon\Mvc\View\Engine\Php'
                ));
                
                return $class;
            },
            'parameters' => [
                'layoutsDir' => APPLICATION_PATH . '/layouts/'
            ]
        ],
        'auth' => [
            'class' => '\App\Service\Auth'
        ]
    ],
    'application' => [
        'modules' => [
            'frontend' => [
                'className' => 'Frontend\Module',
                'path' => APPLICATION_PATH . '/modules/frontend/Module.php'
            ],
            'api' => [
                'className' => 'Api\Module',
                'path' => APPLICATION_PATH . '/modules/api/Module.php'
            ],
            'user' => [
                'className' => 'User\Module',
                'path' => APPLICATION_PATH . '/modules/user/Module.php'
            ],
            'oauth' => [
                'className' => 'OAuth\Module',
                'path' => APPLICATION_PATH . '/modules/oauth/Module.php'
            ],
            'admin' => [
                'className' => 'Admin\Module',
                'path' => APPLICATION_PATH . '/modules/admin/Module.php'
            ]
        ]
        
    ]
];