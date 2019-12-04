<div id="filterBar" class="d-none collapse d-lg-block col-lg-2 navbar-light bg-light">
    <div class="sticky-top py-5">
        <aside id="filterNav" class="navbar navbar-expand-lg">
            <div class="flex-column w-100 bg-light">
                <div class="lead">Filters</div><br>
                <form method="get" action="<?=getUrl()?>">
                    <div class="form-group">
                        <label for="resultsPerPage">Aantal resultaten per pagina</label>
                        <select id="resultsPerPage" name="resultsPerPage" onchange="submit()" class="form-control">
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <br>   <div class="form-group">
                        <label for="priceFilter">Prijs</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="priceFilter" id="exampleRadios1" value="laaghoog">
                            <label class="form-check-label" for="exampleRadios1">
                                Laag naar hoog
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="priceFilter" id="exampleRadios2" value="hooglaag">
                            <label class="form-check-label" for="exampleRadios2">
                                Hoog naar laag
                            </label>
                        </div><br>
                            <label for="colour">Kleur</label><br>
                        <label class="btn btn-outline btn-sm">
                            <input type="checkbox" value="all" name="colour" checked> Alle
                        </label>
                            <label class="btn btn-outline-primary btn-sm">
                                <input type="checkbox" value="colour" name="colour"> Blauw
                            </label>
                        <label class="btn btn-outline-danger btn-sm">
                            <input type="checkbox" value="colour" name="colour"> Rood
                        </label>
                        <label class="btn btn-outline-secondary btn-sm">
                            <input type="checkbox" value="colour" name="colour"> Grijs
                        </label>
                        <label class="btn btn-outline-success btn-sm">
                            <input type="checkbox" value="colour" name="colour"> Groen
                        </label>
                        <label class="btn btn-outline-warning btn-sm">
                            <input type="checkbox" value="colour" name="yellow"> Geel
                        </label>
                        <label class="btn btn-outline-dark btn-sm">
                            <input type="checkbox" value="colour" name="black"> Zwart
                        </label><br>
                        <p align="center">
                        <br><br><button type="submit" class="btn btn-success" name="filter">Filter</button></p>
                    </div>
                </form>
            </div>
        </aside>
    </div>
</div>

<script>
    function showFilters(element){
        element
            .removeClass('d-none')
            .addClass('d-block position-relative')
            .css({'width': '100vw', 'left': 0, 'height': '100vh'});
    }
    
    function hideFilters(element){
        element
            .removeClass('d-block position-relative')
            .addClass('d-none')
            .removeAttr('style');
    }
    let filterBar = $('#filterBar');
    let filterNav = $('#filterNav');
    filterNav
        .on('show.bs.collapse', () => showFilters(filterBar))
        .on('hidden.bs.collapse', () => hideFilters(filterBar));

    $(window).resize(function () {
        //width() =< 975
        
        if($(this).width() >= 975 && filterNav.hasClass('collapse')){
            hideFilters(filterBar);
            filterNav.removeClass('collapse');
        }
    });

</script>