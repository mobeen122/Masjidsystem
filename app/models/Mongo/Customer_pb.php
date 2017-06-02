<?php
namespace App\Models\Mongo;

use Phalcon\Mvc\MongoCollection;
/**
 * fields  (_product, description, rate, weight, price, qty, takenby)
 */
class Customer_pb extends MongoCollection
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
        return 'customer_Bought';
    }
  
}