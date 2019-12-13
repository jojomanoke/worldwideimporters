<?php

use Classes\Database;

$shoppingCart = $_SESSION['shoppingcart'] ?? [];
$conn = Database::getConnection();
$ids = [];
foreach ($shoppingCart as $key => $item) {
    $ids[] = $item['id'];
}

if (isset($_GET['action'])) {

    // Eerst gaan we het product zoeken in de shopping cart array
    $key = array_search($_POST['productId'], array_column($shoppingCart, 'id'), false);
    if ($_GET['action'] === 'addAmount') {

        // Vervolgens voegen we 1 toe aan de hoeveelheid
        $shoppingCart[$key]['amount'] += 1;
    } elseif ($_GET['action'] === 'removeAmount') {

        // of verwijderen we er eentje
        $shoppingCart[$key]['amount'] -= 1;

        // Zodra de hoeveelheid onder de 1 komt moet dit product verwijderd worden.
        if ($shoppingCart[$key]['amount'] < 1) {
            unset($shoppingCart[$key]);
        }


    }


    $_SESSION['shoppingcart'] = array_merge($shoppingCart);
    echo '<script>window.location.href="/shoppingcart"</script>';
}
$query = 'SELECT * FROM stockitems WHERE StockItemID IN (' . implode(', ', $ids) . ')';
$results = $conn->query($query);

$totalPrice = 0.00;

?>
<?php
if ($results) { ?>
    <div class="row"> <?php
        while ($product = $results->fetch_object()) {
            // Eerst halen we de key voor de shopping cart weer op
            $key = array_search($product->StockItemID, array_column($shoppingCart, 'id'), false);

            $productSession = $shoppingCart[$key];
            $amount = $productSession['amount'];
            $totalPrice += $product->RecommendedRetailPrice * $amount;
            ?>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-text">
                            <?= $product->StockItemName ?>
                        </h1>
                        <p class="card-text float-">
                            <?= $product->MarketingComments ?>
                        </p>
                        <form action="<?= url('shoppingcart/delete') ?>" method="post">
                            <input type="hidden" name="product" value="<?= $product->StockItemID ?>">
                            <button class="btn float-right" type="submit" style="color:red"><i class="material-icons">delete</i>Verwijderen
                            </button>
                        </form>
                        <p>
                        <form action="<?= url('shoppingcart/addAmount') ?>" method="post">
                            <input type="hidden" name="productId" value="<?= $product->StockItemID ?>">
                            <button class="btn float-right" type="submit" style="color:blue"><i class="material-icons">add</i>Toevoegen
                            </button>
                        </form>
                        </p>
                        <p>
                        <form action="<?= url('shoppingcart/removeAmount') ?>" method="post">
                            <input type="hidden" name="productId" value="<?= $product->StockItemID ?>">
                            <button class="btn float-right" type="submit" style="color:blue"><i class="material-icons">remove</i>minder
                            </button>
                        </form>
                        </p>
                        <p class="card-text float-left">
                            <img src="<?= getBlob($product->Photo); ?>" alt="Geen afbeelding beschikbaar">
                        </p>
                        <div class="clearfix"></div>
                        <p class="card-text float-right">
                            Aantal: <?= $amount ?> Prijs:
                            €<?= number_format($product->RecommendedRetailPrice * $amount, 2, ',', '.') ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php } ?>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <p class="card-text float-right">
                        Totale prijs: €<?= number_format($totalPrice * 1, 2, ',', '.') ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <p>
        <a href="<?= url('checkout') ?>" class="mt-5 w-25 btn float-right btn-success">Afrekenen</a>
    </p>
<?php } else { ?>
    <div class="container w-100 text-center mt-5">
        <h1>...Geen producten gevonden in de winkelwagen...</h1>
        <img src="/images/winkelwagen.jpg"  alt=" " />
    </div>

<?php } ?>
