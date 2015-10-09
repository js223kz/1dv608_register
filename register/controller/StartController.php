<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-10-08
 * Time: 12:06
 */

namespace controller;
require_once('view/StartView.php');
require_once('view/LayoutView.php');
require_once('view/DateTimeView.php');
require_once('view/RegisterView.php');
require_once('controller/RegisterController.php');

use view\LayoutView;
use view\StartView;

class StartController
{
    private $startView;
    private $layoutView;
    private $dateTimeView;
    private $registerView;
    private $userDAL;
    private $userLoggeIn = false;

    public function __construct(\model\UserDAL $userDAL){
        $this->userDAL = $userDAL;
        $this->startView = new \view\StartView();
        $this->layoutView = new \view\LayoutView();
        $this->dateTimeView = new \view\DateTimeView();
        $this->registerView = new \view\RegisterView();
        $this->executeUserChoice();
    }

    public function executeUserChoice(){

        if($this->startView->userWantsToLogin() && !$this->userDAL->isUserLoggedIn()) {
            if ($this->startView->getUserCredentials() != null) {
                try {
                    $this->userDAL->authenticateUser($this->startView->getUserCredentials());
                    $this->startView->showResponseMessage();
                } catch (\common\EmptyUserNameException $e) {
                    $this->startView->setMessage("Username missing!");
                } catch (\common\EmptyPasswordException $e) {
                    $this->startView->setMessage("Password missing");
                }
            }
        }
        if($this->startView->UserWantsToRegister()){
            $registerController = new \controller\RegisterController($this->registerView);
            $registerController->getUserRegistration();
        }

        if($this->startView->userWantsToLogout() && $this->userDAL->isUserLoggedIn()){
            $this->userDAL->unsetUserLoggedInSession();
            $this->startView->showResponseMessage();

        }

    }

    public function echoHTML(){
        if(!$this->userDAL->isUserLoggedIn() && !$this->startView->UserWantsToRegister()){
            $this->layoutView->render($this->startView->renderLoginHTML(), $this->dateTimeView);
        }
        if($this->userDAL->isUserLoggedIn()){
            $this->layoutView->render($this->startView->renderLogoutHTML(), $this->dateTimeView);
        }
        if(!$this->userDAL->isUserLoggedIn() && $this->startView->UserWantsToRegister()){
            $this->layoutView->render($this->registerView->renderRegistrationHTML(), $this->dateTimeView);
        }
    }
}