<?php
    include("../php/fichiers.php");
    
    session_start();
    
    if( !isset($_GET["f"]) )
        return;

    if( isset($_GET["content"]) ) {
        echo modif($_GET["f"], $_GET["content"]);
    }
    else {
        echo ouvre($_GET["f"]);
    }
?>