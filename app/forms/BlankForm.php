<?php
namespace App\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\Identical;

class BlankForm extends Form
{

    public function getCsrf()
    {
        return $this->security->getToken();
    }
    
    public function initialize($entity = null, $options = null)
    {
        if (isset($options['edit']) && $options['edit']) {
            $id = new Hidden('id');
        } else {
            $id = new Text('id');
        }
        
        $this->add($id);
        
        
        // CSRF
        $csrf = new Hidden('csrf');

        $csrf->addValidator(new Identical([
            'value' => $this->security->getSessionToken(),
            'message' => 'CSRF validation failed'
        ]));

        $csrf->clear();

        $this->add($csrf);

        
        // Sign Up
        $this->add(new Submit('submit', [
            'class' => 'btn red uppercase',
        ]));
    }
}
