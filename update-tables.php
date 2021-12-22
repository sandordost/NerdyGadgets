<?php
$conn = connectToDatabase();

function AddKortingToProduct($conn){

    //Update collumn only if not exists:
    try {
        $sql = "ALTER TABLE stockitems ADD COLUMN korting DECIMAL(5,2) DEFAULT(0)";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }
    catch(Exception $exception){

    }
}

AddKortingToProduct($conn);