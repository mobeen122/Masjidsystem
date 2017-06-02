<?php
namespace App\Models\Faculty;

use Phalcon\Mvc\Model;

/**
 * Vokuro\Models\Profiles
 * All the profile levels in the application. Used in conjenction with ACL lists
 */
class Profiles extends Model
{

    /**
     * ID
     * @var integer
     */
    public $id;

    /**
     * Name
     * @var string
     */
    public $name;

    /**
     * Define relationships to Users and Permissions
     */
    public function initialize()
    {
        $this->hasMany('id', __NAMESPACE__ . '\Users', 'profile_id', [
            'alias' => 'users',
            'foreignKey' => [
                'message' => 'Profile cannot be deleted because it\'s used on Users'
            ]
        ]);

        $this->hasMany('id', __NAMESPACE__ . '\Permissions', 'profilesId', [
            'alias' => 'permissions'
        ]);
    }
}
