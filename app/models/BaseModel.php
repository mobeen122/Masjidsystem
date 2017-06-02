<?php
namespace App\Models;

use Phalcon\Mvc\Model;
use App\Util;
use Phalcon\Mvc\Model\Behavior\SoftDelete;
use Phalcon\Mvc\Model\Behavior\Timestampable;

/**
 *
 * @author Asif
 *
 */
class BaseModel extends Model
{

    use Util;
    public $created_at;

    public function initialize()
    {
        $this->addBehavior(new SoftDelete(
            array(
                'field' => 'is_deleted',
                'value' => $this->AddDateTime()
            )
       ));
        $this->addBehavior(new Timestampable([
            "beforeUpdate" => [
                "field"  => "modified_at",
                "format" => $this->AddDateTime()
            ]
        ]));
    }
    public function beforeValidationOnCreate()
    {
        $this->created_at = $this->AddDateTime();
    }
    
    /**
     * @inheritdoc
     *
     * @access public
     * @static
     * @param array|string $parameters Query parameters
     * @return Phalcon\Mvc\Model\ResultsetInterface
     */
    public static function find($parameters = null)
    {
        $parameters = self::softDeleteFetch($parameters);
    
        return parent::find($parameters);
    }
    
    /**
     * @inheritdoc
     *
     * @access public
     * @static
     * @param array|string $parameters Query parameters
     * @return Phalcon\Mvc\Model
     */
    public static function findFirst($parameters = null)
    {
        $parameters = self::softDeleteFetch($parameters);
    
        return parent::findFirst($parameters);
    }
    
    /**
     * @inheritdoc
     *
     * @access public
     * @static
     * @param array|string $parameters Query parameters
     * @return mixed
     */
    public static function count($parameters = null)
    {
        $parameters = self::softDeleteFetch($parameters);
    
        return parent::count($parameters);
    }
    
    /**
     * @access protected
     * @static
     * @param array|string $parameters Query parameters
     * @return mixed
     */
    protected static function softDeleteFetch($parameters = null)
    {
            
        $deletedField = 'is_deleted';
        
        if ($parameters === null) {
            $parameters = $deletedField . ' IS NULL';
        } else if (is_int($parameters)) {
            $parameters = 'id = ' . $parameters . ' AND ' . $deletedField . ' IS NULL';
        } else if (is_array($parameters) === false && strpos($parameters, $deletedField) === false) {
            $parameters .= ' AND ' . $deletedField . ' IS NULL';
        } else if (is_array($parameters) === true) {
            if (isset($parameters[0]) === true && strpos($parameters[0], $deletedField) === false) {
                $parameters[0] .= ' AND ' . $deletedField . ' IS NULL';
            } else if (isset($parameters['conditions']) === true && strpos($parameters['conditions'], $deletedField) === false) {
                $parameters['conditions'] .= ' AND ' . $deletedField . ' IS NULL';
            }
        }
    
        return $parameters;
    }
 }

