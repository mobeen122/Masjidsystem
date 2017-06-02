<?php
namespace App\Models\Faculty;

use App\Models\BaseModel;

/**
 * PasswordChanges
 * Register when a user changes his/her password
 */
class PasswordChanges extends BaseModel
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
     * @var string
     */
    public $userAgent;

    public function initialize()
    {
        parent::initialize();
        $this->setSource("password_changes");
        $this->belongsTo('user_id', __NAMESPACE__ . '\Users', 'id', [
            'alias' => 'user'
        ]);
    }
}
