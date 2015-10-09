<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-10-09
 * Time: 08:56
 */

namespace controller;
require_once('view/RegisterView.php');
require_once('model/RegisterDAL.php');

class RegisterController
{
    private $registerView;
    private $registerDAL;

    public function __construct(){
        $this->registerView = new \view\RegisterView();
        $this->registerDAL = new\model\RegisterDAL();
        $this->getUserRegistration();
    }

    public function getUserRegistration()
    {
        if($this->registerView->userSubmitsRegistrationForm()){

            $this->registerDAL->saveNewUser($this->registerView->getUserData());
        }
    }
}