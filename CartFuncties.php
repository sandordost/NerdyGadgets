<?php

function getCart()
{
    if (isset($_SESSION['cart'])) {
        $cart = $_SESSION['cart'];
    } else {
        $cart = array();
    }
    return $cart;
}

function saveCart($cart)
{
    $_SESSION["cart"] = $cart;
}

function addProductToCart($stockItemID)
{
    $cart = getCart();

    if (array_key_exists($stockItemID, $cart)) {
        $cart[$stockItemID] += 1;
    } else {
        $cart[$stockItemID] = 1;
    }

    saveCart($cart);
}

function updateProductInCart($stockItemID, $amount)
{
    $cart = getCart();
    if (isset($cart)) {
        $cart[$stockItemID] = $amount;
    }
    saveCart($cart);
    echo "<script>location.href = 'cart.php'</script>";
}

function berekenPrijsMetKorting($prijs, $korting){
    return $prijs / 100 * (100 - $korting);
}

function berekenKortingscode($conn, $prijs, $code){
    $sql = "SELECT * FROM kortingscodes WHERE code = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $code);
    $stmt->execute();

    $result = $stmt->get_result()->fetch_assoc();
    if($result != null) {
        if($result['inPercentage']) {
            return berekenPrijsMetKorting($prijs, $result['korting']);
        }
        else return $prijs - $result['korting'];
    }
    else return null;
}

function GetKortingFromCode($conn, $code){
    $sql = "SELECT korting, inPercentage FROM kortingscodes WHERE code = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $code);
    $stmt->execute();

    $result = $stmt->get_result()->fetch_row();
    if($result != null) {
        return $result;
    }
    else return null;
}