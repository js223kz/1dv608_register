<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-10-08
 * Time: 15:54
 */

namespace view;
require_once('model/User.php');
require_once('model/RegisterDAL.php');

class RegisterView
{

    private static $messageId = 'RegisterView::Message';
    private static $username = 'RegisterView::UserName';
    private static $password = 'RegisterView::Password';
    private static $passwordrepeat = 'RegisterView::PasswordRepeat';
    private static $doRegistration = 'RegisterView::Register';
    private $responseMessage = "";
    private $registerDAL;
    private $userName = "";

    public function __construct(){
        $this->registerDAL = new \model\RegisterDAL();

    }

    /**
     * @return no output but a string
     */
    public function renderRegistrationHTML(){
        return '
            <a href="?back">Back to login</a><h2>Not logged in</h2>
                <h2>Register new user</h2>
                <form method="post">
                    <fieldset>
                    <legend>Register a new user - Write username and password</legend>
                        <p id="' . self::$messageId . '">' .  $this->getInputMessage() . '</p>
                        <label for="'. self::$username .'" >Username :</label>
                        <input type="text" size="20" name="' . self::$username . '" id="' . self::$username . '" value="' . $this->getUserName() . '" />
                        <br/>
                        <label for="' . self::$password . '" >Password  :</label>
                        <input type="password" size="20" name="' . self::$password .  '" id="' . self::$password. '" value="" />
                        <br/>
                        <label for="' . self::$passwordrepeat . '" >Repeat password  :</label>
                        <input type="password" size="20" name="' . self::$passwordrepeat . '" id="' . self::$passwordrepeat . '" value="" />
                        <br/>
                        <input id="submit" type="submit" name="' . self::$doRegistration . '"  value="Register" />
                    </fieldset>
                </form>
		';
    }

    public function UserWantsToGoBack(){
        if (isset($_GET['back'])){
            return true;
        }
        return false;
    }

    public function inputResponse(){
        if($this->userSubmitsRegistrationForm()){
            $this->setUserName($_POST[self::$username]);
            if(mb_strlen($this->getUserName()) < 3){
                $this->responseMessage = 'Username has too few characters, at least 3 characters.<br/>';
            }
            if(mb_strlen($this->getPassword()) < 6){
                $this->responseMessage .= 'Password has too few characters, at least 6 characters.';
            }
            if(!$this->passwordsMatches()){
                $this->responseMessage = 'Passwords do not match.';
            }
            if($this->registerDAL->userAlreadyExists($this->getUserName())){
                $this->responseMessage = 'User exists, pick another username.';
            }
            if(strlen($this->getUserName()) != strlen(strip_tags($this->getUserName()))) {
                $this->responseMessage = 'Username contains invalid characters';
                $this->setUserName("abc");
            }
            if(mb_strlen($this->getUserName()) >= 3 && $this->getPassword() >= 6 && $this->passwordsMatches()){
                return new\model\User($this->getUserName(), $this->getPassword());
            }

            $this->setMessage($this->responseMessage);
        }
        return null;
    }

    public function userSubmitsRegistrationForm(){
        return isset($_POST[self::$doRegistration]);
    }

    private function setMessage($inputMessage){
        $this->responseMessage = $inputMessage;
    }

    private function getInputMessage(){
        return $this->responseMessage;
    }
    private function setUserName($userName){
        $this->userName = $userName;
    }

    private function getUserName(){
        return $this->userName;
    }

    private function getPassword(){
        return trim($_POST[self::$password]);
    }

    private function getRepeatPassword(){
        return trim($_POST[self::$passwordrepeat]);
    }

    private function passwordsMatches(){
        if($this->getPassword() === $this->getRepeatPassword()){
            return true;
        }
        return false;
    }
}
