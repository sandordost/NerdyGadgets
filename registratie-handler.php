<?php
include "database.php";

$email = $_POST['email'];
$wachtwoord = $_POST['password'];
$herwachtwoord = $_POST['password-repeat'];
$voornaam = $_POST['voornaam'];
$tussenvoegsel = $_POST['tussenvoegsel'];
$achternaam = $_POST['achternaam'];
$adres = $_POST['adres'];
$woonplaats = $_POST['woonplaats'];
$land = $_POST['land'];
$postcode = $_POST['postcode'];
$phone = $_POST['phone'];

//Check if isset

if(isset($email)){

    //Check for empty
    if(!empty($email) && !empty($wachtwoord) && !empty($herwachtwoord) && !empty($voornaam) && !empty($achternaam)
        && !empty($adres) && !empty($land) && !empty($postcode) && !empty($woonplaats)){

        //Check if passwords match
        if($wachtwoord === $herwachtwoord){

            //Check if password > 5
            if(strlen($wachtwoord) > 5){
                try {
                    CreateUser($email, $wachtwoord, $voornaam, $tussenvoegsel, $achternaam, $adres, $land, $postcode, $phone, $woonplaats);
                    header("location: login.php?bestiging=true");
                }
                catch(Exception $exception){
                    header("location: registratie.php?error=5");
                }
            }
            else{
                header("location: registratie.php?error=4");
            }
        }
        else{
            header("location: registratie.php?error=3");
        }
    }
    else{
        header("location: registratie.php?error=2");
    }
}
else{
    header("location: registratie.php?error=1");
}