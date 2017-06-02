CREATE TABLE `password_changes` (
  `id` int(10) UNSIGNED NOT NULL,
  `usersId` int(10) UNSIGNED NOT NULL,
  `ipAddress` char(15) NOT NULL,
  `userAgent` varchar(48) NOT NULL,
  `createdAt` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `profilesId` int(10) UNSIGNED NOT NULL,
  `resource` varchar(16) NOT NULL,
  `action` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `permissions` (`id`, `profilesId`, `resource`, `action`) VALUES
(1, 1, 'users', 'index'),
(2, 1, 'users', 'search'),
(3, 1, 'users', 'edit'),
(4, 1, 'users', 'create'),
(5, 1, 'users', 'delete'),
(6, 1, 'users', 'changePassword'),
(7, 1, 'profiles', 'index'),
(8, 1, 'profiles', 'search'),
(9, 1, 'profiles', 'edit'),
(10, 1, 'profiles', 'create'),
(11, 1, 'profiles', 'delete'),
(12, 1, 'permissions', 'index');

CREATE TABLE `profiles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(64) NOT NULL,
  `active` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `profiles` (`id`, `name`, `active`) VALUES
(1, 'Administrators', 'Y'),
(2, 'Teachers', 'Y'),
(3, 'Parents', 'Y'),
(4, 'Education', 'Y'),
(5, 'Users', 'Y');

CREATE TABLE `remember_tokens` (
  `id` int(10) UNSIGNED NOT NULL,
  `usersId` int(10) UNSIGNED NOT NULL,
  `token` char(32) NOT NULL,
  `userAgent` varchar(120) NOT NULL,
  `createdAt` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE `reset_passwords` (
  `id` int(10) UNSIGNED NOT NULL,
  `usersId` int(10) UNSIGNED NOT NULL,
  `code` varchar(48) NOT NULL,
  `createdAt` int(10) UNSIGNED NOT NULL,
  `modifiedAt` int(10) UNSIGNED DEFAULT NULL,
  `reset` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE `success_logins` (
  `id` int(10) UNSIGNED NOT NULL,
  `usersId` int(10) UNSIGNED NOT NULL,
  `ipAddress` char(15) NOT NULL,
  `userAgent` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` char(60) NOT NULL,
  `mustChangePassword` char(1) DEFAULT NULL,
  `profilesId` int(10) UNSIGNED NOT NULL,
  `banned` char(1) NOT NULL,
  `suspended` char(1) NOT NULL,
  `active` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `users` (`id`, `name`, `email`, `username`, `password`, `mustChangePassword`, `profilesId`, `banned`, `suspended`, `active`) VALUES
(1, 'Asif Iqbal', 'Asif@cleartwo.co.uk', 'asif', '$2y$08$OWs5M015L01LOXUxbEdPLu0gxx/Liro/0fYLDdGWF.Liy1Fpq5Id2', 'N', 1, 'N', 'N', 'Y');


ALTER TABLE `password_changes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usersId` (`usersId`);

ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profilesId` (`profilesId`);

ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `active` (`active`);

ALTER TABLE `remember_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `token` (`token`);

ALTER TABLE `reset_passwords`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usersId` (`usersId`);

ALTER TABLE `success_logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usersId` (`usersId`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profilesId` (`profilesId`);


ALTER TABLE `password_changes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
ALTER TABLE `profiles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
ALTER TABLE `remember_tokens`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
ALTER TABLE `reset_passwords`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
ALTER TABLE `success_logins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
  
  
  
  SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE `email_confirmations` (
  `id` int(10) UNSIGNED NOT NULL,
  `usersId` int(10) UNSIGNED NOT NULL,
  `code` char(32) NOT NULL,
  `createdAt` int(10) UNSIGNED NOT NULL,
  `modifiedAt` int(10) UNSIGNED DEFAULT NULL,
  `confirmed` char(1) DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `failed_logins` (
  `id` int(10) UNSIGNED NOT NULL,
  `usersId` int(10) UNSIGNED DEFAULT NULL,
  `ipAddress` char(15) NOT NULL,
  `attempted` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `options` (
  `id` int(11) UNSIGNED NOT NULL,
  `opgroup` varchar(255) NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `password_changes` (
  `id` int(10) UNSIGNED NOT NULL,
  `usersId` int(10) UNSIGNED NOT NULL,
  `ipAddress` char(15) NOT NULL,
  `userAgent` varchar(48) NOT NULL,
  `createdAt` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `profilesId` int(10) UNSIGNED NOT NULL,
  `resource` varchar(16) NOT NULL,
  `action` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `profiles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(64) NOT NULL,
  `active` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `remember_tokens` (
  `id` int(10) UNSIGNED NOT NULL,
  `usersId` int(10) UNSIGNED NOT NULL,
  `token` char(32) NOT NULL,
  `userAgent` varchar(120) NOT NULL,
  `createdAt` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `reset_passwords` (
  `id` int(10) UNSIGNED NOT NULL,
  `usersId` int(10) UNSIGNED NOT NULL,
  `code` varchar(48) NOT NULL,
  `createdAt` int(10) UNSIGNED NOT NULL,
  `modifiedAt` int(10) UNSIGNED DEFAULT NULL,
  `reset` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `success_logins` (
  `id` int(10) UNSIGNED NOT NULL,
  `usersId` int(10) UNSIGNED NOT NULL,
  `ipAddress` char(15) NOT NULL,
  `userAgent` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` char(60) NOT NULL,
  `mustChangePassword` char(1) DEFAULT NULL,
  `profilesId` int(10) UNSIGNED NOT NULL,
  `banned` char(1) NOT NULL,
  `suspended` char(1) NOT NULL,
  `active` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `users` (`id`, `name`, `email`, `username`, `password`, `mustChangePassword`, `profilesId`, `banned`, `suspended`, `active`) VALUES
(1, 'Asif Iqbal', 'Asif@cleartwo.co.uk', 'asif', '$2y$08$OWs5M015L01LOXUxbEdPLu0gxx/Liro/0fYLDdGWF.Liy1Fpq5Id2', 'N', 1, 'N', 'N', 'Y'),
(4, 'Ranjit', 'ranjit@cleartwo.co.uk', 'ranjit', '$2y$08$ZTAxandxeGVOdHpSOWE4aeVIiTDMpo/N./SACqcWuL0q5HPT7/bmC', 'N', 1, 'N', 'N', 'Y'),
(11, 'Asif', 'aico.asif@gmail.com', 'asif.aico', '$2y$08$TFVWTTUzbGNCWncrKzN4W.FEhCHqfkDwFghk9b4l.thkBcbM4xJCK', 'N', 4, 'N', 'N', 'Y'),
(12, 'Mujeb ur Rahman', 'mujeburrahman@ar-company.co.uk', 'mujeb', '$2y$08$Tk1pdzI5ZXVwck1SOUIxYu/uj4DBHxcF1YwIRDyeU.LJnHjTFBEYG', 'N', 4, 'N', 'N', 'Y'),
(13, 'Satnam Singh', 'satnam@cleartwo.co.uk', 'satnam', '$2y$08$MXVRN0ZIMFVKNlJrd25wNuS.Ks0v7Xobq0TQ0r/D1gOiGVjQI2TRS', 'N', 1, 'N', 'N', 'Y'),
(14, 'Jamie Peck', 'jamie@cleartwo.co.uk', 'Jamie', '$2y$08$dmVmeXRLUjlZTTdkN05Od.WcUcMI.jpN9MZU1hVLgicO8D/mWg8DS', 'N', 1, 'N', 'N', 'Y'),
(22, 'asif Iqbal', 'asif@aicotech.co.uk', 'asifIqbal', '$2y$08$MTNkMkZ3TCtTc0YwYUtOc.YO4UYYEr.AHH3ZyGAEQINHOPC8l7AX6', 'Y', 4, 'N', 'N', 'Y');


ALTER TABLE `email_confirmations`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `failed_logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usersId` (`usersId`);

ALTER TABLE `options`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `password_changes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usersId` (`usersId`);

ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profilesId` (`profilesId`);

ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `active` (`active`);

ALTER TABLE `remember_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `token` (`token`);

ALTER TABLE `reset_passwords`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usersId` (`usersId`);

ALTER TABLE `success_logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usersId` (`usersId`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profilesId` (`profilesId`);


ALTER TABLE `email_confirmations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
ALTER TABLE `failed_logins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;
ALTER TABLE `options`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
ALTER TABLE `password_changes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7389;
ALTER TABLE `profiles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
ALTER TABLE `remember_tokens`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
ALTER TABLE `reset_passwords`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
ALTER TABLE `success_logins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=885;
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
  
  
  $results = [];
        $customerB = Customer_b::find();
        /**
         * customer balance
         * [_id] => MongoDB\BSON\ObjectID Object ( [oid] => 57dd66bcb0a5e3b85e8b4569 )
         * [_customer] => MongoDB\BSON\ObjectID Object ( [oid] => 57c953dcb0a5e3ef228b4567 )
         * [_invoice] => MongoDB\BSON\ObjectID Object ( [oid] => 57dd66bcb0a5e3b85e8b4567 )
         * [opening_b] => 1305.72
         * [created_on] => 17-09-2016
         * [orders] => 2389.03
         * [closing_b] => 2694.75
         * [payments] => 1000
         * [_takenby] => MongoDB\BSON\ObjectID Object ( [oid] => 5799bfaab0a5e3c8698b4567 ) )
         */
        /* $transactionManager     = new Manager();
        $transaction            = $transactionManager->get();
        foreach ($customerB as $key)
        {
            
            if (!empty($key->_customer)){
                $mid = (string)$key->_customer;
                $customer = Customerms::findFirst([
                    'conditions' => "mid = '$mid'"
                ]);
                $imid = (string)$key->_invoice;
                $invoice = Customermis::findFirst([
                    'conditions' => "mid = '$imid'"
                ]);
                
                if ($customer && $invoice)
                {
                    $results[] = ['customer' => $customer->id, 'invoice' => $invoice->id];
                    
                    $new = new Customermbs();
                    $new->mid               = (string)$key->_id;
                    $new->customer          = $customer;
                    $new->invoice           = $invoice;
                    $new->setTransaction($transaction);
                    $new->orders            = $key->orders;
                    $new->payment           = $key->payments;
                    $new->created_on        = Customerms::AddDate($key->created_on);
                    $new->create();
                }
            }
        }
        $transaction->commit(); */
        
        $customerI = Customer_i::find();
        /**
         * customer invoices
         * [_id] => MongoDB\BSON\ObjectID Object ( [oid] => 57dd66bcb0a5e3b85e8b4567 )
         * [invoice_date] => 04-09-2016
         * [invoice_number] => Inv81531
         * [added_on] => 17-09-2016
         */
        /* $transactionManager     = new Manager();
        $transaction            = $transactionManager->get();
        foreach ($customerI as $key)
        {
            $new = new Customermis();
            $new->mid               = (string)$key->_id;
            $new->invoice_date      = Customerms::AddDate($key->invoice_date);
            $new->invoice_number    = $key->invoice_number;
            $new->setTransaction($transaction);
            $new->created_at        = Customerms::AddDate($key->added_on);
            $new->create();
        }
        $transaction->commit(); */
        //$results = count($customerI);
        $customerO = Customer_o::find();
        /**
         * Customer orders
         * Array ( [_id] => MongoDB\BSON\ObjectID Object ( [oid] => 57dd66bcb0a5e3b85e8b4568 )
         * [_invoice] => MongoDB\BSON\ObjectID Object ( [oid] => 57dd66bcb0a5e3b85e8b4567 )
         * [invoice_date] => 17-09-2016
         * [added_on] => 17-09-2016
         * [_purchase] => Array (
         *  [0] => MongoDB\BSON\ObjectID Object ( [oid] => 57c9551fb0a5e349248b4567 )
         *  [1] => MongoDB\BSON\ObjectID Object ( [oid] => 57cc0e97b0a5e320758b4567 )
         *  [2] => MongoDB\BSON\ObjectID Object ( [oid] => 57cc14ccb0a5e3407e8b4567 )
         *  [3] => MongoDB\BSON\ObjectID Object ( [oid] => 57cc2e5cb0a5e35a278b4568 ) )
         * [_payment] => Array ( 
         *  [0] => MongoDB\BSON\ObjectID Object ( [oid] => 57ea5589b0a5e3625e8b4567 ) )
         * [_takenby] => MongoDB\BSON\ObjectID Object ( [oid] => 5799bfaab0a5e3c8698b4567 ) )
         */
        
        
        // ['limit' => 500, 'skip' => 3500]
        $customerP = Customer_p::find();
        /**
         * Customer purchases
         * Array ( [_id] => MongoDB\BSON\ObjectID Object ( [oid] => 57c9551fb0a5e349248b4567 )
         * [purchase_no] => ikr- 001
         * [created_on] => 04-09-2016
         * [_takenby] => MongoDB\BSON\ObjectID Object ( [oid] => 57c94c39b0a5e3c1188b4567 )
         * [_bought] => Array (
         *      [0] => MongoDB\BSON\ObjectID Object ( [oid] => 57caf64fb0a5e32e2d8b4567 ) )
         * [total_weight] => 398.8
         * [price] => 275
         * [total_price] => 1136.58
         * [ref_num] => 14279
         * [delivered] => 29-08-2016 )
         */
        /* $results[] = count($customerP);
        $transactionManager     = new Manager();
        $transaction            = $transactionManager->get();
        foreach ($customerP as $key)
        {
            if (!empty($key->_bought))
            {
                foreach ($key->_bought as $k)
                {
                    $got = (string)$k;
                
                    $exb = Customermbps::findFirst(['conditions' => "mid = '$got'"]);
                    if ($exb)
                    {
                        $new = new Customermps();
                        $new->mid       = (string)$key->_id;
                        $new->purchase_no   = $key->purchase_no;
                        $new->price         = !empty($key->price) ? $key->price : 0;
                        $new->setTransaction($transaction);
                        $new->created_at    = Customerms::AddDate($key->created_on);
                        $new->total_price   = !empty($key->total_price)? $key->total_price : 0;
                        $new->total_weight  = !empty($key->total_weight)? $key->total_weight : 0;
                        $new->purchase      = $exb;
                        if ($new->create() == false)
                        {
                            foreach ($new->getMessages() as $message)
                            {
                                $this->flash->error($message);
                            }
                        } 
                    }
                }
            }
            else 
            {
                
            }
            
        }
        
        $transaction->commit(); */
        /* ['limit' => 1000, "skip" => 5000] */
        $customerpd = Customer_pb::find();
        /**
         * [_id] => MongoDB\BSON\ObjectID Object ( [oid] => 57c9605fb0a5e30a328b4567 )
         * [_product] => MongoDB\BSON\ObjectID Object ( [oid] => 57c95909b0a5e3af288b4567 )
         * [rate] => 3.10
         * [weight] => 130.9
         * [ref_num] => 14261
         * [invoice_date] => 29-08-2016
         * [price] => 405.79
         * [_takenby] => MongoDB\BSON\ObjectID Object ( [oid] => 57c94c39b0a5e3c1188b4567 )
         * [qty] => 3
         */
        /* $transactionManager     = new Manager();
        $transaction            = $transactionManager->get();
        foreach ($customerpd as $key)
        {
            
            $new = new Customermbps();
            $new->mid              = (string)$key->_id;
            $new->product_id       = (string)$key->_product;
            $new->setTransaction($transaction);
            $new->rate              = !empty($key->rate) ? $key->rate : 0;
            $new->qty               =  empty($key->qty) ? 1 : $key->qty;
            $new->weight            = empty($key->weight) ? 0 : $key->weight;
            $new->ref_n             = !empty($key->ref_num) ? $key->ref_num : null;
            $new->price             = $key->price;
            if ($new->create() == false)
            {
                foreach ($new->getMessages() as $message)
                {
                    $this->flash->error($message);
                }
            }
            //$results[] = [(string)$key->_id, (string)$key->_product, $rate, $qty, $weight, $ref, $key->price];
            
        }
        $transaction->commit();
        
        $results[] = count($customerpd); */
        
        //$customer = Customer::find();
        /**
         * [_id] => MongoDB\BSON\ObjectID Object ( [oid] => 57c953dcb0a5e3ef228b4567 )
         * [full_name] => Ikram
         * [company] => AI Catering Services Ltd
         * [address] => 269 Park road, Glodwick, Oldham OL4 1RT
         * [cust_id] => a -1
         * [telephone] => 0161 652 5525
         * [mobile] => 0797 334 4486
         * [email] =>
         * [rate] => 2.80
         * [opening_balance] => 1305.72
         * [closing_balance] => 2774.77
         * [created_on] => 18-01-2017
         * [_takenby] => MongoDB\BSON\ObjectID Object ( [oid] => 57c94c39b0a5e3c1188b4567 )
         *
         */
        
        /* foreach ($customer as $key)
        {
            $new = new Customerms();
            $new->mid           = (string)$key->_id;
            $new->full_name     = $key->full_name ? $key->full_name : 'NO Name' ;
            $new->company       = $key->company;
            $new->address       = $key->address;
            $new->telephone     = $key->telephone;
            $new->mobile        = $key->mobile;
            $new->created_at    = Customerms::AddDate($key->created_on);
            $new->opening_balance   = $key->opening_balance;
            $new->closing_balance   = $key->closing_balance;
            if ($new->save()  == false)
            {
                foreach ($new->getMessages() as $message)
                {
                    $this->flash->error($message);
                }
            }
            
            
        } */
        
        
        $customerPay = Customer_pay::find();
        /**
         * {"_id":{"$oid":"57cc5409b0a5e3b1668b4567"},
         * "payment_ref":"31\/08\/16",
         * "amount_paid":"850.00",
         * "payment_method":"Cash",
         * "added_on":"04-09-2016",
         * "_takenby":{"$oid":"57c94c39b0a5e3c1188b4567"}}
         */
        /*
        foreach ($customerPay as $key)
        {
            $new = new Customermpays();
             $new->mid           = (string)$key->_id;
            $new->full_name     = $key->full_name ? $key->full_name : 'NO Name' ;
            $new->company       = $key->company;
            $new->address       = $key->address;
            $new->telephone     = $key->telephone;
            $new->mobile        = $key->mobile;
            $new->created_at    = Customerms::AddDate($key->created_on);
            $new->opening_balance   = $key->opening_balance;
            $new->closing_balance   = $key->closing_balance;
            if ($new->save()  == false)
            {
                foreach ($new->getMessages() as $message)
                {
                    $this->flash->error($message);
                }
            } 
        
        
        }*/
        $this->view->customers = json_encode($results);
