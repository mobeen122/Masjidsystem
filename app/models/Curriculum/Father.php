<?php
namespace App\Models\Curriculum;
use App\Models\BaseModel;

/**
 * fields  (mid, full_name, mobile, email)
 */
class Father extends BaseModel
{
    public $full_name;
    
    
    
    public function initialize()
    {
        $this->setSource("fathers");
        parent::initialize();
        //$this->belongsTo('access_id', __NAMESPACE__.'\Users', 'id', ["alias" => "user",]);
        
    }
    
}
