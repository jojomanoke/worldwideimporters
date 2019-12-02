<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <?php if($_GET['page'] === 'categories' || $_GET['page'] === 'search') {?>
    <button class="navbar-toggler" id="filterToggle" type="button" data-toggle="collapse" data-target="#filterNav"
            aria-controls="filterNav" aria-expanded="false" aria-label="Toggle filters">
        <span class="navbar-toggler-icon"></span>
    </button>
    <?php } ?>
    <a href="/home">
        <img alt="logo" class="img-fluid" style="height: 50px; width: 150px;" src="/images/Wideworldimporters.png">
    </a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">

        <div class="navbar-nav mr-auto">
            <?php include 'navItems.php'; ?>
        </div>

        <div class="navbar-nav col-auto mx-lg-auto w-auto min-vw-75">
            <form class="form-inline w-100" action="" method="GET">
                <div class="input-group w-100">
                    <input id="searchForm" class="form-control w-75" type="search"
                           placeholder="<?php echo trans("general.search") ?>" aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-outline-primary my-0 py-0" onclick="search()"
                                type="submit"><i class="material-icons pt-1">search</i></button>
                    </div>
                </div>
            </form>
        </div>

        <div class="navbar-nav ml-auto">
            <a class="nav-link" href="favorites.php"><i class="material-icons" style="color: black">favorite_border</i></a>

            <a href="/shoppingcart"
               class="nav-link <?php if(getUrl() === '/shoppingcart') echo 'active'; ?>">
                <i class="material-icons-outlined" style="color: black">
                    shopping_basket
                </i>
                <?php if(isset($_SESSION['shoppingcart']) && count($_SESSION['shoppingcart'])){?>
                <span
                        class="badge badge-light"><?= count($_SESSION[ 'shoppingcart' ]) ?>
                </span>
                <span class="sr-only">
                    items in basket
                </span>
                <?php } ?>
            </a>
            <div class="dropdown show">
                <a class="nav-link dropdown-toggle" href="" role="button" id="profiel" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false"><i class="material-icons">person</i></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profiel">
                    <?php if(!(\Classes\Login::isLoggedIn())) {?>
                        <a class="dropdown-item" href="/login">Inloggen</a>
                        <a class="dropdown-item" href="/register">Registreren</a>
                        <div class="dropdown-divider"></div>
                    <?php } ?>
                    <a class="dropdown-item" href="javascript:void(0)">Mijn profiel</a>
                    <?php if(\Classes\Login::isLoggedIn()) {?>
                    <a class="dropdown-item" href="/logout">Uitloggen</a
                    <?php } ?>
                </div>
        </div>
    </div>
</nav>

<script>
    function search() {
        window.event.preventDefault();
        let toSearch = document.getElementById('searchForm').value;
        window.location.href = `/search/${toSearch}`
    }
</script>