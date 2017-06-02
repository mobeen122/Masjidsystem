<?php
namespace App\Controllers;

use App\Models\Faculty\EmailConfirmations;
use App\Models\Faculty\ResetPasswords;

/**
 * UserControlController
 * Provides help to users to confirm their passwords or reset them
 */
class UserControlController extends ControllerBase
{
    public function initialize()
    {
        $this->view->pagetitle = 'Users control';
        parent::initialize();
    }
   
    public function indexAction()
    {

    }

    /**
     * Confirms an e-mail, if the user must change thier password then changes it
     */
    public function confirmEmailAction()
    {
        $code = $this->dispatcher->getParam('code');

        $confirmation = EmailConfirmations::findFirstByCode($code);

        if (!$confirmation) {
            
            $this->flash->error('Confirmation Code Not Valid, Please reset ur password');
            return $this->dispatcher->forward([
                'controller' => 'index',
                'action' => 'index'
            ]);
        }
        else {
           
            if ($confirmation->confirmed != 'N') {
                $this->flash->success('Confirmation Code Already Confirmed, Please Login');
                return $this->dispatcher->forward([
                    'controller' => 'index',
                    'action' => 'index'
                ]);
            }
            else 
            {
                $confirmation->confirmed = 'Y';
                
                $confirmation->user->active = 'Y';
                
                if (!$confirmation->save()) {
                
                    foreach ($confirmation->getMessages() as $message) {
                        $this->flash->error($message);
                    }
                }
                else 
                {
                    /**
                     * Identify the user in the application
                     */
                    $this->auth->authUserById($confirmation->user->id);
                    
                    /**
                     * Check if the user must change his/her password
                     */
                    if ($confirmation->user->mustChangePassword == 'Y') {
                    
                        $this->flash->success('The email was successfully confirmed. Now you must change your password');
                    
                        return $this->dispatcher->forward([
                            'controller' => 'users',
                            'action' => 'changePassword'
                        ]);
                    }
                    else 
                    {
                        $this->flash->success('The email was successfully confirmed, please Login');
                        
                        return $this->dispatcher->forward([
                            'controller' => 'index',
                            'action' => 'index'
                        ]);
                    }
                    
                    
                }
            }

            
        }
        
    }

    public function resetPasswordAction()
    {
        $code = $this->dispatcher->getParam('code');

        $resetPassword = ResetPasswords::findFirstByCode($code);

        if (!$resetPassword) {
            $this->flash->error('Password Code Not Valid, Please reset ur password');
            return $this->dispatcher->forward([
                'controller' => 'index',
                'action' => 'index'
            ]);
        }
        else 
        {
            if ($resetPassword->reset != 'N') {
                $this->flash->success('Password Code Validated, Please Login');
                return $this->dispatcher->forward([
                    'controller' => 'index',
                    'action' => 'index'
                ]);
            }
            else 
            {
                $resetPassword->reset = 'Y';
                
                /**
                 * Change the confirmation to 'reset'
                 */
                if (!$resetPassword->save()) {
                
                    foreach ($resetPassword->getMessages() as $message) {
                        $this->flash->error($message);
                    }
                }
                else 
                {
                    /**
                     * Identify the user in the application
                     */
                    $this->auth->authUserById($resetPassword->user->id);
                    
                    $this->flash->success('Password reset Confirmed Please reset your password');
                    
                    return $this->dispatcher->forward([
                        'controller' => 'users',
                        'action' => 'changePassword'
                    ]);
                }
                
                
            }
            
            
        }

        
    }
}
