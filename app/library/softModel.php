<?php
namespace App;

use Phalcon\Mvc\Model\Behavior\SoftDelete;

/**
 *
 * @author Asif
 *
 */
trait softModel
{
    const DELETED = date('Y-m-d H:i:s');
    const NOT_DELETED = "A";
    public function initialize()
    {
        $this->addBehavior(new SoftDelete(
            array(
                'field' => 'is_deleted',
                'value' => self::DELETED
            )
            ));
    }
    /* public function beforeCreate()
    {
        $this->created_at = date("Y-m-d H:i:s");
    }
    public function beforeUpdate()
    {
        $this->modified_at = date("Y-m-d H:i:s");
    }*/
 }