<?php
namespace App\Controllers;

use App\Models\Mongo\Students_m;


/**
 * Display the default index page.
 */
class StudentsController extends ControllerBase
{

    public function initialize()
    {
        $this->view->pagetitle = 'Students';
        parent::initialize();
    }
    /**
     * Default action. Set the public layout (layouts/public.volt)
     */
    public function indexAction()
    {
        
        $student = Students_m::find(['leaving_date' => null]);
        $this->view->table          = true;
        $this->view->students       = $student;
    }
}
