<?php


use Classes\Login;
use Classes\Query\Query;

$connection = Classes\Database::getConnection();
$productId = $_GET['product'];
$query = 'SELECT s.*, c.ColorName FROM stockitems s left join colors c ON c.ColorID = s.ColorID WHERE StockItemID = ?';
$statement = $connection->prepare($query);
$statement->bind_param('i', $productId);
$statement->execute();
$product = $statement->get_result()->fetch_object();

if(Login::isLoggedIn()) {
    $userID = Login::id();
}

$reviewscore = 0;
if(isset($_POST['stars'], $_POST['review'], $userID)) {
    $reviewscore = (int)$_POST['stars'];
    $datum = (new DateTime())->format('Y-m-d H:i:s');
    $reviewbeschrijving = $_POST['review'];
    $query = 'INSERT INTO reviews (ReviewScore, ReviewDescription, UserID, StockItemID, Date) VALUES (?, ?, ?, ?, ?)';
    $statement = $connection->prepare($query);
    $statement->bind_param('isiis', $reviewscore, $reviewbeschrijving, $userID, $productId, $datum);
    $statement->execute();
}
$reviews = Query::get('reviews')->where('StockItemID', $productId);

    $query = "Select s.SupplierName from suppliers s join stockitems si on s.SupplierID = si.SupplierID where s.SupplierID = $product->SupplierID";
    $statement = $connection->prepare($query);
    $statement->execute();
    $leverancier = $statement->get_result()->fetch_object();


$totaalreviewscore = 0.00;
$aantalreviews = $reviews->count();
if($aantalreviews != 0) {
    foreach($reviews as $review) {
        $totaalreviewscore += $review->ReviewScore;
    }
    $gemiddeldescore = $totaalreviewscore / $reviews->count();
}

/**
 * @todo Product niet gelijk toevoegen op pagina bezoeken maar wanneer er op de knop gedrukt wordt
 * @todo als product al in winkelwagentje staat voeg dan niet extra toe
 */

include(SERVER_ROOT . '/resources/includes/productCarrousel.php');

?>

    <div class="col-6" xmlns="http://www.w3.org/1999/html">
        <?php $ENGLretailprice = $product->RecommendedRetailPrice;
        $NLretailprice = str_replace('.', ',', $ENGLretailprice);
        ?>
        <h1 class="h1 mt-3"><?php echo $product->StockItemName; ?></h1>

        <h2 class="container mt-5 "
            style="border-width: 1px; border-color: black; ">    <?= "<span style=\"color:#3CB371;\"> € $product->RecommendedRetailPrice </span>" ?></h2>
        <form action="/shoppingcart/add" method="post">
            <input type="hidden" name="product" value="<?= $product->StockItemID ?>">
            <button type="submit" class="btn btn-success material-button"><i class="material-icons">shopping_basket</i>
            </button>
        </form>
        <img src="/images/favourite.jpg" height="40" width="50" onclick="AddtoFavourite() "> <br><br>
        <?php $ENGLretailprice = $product->RecommendedRetailPrice;
        $NLretailprice = str_replace(".", ",", $ENGLretailprice);
        ?>
        <div class="card">
            <div class="card-header">
                <?php echo 'Product Details' ?>
            </div>
            <div class="card-body ">
                <?php echo $product->SearchDetails; ?> <br>
                <?php echo trans('products.color') . " : " . $product->ColorName; ?> <br>
                <?php echo trans('products.weight') . " : " . $product->TypicalWeightPerUnit . "Kg"; ?> <br>
                <?php If($product->Size != "") {
                echo trans('products.size') . " : " . $product->Size;} ?> <br>
                <?php If ($leverancier->SupplierName != "") {
                    echo trans('products.leverancier') . " : " . $leverancier->SupplierName;
                } ?>
            </div>
        </div>
    </div>
    <?php
    if (Login::isLoggedIn()) { ?>
        <div class="row mt-5">
            <div class="col-6">
                <form action="/products/<?= $product->StockItemID ?>" method="post">
                    <div class="container">
                        <h3>Reviews</h3>

                        <i class="material-icons reviewssterren" id="star1">star</i>
                        <i class="material-icons reviewssterren" id="star2">star</i>
                        <i class="material-icons reviewssterren" id="star3">star</i>
                        <i class="material-icons reviewssterren" id="star4">star</i>
                        <i class="material-icons reviewssterren" id="star5">star</i>
                        <h1><?php echo $reviewscore ?></h1>

                        <div>
                            <input type="hidden" id="stars" name="stars" value="0">
                            <br><textarea name="review" value="" placeholder="Type hier uw Review" cols="50"
                                          rows="6"></textarea>
                            <br>
                            <button type="submit">verzend</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
        <?php
    }
    ?>
    <?php include SERVER_ROOT . '/resources/includes/review.php'; ?>
    <script>    function AddtoShoppingCart() {
            let data = '<?=json_encode($shoppingarray) ?>';
            let url = '/shoppingcart';

            $.post(url, data)
                .on('success', alert('Succesvol toegevoegd aan winkelwagentje!'))
                .on('error', alert('ERROR'));
        }

    </script>
    <script> function AddtoFavourite() {
            alert("Added item to favourites!");
        }

    </script>
    <script>
        $('.reviewssterren').mouseenter(function () {
            let currentStar = parseInt($(this).attr('id').replace(/[^\d.]/g, ''));

            for (let i = 1; i <= currentStar; i++) {
                $(`#star${i}`).addClass('text-danger');
            }
        }).mouseleave(function () {
            let currentStar = parseInt($(this).attr('id').replace(/[^\d.]/g, ''));

            for (let i = 1; i <= currentStar; i++) {
                $(`#star${i}`).removeClass('text-danger');
            }
        }).on('click', function () {
            let currentStar = parseInt($(this).attr('id').replace(/[^\d.]/g, ''));
            $('.reviewssterren').each(function () {
                $(this).css('color', 'black');
            });
            for (let i = 1; i <= currentStar; i++) {
                $(`#star${i}`).css('color', 'red');
            }
            $('#stars').attr('value', currentStar);
        });

    </script>
    <?php


$statement->free_result();
?>
