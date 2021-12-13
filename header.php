<!-- de inhoud van dit bestand wordt bovenaan elke pagina geplaatst -->
<?php
include "database.php";
$databaseConnection = connectToDatabase();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>NerdyGadgets</title>

    <!-- Javascript -->
    <script src="Public/JS/fontawesome.js"></script>
    <script src="Public/JS/jquery.min.js"></script>
    <script src="Public/JS/bootstrap.min.js"></script>
    <script src="Public/JS/popper.min.js"></script>
    <script src="Public/JS/resizer.js"></script>

    <!-- Style sheets-->
    <link rel="stylesheet" href="Public/CSS/style.css" type="text/css">
    <link rel="stylesheet" href="Public/CSS/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="Public/CSS/typekit.css">
    <link rel="stylesheet" href="Public/CSS/new-header.css">
</head>
<body>
    <div class="new-header">
        <div class="left-bar">
            <div class="logo">
                <a href="./">
                    <img src="Public/ProductIMGHighRes/NerdyGadgetsLogo.png" alt="">
                </a>
            </div>
            <div class="categories">
                <?php
                $HeaderStockGroups = getHeaderStockGroups($databaseConnection);

                foreach ($HeaderStockGroups as $HeaderStockGroup) {
                    ?>
                    <div class="category">
                        <a href="browse.php?category_id=<?php print $HeaderStockGroup['StockGroupID']; ?>"
                           class="HrefDecoration"><?php print $HeaderStockGroup['StockGroupName']; ?></a>
                    </div>
                    <?php
                }
                ?>
                <div class="category">
                    <a href="categories.php" class="HrefDecoration">Alle categorieën</a>
                </div>
            </div>
        </div>
        <div class="right-bar">
            <div class="search-bar">
                <a href="browse.php" class="HrefDecoration"><i class="fas fa-search search"></i> Zoeken</a>
            </div>
            <div id="account-container">
                <div id="profile-info">
                    <a id="account-naam" href="test.php"> Gast</a>
                    <div id="shopping-cart-container">
                        <a id="mijn-winkelmand" href="cart.php" id="winkelmand"><i class="fas fa-shopping-cart search"></i>Mijn winkelmand</a>
                    </div>
                </div>
                <div id="profile-image">
                    <i class="fas fa-user"></i>
                </div>
            </div>
        </div>
    </div>

<!-- einde code voor US3 zoeken -->
    </div>
    <div class="row" id="Content">
        <div class="col-12">
            <div id="SubContent">


