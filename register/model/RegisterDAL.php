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
    private $userExists;
    private $newUserName;
    public function saveNewUser(\model\User $newUser){
        $this->newUserName = $newUser->getUserName();
        $file = fopen("data/" . $this->newUserName . ".txt", "w");
        fwrite($file, $newUser->getPassword());
        fclose($file);
    }

    public function userAlreadyExists(){
        if(file_exists("data/" . $this->newUserName . ".txt")){
            $this->userExists = true;
        }
        return $this->userExists;
    }


}

