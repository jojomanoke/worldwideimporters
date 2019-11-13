<?php
$host = "localhost";
$databasename = "wideworldimporters";
$user = "root";
$pass = ""; //eigen password invullen
$port = 3306;


    $connection = new mysqli($host, $user, $pass, $databasename, $port);
    ?>

    <html lang="en">
    <head>
        <title>Search bar</title>
        <link rel="stylesheet" href="css/style_searchbar.css"/>
        <script type="text/javascript">
            function active() {
                let SearchBar = document.getElementById('SearchBar');

                if (SearchBar.value === 'Search...') {
                    SearchBar.value = '';
                    SearchBar.placeholder = 'Search...'
                }
            }

            function inactive() {
                let SearchBar = document.getElementById('SearchBar');

                if (SearchBar.value === '') {
                    SearchBar.value = 'Search...';
                    SearchBar.placeholder = ''
                }
            }
        </script>
    </head>
    <body>
    <form action="Searchbar_Test.php" method="GET" id="searchform">
        <input type="text" name="q" id="SearchBar" placeholder="" value="Search..."
                                              maxlength="25" autocomplete="off" onmousedown="active()"
                                              onblur="inactive()"/><input type="submit" id="searchBtn" value="zoek!"/>
    </form>
    <?php
    if(isset($_GET['q'])) {
    $q = $_GET['q'];
//    $connection = mysqli_connect($host, $user, $pass, $databasename, $port);

    $sql = "SELECT * From stockitems where StockItemName like '%$q%' or SearchDetails like '%$q%' ";     //zoek query //
    $result = $connection->query($sql);

    while ($row = $result->fetch_assoc()) {
        $naam = $row["StockItemName"];
        $stockitemid = $row["StockItemID"];
        $recretailprice = $row["RecommendedRetailPrice"];
        echo $stockitemid . " " . $naam . " " . $recretailprice . '<br />';
    }
    ?>

    </body>
    </html>
    <?php
     $result->free();
}

    $connection->close();
    ?>