<?php
namespace App\Models\Mongo;

use Phalcon\Mvc\MongoCollection;
/**
 * fields  (_bought, purchase_no, total_weight, total_price, ref_num, delivered, created_on, takenby)
 */
class Customer_p extends MongoCollection
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
        return 'customer_purchase';
    }
  
}