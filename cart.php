<?php
include __DIR__ . "/header.php";
include "cartfuncties.php";
if (isset($_POST["submit"])) {
    $stockItemID = $_POST["stockItemID"];
    $amount = $_POST["amount"];
    removeProductFromCart($stockItemID, $amount);
}
?>
<body>
<h1>Inhoud Winkelwagen</h1>
<?php

$cart = getCart();

if (isset($cart)) {
    foreach ($cart as $item => $amount){
        $product = getStockItem($item, $databaseConnection);
        $StockItemImage = getStockItemImage($item, $databaseConnection);


        if (isset($StockItemImage)) {
            // één plaatje laten zien
            if (count($StockItemImage) == 1) {
                ?>
                <div id="ImageFrame"
                     style="background-image: url('Public/StockItemIMG/<?php print $StockItemImage[0]['ImagePath']; ?>'); background-size: 300px; background-repeat: no-repeat; background-position: center;"></div>
                <?php
            } else if (count($StockItemImage) >= 2) { ?>
                <!-- meerdere plaatjes laten zien -->
                <div id="ImageFrame">
                    <div id="ImageCarousel" class="carousel slide" data-interval="false">
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
                        <div class="carousel-inner">
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


        echo "$item, " . $product['StockItemName'] . ", " . $product['SearchDetails'];
        echo ", Hoeveelheid $amount, Totaalprijs: $" . round($product['SellPrice'] * $amount, 2);

        ?>
<form method="post">
<input type="number" name="stockItemID" value="<?=$product["StockItemID"]?>" hidden>
<input type="number" name="amount" value="<?=($amount)?>" hidden>
<input type="submit" name="submit" value="Verwijderen">
</form>
        <?php
        $laatsteitem = $item;
    }
}

if (isset($item)){

?>
<br>
<p><a href='view.php?id=<?php print $item ?>'>Naar artikelpagina van artikel <?php print $item ?></a></p>
</body>
<?php
}
?>