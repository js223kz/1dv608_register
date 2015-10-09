<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-10-08
 * Time: 15:54
 */

namespace view;


use model\DateTimeModel;

class RegisterView
{

    private static $message = 'RegisterView::Message';
    private static $username = 'RegisterView::UserName';
    private static $password = 'RegisterView::Password';
    private static $passwordrepeat = 'RegisterView::PasswordRepeat';
    private static $doRegistration = 'RegisterView::DoRegistration';

    public function __construct(){
    }
    public function renderRegistrationHTML(){
        return '
            <a href="?register">Back to login</a><h2>Not logged in</h2>
            <div class="container" >
                <h2>Register new user</h2>
                <form action="?register" method="post" enctype="multipart/form-data">
                    <fieldset>
                    <legend>Register a new user - Write username and password</legend>
                        <p id="'. self::$message . '"></p>
                        <label for="'. self::$username .'" >Username :</label>
                        <input type="text" size="20" name"' . self::$username . '" id="' . self::$username . '" value="" />
                        <br/>
                        <label for="' . self::$password . '" >Password  :</label>
                        <input type="password" size="20" name="' . self::$password .  '" id="' . self::$password. '" value="" />
                        <br/>
                        <label for="' . self::$passwordrepeat . '" >Repeat password  :</label>
                        <input type="password" size="20" name="' . self::$passwordrepeat . '" id="' . self::$passwordrepeat . '" value="" />
                        <br/>
                        <input id="submit" type="submit" name="' . self::$doRegistration . '"  value="Register" />
                        <br/>
                    </fieldset>
                </form>
            </div>
		';
    }
}
