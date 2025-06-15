<?php

//If the user click links (index.php?page=???) he will redirect to the pages.
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    
} else {
    $page = "error";
    
}


?>
