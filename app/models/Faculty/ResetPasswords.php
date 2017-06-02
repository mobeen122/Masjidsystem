<?php
namespace App\Models\Faculty;

use App\Models\BaseModel;

/**
 * ResetPasswords
 * Stores the reset password codes and their evolution
 */
class ResetPasswords extends BaseModel
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
    public $code;

    /**
     *
     * @var string
     */
    public $reset;

    /**
     * Before create the user assign a password
     */
    public function beforeValidationOnCreate()
    {
        parent::beforeValidationOnCreate();

        // Generate a random confirmation code
        $this->code = preg_replace('/[^a-zA-Z0-9]/', '', base64_encode(openssl_random_pseudo_bytes(24)));

        // Set status to non-confirmed
        $this->reset = 'N';
    }

    /**
     * Send an e-mail to users allowing him/her to reset his/her password
     */
    public function afterCreate()
    {
        $this->getDI()
            ->getMail()
            ->send([
                $this->user->email => $this->user->name
            ], "Reset your password", 'reset', [
                'username' => $this->user->username,
                'resetUrl' => '/reset-password/' . $this->code . '/' . $this->user->email
            ]);
    }

    public function initialize()
    {
        parent::initialize();
        $this->belongsTo('user_id', __NAMESPACE__ . '\Users', 'id', [
            'alias' => 'user'
        ]);
    }
}
