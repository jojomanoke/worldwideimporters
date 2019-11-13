<?php
include( 'resources/config/globals.php' );
include( 'resources/helpers/functions.php' );
include( 'resources/includes/head.php' );
include( 'resources/includes/navbar.php' );
include( 'resources/includes/searchbarTest.php');
include( 'resources/includes/categoryBar.php');

if(!isset($_GET['search'])) {
    switch(activeUrl()){
        default:
        case '/home':
            include 'resources/pages/home.php';
            break;
    }
} else {
    include 'resources/pages/search.php';
}



include( 'resources/includes/footer.php' );