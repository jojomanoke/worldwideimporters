<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#"><?php echo WEBSITE_NAME ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav mr-auto">
                <?php include 'navItems.php'; ?>
        </div>
        <form class="form-inline" action="" method="GET">
            <input id="searchForm" class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" onclick="search()" type="submit">Search</button>
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