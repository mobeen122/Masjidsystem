<?php
namespace App\Models\Curriculum;
use Phalcon\Mvc\Model;

/**
 * fields  (student_id, class_id)
 */
class StudentsInClasses extends Model
{
    
    public function initialize()
    {
        $this->setSource("studentsinclasses");
        
    }
    
}
