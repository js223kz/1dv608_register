<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-09-14
 * Time: 11:44
 */


namespace controller;
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
require_once('model/UserDAL.php');

class LoginController
{
    private $loginView;
    private $layoutView;
    private $dateTimeView;
    private $userDAL;

    public function __construct(\model\UserDAL $userDB){

        $this->loginView = new \view\LoginView($userDB);
        $this->layoutView = new \view\LayoutView();
        $this->dateTimeView = new \view\DateTimeView();
        $this->userDAL = $userDB;
    }

    public function authenticateUser(){
        if($this->loginView->cookieExist()){
            $this->userDAL->setUserLoggedInSession();
            $this->loginView->showWelcomeWithCookieMessage();
        }

        if($this->loginView->userWantsToLogin() && !$this->userDAL->isLoggedIn()){
            if($this->loginView->getUserCredentials() != null){
                try {
                    $this->userDAL->checkUserCredentials($this->loginView->getUserCredentials());
                        if($this->loginView->keepUserLoggedIn() && $this->userDAL->isLoggedIn()){
                            $this->loginView->setCookie();
                            $this->loginView->showCookieMessage();
                        }else{
                            $this->loginView->showLoginMessage($this->userDAL->isLoggedIn());
                        }
                } catch (\EmtpyUsernameException $e) {
                    $this->loginView->setMessage($e->getMessage());
                } catch (\EmtpyPasswordException $e) {
                    $this->loginView->setMessage($e->getMessage());
                }
            }
        }

      if($this->loginView->userWantsToLogout() && $this->userDAL->isLoggedIn()){
          $this->userDAL->unsetUserLoggedInSession();
          $this->loginView->showLogoutMessage();
          $this->loginView->unsetCookie();
       }
    }
    public function echoHTML(){
        $this->loginView->renderHTML($this->userDAL->isLoggedIn());
    }
}