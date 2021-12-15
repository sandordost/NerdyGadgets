<?php
include "database.php";

$conn = connectToDatabase();
//Create tables if they don't exist yet:

//Klant tabel aanmaken
$sql = "CREATE TABLE IF NOT EXISTS klant(
	klantId INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(256) NOT NULL,
    voornaam VARCHAR(100) NOT NULL,
    tussenvoegsel VARCHAR(50),
    achternaam VARCHAR(120) NOT NULL,
    adres VARCHAR(200) NOT NULL,
    woonplaats VARCHAR(120) NOT NULL,
    land VARCHAR(100) NOT NULL,
    postcode VARCHAR(10) NOT NULL,
    phone VARCHAR(30),
    salt VARCHAR(110) NOT NULL
);";
$stmt = $conn->prepare($sql);
$stmt->execute();