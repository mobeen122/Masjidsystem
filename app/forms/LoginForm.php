<?php
namespace App\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Check;
//use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;
//use Phalcon\Validation\Validator\Identical;

class LoginForm extends Form
{
    /**
     * @var null $lastCsrfValue
     */
   // private $lastCsrfValue = null;
    
    /**
     * Get last Csrf value
     */
    /* public function getCsrf()
    {
        return ($this->lastCsrfValue !== null) ? $this->lastCsrfValue : $this->lastCsrfValue = $this->security->getSessionToken();
    } */
    
    public function initialize() 
    {
        // Email
        $email = new Text('username', [
            'placeholder' => 'Username',
            'class' => 'form-control form-control-solid placeholder-no-fix form-group',
            'autocomplete' => 'off'
        ]);

        $email->addValidators([
            new PresenceOf([
                'message' => 'The Username is required'
            ])
            
        ]);

        $this->add($email);

        // Password
        $password = new Password('password', [
            'placeholder' => 'Password',
            'class' => 'form-control form-control-solid placeholder-no-fix form-group',
            'autocomplete' => 'off'
        ]);

        $password->addValidator(new PresenceOf([
            'message' => 'The password is required'
        ]));

        $password->clear();

        $this->add($password);

        // Remember
        $remember = new Check('remember', [
            'value' => 'yes'
        ]);

        $remember->setLabel('Remember');

        $this->add($remember);

        // CSRF
        /* $csrf = new Hidden('csrf');

        $csrf->addValidator(new Identical([
            'value' => $this->security->getSessionToken(),
            'message' => 'CSRF validation failed'
        ])); 

        $csrf->clear();

        $this->add($csrf); */

        $this->add(new Submit('Login', [
            'class' => 'btn red uppercase'
        ]));
    }
}
