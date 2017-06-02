<?php
namespace App\Models\Faculty;

use App\Models\BaseModel;

/**
 * FailedLogins
 * This model registers unsuccessfull logins registered and non-registered users have made
 */
class FailedLogins extends BaseModel
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $user_id;

    /**
     *
     * @var string
     */
    public $ipAddress;

    /**
     *
     * @var integer
     */
    public $attempted;

    public function initialize()
    {
        parent::initialize();
        $this->setSource("failed_logins");
        $this->belongsTo('user_id', __NAMESPACE__ . '\Users', 'id', [
            'alias' => 'user'
        ]);
    }
}
