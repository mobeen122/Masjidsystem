<?php
namespace App\Models\Curriculum;
use App\Models\BaseModel;

/**
 * fields  (mid, full_name, mobile, email, relationship)
 */
class Guardian extends BaseModel
{
    public $full_name;
    
    
    
    public function initialize()
    {
        $this->setSource("guardians");
        parent::initialize();
        
    }
    
}
