<div id="filterBar" class="d-none collapse d-lg-block col-lg-3 col-xl-2 col-md-4 navbar-light bg-light">
    <div class="sticky-top py-5">
        <aside id="filterNav" class="navbar navbar-expand-lg">
            <div class="flex-column w-100 bg-light">
                <?php use Classes\Query\Query;

                if($_GET['page'] === 'categories' || $_GET['page'] === 'search') { ?>
                    <?php
                    $colorQuery = 'SELECT DISTINCT ColorID FROM stockitems';
                    if($_GET['page'] !== 'search') {
                        $colorQuery .= " WHERE StockItemID IN (SELECT StockItemID FROM stockitemstockgroups WHERE StockGroupID = {$_GET['category']})";
                    } else {
                        $colorQuery .= " WHERE StockItemName = '{$_GET['search']}' OR SearchDetails = '{$_GET['search']}'";
                        if(is_int($_GET['search']) && $_GET['search'] > 0) {
                            $colorQuery .= " OR StockItemID = {$_GET['search']}";
                        }
                    }
                    $colorIds = Query::get($colorQuery)->toArray();
                    $colors = Query::in('colors', 'ColorID', $colorIds);
                    $colors = $colors->sort('ColorID');
                    ?>
                    <div class="lead mb-2">Filters</div>
                    <form method="get" action="<?= getUrl() ?>">
                        <div class="form-group">
                            <label for="ARPP">Resultaten per pagina</label>
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
                        <br>
                        <div class="form-group">
                            <label for="priceFilter">Prijs</label>
                            <div class="form-check">
                                <input class="form-check-input"
                                    <?php if(!isset($_GET['priceFilter']) || (isset($_GET['priceFilter']) && $_GET['priceFilter'] === 'laaghoog')) {
                                        echo 'checked';
                                    } ?>
                                       type="radio" name="priceFilter" id="priceFilterLowHigh" value="laaghoog">
                                <label class="form-check-label" for="priceFilterLowHigh">
                                    Laag naar hoog
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input"
                                    <?php if(isset($_GET['priceFilter']) && $_GET['priceFilter'] === 'hooglaag') {
                                        echo 'checked';
                                    } ?>

                                       type="radio" name="priceFilter" id="priceFilterHighLow" value="hooglaag">
                                <label class="form-check-label" for="priceFilterHighLow">
                                    Hoog naar laag
                                </label>
                            </div>
                            <br>
                            <?php if($colors->count() > 0) { ?>
                                <label for="colour">Kleur</label><br>
                                <button class="btn btn-outline-secondary" type="button" data-toggle="collapse"
                                        data-target="#colorCollapse" aria-expanded="false"
                                        aria-controls="colorCollapse">
                                    Laat kleuren zien
                                </button>
                                <div class="collapse" id="colorCollapse">
                                    <?php
                                    foreach($colors as $color) { ?>
                                        <label class="btn btn-outline btn-sm">
                                            <input type="checkbox"
                                                   <?= (isset($_GET['colour']) && (in_array($color->ColorID, $_GET['colour'], false))) ? 'checked' : '' ?>
                                                   value="<?= $color->ColorID ?>" name="colour[]">
                                            <?= $color->ColorName ?>
                                        </label>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                            <p>
                                <button type="submit" class="mt-5 w-100 btn btn-success">Filter</button>
                            </p>
                        </div>
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