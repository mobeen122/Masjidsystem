<?php
namespace App\Models\Mongo;

use Phalcon\Mvc\MongoCollection;
/**
 * fields  (invoice_date, invoice_number, status, added_on, takenby)
 */
class Customer_i extends MongoCollection
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
        return 'Customer_invoices';
    }
  
}