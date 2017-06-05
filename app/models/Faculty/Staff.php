<?php
namespace App\Models\Faculty;
use Phalcon\Mvc\Model;

/**
 * fields  (full_name, mobile, email, username,  class_id, displayname, gender,  access_id, role, status)
 */
class Staff extends Model
{
    public $full_name;
    public $email;
    public $mobile;
    public $username; 
    public $displayname;
    public $role;
    public $status;
    
    
    
    public function initialize()
    {
        $this->setSource("staff");
        $this->belongsTo('access_id', __NAMESPACE__.'\Users', 'id', ["alias" => "user",]);
        
    }
    
}

