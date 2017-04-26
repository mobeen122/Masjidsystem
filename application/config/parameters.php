<?php
return array(
    'db' => array(
        'adapter' => 'Mysql',
        'host' => 'dbserver.aicotech.co.uk',
        'username' => 'masjid_user',
        'password' => 'q9Zq99d&',
        'dbname' => 'masjidoldham',
        'options' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            PDO::ATTR_PERSISTENT => true
        )
    ),
    'cryptSalt'      => 'eEAfR|_&G&f,+vU]:jFr!!A&+71w1Ms9~8_4L!<@[N@DyaIP_2My|:+.u>/6m,$D',
    'url' => array(
        'baseUri' => '/',
        'staticBaseUri' => '/' //Change to CDN if needed
    ),
    'oauth' => array(
        'redirectUri' => 'http://portal.madinamosqueoldham.org/oauth/index/callback',
        'provider' => array(
            'Facebook' => array(
                'applicationId' => '',
                'applicationSecret' => ''
            ),
            'Twitter' => array(
                'applicationId' => '',
                'applicationSecret' => '',
                'enabled' => false
            ),
            'Google' => array(
                'applicationId' => '',
                'applicationSecret' => '',
                'enabled' => false
            ),
            'Vk' => array(
                'applicationId' => '',
                'applicationSecret' => ''
            ),
            'Github' => array(
                'applicationId' => '',
                'applicationSecret' => ''
            )
        )
    )
);