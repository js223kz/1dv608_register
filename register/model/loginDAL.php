<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-09-14
 * Time: 17:27
 */

namespace model;

class loginDAL
{
    private $users = array();
    private $userLoggedInSession = "loggedIn";

    public function addUserToDatabase(\model\User $user){

        if (isset($this->users[$user->getUserName()])) {
            throw new \Exception("Username already exists");
        }
        else if (isset($this->users[$user->getPassword()])) {
            throw new \Exception("Password already exists");
        }else{
            $key = $user->getUserName();
            $this->users[$key] = $user->getPassword();
        }
    }

    public function setUserLoggedInSession()
    {
        if(!isset($_SESSION[$this->userLoggedInSession])) {
            $_SESSION[$this->userLoggedInSession] = true;
        }
    }

    public function unsetUserLoggedInSession()
    {
        if(isset($_SESSION[$this->userLoggedInSession])) {
            unset($_SESSION[$this->userLoggedInSession]);
            session_destroy();
        }
    }

    public function isUserLoggedIn(){
        if(isset($_SESSION[$this->userLoggedInSession])){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param User $user
     * @return bool
     * @throws \EmtpyPasswordException
     * @throws \EmtpyUsernameException
     */

    public function authenticateUser(\model\User $user){

        $username = $user->getUserName();
        $password = $user->getPassword();

        if(empty($username)){
            throw new \common\EmtpyUsernameException();
        }
        if(empty($password)){
            throw new \common\EmtpyPasswordException();
        }



        if (array_key_exists($username, $this->users)) {

            if($this->users[$username] === $password){
                $this->setUserLoggedInSession();
                return true;
            }else{
               return false;
            }
        }else{
            return false;
        }
    }

}