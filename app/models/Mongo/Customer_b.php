<?php
namespace App\Models\Mongo;

use Phalcon\Mvc\MongoCollection;
/**
 * fields  (_customer, _invoice, opening_b, orders, payments, closing_b, created_on, takenby)
 */
class Customer_b extends MongoCollection
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
        return 'customer_balancesheet';
    }
  
}