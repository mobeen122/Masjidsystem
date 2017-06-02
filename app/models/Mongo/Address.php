<?php
namespace App\Models\Faculty;


use Phalcon\Mvc\MongoCollection;

class Address extends MongoCollection
{
    public $first_line;
    public $area;
    public $town;
    public $post_code;
    public $telephone;
    
    
   /*  public function initialize()
    {
        $this->setSource("Address");
    }*/
    public function getSource()
    {
        return 'address';
    }
    
    public function notSave()
    {
        // Obtain the flash service from the DI container
        $flash = $this->getDI()->getShared("flash");
    
        $messages = $this->getMessages();
    
        // Show validation messages
        foreach ($messages as $message) {
            $flash->error(
                (string) $message
                );
        }
    }
}

