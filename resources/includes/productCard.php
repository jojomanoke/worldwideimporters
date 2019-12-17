<?php

use Classes\Query\Query;

?>
<link href="/css/category_search_pages.css" rel="stylesheet" type="text/css">


<div class="col-12 col-md-6 col-lg-4 col-xl-3 my-3">
    <div class="card h-100 hover" id="<?= $product->StockItemID ?>">
        <div class="card-header">
            <h6>
            <small class="card-text mr-auto">
                Artikelnummer: <?= $product->StockItemID ?>
            </small>
            </h6>
            <h3>
                <small class="card-text float-right" style="color: forestgreen">
                    Prijs: €<?= number_format($product->UnitPrice, 2, ',', '.') ?>
                </small>
            </h3>
        </div>
        <?php $photos = Query::get('photos')->where('StockItemID', $product->StockItemID) ?>
        <img src="<?php if ($photos->count() !== 0) {
            echo $photos->first()->PhotoLocation;
        } else {
            echo 'https://via.placeholder.com/350x200';
        } ?>" class="card-img-top" alt="...">
        <div class="floating-buttons float-right position-absolute">
            <button class="btn btn-primary rounded-circle material-button"><i class="material-icons">favorite_border</i>
            </button>
        </div>
        <div class="card-body">
            <h5 class="card-title"><?= $product->StockItemName ?></h5>
            <p class="card-text"><?= $product->SearchDetails ?></p>
        </div>
        <div class="card-footer">
            <div class="row h-100 text-center">
                <div class="col-auto mr-auto">
                    <a href="/products/<?= $product->StockItemID ?>" class="btn btn-primary material-button">
                        <i class="material-icons-outlined">info</i>
                    </a>
                </div>
                <div class="col-auto ml-auto">
                    <form action="<?= url('shoppingcart/add') ?>" method="post">
                        <input type="hidden" name="product" value="<?= $product->StockItemID ?>">
                        <button type="submit" class="btn btn-success material-button"><i class="material-icons">shopping_basket</i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

</script>