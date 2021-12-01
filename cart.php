<?php
include __DIR__ . "/header.php";
include "cartfuncties.php";

$cart = getCart();

if (isset($_POST["submit"])) {
    if ($_POST["submit"] == "Verwijderen") {
        $stockItemID = $_POST["stockItemID"];
        $amount = $_POST["amount"];
        removeProductFromCart($stockItemID, $amount);
    }
    if ($_POST["submit"] == "Afrekenen") {
        if (isset($cart)) {
            if (count($cart) > 0) {
                foreach ($cart as $item => $amount) {
                    reduceStockItem($item, $amount, $databaseConnection);
                    unset($cart[$item]);
                    saveCart($cart);
                }
                echo "<script>alert('Uw bestelling word verwerkt')</script>";
            } else {
                echo "<script>alert('Test')</script>";
            }
        }
    }
    if ($_POST["submit"] == "Update") {
        $stockItemID = $_POST["stockItemID"];
        $amount = $_POST["amount"];
        if ($amount < 1){
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
<h1 style="margin-top: 80px; margin-bottom: 20px">Inhoud Winkelwagen</h1>
<?php

if (isset($cart)) {
    foreach ($cart as $item => $amount){
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
                    <div id="ImageCarousel" class="carousel slide" data-interval="false" style="height: 150px; width: 200px">
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
        echo "<br>Totaalprijs: $" . round($product['SellPrice'] * $amount, 2);

        ?>
<form method="post">
    <input type="number" name="stockItemID" value="<?=$product["StockItemID"]?>" hidden>
    Hoeveelheid <input type="number" name="amount" value="<?=($amount)?>" style="width: 100px; margin-top: 5px" max="<?=($product['Quantity'])?>">
    <input type="submit" name="submit" value="Update" hidden>
</form>
<form method="post" style="width: 200px">
    <input type="number" name="stockItemID" value="<?=$product["StockItemID"]?>" hidden>
    <input type="number" name="amount" value="<?=($amount)?>" hidden>
    <input type="submit" name="submit" value="Verwijderen" style="width: 200px; margin-top: 5px; display: inline">
</form>
        <?php
        $laatsteitem = $item;

        echo "</div>";

    }
}

if (count($cart) > 0){

?>
<br>
<form method="post">
    <input type="submit" name="submit" value="Afrekenen" style="width: 300px " class="Knop">
</form>
<?php
}
?>
</body>
<br>
<br>
<br>
<br>