<?php

if(!isset($_SESSION)){
    session_start();
}







include( 'resources/classes/Database.php' );
include( 'resources/helpers/functions.php' );
include( 'resources/classes/Query.php' );
include( 'resources/config/globals.php' );
include( 'resources/includes/head.php' );
include( 'resources/includes/navbar.php' );
include( 'resources/includes/categoryBar.php' );
include( 'resources/includes/scripts.php' );

?>
    <div class="container">
        <?php
        if ( !isset($_GET[ 'search' ]) ) {
            switch ( $_GET[ 'page' ] ) {
                default:
                case 'home':
                    include 'resources/pages/home.php';
                    break;

                case 'categories':
                    include 'resources/pages/categories/show.php';
                    break;

                case 'products':
                    include 'resources/pages/products/show.php';
                    break;
    
                case 'editProduct':
                    include 'resources/pages/products/edit.php';
                    break;

                case 'shoppingcart':
                    include 'resources/pages/shoppingcart.php';
                    break;
            }
        } else {
            include 'resources/pages/search.php';
        }
        ?>
    </div>
<?php
include( 'resources/includes/footer.php' );

?>