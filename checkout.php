<?php
include __DIR__ . "/header.php";
include "cartfuncties.php";

$cart = getCart();
arsort($cart);

if(count($cart) < 1){
    echo "<script>window.location.replace('cart.php');</script>";
}

if (isset($_POST["submit"])) { 
    if($_POST["submit"] == "Bestelling Plaatsen"){
        if(count($cart) > 0){
            $voornaam = $_POST['voornaam'];
            $tussenvoegsel = $_POST['tussenvoegsel'];
            $achternaam = $_POST['achternaam'];
            $emailadres = $_POST['emailadres'];
            $adres = $_POST['adres'];
            $land = $_POST['land'];
            $postcode = $_POST['postcode'];
            $woonplaats = $_POST['woonplaats'];
            $telefoon = $_POST['telefoon'];
            $betalingswijze = $_POST['betalingswijze'];
            $klantId = GetCurrentUserData()[0];
            $ordernummer = CreateOrder($voornaam, $tussenvoegsel, $achternaam, $emailadres, $adres, $land, $postcode, $woonplaats, $telefoon, $betalingswijze, date("Y-m-d H:i:s"), $klantId);

            if (isset($cart)) {
                foreach ($cart as $item => $amount) {
                    $product = getStockItem($item, $databaseConnection);
                    CreateOrderLine($ordernummer, $product["StockItemID"], $product["StockItemName"], $amount, $product['SellPrice'], $product['TaxRate']);
                    unset($cart[$item]);
                    saveCart($cart);
                }
            }
            echo "<script>window.location.replace('cart.php');</script>";
        }
    }
}
?>
<body>
    <div id="checkoutLeft" class="CheckoutFrame" style="margin-left: 5%">
        <div id="checkoutInfo">
            <h2 style="margin-bottom: 20px">Persoonlijke gegevens</h2>
            <hr style="background: white; width: 70px; margin-left: 0">
            <form method="post">
                <input type="radio" class="checkoutRadio" name="geslacht" value="Man" id="man" required><label for="man" class="checkoutLabel">Man</label>
                <input type="radio" class="checkoutRadio" name="geslacht" value="Vrouw" id="vrouw" required><label for="vrouw" class="checkoutLabel">Vrouw</label>
                <input type="radio" class="checkoutRadio" name="geslacht" value="Onbepaald" id="onbepaald" required><label for="onbepaald" class="checkoutLabel">Onbepaald</label><br>
                <input style="width: 32.9%" type="text" class="checkoutInput" name="voornaam" value="<?php if($loggedIn){ echo $currentUser[3]; }?>" id="voornaam" placeholder="Voornaam*" required>
                <input style="width: 32.8%" type="text" class="checkoutInput" name="tussenvoegsel" value="<?php if($loggedIn){ echo $currentUser[4]; }?>" id="tussenvoegsel" placeholder="Tussenvoegsel">
                <input style="width: 32.9%" type="text" class="checkoutInput" name="achternaam" value="<?php if($loggedIn){ echo $currentUser[5]; }?>" id="achternaam" placeholder="Achternaam*" required>
                <input type="email" class="checkoutInput" name="emailadres" value="<?php if($loggedIn){ echo $currentUser[1]; }?>" id="emailadres" placeholder="E-mailadres*" required>
                <input type="text" class="checkoutInput" name="adres" value="<?php if($loggedIn){ echo $currentUser[6]; }?>" id="adres" placeholder="Adres*" required>
                <select style="width: 60%; height: 50px; padding-left: 5px; padding-right: 5px;" class="checkoutInput" id="land" name="land" required>
                    <?php if($loggedIn){
                       echo '<option value="' . $currentUser[8] . '" selected>' . $currentUser[8] . '</option>';
                    } else { 
                       echo '<option value="" selected disabled>Land*</option>';
                    }
                    ?>
                    <option value="Afganistan">Afghanistan</option>
                    <option value="Albania">Albania</option>
                    <option value="Algeria">Algeria</option>
                    <option value="American Samoa">American Samoa</option>
                    <option value="Andorra">Andorra</option>
                    <option value="Angola">Angola</option>
                    <option value="Anguilla">Anguilla</option>
                    <option value="Antigua & Barbuda">Antigua & Barbuda</option>
                    <option value="Argentina">Argentina</option>
                    <option value="Armenia">Armenia</option>
                    <option value="Aruba">Aruba</option>
                    <option value="Australia">Australia</option>
                    <option value="Austria">Austria</option>
                    <option value="Azerbaijan">Azerbaijan</option>
                    <option value="Bahamas">Bahamas</option>
                    <option value="Bahrain">Bahrain</option>
                    <option value="Bangladesh">Bangladesh</option>
                    <option value="Barbados">Barbados</option>
                    <option value="Belarus">Belarus</option>
                    <option value="Belgium">Belgium</option>
                    <option value="Belize">Belize</option>
                    <option value="Benin">Benin</option>
                    <option value="Bermuda">Bermuda</option>
                    <option value="Bhutan">Bhutan</option>
                    <option value="Bolivia">Bolivia</option>
                    <option value="Bonaire">Bonaire</option>
                    <option value="Bosnia & Herzegovina">Bosnia & Herzegovina</option>
                    <option value="Botswana">Botswana</option>
                    <option value="Brazil">Brazil</option>
                    <option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
                    <option value="Brunei">Brunei</option>
                    <option value="Bulgaria">Bulgaria</option>
                    <option value="Burkina Faso">Burkina Faso</option>
                    <option value="Burundi">Burundi</option>
                    <option value="Cambodia">Cambodia</option>
                    <option value="Cameroon">Cameroon</option>
                    <option value="Canada">Canada</option>
                    <option value="Canary Islands">Canary Islands</option>
                    <option value="Cape Verde">Cape Verde</option>
                    <option value="Cayman Islands">Cayman Islands</option>
                    <option value="Central African Republic">Central African Republic</option>
                    <option value="Chad">Chad</option>
                    <option value="Channel Islands">Channel Islands</option>
                    <option value="Chile">Chile</option>
                    <option value="China">China</option>
                    <option value="Christmas Island">Christmas Island</option>
                    <option value="Cocos Island">Cocos Island</option>
                    <option value="Colombia">Colombia</option>
                    <option value="Comoros">Comoros</option>
                    <option value="Congo">Congo</option>
                    <option value="Cook Islands">Cook Islands</option>
                    <option value="Costa Rica">Costa Rica</option>
                    <option value="Cote DIvoire">Cote DIvoire</option>
                    <option value="Croatia">Croatia</option>
                    <option value="Cuba">Cuba</option>
                    <option value="Curaco">Curacao</option>
                    <option value="Cyprus">Cyprus</option>
                    <option value="Czech Republic">Czech Republic</option>
                    <option value="Denmark">Denmark</option>
                    <option value="Djibouti">Djibouti</option>
                    <option value="Dominica">Dominica</option>
                    <option value="Dominican Republic">Dominican Republic</option>
                    <option value="East Timor">East Timor</option>
                    <option value="Ecuador">Ecuador</option>
                    <option value="Egypt">Egypt</option>
                    <option value="El Salvador">El Salvador</option>
                    <option value="Equatorial Guinea">Equatorial Guinea</option>
                    <option value="Eritrea">Eritrea</option>
                    <option value="Estonia">Estonia</option>
                    <option value="Ethiopia">Ethiopia</option>
                    <option value="Falkland Islands">Falkland Islands</option>
                    <option value="Faroe Islands">Faroe Islands</option>
                    <option value="Fiji">Fiji</option>
                    <option value="Finland">Finland</option>
                    <option value="France">France</option>
                    <option value="French Guiana">French Guiana</option>
                    <option value="French Polynesia">French Polynesia</option>
                    <option value="French Southern Ter">French Southern Ter</option>
                    <option value="Gabon">Gabon</option>
                    <option value="Gambia">Gambia</option>
                    <option value="Georgia">Georgia</option>
                    <option value="Germany">Germany</option>
                    <option value="Ghana">Ghana</option>
                    <option value="Gibraltar">Gibraltar</option>
                    <option value="Great Britain">Great Britain</option>
                    <option value="Greece">Greece</option>
                    <option value="Greenland">Greenland</option>
                    <option value="Grenada">Grenada</option>
                    <option value="Guadeloupe">Guadeloupe</option>
                    <option value="Guam">Guam</option>
                    <option value="Guatemala">Guatemala</option>
                    <option value="Guinea">Guinea</option>
                    <option value="Guyana">Guyana</option>
                    <option value="Haiti">Haiti</option>
                    <option value="Hawaii">Hawaii</option>
                    <option value="Honduras">Honduras</option>
                    <option value="Hong Kong">Hong Kong</option>
                    <option value="Hungary">Hungary</option>
                    <option value="Iceland">Iceland</option>
                    <option value="Indonesia">Indonesia</option>
                    <option value="India">India</option>
                    <option value="Iran">Iran</option>
                    <option value="Iraq">Iraq</option>
                    <option value="Ireland">Ireland</option>
                    <option value="Isle of Man">Isle of Man</option>
                    <option value="Israel">Israel</option>
                    <option value="Italy">Italy</option>
                    <option value="Jamaica">Jamaica</option>
                    <option value="Japan">Japan</option>
                    <option value="Jordan">Jordan</option>
                    <option value="Kazakhstan">Kazakhstan</option>
                    <option value="Kenya">Kenya</option>
                    <option value="Kiribati">Kiribati</option>
                    <option value="Korea North">Korea North</option>
                    <option value="Korea Sout">Korea South</option>
                    <option value="Kuwait">Kuwait</option>
                    <option value="Kyrgyzstan">Kyrgyzstan</option>
                    <option value="Laos">Laos</option>
                    <option value="Latvia">Latvia</option>
                    <option value="Lebanon">Lebanon</option>
                    <option value="Lesotho">Lesotho</option>
                    <option value="Liberia">Liberia</option>
                    <option value="Libya">Libya</option>
                    <option value="Liechtenstein">Liechtenstein</option>
                    <option value="Lithuania">Lithuania</option>
                    <option value="Luxembourg">Luxembourg</option>
                    <option value="Macau">Macau</option>
                    <option value="Macedonia">Macedonia</option>
                    <option value="Madagascar">Madagascar</option>
                    <option value="Malaysia">Malaysia</option>
                    <option value="Malawi">Malawi</option>
                    <option value="Maldives">Maldives</option>
                    <option value="Mali">Mali</option>
                    <option value="Malta">Malta</option>
                    <option value="Marshall Islands">Marshall Islands</option>
                    <option value="Martinique">Martinique</option>
                    <option value="Mauritania">Mauritania</option>
                    <option value="Mauritius">Mauritius</option>
                    <option value="Mayotte">Mayotte</option>
                    <option value="Mexico">Mexico</option>
                    <option value="Midway Islands">Midway Islands</option>
                    <option value="Moldova">Moldova</option>
                    <option value="Monaco">Monaco</option>
                    <option value="Mongolia">Mongolia</option>
                    <option value="Montserrat">Montserrat</option>
                    <option value="Morocco">Morocco</option>
                    <option value="Mozambique">Mozambique</option>
                    <option value="Myanmar">Myanmar</option>
                    <option value="Nambia">Nambia</option>
                    <option value="Nauru">Nauru</option>
                    <option value="Nepal">Nepal</option>
                    <option value="Netherland Antilles">Netherland Antilles</option>
                    <option value="Netherlands">Netherlands</option>
                    <option value="Nevis">Nevis</option>
                    <option value="New Caledonia">New Caledonia</option>
                    <option value="New Zealand">New Zealand</option>
                    <option value="Nicaragua">Nicaragua</option>
                    <option value="Niger">Niger</option>
                    <option value="Nigeria">Nigeria</option>
                    <option value="Niue">Niue</option>
                    <option value="Norfolk Island">Norfolk Island</option>
                    <option value="Norway">Norway</option>
                    <option value="Oman">Oman</option>
                    <option value="Pakistan">Pakistan</option>
                    <option value="Palau Island">Palau Island</option>
                    <option value="Palestine">Palestine</option>
                    <option value="Panama">Panama</option>
                    <option value="Papua New Guinea">Papua New Guinea</option>
                    <option value="Paraguay">Paraguay</option>
                    <option value="Peru">Peru</option>
                    <option value="Phillipines">Philippines</option>
                    <option value="Pitcairn Island">Pitcairn Island</option>
                    <option value="Poland">Poland</option>
                    <option value="Portugal">Portugal</option>
                    <option value="Puerto Rico">Puerto Rico</option>
                    <option value="Qatar">Qatar</option>
                    <option value="Republic of Montenegro">Republic of Montenegro</option>
                    <option value="Republic of Serbia">Republic of Serbia</option>
                    <option value="Reunion">Reunion</option>
                    <option value="Romania">Romania</option>
                    <option value="Russia">Russia</option>
                    <option value="Rwanda">Rwanda</option>
                    <option value="St Barthelemy">St Barthelemy</option>
                    <option value="St Eustatius">St Eustatius</option>
                    <option value="St Helena">St Helena</option>
                    <option value="St Kitts-Nevis">St Kitts-Nevis</option>
                    <option value="St Lucia">St Lucia</option>
                    <option value="St Maarten">St Maarten</option>
                    <option value="St Pierre & Miquelon">St Pierre & Miquelon</option>
                    <option value="St Vincent & Grenadines">St Vincent & Grenadines</option>
                    <option value="Saipan">Saipan</option>
                    <option value="Samoa">Samoa</option>
                    <option value="Samoa American">Samoa American</option>
                    <option value="San Marino">San Marino</option>
                    <option value="Sao Tome & Principe">Sao Tome & Principe</option>
                    <option value="Saudi Arabia">Saudi Arabia</option>
                    <option value="Senegal">Senegal</option>
                    <option value="Seychelles">Seychelles</option>
                    <option value="Sierra Leone">Sierra Leone</option>
                    <option value="Singapore">Singapore</option>
                    <option value="Slovakia">Slovakia</option>
                    <option value="Slovenia">Slovenia</option>
                    <option value="Solomon Islands">Solomon Islands</option>
                    <option value="Somalia">Somalia</option>
                    <option value="South Africa">South Africa</option>
                    <option value="Spain">Spain</option>
                    <option value="Sri Lanka">Sri Lanka</option>
                    <option value="Sudan">Sudan</option>
                    <option value="Suriname">Suriname</option>
                    <option value="Swaziland">Swaziland</option>
                    <option value="Sweden">Sweden</option>
                    <option value="Switzerland">Switzerland</option>
                    <option value="Syria">Syria</option>
                    <option value="Tahiti">Tahiti</option>
                    <option value="Taiwan">Taiwan</option>
                    <option value="Tajikistan">Tajikistan</option>
                    <option value="Tanzania">Tanzania</option>
                    <option value="Thailand">Thailand</option>
                    <option value="Togo">Togo</option>
                    <option value="Tokelau">Tokelau</option>
                    <option value="Tonga">Tonga</option>
                    <option value="Trinidad & Tobago">Trinidad & Tobago</option>
                    <option value="Tunisia">Tunisia</option>
                    <option value="Turkey">Turkey</option>
                    <option value="Turkmenistan">Turkmenistan</option>
                    <option value="Turks & Caicos Is">Turks & Caicos Is</option>
                    <option value="Tuvalu">Tuvalu</option>
                    <option value="Uganda">Uganda</option>
                    <option value="United Kingdom">United Kingdom</option>
                    <option value="Ukraine">Ukraine</option>
                    <option value="United Arab Erimates">United Arab Emirates</option>
                    <option value="United States of America">United States of America</option>
                    <option value="Uraguay">Uruguay</option>
                    <option value="Uzbekistan">Uzbekistan</option>
                    <option value="Vanuatu">Vanuatu</option>
                    <option value="Vatican City State">Vatican City State</option>
                    <option value="Venezuela">Venezuela</option>
                    <option value="Vietnam">Vietnam</option>
                    <option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
                    <option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
                    <option value="Wake Island">Wake Island</option>
                    <option value="Wallis & Futana Is">Wallis & Futana Is</option>
                    <option value="Yemen">Yemen</option>
                    <option value="Zaire">Zaire</option>
                    <option value="Zambia">Zambia</option>
                    <option value="Zimbabwe">Zimbabwe</option>
                </select>
                <input style="width: 39.3%" type="text" class="checkoutInput" name="postcode" value="<?php if($loggedIn){ echo $currentUser[9]; }?>" id="postcode" placeholder="Postcode*" required>
                <input type="text" class="checkoutInput" name="woonplaats" value="<?php if($loggedIn){ echo $currentUser[7]; }?>" id="woonplaats" placeholder="Woonplaats*" required>
                <input type="text" class="checkoutInput" name="telefoon" value="<?php if($loggedIn){ echo $currentUser[10]; }?>" id="telefoon" placeholder="Telefoonnummer (optioneel)">
                <select style="width: 100%; height: 50px; padding-left: 5px; padding-right: 5px;" class="checkoutInput" id="betalingswijze" name="betalingswijze" required>
                    <option value="" disabled selected>Betalingswijze*</option>
                    <option value="ideal">iDEAL</option>
                    <option value="paypal">PayPal</option>
                    <option value="klarna">Klarna</option>
                    <option value="creditcard">Credit Card</option>
                    <option value="bankoverschrift">Bankoverschrift</option>
                    <option value="achteraf">Achteraf Betalen</option>
                    <option value="bancontact">Bancontact</option>
                </select><br><br>
                <input type="submit" name="submit" value="Bestelling Plaatsen" class="Knop" style="width: 250px; height: 50px; font-size: 20px; line-height: 0;">
                <a href="cart.php"><input type="button" value="Annuleren" class="KnopReversed" style="width: 250px; height: 50px; font-size: 20px; line-height: 0; float: right"></a>
            </form>
        </div>
    </div>
    <div id="checkoutRight" class="CheckoutFrame" style="width: 44%">
        <div id="checkoutCart">
            <h2 style="margin-bottom: 20px">Inhoud winkelwagen</h2>
            <hr style="background: white; width: 70px; margin-left: 0">
            <?php
            if (isset($cart)) {
                $totaalprijs_zonderkorting = 0;
                $totaalprijs = 0;
                foreach ($cart as $item => $amount) {
                    $product = getStockItem($item, $databaseConnection);
                    $StockItemImage = getStockItemImage($item, $databaseConnection);
                    ?>
                    <div>
                        <?php
                        if (isset($product['ImagePath'])) { ?>
                            <div class="checkoutImage"
                                 style="background-image: url('<?php print "Public/StockItemIMG/" . $product['ImagePath']; ?>'); background-size: 92px; background-repeat: no-repeat; background-position: center;"></div>
                        <?php } else if (isset($product['BackupImagePath'])) { ?>
                            <div class="checkoutImage"
                                 style="background-image: url('<?php print "Public/StockGroupIMG/" . $product['BackupImagePath'] ?>'); background-size: cover;"></div>
                        <?php }
                        ?>
                        <a style="color: white" href="view.php?id=<?= $item ?>"><b><?= $product['StockItemName'] ?></b></a><br>
                        Hoeveelheid: <?= $amount ?><br>
                        Aantal op voorraad: <?= $product['Quantity'] ?><br>
                        Totaalprijs: €<?= number_format(berekenPrijsMetKorting($product['SellPrice'] * $amount, $product['korting']), 2) ?><br>
                    </div>
                    <br>
                    <?php
                    $totaalprijs_zonderkorting += $product['SellPrice'] * $amount;
                    $totaalprijs += berekenPrijsMetKorting($product['SellPrice'] * $amount, $product['korting']);
                }
            }
            if (isset($totaalprijs)){
            ?>
            <h6>
            <?php
            if($totaalprijs < 30) {
                echo "€5.50 verzendkosten";
                $totaalprijs += 5.5;
                $totaalprijs_zonderkorting += 5.5;
            }
            else {
                echo "Gratis verzending";
            } ?>
            </h6>
            <hr style="background: white; width: 250px; margin-left: 0; margin-top: -5px; border: 1px solid; margin-bottom: 0   ;">
            <?php if(isset($_SESSION['kortingscode']) && !empty($_SESSION['kortingscode'])){
                $korting = GetKortingFromCode($conn, $_SESSION['kortingscode']);
                $kortingscode = $_SESSION['kortingscode'];
                if(isset($korting) && $korting != null && !empty($korting)) { ?>
                    <h4><s>Totaal: €<b><?= number_format($totaalprijs, 2) ?></b></s></h4>
                    <?php
                    if ($korting[1] == 1) {
                        echo "<p style='color:#88cb76'>Kortingscode <b>'$kortingscode'</b> toegepast (" . number_format($korting[0], 1) . "% korting)</p>";
                    } else {
                        echo "<p style='color:#88cb76'>Kortingscode <b>'$kortingscode'</b> toegepast (€" . $korting[0] . " korting)</p>";
                    }
                    ?>
                    <h4>Totaal: €<b><?= number_format(berekenKortingscode($conn, $totaalprijs, $kortingscode), 2) ?></b></h4>
                <?php } else{ ?>
                <h4>Totaal: €<b><?= number_format($totaalprijs, 2) ?></b></h4>
                <?php }} ?>

            <?php } ?>
            <?php if($totaalprijs != $totaalprijs_zonderkorting){ ?>
                <h4 style="color:#7d9b69;">Je bespaart: €<?= number_format($totaalprijs_zonderkorting - $totaalprijs, 2)?></h4>
            <?php } ?>
        </div>
    </div>
</body>