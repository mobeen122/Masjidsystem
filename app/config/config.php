<?php

use Phalcon\Config;
use Phalcon\Logger;

return new Config([
    'database' => [
        'adapter' => 'Mysql',
        'host' => 'localhost',
        'username' => 'masjid_user',
        'password' => 'Zgg2s6_0',
        'dbname' => 'masjidoldham',
        'options' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            PDO::ATTR_PERSISTENT => true
        ),
        'mongo' => array(
            // This group is used when no instance name has been provided.
            'hostname'   => 'localhost',
            'database'   => 'masjid_mg',
            'port'       => 23557,
            'compress'   => true,
            'username'   => false,
            'password'   => false,
      )
    ],
    
    
    'mail' => [
        
        'driver' 	 => 'smtp',
        'host'	 	 => 'smtp.mandrillapp.com',
        'port'	 	 => 587,
        'encryption' => 'tls',
        'username'   => 'info@cleartwo.co.uk',
        'password'	 => 'VdLroU6u9LR6jT1VlPWCqw',
        'from'		 => [
            'email' => 'ducation@madinamosqueoldham.org',
            'name'	=> 'Masjid System'
        ],
    ],
    'application' => [
        'libraryDir'     => APP_PATH . '/library/',
        'layoutDir'      => APP_PATH . '/layouts/',
        'controllersDir' => APP_PATH . '/controllers/',
        'modelsDir'      => APP_PATH . '/models/',
        'formsDir'       => APP_PATH . '/forms/',
        'viewsDir'       => APP_PATH . '/views/',
        'cacheDir'       => 'cache/', 
        'Phalcon'        => BASE_PATH . '/vendor/phalcon/incubator/Library/Phalcon/',
        'vender'         => BASE_PATH . '/vendor/',
        'baseUri'        => '/',
        'publicUrl'      => 'education.madinamosqueoldham.org',
        'cryptSalt'      => 'eEAfR|_&G&f,+vU]:jFr!!A&+71w1Ms9~8_4L!<@[N@DyaIP_2My|:+.u>/6m,$D',
        'company'        => 'Madina Mosque &amp; Islamic Centre',
        'title'          => ' | Masjid System ',
        'address'        => '6 Clydesdale Street',
        'address2'       => 'Coppice',
        'town'           => 'Oldham',
        'postcode'       => 'OL8 1BT',
        'telephone'      => '0161 628 0624',
        'mobile'         => '0784 605 9925',
        'Charity Number' => '1137153',
        'sortcode'       => '30-96-26',
        'account'        => '13662460',
        'domain'         => 'education.madinamosqueoldham.org',
    ],
    
    'amazon' => [
        'AWSAccessKeyId' => '',
        'AWSSecretKey' => ''
    ],
    'logger' => [
        'path'     => BASE_PATH . '/logs/',
        'format'   => '%date% [%type%] %message%',
        'date'     => 'D j H:i:s',
        'logLevel' => Logger::DEBUG,
        'filename' => 'application.log',
    ],
    // Set to false to disable sending emails (for use in test environment)
    'useMail' => true
]);
