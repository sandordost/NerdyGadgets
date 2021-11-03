<?php
include __DIR__ . "/header.php";

if (isset($_GET['add_item'])) {
    array_push($_SESSION['Winkelmand'], $_GET['add_item']);
}

if (isset($_GET['delete_item'])) {
    unset($_SESSION['Winkelmand'][$_GET['delete_item']]);
}

foreach ($_SESSION['Winkelmand'] as $key => $row){
    $product = getStockItem($row, $databaseConnection);
    echo $product['StockItemName'] . "<a href='winkelmand.php?delete_item=$key'>Verwijder</a>";
    echo $key;
    echo "<br>";
}