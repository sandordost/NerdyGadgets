<div class="Background">
    <div class="row" id="Header">
        <div class="col-1"><a href="./" id="LogoA">
                <div id="LogoImage"></div>
            </a></div>
        <div class="col-6" id="CategoriesBar">
            <ul id="ul-class">
                <?php
                $HeaderStockGroups = getHeaderStockGroups($databaseConnection);

                foreach ($HeaderStockGroups as $HeaderStockGroup) {
                    ?>
                    <li>
                        <a href="browse.php?category_id=<?php print $HeaderStockGroup['StockGroupID']; ?>"
                           class="HrefDecoration"><?php print $HeaderStockGroup['StockGroupName']; ?></a>
                    </li>
                    <?php
                }
                ?>
                <li>
                    <a href="categories.php" class="HrefDecoration">Alle categorieën</a>
                </li>
            </ul>
        </div>
        <!-- code voor US3: zoeken -->

        <ul id="ul-class-navigation">
            <li>
                <a href="browse.php" class="HrefDecoration"><i class="fas fa-search search"></i> Zoeken</a>
            </li>
            <div id="account-container">
                <div id="profile-info">
                    <a id="account-naam" href="test.php"> Gast</a>
                    <div id="shopping-cart-container">
                        <a id="mijn-winkelmand" href="cart.php" id="winkelmand"><i class="fas fa-shopping-cart search"></i>Winkelmand</a>
                    </div>
                </div>
                <div id="profile-image">
                    <img src="Public/Img/account.svg" alt="">
                </div>
            </div>
        </ul>
