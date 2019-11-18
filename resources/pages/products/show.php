<?php
$connection = Database::getConnection();
$productId = $_GET[ 'product' ];
$query = 'SELECT * FROM stockitems WHERE StockItemID = ? LIMIT 1';
$statement = $connection->prepare($query);
$statement->bind_param('i', $productId);
$statement->execute();
$product = $statement->get_result()->fetch_object();
?>
    <h1 class="h1"><?php echo $product->StockItemName; ?></h1>

<div class="row">
    <div class="col-6">
        <link rel="stylesheet" type="text/css" href="/css/style_productweergave.css">
        <!-- Container for the image gallery -->
        <div class="container" >

            <!-- Full-width images with number text -->
            <div class="mySlides">
                <div class="numbertext">1 / 6</div>
                <img src="<?php if (isset($row['Photo']) && ( $row[ 'Photo' ] != null )) {
                    echo getBlob($row[ 'Photo' ]);
                } else {
                    echo 'https://via.placeholder.com/350x200';
                } ?>" style="width:100%" height="60%">
            </div>

            <div class="mySlides">
                <div class="numbertext">2 / 6</div>
                <img src="<?php if (isset($row['Photo']) && ( $row[ 'Photo' ] != null )) {
                    echo getBlob($row[ 'Photo' ]);
                } else {
                    echo 'https://via.placeholder.com/350x200';
                } ?>" style="width:100%" height="60%">
            </div>

            <div class="mySlides">
                <div class="numbertext">3 / 6</div>
                <img src="<?php if (isset($row['Photo']) && ( $row[ 'Photo' ] != null )) {
                    echo getBlob($row[ 'Photo' ]);
                } else {
                    echo 'https://via.placeholder.com/350x200';
                } ?>" style="width:100%" height="60%">
            </div>

            <div class="mySlides">
                <div class="numbertext">4 / 6</div>
                <img src="<?php if (isset($row['Photo']) && ( $row[ 'Photo' ] != null )) {
                    echo getBlob($row[ 'Photo' ]);
                } else {
                    echo 'https://via.placeholder.com/350x200';
                } ?>" style="width:100%" height="60%">
            </div>

            <div class="mySlides">
                <div class="numbertext">5 / 6</div>
                <img src="<?php if (isset($row['Photo']) && ( $row[ 'Photo' ] != null )) {
                    echo getBlob($row[ 'Photo' ]);
                } else {
                    echo 'https://via.placeholder.com/350x200';
                } ?>" style="width:100%" height="60%">
            </div>

            <div class="mySlides">
                <div class="numbertext">6 / 6</div>
                <img src="<?php if (isset($row['Photo']) && ( $row[ 'Photo' ] != null )) {
                    echo getBlob($row[ 'Photo' ]);
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
                <div class="column">
                    <img src="<?php if (isset($row['Photo']) && ( $row[ 'Photo' ] != null )) {
                        echo getBlob($row[ 'Photo' ]);
                    } else {
                        echo 'https://via.placeholder.com/350x200';
                    } ?>" class="card-img-top" alt="..." style="width:100%" onclick="currentSlide(1)" >
                </div>
                <div class="column">
                    <img src="<?php if (isset($row['Photo']) && ( $row[ 'Photo' ] != null )) {
                        echo getBlob($row[ 'Photo' ]);
                    } else {
                        echo 'https://via.placeholder.com/350x200';
                    } ?>" class="card-img-top" alt="..." style="width:100%" onclick="currentSlide(1)" >
                </div>
                <div class="column">
                    <img src="<?php if (isset($row['Photo']) && ( $row[ 'Photo' ] != null )) {
                        echo getBlob($row[ 'Photo' ]);
                    } else {
                        echo 'https://via.placeholder.com/350x200';
                    } ?>" class="card-img-top" alt="..." style="width:100%" onclick="currentSlide(1)" >
                </div>
                <div class="column">
                    <img src="<?php if (isset($row['Photo']) && ( $row[ 'Photo' ] != null )) {
                        echo getBlob($row[ 'Photo' ]);
                    } else {
                        echo 'https://via.placeholder.com/350x200';
                    } ?>" class="card-img-top" alt="..." style="width:100%" onclick="currentSlide(1)" >
                </div>
                <div class="column">
                    <img src="<?php if (isset($row['Photo']) && ( $row[ 'Photo' ] != null )) {
                        echo getBlob($row[ 'Photo' ]);
                    } else {
                        echo 'https://via.placeholder.com/350x200';
                    } ?>" class="card-img-top" alt="..." style="width:100%" onclick="currentSlide(1)" >
                </div>
                <div class="column">
                    <img src="<?php if (isset($row['Photo']) && ( $row[ 'Photo' ] != null )) {
                        echo getBlob($row[ 'Photo' ]);
                    } else {
                        echo 'https://via.placeholder.com/350x200';
                    } ?>" class="card-img-top" alt="..." style="width:100%" onclick="currentSlide(1)" >
                </div>
            </div>
        </div>
    </div>
    <div class="col-6">
        <h2><?= "<span style=\"color:#ff0000;\"> $product->RecommendedRetailPrice </span>" ?></h2>
        <button type="button" class="btn btn-warning"><?=trans('products.addToCart'); ?></button>

    </div>
</div>
    <script src="/js/productweergave.js"></script>
<?php
$statement->free_result();
?>