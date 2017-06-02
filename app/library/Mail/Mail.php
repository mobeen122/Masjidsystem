<?php
namespace App\Mail;

use Phalcon\Mvc\User\Component;
use Phalcon\Mvc\View;
use Phalcon\Ext\Mailer\Manager as Mailer;

/**
 * 
 * Sends e-mails based on pre-defined templates
 */
class Mail extends Component
{
    protected $transport;

    protected $amazonSes;

    /**
     * Send a raw e-mail via AmazonSES
     *
     * @param string $raw
     * @return bool
     */
    private function amazonSESSend($raw)
    {
        if ($this->amazonSes == null) {
            $this->amazonSes = new \AmazonSES(
                [
                    'key'    => $this->config->amazon->AWSAccessKeyId,
                    'secret' => $this->config->amazon->AWSSecretKey
                ]
            );
            @$this->amazonSes->disable_ssl_verification();
        }

        $response = $this->amazonSes->send_raw_email(
            [
                'Data' => base64_encode($raw)
            ],
            [
                'curlopts' => [
                    CURLOPT_SSL_VERIFYHOST => 0,
                    CURLOPT_SSL_VERIFYPEER => 0
                ]
            ]
        );

        if (!$response->isOK()) {
            $this->logger->error('Error sending email from AWS SES: ' . $response->body->asXML());
        }

        return true;
    }

    /**
     * Applies a template to be used in the e-mail
     *
     * @param string $name
     * @param array $params
     * @return string
     */
    public function getTemplate($name, $params)
    {
        $parameters = array_merge([
            'publicUrl' => $this->config->application->publicUrl
        ], $params);

        return $this->view->getRender('emailTemplates', $name, $parameters, function ($view) {
            $view->setRenderLevel(View::LEVEL_LAYOUT);
        });

        return $view->getContent();
    }

    /**
     * Sends e-mails via AmazonSES based on predefined templates
     *
     * @param array $to
     * @param string $subject
     * @param string $name
     * @param array $params
     * @return bool|int
     * @throws Exception
     */
    public function send($to, $subject, $name, $params)
    {
        // Settings
        $mailConfig = [
            'driver' 	 => 'smtp',
            'host'	 	 => 'smtp.mandrillapp.com',
            'port'	 	 => 587,
            'encryption' => 'tls',
            'username'   => 'info@cleartwo.co.uk',
            'password'	 => 'qqhr-T-MxMt7qdwWnzr3FQ',   //'VdLroU6u9LR6jT1VlPWCqw',
            'from'		 => [
                'email' => 'noreply@aicotech.co.uk',
                'name'	=> 'Masjid System'
            ],
        ];
        //$config = $this->getConfig();
        $template = $this->getTemplate($name, $params);

        // Create the message
        $mailer = new Mailer($mailConfig);
        $message = $mailer->createMessage()
                ->to($to)
		        ->subject($subject)
		        ->content($template);
        $message->send();
        
        return $message;
    }
}
