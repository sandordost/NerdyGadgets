<?php
include "database.php";
if(isset($_GET['action']) && $_GET['action'] == "logout"){
    unset($_SESSION['klant']);
    header("location: index.php");
}

$email = $_POST['email'];
$pass = $_POST['wachtwoord'];

$user = verifyUser($email, $pass);

if($user == null){
    header("location: index.php?error=login");
}
else {
    $_SESSION['klant']['email'] = $email;
    $_SESSION['klant']['pass'] = $pass;
    $_SESSION['klant']['id'] = $user;
    header("location: index.php");
}


