<?php
    function statistiques($lignes) {
        return array(
            "gain" => gain($lignes),
            "depense" => depense($lignes),
            "total" => total($lignes),
            "nombre" => count($lignes),
            "nb_mois" => nb_mois($lignes),
            "moyenne_depense" => round(depense($lignes) / nb_mois($lignes), 2)
        );
    }
    
    function gain($liste) {
        $encaisse = 0;
        foreach( $liste as $i => $ligne ) {
            if( $ligne['montant'] < 0 )
                $encaisse -= $ligne['montant'];
        }
        return $encaisse;
    }
    
    function depense($liste) {
        $depense = 0;
        foreach( $liste as $i => $ligne ) {
            if( $ligne['montant'] > 0 )
                $depense += $ligne['montant'];
        }
        return $depense;
    }
    
    function total($liste) {
        return depense($liste) - gain($liste);
    }
    
    function nb_mois($liste) {
        $liste_mois = array();
        foreach( $liste as $i => $ligne ) {
            $mois = mktime(1, 1, 0, date("n", $ligne['date']), 1, date("Y", $ligne['date']) );
            if( !isset($liste_mois[$mois]) )
                $liste_mois[$mois] = array();
        }
        return count($liste_mois);
    }
?>