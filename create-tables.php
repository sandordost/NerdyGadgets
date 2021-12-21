<?php
$conn = connectToDatabase();
//Create tables if they don't exist yet:

//Klant tabel aanmaken
function createKlant($conn) {
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
        telefoon VARCHAR(30),
        salt VARCHAR(110) NOT NULL
    );";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
}

function createBestelling($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS bestelling(
        BestellingID INT PRIMARY KEY AUTO_INCREMENT,
        Voornaam VARCHAR(100) NOT NULL,
        Tussenvoegsel VARCHAR(50),
        Achternaam VARCHAR(120) NOT NULL,
        Emailadres VARCHAR(100) NOT NULL,
        Adres VARCHAR(200) NOT NULL,
        Land VARCHAR(100) NOT NULL,
        Postcode VARCHAR(10) NOT NULL,
        Woonplaats VARCHAR(120) NOT NULL,
        Telefoon VARCHAR(30),
        Betalingswijze VARCHAR(30) NOT NULL,
        Bestellingsdatum DATE NOT NULL,
        Verzonden TINYINT(1),
        Betaald TINYINT(1),
        klantId INT(11)
        );";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
}

function createBestellingsLijn($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS bestellingsLijn(
        BestellingsLijnID INT PRIMARY KEY AUTO_INCREMENT,
        BestellingID INT NOT NULL,
        StockItemID INT NOT NULL,
        Beschrijving VARCHAR(100) NOT NULL,
        Hoeveelheid INT(11) NOT NULL,
        Prijs DECIMAL(18,2),
        BTW DECIMAL(18,3) NOT NULL
        );";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
}

createKlant($conn);
createBestelling($conn);
createBestellingsLijn($conn);