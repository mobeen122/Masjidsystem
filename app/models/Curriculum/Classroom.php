<?php
namespace App\Models\Curriculum;
use App\Models\BaseModel;

/**
 * fields  (mid, name, age_group)
 */
class Classroom extends BaseModel
{
    
    public function initialize()
    {
        $this->setSource("classrooms");
        parent::initialize();
        
    }
    
}
