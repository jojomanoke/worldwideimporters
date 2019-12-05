<?php

use Classes\Query\Query;

$categories = Query::get('stockgroups');
$category = $_GET['category'] ?? 0;
$page = $_GET['page'];
if($page === 'categories' || $page === 'search') {
    include SERVER_ROOT . '/resources/includes/sidebar.php';
}
?>

    <!--    <div class="container-fluid pt-5 mt-5 fixed-top h-100 d-none d-lg-block border-right">-->
    <!--        <div class="row h-100">-->
    <!--            <aside class="col-12 col-md-2 p-0 bg-white">-->
    <!--                <nav class="navbar navbar-expand navbar-light nav-pills bg-white flex-md-column flex-row align-items-start">-->
    <!--                    <div class="collapse navbar-collapse">-->
    <!--                        <ul class="flex-md-column flex-row navbar-nav w-100 justify-content-between">-->
    <!--                            --><?php //while ( $category = $categories->fetch_assoc() ) { ?>
    <!--                                <li class="nav-item">-->
    <!--                                    <a class="nav-link pl-0 --><?php //if ( $cate == $category[ 'StockGroupID' ] ) echo 'active'; ?><!--"-->
    <!--                                       href="/categories/--><?php //echo $category[ 'StockGroupID' ]; ?><!--">--><?php //echo $category[ 'StockGroupName' ]; ?><!--</a>-->
    <!--                                </li>-->
    <!--                            --><?php //} ?>
    <!--                        </ul>-->
    <!--                    </div>-->
    <!---->
    <!---->
    <!--                </nav>-->
    <!--            </aside>-->
    <!--        </div>-->
    <!--    </div>-->
    <div class="col-9 mx-auto">
    <ul class="nav nav-tabs justify-content-center sticky-top bg-white">
        <?php foreach($categories as $item) { ?>
            <li class="nav-item">
                <a class="nav-link <?= ((int)$category === (int)$item->StockGroupID) ? 'active' : '' ?>"
                   href="/categories/<?php echo $item->StockGroupID; ?>"><?php echo $item->StockGroupName; ?></a>
            </li>
        <?php } ?>
    </ul>
<?php
?>