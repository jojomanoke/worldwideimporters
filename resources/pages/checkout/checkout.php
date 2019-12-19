

<?php

use Classes\Database;
use Classes\Login;
use Classes\Auth;
$_SESSION['shoppingcart'];
$shoppingCart = $_SESSION['shoppingcart'];
$conn = Database::getConnection();
$productIds = array_column($shoppingCart, 'id'); $query = 'SELECT * FROM stockitems WHERE StockItemID IN ('.implode(', ', $productIds).')';
$results = $conn->query($query);
$loggedIn = Login::isLoggedIn();
if($loggedIn){
    $user = Auth::user();
}

?>


<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            font-family: Arial;
            font-size: 17px;
            padding: 8px;
        }

        * {
            box-sizing: border-box;
        }

        .row {
            display: -ms-flexbox; /* IE10 */
            display: flex;
            -ms-flex-wrap: wrap; /* IE10 */
            flex-wrap: wrap;
            margin: 0 -16px;
        }

        .col-25 {
            -ms-flex: 25%; /* IE10 */
            flex: 25%;
        }

        .col-50 {
            -ms-flex: 50%; /* IE10 */
            flex: 50%;
        }

        .col-75 {
            -ms-flex: 75%; /* IE10 */
            flex: 75%;
        }

        .col-25,
        .col-50,
        .col-75 {
            padding: 0 16px;
        }

        .container {
            background-color: #f2f2f2;
            padding: 5px 20px 15px 20px;
            border: 1px solid lightgrey;
            border-radius: 3px;
        }

        input[type=text] {
            width: 100%;
            margin-bottom: 20px;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        label {
            margin-bottom: 10px;
            display: block;
        }

        .icon-container {
            margin-bottom: 20px;
            padding: 7px 0;
            font-size: 24px;
        }

        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 12px;
            margin: 10px 0;
            border: none;
            width: 100%;
            border-radius: 3px;
            cursor: pointer;
            font-size: 17px;
        }

        .btn:hover {
            background-color: #45a049;
        }

        a {
            color: #2196F3;
        }

        hr {
            border: 1px solid lightgrey;
        }

        span.price {
            float: right;
            color: grey;
        }

        /* Responsive layout - when the screen is less than 800px wide, make the two columns stack on top of each other instead of next to each other (also change the direction - make the "cart" column go on top) */
        @media (max-width: 800px) {
            .row {
                flex-direction: column-reverse;
            }
            .col-25 {
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>

<div class="row mt-5">
    <div class="col-75">
        <div class="container">
            <form action="/action_page.php">

                <div class="row">
                    <div class="col-50">
                        <h3>Factuur Adres</h3>
                        <label for="fname"><i class="fa fa-user"></i> Volledige naam</label>
                        <input type="text" value="<?=$loggedIn ? $user->FirstName : ''?>" id="fname" name="firstname" placeholder="Jan van den Boom">
                        <label for="email"><i class="fa fa-envelope"></i> E-mail</label>
                        <input type="text" value="<?=$loggedIn ? $user->Email : ''?>" id="email" name="email" placeholder="john@voorbeeld.nl">
                        <label for="adr"><i class="fa fa-address-card-o"></i> Adres</label>
                        <input type="text" value="<?=$loggedIn ? $user->Address : ''?>" id="adr" name="address" placeholder="Zambiosastraat 15">
                        <label for="city"><i class="fa fa-institution"></i> Stad</label>
                        <input type="text" value="<?=$loggedIn ? $user->City : ''?>" id="city" name="city" placeholder="Zwolle">

                        <div class="row">
                            <div class="col-50">
                                <label for="state">Provincie</label>
                                <input type="text" id="state" name="Provincie" placeholder="Gelderland">
                            </div>
                            <div class="col-50">
                                <label for="zip">Postcode</label>
                                <input type="text" value="<?=$loggedIn ? $user->ZipCode : ''?>" id="zip" name="Postcode" placeholder="8899HJ">
                            </div>
                        </div>
                    </div>

                    <div class="col-50">
                        <h3>Betaling (WIP)</h3>
                        <label for="fname"></label>
                        <div class="icon-container">
                            <i><img src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/pp-acceptance-large.png" alt="Buy now with PayPal" /></i>

                        </div>
                    </div>

                </div>
                <input type="submit" value="Betalen (WIP)" class="btn">
            </form>
        </div>
    </div>

    <div class="col-25">
        <div class="container">
            <h4>Winkelmand <span class="price" style="color:black"><i class="fa fa-shopping-cart"></i></span></h4>
            <?php if ($results){ ?>
            <?php
                $totalPrice = 0.00;
            while ($product = $results->fetch_object()) {
            // Eerst halen we de key voor de shopping cart weer op
            $key = array_search($product->StockItemID, array_column($shoppingCart, 'id'), false);

            $productSession = $shoppingCart[$key];
            $amount = $productSession['amount'];
            $verzendkosten = 0.00;

            $totalPrice += $product->RecommendedRetailPrice * $amount;

            if($totalPrice <= 50){
                $verzendkosten = 3.95;
            }
            ?>
                <p><a><b><?= $product->StockItemName ?></b></a> <a> x<?= $amount ?></a><b><span class="price"><?= $product->RecommendedRetailPrice ?></span></b></p><br>
            <?php } ?>
            <?php } ?>
            <hr>
            <p>Verzendkosten <span class="price" style="color:black"><b><?= number_format($verzendkosten, 2, ',', '.' ) ?> </b></span></p>
            <p>Totaal <span class="price" style="color:black"><b> <?= number_format($totalPrice * 1 + $verzendkosten, 2, ',', '.')  ?></b></span></p>
        </div>
    </div>
</div>


</body>
</html>
