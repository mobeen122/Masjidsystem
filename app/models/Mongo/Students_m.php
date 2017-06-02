<?php
namespace App\Models\Mongo;
use App\Util;
use Phalcon\Mvc\MongoCollection;
/**
 * fields  (full_name, birthdate, gender, proof, mic_number, enrolled_date, leaving_date, access_id, med_condition, application_received)
 */
class Students_m extends MongoCollection
{
    use Util;
    public function getSource()
    {
        return 'Student';
    }
  
    
    public static function GetFullname($id)
    {
        $object = Students_m::findById($id);
        if (isset($object))
        {
            return $object->full_name;
        }
    }
}