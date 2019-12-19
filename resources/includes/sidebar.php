<?php

use Classes\Query\Query;

?>
<div id="filterBar" class="d-none collapse d-lg-block col-lg-3 col-xl-2 col-12 navbar-light bg-light">
    <div class="sticky-top py-5">
        <aside id="filterNav" class="navbar navbar-expand-lg">
            <div class="flex-column w-100 bg-light">
                <?php
                
                if(!isset($_GET['page']) || $_GET['page'] === 'categories' || $_GET['page'] === 'home' || $_GET['page'] === 'search') {
                    if(!isset($_GET['page'])) {
                        $_GET['page'] = 'categories';
                    }
                    ?>
                    <div class="lead mb-2">Filters</div>
                    <form method="get" action="<?= getUrl() ?>">
                        <div class="form-group">
                            <label for="ARPP"><?= trans('filters.resultsPerPage') ?></label>
                            <select id="ARPP" onchange="submit()" class="form-control w-auto" name="ARPP">
                                <option <?php if(isset($_GET['ARPP']) && (int)$_GET['ARPP'] === 25) {
                                    echo 'selected';
                                } ?> value=25>25
                                </option>
                                <option <?php if(isset($_GET['ARPP']) && (int)$_GET['ARPP'] === 50) {
                                    echo 'selected';
                                } ?> value=50>50
                                </option>
                                <option <?php if(isset($_GET['ARPP']) && (int)$_GET['ARPP'] === 100) {
                                    echo 'selected';
                                } ?> value=100>100
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="priceFilter"><?= trans('filters.price.price') ?></label>
                            <div class="form-check">
                                <input class="form-check-input"
                                    <?php if(!isset($_GET['priceFilter']) || (isset($_GET['priceFilter']) && $_GET['priceFilter'] === 'laaghoog')) {
                                        echo 'checked';
                                    } ?>
                                       type="radio" name="priceFilter" id="priceFilterLowHigh" value="laaghoog">
                                <label class="form-check-label" for="priceFilterLowHigh">
                                    <?= trans('filters.price.lowHigh') ?>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input"
                                    <?php if(isset($_GET['priceFilter']) && $_GET['priceFilter'] === 'hooglaag') {
                                        echo 'checked';
                                    } ?>

                                       type="radio" name="priceFilter" id="priceFilterHighLow" value="hooglaag">
                                <label class="form-check-label" for="priceFilterHighLow">
                                    <?= trans('filters.price.highLow') ?>
                                </label>
                            </div>
                        </div>
                        <?php
                        $colorQuery = 'SELECT DISTINCT ColorID FROM stockitems';
                        $allColorIDs = Query::get('colors', 'ColorID')->toArray();
                        if($_GET['page'] !== 'search') {
                            if(isset($_GET['category'])) {
                                $colorQuery .= " WHERE StockItemID IN (SELECT StockItemID FROM stockitemstockgroups WHERE StockGroupID = {$_GET['category']})";
                            }
                        } else {
                            $search = $_GET['search'] ?? ' ';
                            $colorQuery .= " WHERE StockItemName LIKE '%{$search}%' OR SearchDetails LIKE '%{$search}%'";
                            if(is_int($search) && $search > 0) {
                                $colorQuery .= " OR StockItemID = {$search}";
                            }
                            $colorQuery .= ' AND ColorID IN (' . implode(', ', $_GET['colour'] ?? $allColorIDs) . ')';
                        }
                        $colors = Query::get($colorQuery)->toArray();
                        $colors = Query::in('colors', 'ColorID', $colors);
                        $colors = $colors->sort('ColorID');
                        
                        ?>
                        <?php if($colors->count() > 0) { ?>
                            <div class="form-group">
                                <button class="btn btn-outline-secondary col-12 mb-3" type="button"
                                        data-toggle="collapse"
                                        data-target="#colorCollapse" aria-expanded="false"
                                        aria-controls="colorCollapse">
                                    <?= trans('filters.colors.colors') ?>
                                </button>
                                <div class="collapse" id="colorCollapse">
                                    <?php
                                    foreach($colors as $color) { ?>
                                        <label class="btn btn-outline btn-sm">
                                            <input type="checkbox"
                                                   <?= (isset($_GET['color']) && (in_array($color->ColorID, $_GET['color'], false))) ? 'checked' : '' ?>
                                                   value="<?= $color->ColorID ?>" name="color[]">
                                            <?= trans('filters.colors.' . $color->ColorName) ?>
                                        </label>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>
                        <?php
                        $sizeQuery = 'SELECT DISTINCT Size FROM stockitems';
                        if($_GET['page'] !== 'search') {
                            if(isset($_GET['category'])) {
                                $sizeQuery .= " WHERE StockItemID IN (SELECT StockItemID FROM stockitemstockgroups WHERE StockGroupID = {$_GET['category']})";
                            }
                        } else {
                            $search = $_GET['search'] ?? '';
                            $sizeQuery .= " WHERE StockItemName LIKE '%{$search}%' OR SearchDetails LIKE '%{$search}%'";
                            if(is_int($search) && $search > 0) {
                                $sizeQuery .= " OR StockItemID = {$search}";
                            }
                            $sizeQuery .= ' AND Size IN (' . implode(', ', $_GET['size'] ?? Query::get('stockitems', 'DISTINCT Size')->toArray()) . ')';
                        }
                        $sizes = Query::get($sizeQuery);
                        $sizes = $sizes->sort('Size', false);
                        if($sizes->count() > 0) { ?>
                            <div class="form-group">
                                <button class="btn btn-outline-secondary col-12 mb-3" type="button"
                                        data-toggle="collapse"
                                        data-target="#sizeCollapse" aria-expanded="false"
                                        aria-controls="sizeCollapse">
                                    <?= trans('filters.sizes') ?>
                                </button>
                                <div class="collapse" id="sizeCollapse">
                                    <?php foreach($sizes as $size) { ?>
                                        <label class="btn btn-outline btn-sm">
                                            <input type="checkbox"
                                                   <?= (isset($_GET['size']) && (in_array($size->scalar, $_GET['size'], false))) ? 'checked' : '' ?>
                                                   value="<?= $size->scalar ?>" name="size[]">
                                            <?= $size->scalar ?>
                                        </label>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>
                        
                        <?php
                        $brandQuery = 'SELECT DISTINCT Brand FROM stockitems';
                        if($_GET['page'] !== 'search') {
                            if(isset($_GET['category'])) {
                                $brandQuery .= " WHERE StockItemID IN (SELECT StockItemID FROM stockitemstockgroups WHERE StockGroupID = {$_GET['category']})";
                            }
                        } else {
                            $search = $_GET['search'] ?? '';
                            $brandQuery .= " WHERE StockItemName LIKE '%{$search}%' OR SearchDetails LIKE '%{$search}%'";
                            if(is_int($search) && $search > 0) {
                                $brandQuery .= " OR StockItemID = {$search}";
                            }
                            $brandQuery .= ' AND Brand IN (' . implode(', ', $_GET['brand'] ?? Query::get('stockitems', 'DISTINCT Brand')->toArray()) . ')';
                        }
                        $brands = Query::get($brandQuery);
                        $brands = $brands->sort('Brand', false);
                        if($brands->count() > 0) { ?>
                            <div class="form-group">
                                <button class="btn btn-outline-secondary col-12 mb-3" type="button"
                                        data-toggle="collapse"
                                        data-target="#brandCollapse" aria-expanded="false"
                                        aria-controls="brandCollapse">
                                    <?= trans('filters.brands') ?>
                                </button>
                                <div class="collapse" id="brandCollapse">
                                    <?php foreach($brands as $brand) { ?>
                                        <label class="btn btn-outline btn-sm">
                                            <input type="checkbox"
                                                   <?= (isset($_GET['brand']) && (in_array($brand->scalar, $_GET['brand'], false))) ? 'checked' : '' ?>
                                                   value="<?= $brand->scalar ?>" name="brand[]">
                                            <?= $brand->scalar ?>
                                        </label>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>

                        <p>
                            <button type="submit"
                                    class="mt-5 w-100 btn btn-success"><?= trans('filters.filter') ?></button>
                        </p>
                    </form>
                <?php } ?>
            </div>
        </aside>
    </div>
</div>

<script>
    function showFilters(element) {
        element
            .removeClass('d-none')
            .addClass('d-block position-relative')
            .css({'width': '100vw', 'left': 0, 'height': '100vh'});
    }

    function hideFilters(element) {
        element
            .removeClass('d-block position-relative')
            .addClass('d-none')
            .removeAttr('style');
    }

    let filterBar = $('#filterBar');
    let filterNav = $('#filterNav');
    filterNav
        .on('show.bs.collapse', (e) => {
            if (!(e.target === $('#colorCollapse')[0])) {

                showFilters(filterBar)
            }
        })
        .on('hidden.bs.collapse', (e) => {
            if (!(e.target === $('#colorCollapse')[0])) {
                hideFilters(filterBar)
            }
        });

    $(window).resize(function () {
        //width() =< 975

        if ($(this).width() >= 975 && filterNav.hasClass('collapse')) {
            hideFilters(filterBar);
            filterNav.removeClass('collapse');
        }
    });

</script>