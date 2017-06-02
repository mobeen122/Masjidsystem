<?php
namespace App\Models\Faculty;
use Phalcon\Mvc\Model;

class Staff extends Model
{
    public $full_name;
    public $email;
    public $username; 
    public $access;
    public $role;
    public $status;
    
    
    
    public function initialize()
    {
        $this->setSource("staff");
        $this->belongsTo('user_id', __NAMESPACE__.'\Users', 'id', ["alias" => "user",]);
    }
    
}

