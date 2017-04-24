<?php
return array(
    'db' => array(
        'adapter' => 'Mysql',
        'host' => 'localhost',
        'username' => 'masjid_user',
        'password' => 'Zgg2s6_0',
        'dbname' => 'masjidoldham',
        'options' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            PDO::ATTR_PERSISTENT => true
        )
    ),
    'url' => array(
        'baseUri' => '/',
        'staticBaseUri' => '/static/' //Change to CDN if needed
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