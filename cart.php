<?php
include __DIR__ . "/header.php";
include "cartfuncties.php";
?>
<body>
<h1>Inhoud Winkelwagen</h1>

<?php

$cart = getCart();

if (isset($cart)) {
    foreach ($cart as $item => $amount){
        $product = getStockItem($item, $databaseConnection);
        echo "$item, " . $product['StockItemName'];
        echo ", Hoeveelheid $amount, Totaalprijs: $" . round($product['SellPrice'] * $amount, 2);

        ?>

        <form method="post">
            <input type="number" name="stockItemID" value="<?php print($product["StockItemID"]) ?>" hidden>
            <input type="number" name="amount" value="<?php print($amount) ?>" hidden>
            <input type="submit" name="submit" value="Verwijderen">
        </form>

        <?php
        $laatsteitem = $item;
    }

    if (isset($_POST["submit"])) {
        $stockItemID = $_POST["stockItemID"];
        $amount = $_POST["amount"];
        removeProductFromCart($stockItemID, $amount);
    }
}

if (isset($item)){

?>
<br>
<p><a href='view.php?id= <?php print $item ?>'>Naar artikelpagina van artikel <?php print $item ?></a></p>
</body>

<?php
}
?>