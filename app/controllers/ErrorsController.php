<?php
namespace App\Controllers;

class ErrorsController extends ControllerBase
{
    public function initialize()
    {
        $this->view->pagetitle = 'Oops!';
        parent::initialize();
    }
    public function show404Action()
    {
    }
    public function show401Action()
    {
    }
    public function show500Action()
    {
    }
}

