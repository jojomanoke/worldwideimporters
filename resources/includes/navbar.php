<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <img class="bg-transparent" src="/images/Wideworldimporters.png" height="60" width="200">

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav mr-auto">
            <?php include 'navItems.php'; ?>
        </div>
        <form class="form-inline" action="" method="GET">
            <a href="/shoppingcart" class="btn btn-outline-success my-2 my-sm-0 mr-sm-2"><?php echo trans("general.shoppingcart") ?></a>
            <input id="searchForm" class="form-control mr-sm-2" type="search" placeholder="<?php echo trans("general.search") ?>" aria-label="Search">
            <button class="btn btn-outline-primary my-2 my-sm-0" onclick="search()" type="submit"><?php echo trans("general.search") ?></button>
        </form>
    </div>
</nav>

<script>
    function search() {
        window.event.preventDefault();
        let toSearch = document.getElementById('searchForm').value;
        window.location.href = `/search/${toSearch}`

    }
</script>