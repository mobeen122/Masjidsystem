<?php
namespace App\Controllers;


//use App\Models\Mongo\Student_fm;

/**
 * Display the default index page.
 */
class DashboardController extends ControllerBase
{

    public function initialize()
    {
        $this->view->pagetitle = 'Dashboard';
        parent::initialize();
    }
    /**
     * Default action. Set the public layout (layouts/public.volt)
     */
    public function indexAction()
    {
        /**
         *  [_id] => MongoDB\BSON\ObjectID Object ( [oid] => 56fd37f7b0a5e3e53d8b4567 ) 
         *  [full_name] => Adam Kashif 
         *  [birthdate] => 27-07-2003 
         *  [gender] => Male 
         *  [proof] => Passport 
         *  [mic_number] => 466 
         *  [med_condition] => none 
         *  [application_received] => 08-08-2016 
         *  [_address] => MongoDB\BSON\ObjectID Object ( [oid] => 56d95c17b0a5e33f168b463e ) 
         *  [_father] => MongoDB\BSON\ObjectID Object ( [oid] => 56d96272b0a5e3901c8b461c ) 
         *  [_mother] => MongoDB\BSON\ObjectID Object ( [oid] => 56d965afb0a5e3401f8b461f ) 
         *  [_doctor] => MongoDB\BSON\ObjectID Object ( [oid] => 56d93c80b0a5e30d6e8b4597 ) 
         *  [enrolled_date] => 08-08-2016 ) 
         * @var array $student
         */
        
        //$agent = [$this->request->getUserAgent(), $this->request->getClientAddress()];
        
        //$student = Students_m::find(['limit' => 5]);
        //$students = Student_fm::find();
        
        $this->view->students = [];
        $this->view->pagedetails    = 'Member Area';
    }
    
    public function convertAction()
    {
        
        
    }
}
