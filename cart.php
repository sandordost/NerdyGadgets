<?php
include __DIR__ . "/header.php";
include "cartfuncties.php";

$cart = getCart();
arsort($cart);

if (isset($_POST["submit"])) {
    if ($_POST["submit"] == "Verwijderen") {
        $stockItemID = $_POST["stockItemID"];
        unset($cart[$stockItemID]);
        saveCart($cart);
    }
    if ($_POST["submit"] == "Update") {
        $stockItemID = $_POST["stockItemID"];
        $product = $_POST["product"];
        $quantity = $_POST["quantity"];
        $amount = $_POST["amount"];
        if ($amount > $quantity){
            echo "<script>alert('Niet genoeg voorraad van " . $product . " " . ($amount - $quantity) . " item te veel')</script>";
        } elseif ($amount < 1) {
            unset($cart[$stockItemID]);
            saveCart($cart);
        } else {
            updateProductInCart($stockItemID, $amount);
        }
    }
}
?>
<body>
<div style="padding-right: 110px; padding-left: 110px">
    <h1 style="margin-top: 60px; margin-bottom: 20px">Inhoud Winkelwagen</h1>
    <hr style="background: white; width: 70px; margin-left: 0">
    <br>
    <?php

    if (isset($cart)) {
    foreach ($cart

    as $item => $amount) {
    $product = getStockItem($item, $databaseConnection);
    $StockItemImage = getStockItemImage($item, $databaseConnection);

    echo "<div style='margin-bottom: 40px'>";

    if (isset($StockItemImage)) {
        // één plaatje laten zien
        if (count($StockItemImage) == 1) {
            ?>
            <div id="ImageFrame"
                 style="background-image: url('Public/StockItemIMG/<?php print $StockItemImage[0]['ImagePath']; ?>'); background-size: 150px; background-repeat: no-repeat; background-position: center; height: 150px; width: 200px"></div>
            <?php
        } else if (count($StockItemImage) >= 2) { ?>
            <!-- meerdere plaatjes laten zien -->
            <div id="ImageFrame" style="height: 150px; width: 200px">
                <div id="ImageCarousel" class="carousel slide" data-interval="false"
                     style="height: 150px; width: 200px">
                    <!-- Indicators -->
                    <ul class="carousel-indicators">
                        <?php for ($i = 0; $i < count($StockItemImage); $i++) {
                            ?>
                            <li data-target="#ImageCarousel"
                                data-slide-to="<?php print $i ?>" <?php print (($i == 0) ? 'class="active"' : ''); ?>></li>
                            <?php
                        } ?>
                    </ul>

                    <!-- slideshow -->
                    <div class="carousel-inner" style="height: 150px">
                        <?php for ($i = 0; $i < count($StockItemImage); $i++) {
                            ?>
                            <div class="carousel-item <?php print ($i == 0) ? 'active' : ''; ?>">
                                <img src="Public/StockItemIMG/<?php print $StockItemImage[$i]['ImagePath'] ?>">
                            </div>
                        <?php } ?>
                    </div>

                    <!-- knoppen 'vorige' en 'volgende' -->
                    <a class="carousel-control-prev" href="#ImageCarousel" data-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </a>
                    <a class="carousel-control-next" href="#ImageCarousel" data-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </a>
                </div>
            </div>
            <?php
        }
    } else {
        ?>
        <div id="ImageFrame"
             style="background-image: url('Public/StockGroupIMG/<?php print $item['BackupImagePath']; ?>'); background-size: cover;"></div>
        <?php
    }

    echo "<h2><a style='color: white' href='view.php?id=" . $product['StockItemID'] . "'>" . $product['StockItemName'] . "</a></h2>";
    echo "<br>Totaalprijs: €" . number_format($product['SellPrice'] * $amount, 2);

    ?>
    <form method="post">
        <input type="number" name="stockItemID" value="<?= $product["StockItemID"] ?>" hidden>
        <input type="number" name="quantity" value="<?= $product["Quantity"] ?>" hidden>
        <input type="text" name="product" value="<?= $product["StockItemName"] ?>" hidden>
        Hoeveelheid <input type="number" name="amount" value="<?= ($amount) ?>"
                           style="width: 100px; margin-top: 5px" max="<?= ($product['Quantity']) ?>">
        <input type="submit" name="submit" value="Update" hidden>
    </form>
    <form method="post" style="width: 200px">
        <input type="number" name="stockItemID" value="<?= $product["StockItemID"] ?>" hidden>
        <input type="submit" name="submit" value="Verwijderen"
               style="width: 200px; margin-top: 5px; display: inline">
    </form>
</div>
<?php
}
}

if (count($cart) > 0) { ?>
    <br>
    <form method="post" action="checkout.php">
        <input type="submit" name="submit" value="Afrekenen" style="width: 300px " class="Knop">
    </form>
<?php } ?>
<br><br><br><br>
</body>