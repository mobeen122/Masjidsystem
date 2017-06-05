<?php
namespace App\Models\Curriculum;
use App\Models\BaseModel;

/**
 * fields  (mid, student_id, date_paid, amount, due_date, ref, payment_status)
 */
class Fee extends BaseModel
{
    
    public function initialize()
    {
        $this->setSource("fees");
        parent::initialize();
        
    }
    
}
