<?php
namespace App\Controllers;


use App\Models\Mongo\Student_fm;


/**
 * Display the default index page.
 */
class FeesController extends ControllerBase
{

    public function initialize()
    {
        $this->view->pagetitle = 'Students Fees';
        parent::initialize();
    }
    /**
     * Default action. Set the public layout (layouts/public.volt)
     */
    public function indexAction()
    {
        
        $student = Student_fm::find();
        $this->view->table          = true;
        $this->view->students       = $student;
    }
}
