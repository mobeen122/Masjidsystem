<?php
namespace App\Models\Faculty;

use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness;
use App\Models\BaseModel;

/**
 * App\Models\Users
 * All the users registered in the application
 */
class Users extends BaseModel
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
    public $name;
    
    /**
     *
     * @var string
     */
    public $username;

    /**
     *
     * @var string
     */
    public $email;

    /**
     *
     * @var string
     */
    public $password;

    /**
     *
     * @var string
     */
    public $mustChangePassword;

    /**
     *
     * @var string
     */
    public $profile_id;

    /**
     *
     * @var string
     */
    public $banned;

    /**
     *
     * @var string
     */
    public $suspended;

    /**
     *
     * @var string
     */
    public $active;

    /**
     * Before create the user assign a password
     */
    public function beforeValidationOnCreate()
    {
        parent::beforeValidationOnCreate();
        if (empty($this->password)) {

            // Generate a plain temporary password
            $tempPassword = preg_replace('/[^a-zA-Z0-9]/', '', base64_encode(openssl_random_pseudo_bytes(12)));

            // The user must change its password in first login
            $this->mustChangePassword = 'Y';

            // Use this password as default
            $this->password = $this->getDI()
                ->getSecurity()
                ->hash($tempPassword);
        } else {
            // The user must not change its password in first login
            $this->mustChangePassword = 'N';
        }

        // The account must be confirmed via e-mail
        // Only require this if emails are turned on in the config, otherwise account is automatically active
        if ($this->getDI()->get('config')->useMail) {
            $this->active = 'N';
        } else {
            $this->active = 'Y';
        }
        
        // The account is not suspended by default
        $this->suspended = 'N';

        // The account is not banned by default
        $this->banned = 'N';
    }

    /**
     * Send a confirmation e-mail to the user if the account is not active
     */
    public function afterSave()
    {
        // Only send the confirmation email if emails are turned on in the config
        if ($this->getDI()->get('config')->useMail) {

            if ($this->active == 'N') {

                $emailConfirmation = new EmailConfirmations();

                $emailConfirmation->user_id = $this->id;

                if ($emailConfirmation->save()) {
                    $this->getDI()
                        ->getFlash()
                        ->notice('A confirmation mail has been sent to ' . $this->email);
                }
            }
        }
    }

    /**
     * Validate that emails are unique across users
     */
    public function validation()
    {
        $validator = new Validation();

        $validator->add('username', new Uniqueness([
            "message" => "The username is already registered"
        ]));

        return $this->validate($validator);
    }

    public function initialize()
    {
        $this->belongsTo('profile_id', __NAMESPACE__ . '\Profiles', 'id', [
            'alias' => 'profile',
            'reusable' => true
        ]);

        $this->hasMany('id', __NAMESPACE__ . '\SuccessLogins', 'user_id', [
            'alias' => 'successLogins',
            
        ]);

        $this->hasMany('id', __NAMESPACE__ . '\PasswordChanges', 'user_id', [
            'alias' => 'passwordChanges',
            
        ]);

        $this->hasMany('id', __NAMESPACE__ . '\ResetPasswords', 'user_id', [
            'alias' => 'resetPasswords',
            
        ]);
        
        //$this->hasOne('id', __NAMESPACE__ . '\Staff', 'user_id' , ["alias" => "staff",]);
    }
}
