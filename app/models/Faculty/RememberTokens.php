<?php
namespace App\Models\Faculty;

use App\Models\BaseModel;

/**
 * RememberTokens
 * Stores the remember me tokens
 */
class RememberTokens extends BaseModel
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
    public $token;

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
