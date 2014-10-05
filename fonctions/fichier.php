<?php
    require_once("../php/fichiers.php");
    
    session_start();
    listerFichiers();
    
    if( !isset($_GET["f"]) )
        return;

    if( isset($_GET["content"]) ) {
        echo modif($_GET["f"], $_GET["content"]);
    }
    else {
        $r = array(
            "contenu" => json_decode(ouvre($_GET["f"]), true),
            "fichiers" => json_decode(listerFichiers(), true),
            "comptes" => listerComptes()
        );
        echo json_encode($r);
    }
?>