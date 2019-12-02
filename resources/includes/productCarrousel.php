<div class="row my-5">
    <div class="col-md-6 col-12">
        <link rel="stylesheet" type="text/css" href="/css/style_productweergave.css">
        <!-- Container for the image gallery -->
        <div class="container" style="height: 100%; width: 100%;">

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