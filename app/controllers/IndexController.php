<?php
namespace App\Controllers;

use App\Forms\LoginForm;
use Phalcon\Security;
use App\Models\Faculty\Users;
use Phalcon\Mvc\Controller;
use Phalcon\Assets\Filters\Cssmin;
use Phalcon\Assets\Filters\Jsmin;
use App\Models\Faculty\FailedLogins;

/**
 * Display the default index page.
 */
class IndexController extends Controller
{

    protected function fastCache()
    {
        $ExpireDate = new \DateTime();
        $ExpireDate->modify('+1 hour');
        $response = $this->di['response'];
        $response->setExpires($ExpireDate);
        $response->setHeader('Cache-Control', 'public, max-age=3600, s-max=3600, must-revalidate, proxy-revalidate');
    }
    
    public function initialize()
    {
        $this->view->pagetitle = 'Login';
        //parent::initialize();
        
        $this->fastCache();
        
        $asset = $this->assets;
        // All required Layout Css
        $asset->collection('mandatorycss')
        ->addCss('assets/global/plugins/bootstrap/css/bootstrap.min.css')
        ->addCss('assets/global/plugins/select2/css/select2.min.css')
        ->addCss('assets/global/plugins/select2/css/select2-bootstrap.min.css')
        /* ->join(true)
         ->setTargetLocal(true)
         ->setTargetPath("main.min.css")
         ->setTargetUri('main.min.css')
         ->addFilter(new Cssmin()) */;
        
        $asset->collection('globelcss')
        ->addCss('assets/global/css/components-md.min.css', true)
        ->addCss('assets/global/css/plugins-md.min.css', true)
        ->join(true)
        ->setTargetLocal(true)
        ->setTargetPath("globel.css")
        ->setTargetUri('globel.css')
        ->addFilter(new Cssmin());
        
        
        
        $asset->collection('layoutcss')
        ->addCss('assets/layouts/layout3/css/layout.min.css', true)
        ->addCss('assets/layouts/layout3/css/themes/default.min.css', true)
        ->addCss('assets/layouts/layout3/css/custom.min.css', true)
        ->join(true)
        ->setTargetLocal(true)
        ->setTargetPath("layout.css")
        ->setTargetUri('layout.css')
        ->addFilter(new Cssmin());
        
        // All required JS
        
        $asset->collection('corejs')
        ->addJs('assets/global/plugins/jquery.min.js', true)
        ->addJs('assets/global/plugins/bootstrap/js/bootstrap.min.js', true)
        ->addJs('assets/global/plugins/js.cookie.min.js', true)
        ->addJs('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js', true)
        ->addJs('assets/global/plugins/jquery.blockui.min.js', true)
        ->addJs('assets/global/plugins/select2/js/select2.full.min.js', true)
        ->join(true)
        ->setTargetLocal(true)
        ->setTargetPath("core.js")
        ->setTargetUri('core.js')
        ->addFilter(new Jsmin());
        
        
        
        $asset->collection('appjs')
        ->addJs('assets/global/scripts/app.min.js', true)
        ->addJs('assets/pages/scripts/components-select2.js', true) ;
        
        
        
        $asset->collection('layoutjs')
        ->addJs('assets/layouts/layout3/scripts/layout.min.js');
        
        $this->flash->output();
    }
    
    
    
    /**
     * Default action. Set the public layout (layouts/public.volt)
     */
    public function indexAction()
    {

        $form = new LoginForm();
        
        if ($this->request->isPost()) 
        {
            if ($form->isValid($this->request->getPost()) != false)
            {
                
                if ($this->security->checkToken()) 
                {
                    $login    = $this->request->getPost("username");
                    $password = $this->request->getPost("password");
                    
                    
                    $user = Users::findFirst(['conditions' => "username = '$login'"]);
                    
                    if ($user) {
                        if ($this->security->checkHash($password, $user->password)) {
                            
                            
                            $this->session->set('auth-identity', [
                                'id' => $user->id,
                                'name' => $user->name,
                                'profile' => $user->profile->name
                            ]);
                            
                            return $this->dispatcher->forward(
                                [
                                    "controller" => "dashboard",
                                    "action"     => "index",
                                ]
                            );
                            
                        }
                        else {
                            
                            $failedLogin        = new FailedLogins();
                            $failedLogin->user  = $user;
                            $failedLogin->ipAddress = $this->request->getClientAddress();
                            $failedLogin->attempted = time();
                            $failedLogin->save();
                            $this->flash->error('Wrong Username/password combination');
                        }
                    }
                    else
                    {
                        $this->flash->error('No User Found');
                    }
                }
                
            }
            else
            {
                foreach ($form->getMessages() as $message) {
                    $this->flash->error((string) $message);
                }
            }
        }
        
        $this->view->form   = $form;
        $this->view->login  = true;
        $this->view->setTemplateAfter('login');
        
    }

    
}
