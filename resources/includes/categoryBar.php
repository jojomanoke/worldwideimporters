<?php

use Classes\Query\Query;

$categories = Query::get('stockgroups');
$category = $_GET['category'] ?? 0;
$page = $_GET['page'];
if($page === 'categories' || $page === 'search') {
    include SERVER_ROOT . '/resources/includes/sidebar.php';
}
?>
    <div class="col-12 col-md-9 mx-md-auto">
    <ul class="nav nav-tabs justify-content-center sticky-top bg-white d-none d-md-flex">
        <?php foreach($categories as $item) { ?>
            <li class="nav-item">
                <a class="nav-link <?= ((int)$category === (int)$item->StockGroupID) ? 'active' : '' ?>"
                   href="/categories/<?php echo $item->StockGroupID; ?>"><?php echo $item->StockGroupName; ?></a>
            </li>
        <?php } ?>
    </ul>
<?php
?>