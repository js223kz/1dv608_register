<?php

namespace view;

require_once('model/loginDAL.php');


class LoginView
{

	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';
	private static $keep = 'LoginView::KeepMeLoggedIn';
	private static $messageId = 'LoginView::Message';
	private $username = "";
	private $pwd;
	private $message = "";
	private $userDAL;

	public function __construct(\model\loginDAL $userDB){
		$this->userDAL = $userDB;
	}

	public function userWantsToLogin(){
		return isset($_POST[self::$login]);
	}

	public function userWantsToLogout(){
		return isset($_POST[self::$logout]);
	}

	public function keepUserLoggedIn(){
		return isset($_POST[self::$keep]);
	}

	public function setCookie(){
		setcookie(self::$cookieName, $this->getUserName());
		setcookie(self::$cookiePassword, $this->generateRadomString());
	}

	public function unsetCookie(){
		if (isset($_SERVER['HTTP_COOKIE'])) {
			$cookies = explode(';', $_SERVER['HTTP_COOKIE']);
			foreach($cookies as $cookie) {
				$parts = explode('=', $cookie);
				$name = trim($parts[0]);
				setcookie($name, '', time()-1000);
				setcookie($name, '', time()-1000, '/');
			}
		}
	}

	public function setMessage($message){
		$this->message = $message;
	}

	public function getMessage(){
		return $this->message;
	}

	public function showLogoutMessage(){
		$this->setMessage("Bye bye!");
	}
	public function showCookieMessage(){
		$this->setMessage("Welcome and you will be remembered!");

	}

	public function showWelcomeWithCookieMessage(){
			$this->setMessage("Welcome back with cookie");

	}

	public function cookieExist(){
		return isset($_COOKIE[self::$cookieName]);
	}

	public function showMessage($isLoggedIn){
		if($isLoggedIn){

			$this->setMessage("Welcome");
		}
	}

	public function welcomeBackMessage(){
		$this->setMessage("Welcome back with cookie");
	}

	private function setUserName($username){
		$this->username = $username;
	}

	private function getUserName(){
		return $this->username;
	}

	private function setPassword($password){
		$this->pwd = $password;
	}

	private function getPassword(){
		return $this->pwd;
	}

	public function generateRadomString(){
			$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$randomStringLength = 20;
			$charactersLength = strlen($chars);
			$randomString = '';
			for ($i = 0; $i < $randomStringLength; $i++) {
				$randomString .= $chars[rand(0, $charactersLength - 1)];
			}
			return $randomString;
		}





	public function getUserCredentials()
	{
		$this->setUserName(trim($_POST[self::$name])) ;
		$this->setPassword(trim($_POST[self::$password]));

		if ($this->userWantsToLogin() && $this->getUserName() == '') {
			$this->setMessage('Username is missing');
		} else if ($this->userWantsToLogin() && $this->getPassword() == '') {
			$this->setMessage('Password is missing');
		}
		if ($this->userWantsToLogin() && $this->getUserName() != '' && $this->getPassword() != '') {
			try{
				return new \model\User($this->getUserName(), $this->getPassword());
			}catch(\EmptyUserNameException $e){
				$this->setMessage($e->getMessage());
			}catch(\EmptyPasswordException $e){
				$this->setMessage($e->getMessage());
			}
		}
		return null;
	}

	public function renderHTML($loggedIn)
	{

		if ($loggedIn == false) {
			return $this->renderLoginHTML();
		} else {
			return $this->renderLogoutHTML();
		}
		die;
	}

	/**
	 * Generate HTML code on the output buffer for the logout button
	 * @return  void, BUT writes to standard output!
	 */
	private function renderLogoutHTML(){

		return '
			<h2>Logged in</h2>
			<form  method="post" >
				<p id="' . self::$messageId . '">' . $this->getMessage() . '</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
	}

	/**
	 * Generate HTML code on the output buffer for the login view
	 * @return  void, BUT writes to standard output!
	 */
	private function renderLoginHTML(){
		return '
			<h2>Not logged in</h2>
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
}