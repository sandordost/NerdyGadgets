<?php
$conn = connectToDatabase();

function AddKortingToProduct($conn){

    //Update collumn only if not exists:
    $sql = "ALTER TABLE stockitems ADD COLUMN IF NOT EXISTS korting DECIMAL(5,2) DEFAULT(0)";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
}

AddKortingToProduct($conn);