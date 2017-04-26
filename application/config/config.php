<?php

use Phalcon\Config;

return new Config([
    'mail' => [
        'fromName' => 'ARCO CRM',
        'fromEmail' => 'noreply@aicotech.co.uk',
        'smtp' => [
            'server' => 'smtp.mandrillapp.com',
            'port' => 587,
            'security' => 'tls',
            'username' => 'info@cleartwo.co.uk',
            'password' => 'UCkHsA0eZJ-YEvRXJopKTQ'
        ]
    ],
    'companydata' => [
        
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
        'domain'         => 'portal.madinamosqueoldham.org',
    ],
    
    'amazon' => [
        'AWSAccessKeyId' => '',
        'AWSSecretKey' => ''
    ],
    // Set to false to disable sending emails (for use in test environment)
    'useMail' => true
]);
