<?php

require_once('ini.php');
require_once('model/User.php');
require_once('model/loginDAL.php');
require_once('model/DateTimeModel.php');
require_once('view/LayoutView.php');
require_once('controller/StartController.php');


session_start();

unset($_SESSION["PHPSESSID"]);

//CREATE NEW USERDATABASE FAKE OBJECT
$loginDAL = new \model\loginDAL();
//$user;
//CREATE NEW USER OBJECT AND ADD IT TO FAKE DATABASE
/*try {
    $user = new \model\User("Admin", "Password");
} catch (Exception $e) {
    echo $e->getMessage();
}

try {
    $loginDAL->addUserToDatabase($user);
} catch (Exception $e) {
    echo $e->getMessage();
}*/

$startController = new \controller\StartController($loginDAL);
$startController->echoHTML();

