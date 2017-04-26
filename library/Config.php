<?php
namespace App;

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
        /* 'controllersDir' => APP_PATH . '/controllers/',
        'modelsDir'      => APP_PATH . '/models/',
        'formsDir'       => APP_PATH . '/forms/',
        'viewsDir'       => APP_PATH . '/views/',
        'libraryDir'     => APP_PATH . '/library/',
        'pluginsDir'     => APP_PATH . '/plugins/',
        'cacheDir'       => BASE_PATH . '/cache/',
        'Phalcon'        => BASE_PATH . '/vendor/phalcon/incubator/Library/Phalcon/',
        'baseUri'        => '/',
        'publicUrl'      => 'www.aicotech.co.uk', */
        'cryptSalt'      => 'eEAfR|_&G&f,+vU]:jFr!!A&+71w1Ms9~8_4L!<@[N@DyaIP_2My|:+.u>/6m,$D',
        'company'        => 'ARCO Ltd',
        'title'          => 'ARCO CRM | ',
        'address'        => 'Unit 3 St Elizabeth Trading Estate',
        'address2'       => 'Grey Street',
        'town'           => 'Denton',
        'postcode'       => 'M34 3RU',
        'telephone'      => '0161 624 8153',
        'mobile'         => '07831 138023',
        'vat'            => 'GB 151 081 545',
        'sortcode'       => '40-31-17',
        'account'        => '01553607',
        'companyno'      => '8716750',
        'domain'         => 'aicotech.uk',
    ],
    
    'amazon' => [
        'AWSAccessKeyId' => '',
        'AWSSecretKey' => ''
    ],
    // Set to false to disable sending emails (for use in test environment)
    'useMail' => true
]);
