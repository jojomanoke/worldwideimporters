<?php
$connection = Database::getConnection();
$productId = $_GET['product'];
$query = 'SELECT s.*, c.ColorName FROM stockitems s left join colors c ON c.ColorID = s.ColorID WHERE StockItemID = ?';
$statement = $connection->prepare($query);
$statement->bind_param('i', $productId);
$statement->execute();
$product = $statement->get_result()->fetch_object();

/**
 * @todo Product niet gelijk toevoegen op pagina bezoeken maar wanneer er op de knop gedrukt wordt
 * @todo als product al in winkelwagentje staat voeg dan niet extra toe
 */

$shoppingarray = array(
    "id" => $product->StockItemID,
    "Naam" => $product->StockItemName,
);
//
//function WinkelMand(){
//     $_SESSION["shoppingcart"] = [];
//
//
//    array_push($_SESSION["shoppingcart"], $shoppingarray);
//}


?>

    <div class="row">

        <div class="col-6">
            <br>
            <link rel="stylesheet" type="text/css" href="/css/style_productweergave.css">
            <!-- Container for the image gallery -->
            <div class="container">

                <!-- Full-width images with number text -->
                <div class="mySlides">
                    <div class="numbertext">1 / 6</div>
                    <img src="<?php if (isset($row['Photo']) && ($row['Photo'] != null)) {
                        echo getBlob($row['Photo']);
                    } else {
                        echo 'https://via.placeholder.com/350x200';
                    } ?>" style="width:100%" height="60%">
                </div>

                <div class="mySlides">
                    <div class="numbertext">2 / 6</div>
                    <img src="<?php if (isset($row['Photo']) && ($row['Photo'] != null)) {
                        echo getBlob($row['Photo']);
                    } else {
                        echo 'https://via.placeholder.com/350x200';
                    } ?>" style="width:100%" height="60%">
                </div>

                <div class="mySlides">
                    <div class="numbertext">3 / 6</div>
                    <img src="<?php if (isset($row['Photo']) && ($row['Photo'] != null)) {
                        echo getBlob($row['Photo']);
                    } else {
                        echo 'https://via.placeholder.com/350x200';
                    } ?>" style="width:100%" height="60%">
                </div>

                <div class="mySlides">
                    <div class="numbertext">4 / 6</div>
                    <img src="<?php if (isset($row['Photo']) && ($row['Photo'] != null)) {
                        echo getBlob($row['Photo']);
                    } else {
                        echo 'https://via.placeholder.com/350x200';
                    } ?>" style="width:100%" height="60%">
                </div>

                <div class="mySlides">
                    <div class="numbertext">5 / 6</div>
                    <img src="<?php if (isset($row['Photo']) && ($row['Photo'] != null)) {
                        echo getBlob($row['Photo']);
                    } else {
                        echo 'https://via.placeholder.com/350x200';
                    } ?>" style="width:100%" height="60%">
                </div>

                <div class="mySlides">
                    <div class="numbertext">6 / 6</div>
                    <img src="<?php if (isset($row['Photo']) && ($row['Photo'] != null)) {
                        echo getBlob($row['Photo']);
                    } else {
                        echo 'https://via.placeholder.com/350x200';
                    } ?>" style="width:100%" height="60%">
                </div>

                <!-- Next and previous buttons -->
                <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                <a class="next" onclick="plusSlides(1)">&#10095;</a>

                <!-- Image text -->
                <div class="caption-container">
                    <p id="caption"></p>
                </div>

                <!-- Thumbnail images -->
                <div class="row">
                    <div class="column" onclick="">
                        <img src="<?php if (isset($row['Photo']) && ($row['Photo'] != null)) {
                            echo getBlob($row['Photo']);
                        } else {
                            echo 'https://via.placeholder.com/350x200';
                        } ?>" class="card-img-top" alt="..." style="width:100%" onclick="currentSlide(1)">
                    </div>
                    <div class="column">
                        <img src="<?php if (isset($row['Photo']) && ($row['Photo'] != null)) {
                            echo getBlob($row['Photo']);
                        } else {
                            echo 'https://via.placeholder.com/350x200';
                        } ?>" class="card-img-top" alt="..." style="width:100%" onclick="currentSlide(1)">
                    </div>
                    <div class="column">
                        <img src="<?php if (isset($row['Photo']) && ($row['Photo'] != null)) {
                            echo getBlob($row['Photo']);
                        } else {
                            echo 'https://via.placeholder.com/350x200';
                        } ?>" class="card-img-top" alt="..." style="width:100%" onclick="currentSlide(1)">
                    </div>
                    <div class="column">
                        <img src="<?php if (isset($row['Photo']) && ($row['Photo'] != null)) {
                            echo getBlob($row['Photo']);
                        } else {
                            echo 'https://via.placeholder.com/350x200';
                        } ?>" class="card-img-top" alt="..." style="width:100%" onclick="currentSlide(1)">
                    </div>
                    <div class="column">
                        <img src="<?php if (isset($row['Photo']) && ($row['Photo'] != null)) {
                            echo getBlob($row['Photo']);
                        } else {
                            echo 'https://via.placeholder.com/350x200';
                        } ?>" class="card-img-top" alt="..." style="width:100%" onclick="currentSlide(1)">
                    </div>
                    <div class="column">
                        <img src="<?php if (isset($row['Photo']) && ($row['Photo'] != null)) {
                            echo getBlob($row['Photo']);
                        } else {
                            echo 'https://via.placeholder.com/350x200';
                        } ?>" class="card-img-top" alt="..." style="width:100%" onclick="currentSlide(1)">
                    </div>
                </div>
            </div>
        </div>
        <div>

        </div>
        <div class="col-6">
            <br>
            <h1 class="h1"><?php echo $product->StockItemName; ?></h1>
            <div class="text-sm-right" style="border: #1b1e21"> World Wide Importers</div>
            <h2 class="container">    <?= "<span style=\"color:#ff0000;\"> $product->RecommendedRetailPrice </span>" ?></h2>
            <button type="button" onclick="AddtoShoppingCart()" name="shoppingcart"
                    class="btn btn-warning"><?= trans('products.addToCart'); ?></button>
            <img src="/images/favourite.jpg" height="40" width="50" onclick="AddtoFavourite() "> <br><br>
            <div class="">
                <h3><?php echo 'Product Details' ?> </h3>
                <?php echo $product->SearchDetails; ?> <br>
                <?php echo trans('products.color') . " : " . $product->ColorName; ?> <br>
                <?php echo trans('products.weight') . " : " . $product->TypicalWeightPerUnit . "Kg"; ?> <br>
                <?php If ($product->Size != "") {
                    echo trans('products.size') . " : " . $product->Size;
                } ?>
            </div>
            <div>
                <br><br>
                Gratis Bezorging <br>
                Klantservice 24/7 <br>
                Gratis retouneren <br>
            </div>
        </div>
    </div>
    <h3>Reviews</h3>
    <i class="fa fa-star fa-2x" style="color:white"></i>
    <script src="/js/productweergave.js"></script>

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

<?php


$statement->free_result();
?>