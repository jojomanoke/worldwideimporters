<?php
$products = Query::get('stockitems')->take(10);
?>
<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <?php for ( $i = 1; $i < $products->count(); $i++ ) { ?>
            <li data-target="#carouselExampleIndicators" data-slide-to="<?= $i ?>"></li>
        <?php } ?>
    </ol>
    <div class="carousel-inner">
        <?php foreach ( $products as $key => $product ) { ?>
            <div class="carousel-item h-100 <?php if ( (int)$key === 0 ) {
                echo 'active';
            } ?>">
                
                <?php if ( strlen($product->Photo) ) {
                    $imageHeight = imagesy(imagecreatefromstring($product->Photo));
                    $imageWidth = imagesx(imagecreatefromstring($product->Photo));
                    $newImageSize = resizeImage($imageWidth, $imageHeight, 450, 450);
                    ?>
                    <img style="max-height: <?=$newImageSize['height']?>px; max-width: <?=$newImageSize['width']?>px;>"
                         src="<?= getBlob($product->Photo) ?>"
                         class="d-block w-100"
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
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>


