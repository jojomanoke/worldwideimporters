<div id="filterBar" class="d-none collapse d-lg-block col-lg-2 navbar-light bg-light">
    <div class="sticky-top py-5">
        <aside id="filterNav" class="navbar navbar-expand-lg">
            <div class="flex-column w-100 bg-light">
                <div class="lead">Filters</div>
                <form method="get" action="<?=getUrl()?>">
                    <div class="form-group">
                        <label for="ARPP">Resultaten per pagina</label>
                        <select id="ARPP" onchange="submit()" class="form-control w-auto" name="ARPP">
                            <option <?php if (isset($_GET['ARPP']) && $_GET['ARPP'] == 25) {
                                echo "selected";
                            } ?> value=25>25
                            </option>
                            <option <?php if (isset($_GET['ARPP']) && $_GET['ARPP'] == 50) {
                                echo "selected";
                            } ?> value=50>50
                            </option>
                            <option <?php if (isset($_GET['ARPP']) && $_GET['ARPP'] == 100) {
                                echo "selected";
                            } ?> value=100>100
                            </option>
                        </select>
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