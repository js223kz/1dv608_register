<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-10-09
 * Time: 08:56
 */

namespace controller;
require_once('view/RegisterView.php');

class RegisterController
{
    private $registerView;
    public function __construct(\view\RegisterView $registerView){
        $this->registerView = new \view\RegisterView();
    }

    public function getUserRegistration()
    {
    }
}