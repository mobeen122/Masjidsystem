<?php
namespace App\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Password;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Confirmation;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\Identical;

class ChangePasswordForm extends Form
{

    private $lastCsrfValue = null;    
    /**
     * Get last Csrf value
     */
    public function getCsrf()
    {
        return ($this->lastCsrfValue !== null) ? $this->lastCsrfValue : $this->lastCsrfValue = $this->security->getSessionToken();
    }
    public function initialize()
    {
        // Password
        $password = new Password('password', ['class' => 'form-control ', 'autocomplete' => 'off']);

        $password->addValidators([
            new PresenceOf([
                'message' => 'Password is required'
            ]),
            new StringLength([
                'min' => 8,
                'messageMinimum' => 'Password is too short. Minimum 8 characters'
            ]),
            new Confirmation([
                'message' => 'Password doesn\'t match confirmation',
                'with' => 'confirmPassword'
            ])
        ]);

        $this->add($password);

        // Confirm Password
        $confirmPassword = new Password('confirmPassword', ['class' => 'form-control ', 'autocomplete' => 'off']);

        $confirmPassword->addValidators([
            new PresenceOf([
                'message' => 'The confirmation password is required'
            ])
        ]);

        $this->add($confirmPassword);
        
        // CSRF
        $csrf = new Hidden('csrf');
        
        $csrf->addValidator(new Identical([
            'value' => $this->security->getSessionToken(),
            'message' => 'CSRF validation failed'
        ]));
        
        $csrf->clear();
        
        $this->add($csrf);
        
        $this->add(new Submit('Change Password', [
            'class' => 'btn btn-primary'
        ]));
    }
}
