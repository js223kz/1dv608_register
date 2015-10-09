<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-10-08
 * Time: 12:06
 */
namespace view;
require_once('model/UserDAL.php');
class StartView
{
    private static $login = 'LoginView::Login';
    private static $logout = 'LoginView::Logout';
    private static $name = 'LoginView::UserName';
    private static $password = 'LoginView::Password';
    private static $cookieName = 'LoginView::CookieName';
    private static $cookiePassword = 'LoginView::CookiePassword';
    private static $keep = 'LoginView::KeepMeLoggedIn';
    private static $messageId = 'LoginView::Message';
    private static $register = 'LoginView::Register';
    private $message = "";
    private $userName = "";
    private $pwd = "";
    private $userDAL;
    public function __construct(){
        $this->userDAL = new \model\UserDAL();
    }
    public function UserWantsToRegister(){
        if (isset($_GET['register'])){
            return true;
        }
        return false;
    }
    public function renderLogoutHTML(){
        return '
			<h2>Logged in</h2>
			<form  method="post" >
				<p id="' . self::$messageId . '">' . $this->getMessage() . '</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
    }
    public function renderLoginHTML(){
        return '
			<h2>Not logged in</h2>
			<a href="?register" name="' . self::$register . '">Register a new user</a>
			<form method="POST">
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $this->getMessage() . '</p>
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . $this->getUserName() . '"/>
					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />
					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';
    }
    /**
     * @return bool
     */
    public function userWantsToLogin(){
        return isset($_POST[self::$login]);
    }
    /*************************************
     * @return bool
     *************************************/
    public function userWantsToLogout(){
        return isset($_POST[self::$logout]);
    }
    public function isUserLoggedIn(){
        if ($this->userDAL->isUserLoggedIn()){
            return true;
        }
        return false;
    }
    /*************************************
     * @param String $message
     * @return String
     *************************************/
    public function setMessage($message){
        $this->message = $message;
    }
    public function getMessage(){
        return $this->message;
    }
    public function showResponseMessage(){
        if($this->userWantsToLogin() && !$this->isUserLoggedIn()){
            $this->setMessage("Wrong name or password");
        }
        if($this->isUserLoggedIn()){
            $this->setMessage("Welcome");
        }
        if($this->userWantsToLogout() && !$this->isUserLoggedIn()){
            $this->setMessage("Bye bye!");
        }
    }
    /**
     * @param String $username
     */
    private function setUserName($username){
        $this->userName = $username;
    }
    /**
     * @return string
     */
    private function getUserName(){
        return $this->userName;
    }
    private function setPassword($password){
        $this->pwd = $password;
    }
    /**
     * @return string
     */
    private function getPassword(){
        return $this->pwd;
    }
    public function getUserCredentials(){
        $this->setUserName(trim($_POST[self::$name])) ;
        $this->setPassword(trim($_POST[self::$password]));
        if ($this->userWantsToLogin() && $this->getUserName() == '') {
            $this->setMessage('Username is missing');
        }else if($this->userWantsToLogin() && $this->getPassword() == ''){
            $this->setMessage('Password is missing');
        }else if($this->userWantsToLogin()&& $this->getUserName() != '' && $this->getPassword() != ''){
            try {
                return new \model\User($this->getUserName(), $this->getPassword());
            } catch (\common\EmptyUserNameException $e) {
                $this->setMessage("Username is missing!");
            } catch (\common\EmptyPasswordException $e) {
                $this->setMessage("Password is missing!");
            }
        }else{
            return null;
        }
    }
}