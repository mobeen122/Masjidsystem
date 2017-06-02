<?php
namespace App\Controllers;

use Phalcon\Tag;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use App\Forms\ChangePasswordForm;
use App\Forms\UsersForm;
use App\Models\Faculty\Users;
use App\Models\Faculty\PasswordChanges;
use App\Models\Faculty\Profiles;

/**
 * App\Controllers\UsersController
 * CRUD to manage users
 */
class UsersController extends ControllerBase
{

     public function initialize()
    {
        $this->view->pagetitle = 'Users';
        parent::initialize();
    }

    /**
     * Default action, shows the search form
     */
    public function indexAction()
    {
        $users = Users::find();
        
        
        $this->view->users = $users;
        $this->view->table  = true;
    }

    /**
     * Searches for users
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'App\Models\Faculty\Users', $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = [];
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $users = Users::find($parameters);
        if (count($users) == 0) {
            $this->flash->notice("The search did not find any users");
            return $this->dispatcher->forward([
                "action" => "index"
            ]);
        }

        $paginator = new Paginator([
            "data" => $users,
            "limit" => 10,
            "page" => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Creates a User
     */
    public function createAction()
    {
        
        if ($this->request->isPost()) {

            $name       = $this->request->getPost('name', 'striptags');
            $prof       = $this->request->getPost('profile_id', 'int');
            $email      = $this->request->getPost('email', 'email');
            $username   = $this->request->getPost('username', 'striptags');
            
            $profile = Profiles::findFirst("id = $prof");
            if ($profile)
            {
                $user = new Users();
                $user->name     = $name;
                $user->profile  = $profile;
                $user->email    = $email;
                $user->username = $username;
            }

            if (!$user->save()) {
                $this->flash->error($user->getMessages());
            } else {

                $this->flash->success("User was created successfully");
                return $this->dispatcher->forward([
                    'action' => 'index'
                ]);
                Tag::resetInput();
            }
        }

        $this->view->form = new UsersForm(null);
    }

    /**
     * Saves the user from the 'edit' action
     */
    public function editAction($id)
    {
        $user = Users::findFirst("id = $id");
        if (!$user) {
            $this->flash->error("User was not found");
            return $this->dispatcher->forward([
                'action' => 'index'
            ]);
        }

        if ($this->request->isPost()) {

            $user->assign([
                'name'          => $this->request->getPost('name', 'striptags'),
                'profile_id'    => $this->request->getPost('profile_id', 'int'),
                'email'         => $this->request->getPost('email', 'email'),
                'username'      => $this->request->getPost('username', 'striptags'),
                'banned'        => $this->request->getPost('banned'),
                'suspended'     => $this->request->getPost('suspended'),
                'active'        => $this->request->getPost('active')
            ]);

            if (!$user->save()) {
                $this->flash->error($user->getMessages());
            } else {

                $this->flash->success("User was updated successfully");
                return $this->dispatcher->forward([
                    'action' => 'index'
                ]);
                Tag::resetInput();
            }
        }

        $this->view->user = $user;

        $this->view->form = new UsersForm($user, [
            'edit' => true
        ]);
    }

    /**
     * Deletes a User
     *
     * @param int $id
     */
    public function deleteAction($id)
    {
        $user = Users::findFirstById($id);
        if (!$user) {
            $this->flash->error("User was not found");
            return $this->dispatcher->forward([
                'action' => 'index'
            ]);
        }

        if (!$user->delete()) {
            $this->flash->error($user->getMessages());
        } else {
            $this->flash->success("User was deleted");
        }

        return $this->dispatcher->forward([
            'action' => 'index'
        ]);
    }

    /**
     * Users must use this action to change its password
     */
    public function changePasswordAction()
    {
        $form = new ChangePasswordForm();

        if ($this->request->isPost()) {

            if (!$form->isValid($this->request->getPost())) {

                foreach ($form->getMessages() as $message) {
                    $this->flash->error($message);
                }
            } else {

                $user = $this->auth->getUser();

                $this->view->user = $user;
                $user->password = $this->security->hash($this->request->getPost('password'));
                $user->mustChangePassword = 'N';
                
                $passwordChange = new PasswordChanges();
                $passwordChange->user = $user;
                $passwordChange->ipAddress = $this->request->getClientAddress();
                $passwordChange->userAgent = $this->request->getUserAgent();

                if (!$passwordChange->save()) {
                    $this->flash->error($passwordChange->getMessages());
                } else {

                    $this->flash->success('Your password was successfully changed');
                    return $this->response->redirect('dashboard');
                    Tag::resetInput();
                }
            }
        }

        $this->view->form = $form;
    }
}
