<?php $colors = \Classes\Query\Query::get('colors'); ?>

<div id="filterBar" class="d-none collapse d-lg-block col-lg-2 navbar-light bg-light">
    <div class="sticky-top py-5">
        <aside id="filterNav" class="navbar navbar-expand-lg">
            <div class="flex-column w-100 bg-light">
                <div class="lead mb-2">Filters</div>
                <form method="get" action="<?= getUrl() ?>">
                    <div class="form-group">
                        <label for="ARPP">Resultaten per pagina</label>
                        <select id="ARPP" onchange="submit()" class="form-control w-auto" name="ARPP">
                            <option <?php if ( isset($_GET[ 'ARPP' ]) && $_GET[ 'ARPP' ] == 25 ) {
                                echo "selected";
                            } ?> value=25>25
                            </option>
                            <option <?php if ( isset($_GET[ 'ARPP' ]) && $_GET[ 'ARPP' ] == 50 ) {
                                echo "selected";
                            } ?> value=50>50
                            </option>
                            <option <?php if ( isset($_GET[ 'ARPP' ]) && $_GET[ 'ARPP' ] == 100 ) {
                                echo "selected";
                            } ?> value=100>100
                            </option>
                        </select>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="priceFilter">Prijs</label>
                        <div class="form-check">
                            <input class="form-check-input"
                                <?php if (!isset($_GET['priceFilter']) || ( isset($_GET[ 'priceFilter' ]) && $_GET[ 'priceFilter' ] === 'laaghoog' )) {
                                    echo 'checked';
                                } ?>
                                   type="radio" name="priceFilter" id="priceFilterLowHigh" value="laaghoog">
                            <label class="form-check-label" for="priceFilterLowHigh">
                                Laag naar hoog
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input"
                                <?php if ( isset($_GET[ 'priceFilter' ]) && $_GET[ 'priceFilter' ] === 'hooglaag' ) {
                                    echo 'checked';
                                } ?>

                                   type="radio" name="priceFilter" id="priceFilterHighLow" value="hooglaag">
                            <label class="form-check-label" for="priceFilterHighLow">
                                Hoog naar laag
                            </label>
                        </div>
                        <br>
                        <label for="colour">Kleur</label><br>
                        <button class="btn btn-outline-secondary" type="button" data-toggle="collapse"
                                data-target="#colorCollapse" aria-expanded="false" aria-controls="colorCollapse">
                            Laat kleuren zien
                        </button>
                        <div class="collapse" id="colorCollapse">
                            <?php foreach ( $colors as $color ) { ?>
                                <label class="btn btn-outline btn-sm">
                                    <input type="checkbox" value="<?= $color->ColorID ?>" name="colour[]">
                                    <?= $color->ColorName ?>
                                </label>
                            <?php } ?>
                        </div>
                        <p>
                            <button type="submit" class="float-right btn btn-success">Filter</button>
                        </p>
                    </div>
                </form>
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
            if(!(e.target === $('#colorCollapse')[0])){
                
                showFilters(filterBar)
            }
        })
        .on('hidden.bs.collapse', (e) => {
            if(!(e.target === $('#colorCollapse')[0])){
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