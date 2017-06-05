<?php
namespace App\Models\Curriculum;
use App\Models\BaseModel;

/**
 * fields  (mid, address_id, father_id, mother_id, other_id, doctor_id, full_name, birthdate, gender, proof, mic, enrolled_date, leaving_date, med_condition, application_received)
 */
class Student extends BaseModel
{
    public $full_name;
    
    
    
    public function initialize()
    {
        $this->setSource("students");
        parent::initialize();
        //$this->belongsTo('access_id', __NAMESPACE__.'\Users', 'id', ["alias" => "user",]);
        
    }
    
}
