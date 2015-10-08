<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-09-14
 * Time: 17:03
 */

namespace model;

class User
{
    private $userName;
    private $passWord;

    public function __construct($userName, $passWord){
        if(empty($userName) || !is_string($userName)){
            throw new \common\EmptyUserNameException();
            //throw new \EmptyUserNameException("Username can't be empty!");
        }
        if(empty($passWord) || !is_string($passWord)){
            throw new \common\EmptyPasswordException();
        }

        $this->userName = $userName;
        $this->passWord = $passWord;
    }

    public function getUserName(){
        return $this->userName;
    }

    public function getPassword(){
        return $this->passWord;
    }
}