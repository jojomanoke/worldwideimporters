<link href="/css/category_search_pages.css" rel="stylesheet" type="text/css">

<?php
foreach ($reviews as $review) { ?>

    <div class="card hover mb-5 mt-5" id="Review">
        <div class="card-img-top" alt="...">
            </div>
            <div class="card-body">
                <h5 class="card-title"><?= $review->ReviewScore ?></h5>
                <p class="card-text"><?= $review->ReviewDescription ?></p>
            </div>
        </div>
    </div>
    <?Php
}
?>