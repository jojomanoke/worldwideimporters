<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a href="/home">
        <img class="bg-transparent" src="/images/Wideworldimporters.png" height="60" width="200">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav mr-auto">
            <?php include 'navItems.php'; ?>
        </div>
        <form class="form-inline" action="" method="GET">
            <input id="searchForm" class="form-control mr-sm-2" type="search"
                   placeholder="<?php echo trans("general.search") ?>" aria-label="Search">
            <button class="btn btn-outline-primary my-2 my-sm-0" onclick="search()"
                    type="submit"><?php echo trans("general.search") ?></button>&nbsp;&nbsp;
            <a href="/shoppingcart"
               class="btn btn-outline-success my-2 my-sm-0 mr-sm-2"><?php echo trans("general.shoppingcart") ?></a>
                    <div class="dropdown show">
                    <a class="btn btn-primary dropdown-toggle" href="" role="button" id="profiel" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Account</a>
                    <div class="dropdown-menu" aria-labelledby="profiel">
                        <a class="dropdown-item" href="/">Inloggen</a>
                        <a class="dropdown-item" href="">Registreren</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="">Mijn profiel</a>
                </div>
            </div>
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