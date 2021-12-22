<?php

$show_message = false;
$message_class = "";
$message_text = "Er is iets verkeerd gegaan";

if(isset($_GET['register_confirmation'])){

    $register_confirmation = $_GET['register_confirmation'];

    if(!empty($register_confirmation) && $register_confirmation == true) {
        $show_message = true;
        $message_class = "confirmation-message";
        $message_text = "";
    }
}

if(isset($_GET['error'])){

    $errormsg = $_GET['error'];
    $message_class = "error-message";
    $show_message = true;

    if(!empty($errormsg)){

        if($errormsg == "login"){
            $message_text = "Inloggen is mislukt, controlleer of de gegevens correct zijn ingevoerd.";
        }
    }
}