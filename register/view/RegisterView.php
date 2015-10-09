<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-10-08
 * Time: 15:54
 */

namespace view;

class RegisterView
{

    private static $messageId = 'RegisterView::Message';
    private static $username = 'RegisterView::UserName';
    private static $password = 'RegisterView::Password';
    private static $passwordrepeat = 'RegisterView::PasswordRepeat';
    private static $doRegistration = 'RegisterView::Register';
    private $responseMessage = "";
    private $userName;
    private $pwd;
    private $pwdRepeat;

    public function __construct(){
    }
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

        if($this->userSubmitsRegistrationForm() && mb_strlen($this->getUserName()) < 3){
            $this->responseMessage = 'Username has too few characters, at least 3 characters.<br/>';
        }
        if($this->userSubmitsRegistrationForm() && mb_strlen($this->getPassword()) < 6){
            $this->responseMessage .= 'Password has too few characters, at least 6 characters.';
        }
        $this->setMessage($this->responseMessage);
        return $this->renderRegistrationHTML();
    }

    public function userSubmitsRegistrationForm(){
        return isset($_POST[self::$doRegistration]);
    }

    private function setMessage($inputMessage){
        $this->inputMessage = $inputMessage;
    }

    private function getInputMessage(){
        return $this->inputMessage;
    }

    private function getUserName(){
        if(isset($_POST[self::$username])){
            return trim($_POST[self::$username]);
        }
        return "";
    }

    private function getPassword(){
        return trim($_POST[self::$password]);
    }

    private function getRepeatPassword(){
        return trim($_POST[self::$passwordrepeat]);
    }


}
