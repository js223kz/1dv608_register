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

    public function __construct(){
        var_dump("Registrationview");
    }
    /*public function renderRegistrationHTML(){
        return '
            <h1>Assignment 2</h1>
            <a href='?register'>Back to login</a><h2>Not logged in</h2>    <div class="container" >

                <h2>Register new user</h2>
                <form action='?register' method='post' enctype='multipart/form-data'>
                    <fieldset>
                    <legend>Register a new user - Write username and password</legend>
                        <p id='RegisterView::Message'></p>
                        <label for='RegisterView::UserName' >Username :</label>
                        <input type='text' size='20' name='RegisterView::UserName' id='RegisterView::UserName' value='' />
                        <br/>
                        <label for='RegisterView::Password' >Password  :</label>
                        <input type='password' size='20' name='RegisterView::Password' id='RegisterView::Password' value='' />
                        <br/>
                        <label for='RegisterView::PasswordRepeat' >Repeat password  :</label>
                        <input type='password' size='20' name='RegisterView::PasswordRepeat' id='RegisterView::PasswordRepeat' value='' />
                        <br/>
                        <input id='submit' type='submit' name='DoRegistration'  value='Register' />
                        <br/>
                    </fieldset>
                </form><p>Thursday, the 8th of October 2015, The time is 15:53:21</p>    </div>
			';
    }*/
}