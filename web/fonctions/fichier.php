<?php
    require_once("../php/fichiers.php");
    require_once("../php/comptes.php");
    
    session_start();
    
    $erreurs = array();
    
    if( isset($_GET["add"]) ) { // Crée un fichier, en retourne le nom
        echo creer(json_decode($_GET["add"], true));
        return;
    }
    
    $r = array(
        "fichiers" => json_decode(listerFichiers(), true),
        "comptes" => listerComptes(),
        "erreurs" => array()
    );
    
    if( !isset($_SESSION["utilisateur"]) )
        $r["erreurs"][] = erreur("Vous n'êtes pas connecté.", "Connectez vous pour gérer des fichiers.", "warning");
    
    if( isset($_GET["f"]) && $_GET["f"] != "" ) {
        if( isset($_GET["raw"]) ) { // Obtention du fichier brut
            if( $_GET["raw"] == "json" )
                $r = ouvre($_GET["f"]);
            elseif( $_GET["raw"] == "csv" )
                $r = getCSV($_GET["f"]);
            echo $r;
            return;
        }
        
        if( isset($_GET["content"]) ) { // Modification
            $modifie = modif($_GET["f"], $_GET["content"]);
            if( isErreur($modifie) )
                $r["erreurs"][] = $modifie;
            else
                $r["contenu"] =  $modifie;
        }
        else { // Lecture classique
            $con = json_decode(ouvre($_GET["f"]), true);
            if( isErreur($con) )
                $r["erreurs"][] = $con;
            else
                $r["contenu"] = $con;
        }
    }
    
    echo json_encode($r);
?>