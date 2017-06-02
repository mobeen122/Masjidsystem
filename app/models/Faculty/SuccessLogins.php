<?php
namespace App\Models\Faculty;

use App\Models\BaseModel;

/**
 * SuccessLogins
 * This model registers successfull logins registered users have made
 */
class SuccessLogins extends BaseModel
{

    /**
     *
     * @var integer
     */
    public $id;

   
    /**
     *
     * @var string
     */
    public $ipAddress;

    /**
     *
     * @var string
     */
    public $userAgent;

    public function initialize()
    {
        parent::initialize();
        $this->belongsTo('user_id', __NAMESPACE__ . '\Users', 'id', [
            'alias' => 'user'
        ]);
    }
}
