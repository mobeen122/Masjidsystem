<?php
namespace App\Models\Mongo;

use Phalcon\Mvc\MongoCollection;
/**
 * fields  (_invoice, _purchase, _payment,  added_on, takenby)
 */
class Customer_o extends MongoCollection
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
        return 'Customer_orders';
    }
  
}