<?php
$shoppingCart = $_SESSION['shoppingcart'] ?? [];


$conn = \Classes\Database::getConnection();
$ids = [];
foreach($shoppingCart as $key => $item){
    $ids[] = $item['id'];
}

$query = "SELECT * FROM stockitems WHERE StockItemID IN (" . implode(', ', $ids) . ')';
$results = $conn->query($query);

$totalPrice = 0.00;
?>
<?php
if ($results){ ?>
<div class="row"> <?php
    while ($product = $results->fetch_object()) {
        $totalPrice += $product->RecommendedRetailPrice
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
                    <form action="/shoppingcart/delete" method="post">
                        <input type="hidden" name="product" value="<?= $product->StockItemID ?>">
                        <button class="btn float-right" type="submit" style="color:red"><i class="material-icons">delete</i>Verwijderen</button>
                    </form>
                    <p>
                        <form action="/shoppingcart/AantalToevoegen" method="post">
                        <input type="hidden" name="Toevoegen" value="<?= $product->StockItemID ?>">
                        <button class="btn float-right" type="submit" style="color:blue"><i class="material-icons">add</i>Toevoegen</button>
                    </form>
                    </p>
                    <p class="card-text float-left" >
                        <img src="<?= getBlob($product->Photo); ?>" alt="Geen afbeelding beschikbaar">
                    </p>
                    <div class="clearfix"></div>
                    <p class="card-text float-right" >
                        Prijs: €<?php if(isset($_POST['Toevoegen'])){
                            echo str_replace('.',',',($product->RecommendedRetailPrice)*2);
                        }else{
                            echo str_replace('.',',',$product->RecommendedRetailPrice);
                        }
                         ?>
                    </p>
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <p class="card-text float-right">
                    Totale prijs: €<?=str_replace('.', ',',$totalPrice) ?>
                </p>
            </div>
        </div>
    </div>
</div>
<?php } else{ ?>
    <div class="container w-100 text-center mt-5">
        <h1>...Geen producten gevonden in de winkelwagen...</h1>
    </div>
<?php } ?>
