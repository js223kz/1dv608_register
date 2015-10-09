<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-10-09
 * Time: 14:55
 */

namespace model;

require_once('model/User.php');

class RegisterDAL
{
    public function saveNewUser(\model\User $newUser){
        $newUser->getUserName();
        $file = fopen("data/" . $newUser->getUserName() . ".txt", "w");
        fwrite($file, $newUser->getPassword());
        fclose($file);
    }

    public function userAlreadyExists($username){

        if(file_exists("data/" . $username . ".txt")){
            return true;
        }
        return false;
    }


}

