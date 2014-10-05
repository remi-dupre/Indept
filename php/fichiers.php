<?php
    function ouvre($fichier) {
        $contenu = file_get_contents("../fichiers/$fichier.json");
        $json = json_decode($contenu, true);
        
        $est_proprietaire = $json["donneur"] == $_SESSION["utilisateur"]["login"] || $json["receveur"] == $_SESSION["utilisateur"]["login"];
        if($est_proprietaire || $json["partage"] == "public") {
            return $contenu;
        }
        
        return false;
    }
    
    
    function modif($fichier, $nvContenu) {
        $contenu = ouvre($fichier);
        $jsonAnc = json_decode($contenu, true);
        $jsonNv  = json_decode($nvContenu, true);
        $est_proprietaire = $jsonAnc["donneur"] == $_SESSION["utilisateur"]["login"] || $jsonAnc["receveur"] == $_SESSION["utilisateur"]["login"];
        
        if($contenu == false)
            return "Erreur : Impossible d'ouvrir le fichier";
        if(!$est_proprietaire)
            return "Erreur : Permission non accordée";
            
        if( $json["receveur"] == $_SESSION["utilisateur"]["login"] ) {
            // Virer les trucs interdits
        }
        
        file_put_contents("../fichiers/$fichier.json", $nvContenu);
        return $nvContenu;
    }
    
    
    function listerFichiers() {
        $liste = array();
        $dir = opendir("../fichiers");
        while($file = readdir($dir)) {
            if($file != "." && $file != "..") {
                $fichier = explode(".", $file)[0];
                $proprio = explode("-", $fichier);
                if( in_array($_SESSION["utilisateur"]["login"], $proprio) ) {
                    $liste[] = array(
                        "fichier" => $fichier,
                        "nom" => json_decode(ouvre($fichier), true)["nom"]
                    );
                }
            }
        }
        closedir($dir); 
        return json_encode($liste);
    }
    
    function listerComptes() {
        $liste = array();
        $dir = opendir("../comptes");
        while($file = readdir($dir)) {
            if($file != "." && $file != "..") {
                $fichier = explode(".", $file)[0];
                $liste[$fichier] = json_decode(file_get_contents("../comptes/$file"), true)["pseudo"];
            }
        }
        closedir($dir); 
        return $liste;
    }
?>