<div class="row my-5" style="width: 95%; height: 50%;">
    <!--    <div class="col-md-6 col-12" style="height: 400px">-->
    <!--        <link rel="stylesheet" type="text/css" href="/css/style_productweergave.css">-->
    <!--        <div class="container" style="height: 90px; width: 100%;">-->
    <!---->
    <!--            <div class="mySlides" style="height: 90px">-->
    <!--                <div class="numbertext">1 / 6</div>-->
    <!--                <img src="--><?php //if(isset($row['Photo']) && ($row['Photo'] != null)) {
    //                    echo getBlob($row['Photo']);
    //                } else {
    //                    echo 'https://via.placeholder.com/350x200';
    //                } ?><!--" style="width:100%" height="60%">-->
    <!--            </div>-->
    <!---->
    <!--            <div class="mySlides">-->
    <!--                <div class="numbertext">2 / 6</div>-->
    <!--                <img src="--><?php //if(isset($row['Photo']) && ($row['Photo'] != null)) {
    //                    echo getBlob($row['Photo']);
    //                } else {
    //                    echo 'https://via.placeholder.com/350x200';
    //                } ?><!--" style="width:100%" height="60%">-->
    <!--            </div>-->
    <!---->
    <!--            <div class="mySlides">-->
    <!--                <div class="numbertext">3 / 6</div>-->
    <!--                <img src="--><?php //if(isset($row['Photo']) && ($row['Photo'] != null)) {
    //                    echo getBlob($row['Photo']);
    //                } else {
    //                    echo 'https://via.placeholder.com/350x200';
    //                } ?><!--" style="width:100%" height="60%">-->
    <!--            </div>-->
    <!---->
    <!--            <div class="mySlides">-->
    <!--                <div class="numbertext">4 / 6</div>-->
    <!--                <img src="--><?php //if(isset($row['Photo']) && ($row['Photo'] != null)) {
    //                    echo getBlob($row['Photo']);
    //                } else {
    //                    echo 'https://via.placeholder.com/350x200';
    //                } ?><!--" style="width:100%" height="60%">-->
    <!--            </div>-->
    <!---->
    <!--            <div class="mySlides">-->
    <!--                <div class="numbertext">5 / 6</div>-->
    <!--                <img src="--><?php //if(isset($row['Photo']) && ($row['Photo'] != null)) {
    //                    echo getBlob($row['Photo']);
    //                } else {
    //                    echo 'https://via.placeholder.com/350x200';
    //                } ?><!--" style="width:100%" height="60%">-->
    <!--            </div>-->
    <!---->
    <!--            <div class="mySlides">-->
    <!--                <div class="numbertext">6 / 6</div>-->
    <!--                <img src="--><?php //if(isset($row['Photo']) && ($row['Photo'] != null)) {
    //                    echo getBlob($row['Photo']);
    //                } else {
    //                    echo 'https://via.placeholder.com/350x200';
    //                } ?><!--" style="width:100%" height="60%">-->
    <!--            </div>-->
    <!---->
    <!--            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>-->
    <!--            <a class="next" onclick="plusSlides(1)">&#10095;</a>-->
    <!---->
    <!--            <div class="caption-container">-->
    <!--                <p id="caption"></p>-->
    <!--            </div>-->
    <!---->
    <!--            <div class="row">-->
    <!--                <div class="column" onclick="">-->
    <!--                    <img src="--><?php //if(isset($row['Photo']) && ($row['Photo'] != null)) {
    //                        echo getBlob($row['Photo']);
    //                    } else {
    //                        echo 'https://via.placeholder.com/350x200';
    //                    } ?><!--" class="card-img-top" alt="..." style="width:100%" onclick="currentSlide(1)">-->
    <!--                </div>-->
    <!--                <div class="column">-->
    <!--                    <img src="--><?php //if(isset($row['Photo']) && ($row['Photo'] != null)) {
    //                        echo getBlob($row['Photo']);
    //                    } else {
    //                        echo 'https://via.placeholder.com/350x200';
    //                    } ?><!--" class="card-img-top" alt="..." style="width:100%" onclick="currentSlide(1)">-->
    <!--                </div>-->
    <!--                <div class="column">-->
    <!--                    <img src="--><?php //if(isset($row['Photo']) && ($row['Photo'] != null)) {
    //                        echo getBlob($row['Photo']);
    //                    } else {
    //                        echo 'https://via.placeholder.com/350x200';
    //                    } ?><!--" class="card-img-top" alt="..." style="width:100%" onclick="currentSlide(1)">-->
    <!--                </div>-->
    <!--                <div class="column">-->
    <!--                    <img src="--><?php //if(isset($row['Photo']) && ($row['Photo'] != null)) {
    //                        echo getBlob($row['Photo']);
    //                    } else {
    //                        echo 'https://via.placeholder.com/350x200';
    //                    } ?><!--" class="card-img-top" alt="..." style="width:100%" onclick="currentSlide(1)">-->
    <!--                </div>-->
    <!--                <div class="column">-->
    <!--                    <img src="--><?php //if(isset($row['Photo']) && ($row['Photo'] != null)) {
    //                        echo getBlob($row['Photo']);
    //                    } else {
    //                        echo 'https://via.placeholder.com/350x200';
    //                    } ?><!--" class="card-img-top" alt="..." style="width:100%" onclick="currentSlide(1)">-->
    <!--                </div>-->
    <!--                <div class="column">-->
    <!--                    <img src="--><?php //if(isset($row['Photo']) && ($row['Photo'] != null)) {
    //                        echo getBlob($row['Photo']);
    //                    } else {
    //                        echo 'https://via.placeholder.com/350x200';
    //                    } ?><!--" class="card-img-top" alt="..." style="width:100%" onclick="currentSlide(1)">-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <?php
    $photos = \Classes\Query\Query::get('photos')->where('StockItemID', $product->StockItemID);
    ?>
    <div id="carouselExampleIndicators" class="carousel slide bg-dark" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <?php for($i = 1; $i < $photos->count(); $i++) { ?>
                <li data-target="#carouselExampleIndicators" data-slide-to="<?= $i ?>"></li>
            <?php } ?>
        </ol>
        <div class="carousel-inner">
            <?php foreach($photos as $key => $photo) { ?>
                <div class="carousel-item h-100 <?php if((int)$key === 0) {
                    echo 'active';
                } ?>">
                    <img src="<?= $photo->PhotoLocation ?>"
                         class="d-block w-100 mx-auto"
                         alt="<?= $product->StockItemName ?>">
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