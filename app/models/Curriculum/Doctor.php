<?php
namespace App\Models\Curriculum;
use App\Models\BaseModel;

/**
 * fields  (mid, surgery, Address, telephone)
 */
class Doctor extends BaseModel
{
    

    
    public function initialize()
    {
        $this->setSource("doctors");
        parent::initialize();
        
    }
    
}
