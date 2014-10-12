<?php
    require_once("../php/fichiers.php");
    require_once("../php/comptes.php");
    
    session_start();
    
    if( isset($_GET["add"]) ) {
        echo creer(json_decode($_GET["add"], true));
        return;
    }
    
    $r = array(
        "fichiers" => json_decode(listerFichiers(), true),
        "comptes" => listerComptes()
    );
    
    if( isset($_GET["f"]) && $_GET["f"] != "" ) {
        if( isset($_GET["raw"]) ) {
            if( $_GET["raw"] == "json" )
                $r = ouvre($_GET["f"]);
            echo $r;
            return;
        }
        
        if( isset($_GET["content"]) ) {
            $r["contenu"] =  modif($_GET["f"], $_GET["content"]);
        }
        else {
            $r["contenu"] = json_decode(ouvre($_GET["f"]), true);
        }
        $r["stats"] = stats($_GET["f"]);
    }
    
    echo json_encode($r);
?>