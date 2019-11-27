<?php
$products = Classes\Query\Query::get('stockitems')->take(10);
?>
<div class="card my-5">
    <div class="card-header">
        <h2 class="h2">
            Featured products
        </h2>
    </div>
    <div class="card-body">
        <div id="carouselExampleIndicators" class="carousel slide bg-transparent" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <?php for ( $i = 1; $i < $products->count(); $i++ ) { ?>
                    <li data-target="#carouselExampleIndicators" data-slide-to="<?= $i ?>"></li>
                <?php } ?>
            </ol>
            <div class="carousel-inner bg-transparent">
                <?php foreach ( $products as $key => $product ) { ?>
                    <div class="carousel-item bg-transparent h-100 <?php if ( (int)$key === 0 ) {
                        echo 'active';
                    } ?>">
                        
                        <?php if ( strlen($product->Photo) ) {
                            $imageHeight = imagesy(imagecreatefromstring($product->Photo));
                            $imageWidth = imagesx(imagecreatefromstring($product->Photo));
                            $newImageSize = resizeImage($imageWidth, $imageHeight, 450, 450);
                            ?>
                            <img style="max-height: <?= $newImageSize[ 'height' ] ?>px; max-width: <?= $newImageSize[ 'width' ] ?>px;>"
                                 src="<?= getBlob($product->Photo) ?>"
                                 class="d-block w-100 mx-auto"
                                 alt="<?= $product->StockItemName ?>">
                        <?php } else { ?>
                            <img style="height: 450px" src="https://via.placeholder.com/380" class="d-block w-100"
                                 alt="<?= $product->StockItemName ?>">
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span style="color: black;" class="carousel-control-next-icon text-dark" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
</div>


