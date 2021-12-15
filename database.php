<!-- dit bestand bevat alle code die verbinding maakt met de database -->
<?php

session_start();

function connectToDatabase() {
    $Connection = null;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Set MySQLi to throw exceptions
    try {
        $Connection = mysqli_connect("localhost", "root", "root", "nerdygadgets");
        mysqli_set_charset($Connection, 'latin1');
        $DatabaseAvailable = true;
    } catch (mysqli_sql_exception $e) {
        $DatabaseAvailable = false;
    }
    if (!$DatabaseAvailable) {
        ?><h2>Website wordt op dit moment onderhouden.</h2><?php
        die();
    }

    return $Connection;
}

function getHeaderStockGroups($databaseConnection) {
    $Query = "
                SELECT StockGroupID, StockGroupName, ImagePath
                FROM stockgroups 
                WHERE StockGroupID IN (
                                        SELECT StockGroupID 
                                        FROM stockitemstockgroups
                                        ) AND ImagePath IS NOT NULL
                ORDER BY StockGroupID ASC";
    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_execute($Statement);
    $HeaderStockGroups = mysqli_stmt_get_result($Statement);
    return $HeaderStockGroups;
}

function getStockGroups($databaseConnection) {
    $Query = "
            SELECT StockGroupID, StockGroupName, ImagePath
            FROM stockgroups 
            WHERE StockGroupID IN (
                                    SELECT StockGroupID 
                                    FROM stockitemstockgroups
                                    ) AND ImagePath IS NOT NULL
            ORDER BY StockGroupID ASC";
    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_execute($Statement);
    $Result = mysqli_stmt_get_result($Statement);
    $StockGroups = mysqli_fetch_all($Result, MYSQLI_ASSOC);
    return $StockGroups;
}

function getStockItem($id, $databaseConnection) {
    $Result = null;

    $Query = " 
           SELECT SI.StockItemID, 
            (RecommendedRetailPrice*(1+(TaxRate/100))) AS SellPrice, 
            StockItemName,
            CONCAT('Voorraad: ',QuantityOnHand)AS QuantityOnHand,
            QuantityOnHand as Quantity,
            SearchDetails, 
            (CASE WHEN (RecommendedRetailPrice*(1+(TaxRate/100))) > 50 THEN 0 ELSE 6.95 END) AS SendCosts, MarketingComments, CustomFields, SI.Video,
            (SELECT ImagePath FROM stockgroups JOIN stockitemstockgroups USING(StockGroupID) WHERE StockItemID = SI.StockItemID LIMIT 1) as BackupImagePath   
            FROM stockitems SI 
            JOIN stockitemholdings SIH USING(stockitemid)
            JOIN stockitemstockgroups ON SI.StockItemID = stockitemstockgroups.StockItemID
            JOIN stockgroups USING(StockGroupID)
            WHERE SI.stockitemid = $id
            GROUP BY StockItemID";

    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_execute($Statement);
    $ReturnableResult = mysqli_stmt_get_result($Statement);
    if ($ReturnableResult && mysqli_num_rows($ReturnableResult) == 1) {
        $Result = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC)[0];
    }

    return $Result;
}

function getStockItemImage($id, $databaseConnection) {

    $Query = "
                SELECT ImagePath
                FROM stockitemimages 
                WHERE StockItemID = $id";

    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_execute($Statement);
    $R = mysqli_stmt_get_result($Statement);
    $R = mysqli_fetch_all($R, MYSQLI_ASSOC);

    return $R;
}

function reduceStockItem($id, $amount, $databaseConnection) {
    $Query = "
                UPDATE stockitemholdings
                SET QuantityOnHand = QuantityOnHand - $amount
                WHERE StockItemID = $id
    ";

    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_execute($Statement);
}

//Returns null if the user was not found
//Returns klantId if the user was found
function verifyUser($email, $password){
    $conn = connectToDatabase();

    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    $sql = "SELECT klantId, password, salt FROM klant WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);

    $stmt->execute();
    $result = $stmt->get_result();
    $num_count = $result->num_rows;

    $row = $result->fetch_row();

    if($num_count > 0) {
        for($i = 65; $i < 91; $i++){
            if(encryptPassword($password, $row[2], chr($i)) == $row[1]){
                return $row[0];
            }
        }
    }
    return null;
}

//Maakt de gebruiker aan in de database
function CreateUser($email, $wachtwoord, $voornaam, $tussenvoegsel, $achternaam, $adres, $land, $postcode, $phone)
{
    $Connection = connectToDatabase();

    $salt = $postcode . $achternaam;
    $pepper = generatePepper();

    $encryptedPass = encryptPassword($wachtwoord, $salt, $pepper);

    $sql = "INSERT INTO klant (email, password, voornaam, tussenvoegsel, achternaam, adres, land, postcode, telefoon, salt) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
    $stmt = $Connection->prepare($sql);
    $stmt->bind_param('ssssssssss', $email, $encryptedPass, $voornaam, $tussenvoegsel, $achternaam,
        $adres, $land, $postcode, $phone, $salt);
    $stmt->execute();
}

//Krijgt de details van de huidig ingelogte klant
function GetCurrentUserData(){
    if(isset($_SESSION['klant'])) {
        $id = verifyUser($_SESSION['klant']['email'], $_SESSION['klant']['pass']);
        if($id == null) {
            return null;
        }
    }
    else{
        return null;
    }

    $conn = connectToDatabase();

    $sql = "SELECT * FROM klant WHERE klantId = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    $stmt->execute();

    $result = $stmt->get_result();

    return $result->fetch_row();
}

function encryptPassword($password, $salt, $pepper){
    // Salt wordt gebruikt om het wachtwoord te beveiligen tegen "rainbow tables"
    // (databases met veel mogelijke wachtwoorden)
    // Salt wordt voor het hashen aan het wachtwoord geplakt maar voorkomt geen bruteforce aanval
    // omdat de hacker nog steeds in de database de salt kan aflezen

    // Pepper is een korte tekst of een teken die achter een wachtwoord wordt geplakt. Het teken is
    // willekeurig (Random) en wordt niet opgeslagen in de database.
    // Om het wachtwoord te kunnen herkennen zal de website alle mogelijke tekens uitproberen tot dat
    // er een wachtwoord hash voorkomt die overeen komt met de hash van de website met een van de
    // willekeurige tekens

    // Hashing wordt gebruikt om een wachtwoord onleesbaar te maken, door gebruik te maken
    // van een goede hashmethode kan het onmogelijk worden om het wachtwoord terug om te zetten
    $hashedPass = hash("sha512", $password . $salt . $pepper);

    return $hashedPass;
}

function generatePepper(){
    return chr(rand(65,90));
}