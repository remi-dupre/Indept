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
        
        echo file_put_contents("../fichiers/$fichier.json", $nvContenu);
        return $nvContenu;
    }
?>