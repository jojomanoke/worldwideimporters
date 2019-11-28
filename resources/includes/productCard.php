<link href="/css/category_search_pages.css" rel="stylesheet" type="text/css">


<div class="col-12 col-md-6 col-lg-4 col-xl-3 my-3">
    <div class="card h-100 hover" id="<?= $row[ 'StockItemID' ] ?>">
        <?php if ( $_GET[ 'page' ] === 'search' ) { ?>
            <div class="card-header">
                <small class="card-text">
                    Artikelnummer: <?php echo $row[ 'StockItemID' ]; ?>
                </small>
            </div>
        <?php } ?>
        <img src="<?php if ( isset($row[ 'Photo' ]) && ( $row[ 'Photo' ] != null ) ) {
            echo getBlob($row[ 'Photo' ]);
        } else {
            echo 'https://via.placeholder.com/350x200';
        } ?>" class="card-img-top" alt="...">
        <div class="floating-buttons float-right position-absolute">
            <button class="btn btn-primary rounded-circle material-button"><i class="material-icons">favorite_border</i>
            </button>
        </div>
        <div class="card-body">
            <h5 class="card-title"><?php echo $row[ 'StockItemName' ]; ?></h5>
            <p class="card-text"><?php echo $row[ 'SearchDetails' ]; ?></p>
        </div>
        <div class="card-footer">
            <div class="row h-100 text-center">
                <div class="col-auto mr-auto">
                    <a href="/products/<?php echo $row[ 'StockItemID' ]; ?>" class="btn btn-primary material-button">
                        <i class="material-icons-outlined">info</i>
                    </a>
                </div>
                <div class="col-auto ml-auto">
                    <form action="/shoppingcart/add" method="post">
                        <input type="hidden" name="product" value="<?=$row['StockItemID']?>">
                        <button type="submit" class="btn btn-success material-button"><i class="material-icons">shopping_basket</i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

</script>