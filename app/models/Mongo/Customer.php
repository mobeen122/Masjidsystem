<?php
namespace App\Models\Mongo;

use Phalcon\Mvc\MongoCollection;
/**
 * fields  (account_no, company, display, Address, sortorder, town, postcode, telephone, email, created_at, modified_at, opening_balance, closing_balance, delivery_id)
 */
class Customer extends MongoCollection
{
    
    /* public $id;
    public $account_no;
    public $company;
    public $display;
    public $address;
    public $town;
    public $postcode;
    public $telephone;
    public $email;
    public $opening_balance;
    public $closing_balance;
    public $sortorder; */
    
    
    public function getSource()
    {
        return 'Customers';
    }
  
}