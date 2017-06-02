<?php
namespace App\Models\Faculty;

use App\Models\BaseModel;

/**
 * EmailConfirmations
 * Stores the reset password codes and their evolution
 */
class EmailConfirmations extends BaseModel
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

    public $code;
    public $confirmed;

    /**
     * Before create the user assign a password
     */
    public function beforeValidationOnCreate()
    {
        parent::beforeValidationOnCreate();

        // Generate a random confirmation code
        $this->code = preg_replace('/[^a-zA-Z0-9]/', '', base64_encode(openssl_random_pseudo_bytes(24)));

        // Set status to non-confirmed
        $this->confirmed = 'N';
    }


    /**
     * Send a confirmation e-mail to the user after create the account
     */
    public function afterCreate()
    {
        $this->getDI()
            ->getMail()
            ->send([
                $this->user->email => $this->user->name
            ], "Please confirm your email", 'confirmation', [
                'username' => $this->user->username,
                'confirmUrl' => '/confirm/' . $this->code . '/' . $this->user->email
            ]);
    }

    public function initialize()
    {
        parent::initialize();
        $this->setSource("email_confirmations");
        $this->belongsTo('user_id', __NAMESPACE__ . '\Users', 'id', [
            'alias' => 'user'
        ]);
    }
}
