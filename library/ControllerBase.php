<?php
namespace App;

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Assets\Filters\Cssmin;
use Phalcon\Assets\Filters\Jsmin;
use Phalcon\Mvc\View;
//use Phalcon\Events\Manager;

/**
 * ControllerBase
 * This is the base controller for all controllers in the application
 */
class ControllerBase extends Controller
{
    /**
     * Execute before the router so we can determine if this is a private controller, and must be authenticated, or a
     * public controller that is open to all.
     *
     * @param Dispatcher $dispatcher
     * @return boolean
     */
    /* public function beforeExecuteRoute(Dispatcher $dispatcher)
    {
        $controllerName = $dispatcher->getControllerName();

        // Only check permissions on private controllers
        if ($this->acl->isPrivate($controllerName)) {

            // Get the current identity
            $identity = $this->auth->getIdentity();

            // If there is no identity available the user is redirected to index/index
            if (!is_array($identity)) {

                $this->flash->notice('You don\'t have access to this module: private');

                $dispatcher->forward([
                    'controller' => 'index',
                    'action' => 'index'
                ]);
                return false;
            }

            // Check if the user have permission to the current option
            $actionName = $dispatcher->getActionName();
            if (!$this->acl->isAllowed($identity['profile'], $controllerName, $actionName)) {

                $this->flash->notice('You don\'t have access to this module: ' . $controllerName . ':' . $actionName);

                if ($this->acl->isAllowed($identity['profile'], $controllerName, 'index')) {
                    $dispatcher->forward([
                        'controller' => $controllerName,
                        'action' => 'index'
                    ]);
                } else {
                    $dispatcher->forward([
                        'controller' => 'user_control',
                        'action' => 'index'
                    ]);
                }

                return false;
            }
            $is_ajax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
            if ($is_ajax) {
                $this->view->disableLevel(View::LEVEL_MAIN_LAYOUT);
            
                $eventsManager = new Manager();
            
                $eventsManager->attach('view:afterRender', function ($event, $view) {
                    $view->setContent(json_encode(array(
                        'content' => $view->getContent(),
                    )));
                });
            
                    $this->view->setEventsManager($eventsManager);
                    $this->response->setHeader('Content-Type', 'text/plain');
            }
        }
    } */

    protected function fastCache()
    {
        $ExpireDate = new \DateTime();
        $ExpireDate->modify('+1 hour');
        $response = $this->di['response'];
        $response->setExpires($ExpireDate);
        $response->setHeader('Cache-Control', 'public, max-age=3600, s-max=3600, must-revalidate, proxy-revalidate');
    }
    
    public function initialize() {
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
        
        
        $this->view->setTemplateAfter('common');
        $this->flash->output();
        
    }
    public function indexAction(){}
    
    
}
