<?php
$conn = Database::getConnection();
$query = 'SELECT * FROM stockitems';
$statement = $conn->prepare($query);
$statement->execute();
$productCount = $statement->num_rows;
$results = $statement->get_result();
?>
<div id="productsCarousel" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <?php for ( $i = 0; $i <= $productCount; $i++ ) { ?>
            <li data-target="#productsCarousel" data-slide-to="<?= $i ?>"></li>
        <?php } ?>
    </ol>
    <div class="carousel-inner">
        <?php while ( $product = $results->fetch_object() ) { ?>
            <div class="carousel-item">
                <img src="<?php if ( $product->Photo != null ) {
                    echo getBlob($product->Photo);
                } else {
                    echo 'https://via.placeholder.com/350x200';
                } ?>>" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5><?=$product->StockItemName?>></h5>
                    <p><?=$product->MarketingComments ?>></p>
                </div>
            </div>
        <?php } ?>
    </div>
    <a class="carousel-control-prev" href="#productsCarousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#productsCarousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
