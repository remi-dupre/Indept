<?php
    require_once('../php/statistiques.php');

    function recap($json) {
        $nom_fichier = $json['nom'];
        $date_modif = date('d/m/Y', $json['derniere_edition']);
        extract( statistiques($json['liste']) );
        return "
            \\begin{itemize}
                \\item Nom du fichier : \\textbf{ $nom_fichier }
                \\item Dernière édition : \\textbf{ $date_modif }
                \\item Total : \\textbf{ $total € }
                \\begin{itemize}
                    \\item Dépensé : $depense €
                    \\item Encaissé : $gain €
                    \\item Nombre d'éléments : $nombre
                \\end{itemize}
                \\item Dépense par mois : \\textbf{ $moyenne_depense €} en $nb_mois mois
            \\end{itemize}
        ";
    }
    
    function detail($json) {
        $retour = '';
        $liste_mois = array();
        foreach( $json['liste'] as $i => $ligne ) {
            $mois = mktime(1, 1, 0, date("n", $ligne['date']), 1, date("Y", $ligne['date']) );
            if( !isset($liste_mois[$mois]) ) $liste_mois[$mois] = array();
            array_push($liste_mois[$mois], $ligne);
        }
        uksort($liste_mois);
        
        foreach( $liste_mois as $mois => $lignes ) {
            usort($lignes, "ordreLignes");
            $retour .= '
                \\begin{minipage}{\linewidth}
                    \\paragraph{ ' . date_MY($mois) . ' }' . detailListe($lignes) .
                '\\end{minipage} ~~\\\\~~\\\\
            ';
        }
        
        return $retour;
    }
    
    function detailListe($liste) {
        $stats = infos_mois($liste);
        $nb_lignes = count($liste);
        
        foreach( $liste as $i => $ligne ) {
            $lignes .= ligneTableau($ligne);
            if( $ligne['montant'] > 0 ) $depense += $ligne['montant'];
            else $encaisse -= $ligne['montant'];
        }
        
        return "
            \\hfill $stats ~~\\\\~~\\\\
            \\begin{tabularx}{\\textwidth}{| l | c | c | X |}
                \\hline $lignes
            \\end{tabularx}
        ";
    }
    
    function infos_mois($liste) {
        $stats = statistiques($liste);
        
        return 'Dépensé : '.$stats['depense'].'€, Encaissé : '.$stats['gain'].'€, total : '.$stats['total'].'€';
    }
    
    function ligneTableau($ligne) {
        $nom = tex_format( $ligne['titre'] );
        $montant = $ligne['montant'];
        $date = date('d/m/Y', $ligne['date']);
        $description = tex_format( $ligne['description'] );
        $couleur = $montant < 0 ? "gain" : "normal";
        return " \\rowcolor{".$couleur."} $nom & $montant € & $date & $description \\\\ \\hline ";
    }
    
    function ordreLignes($ligneA, $ligneB) {
        return $ligneA['date'] - $ligneB['date'];
    }
    
    function date_MY($timestamp) {
        $mois = array('', 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
        return $mois[ date('n', $timestamp) ] . date(' Y', $timestamp);
    }
    
    function tex_format($str) {
        $str = str_replace('&', '\&', $str);
        return $str;
    }
?>