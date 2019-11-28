<?php
if($_POST['product'] && $_GET['action'] === 'add'){
    $shoppingCart = $_SESSION[ 'shoppingcart' ] ?? [];
    $shoppingCart[] = $_POST[ 'product' ];
}

dd($shoppingCart);