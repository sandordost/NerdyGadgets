<?php
include "database.php";

if(isset($_GET['bestiging'])){
    $bestiging = $_GET['bestiging'];
    if(!empty($bestiging) && $bestiging == true) {
        header("location: index.php?register_confirmation=true");
        die();
    }
}

if(isset($_GET['action']) && $_GET['action'] == "logout"){
    unset($_SESSION['klant']);
    header("location: index.php");
    die();
}

$email = $_POST['email'];
$pass = $_POST['wachtwoord'];

$user = verifyUser($email, $pass);

if($user == null){
    header("location: index.php?error=login");
    die();
}
else {
    $_SESSION['klant']['email'] = $email;
    $_SESSION['klant']['pass'] = $pass;
    $_SESSION['klant']['id'] = $user;
    header("location: index.php");
}


