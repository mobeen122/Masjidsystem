<?php
namespace App\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Select;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;
use App\Models\Faculty\Profiles;
use Phalcon\Validation\Validator\Identical;
use Phalcon\Forms\Element\Submit;


class UsersForm extends Form
{

    private $lastCsrfValue = null;    
    /**
     * Get last Csrf value
     */
    public function getCsrf()
    {
        return ($this->lastCsrfValue !== null) ? $this->lastCsrfValue : $this->lastCsrfValue = $this->security->getSessionToken();
    }
    public function initialize($entity = null, $options = null)
    {

        // In edition the id is hidden
        if (isset($options['edit']) && $options['edit']) {
            $id = new Hidden('id');
        } else {
            $id = new Text('id', [
            'class' => 'form-control ',
        ]);
        }

        $this->add($id);

        $name = new Text('name', [
            'class' => 'form-control ',
            'placeholder' => 'Name'
        ]);

        $name->addValidators([
            new PresenceOf([
                'message' => 'The name is required'
            ])
        ]);

        $this->add($name);
        
        $username = new Text('username', [
            'class' => 'form-control ',
            'placeholder' => 'username'
        ]);
        
        $username->addValidators([
            new PresenceOf([
                'message' => 'The username is required'
            ])
        ]);
        
        $this->add($username);

        $email = new Text('email', [
            'class' => 'form-control ',
            'placeholder' => 'Email'
        ]);

        $email->addValidators([
            new PresenceOf([
                'message' => 'The e-mail is required'
            ]),
            new Email([
                'message' => 'The e-mail is not valid'
            ])
        ]);

        $this->add($email);
        
        // CSRF
        $csrf = new Hidden('csrf');
        
        $csrf->addValidator(new Identical([
            'value' => $this->security->getSessionToken(),
            'message' => 'CSRF validation failed'
        ]));
        
        $csrf->clear();
        
        $this->add($csrf);

        $profiles = Profiles::find([
            'active = :active:',
            'bind' => [
                'active' => 'Y'
            ]
        ]);

        $this->add(new Select('profile_id', $profiles, [
            'using' => [
                'id',
                'name'
            ],
            'class' => 'form-control  select2',
            'useEmpty' => true,
            'emptyText' => '...',
            'emptyValue' => ''
        ]));

        $this->add(new Select('banned', [
            'Y' => 'Yes',
            'N' => 'No'
        ]));

        $this->add(new Select('suspended', [
            'Y' => 'Yes',
            'N' => 'No'
        ]));

        $this->add(new Select('active', [
            'Y' => 'Yes',
            'N' => 'No'
        ]));
        
        $this->add(new Submit('submit', [
            'class' => 'btn btn-transparent red uppercase',
        ]));
    }
}
