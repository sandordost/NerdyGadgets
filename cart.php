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
    $totaalprijs = 0;
    foreach ($cart as $item => $amount) {
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
    echo "<br>Totaalprijs: €" . number_format(berekenPrijsMetKorting($product['SellPrice'] * $amount, $product['korting']), 2);

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
$totaalprijs += (berekenPrijsMetKorting($product['SellPrice'] * $amount, $product['korting']));
}
}
if (count($cart) > 0) {

if (isset($totaalprijs)){
    ?>

    <h6><?php if($totaalprijs < 30){ echo "€" . number_format((30 - $totaalprijs), 2) . " extra benodigd voor gratis verzending<br>€5.50 verzendkosten"; $totaalprijs += 5.5; } else { echo "Gratis verzending"; } ?></h6>
    <?php
    if(isset($_GET['kortingscode'])) {
        if (!empty($_GET['kortingscode'])) {
            $kortingscode = $_GET['kortingscode'];
            $korting = GetKortingFromCode($conn, $kortingscode);
            $_SESSION['kortingscode'] = $kortingscode;
            $prijsMetKortingscode = number_format(berekenKortingscode($conn, $totaalprijs, $kortingscode), 2);
        }
    }
    ?>
    <hr style="background: white; width: 250px; margin-left: 0; margin-top: -5px; border: 1px solid; margin-bottom: 0   ;">
    <?php if(isset($korting) && $korting != null && !empty($korting)){ ?>
        <h4><s>Totaal: €<b><?= number_format($totaalprijs, 2) ?></b></s></h4>
    <?php } else { ?>
        <h4>Totaal: €<b><?= number_format($totaalprijs, 2) ?></b></h4>
    <?php } ?>
    <?php 
}
?>
    <br>
    <?php
    if(!isset($korting) || $korting == null){
        if(isset($kortingscode) ||!empty($kortingscode))
        echo "<p style='color:#b65e5e'>Kortingscode: '$kortingscode' wordt niet herkent</p>";
    }
    else {
        if ($korting[1] == 1) {
            echo "<p style='color:#88cb76'>Kortingscode <b>'$kortingscode'</b> toegepast (" . number_format($korting[0], 1) . "% korting)</p>";
        } else {
            echo "<p style='color:#88cb76'>Kortingscode <b>'$kortingscode'</b> toegepast (€" . $korting[0] . " korting)</p>";
        }
        echo "<h3>Met kortingscode: €$prijsMetKortingscode</h3>";
    }
    ?>
    <form id="kortingscode-form" action="cart.php" method="get">
        <input placeholder="kortingscode ..." type="text" name="kortingscode" class="kortingscode-input">
        <input class="kortingscode-input" type="submit" value="kortingscode toepassen">
    </form>

    <form method="post" action="checkout.php">
        <input type="submit" name="submit" value="Afrekenen" style="width: 300px " class="Knop">
    </form>
<?php } else { ?>
    <h4>Uw winkelwagen is leeg.</h4>
    <h4>Zoek <a href="categories.php">hier</a> naar producten</h4>
<?php
}
 ?>
<br><br><br><br>
</body>