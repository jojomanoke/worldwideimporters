<link href="/css/category_search_pages.css" rel="stylesheet" type="text/css">

<?php
foreach ($reviews as $review) { ?>

    <div class="card hover mb-2 mt-5 justify-content-center" id="Review" style="width: 70%">
        <div class="card-header"></div>
        <div class="card-body">
            <h5 class="card-title" style="width: 80%"><?= $review->ReviewScore ?> <i
                        class="material-icons reviewssterren" id="starreviewscore">star</i></h5>
            <p class="card-text" style="width: 80%"><?= $review->ReviewDescription ?></p>
        </div>
        <div class="card-footer">
          <!--  <i class="material-icons deletefunction" id="garbagecan" style="align-items: end">delete</i>-->
        </div>
    </div>
    <?Php
}
?>
