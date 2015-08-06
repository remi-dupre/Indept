<?php
    require_once("../php/fichiers.php");
    session_start();
    setlocale(LC_TIME, "fr_FR");
    
    $id = rand();
    
    $tex = file_get_contents('facture.tex');
    $json = json_decode( ouvre( $_GET['f'] ), true );
    
    $tex = str_replace('%_RECAP_%', recap($json), $tex);
    $tex = str_replace('%_DETAIL_%', detail($json), $tex);
    
    file_put_contents("facture$id.tex", $tex);
    exec("xelatex facture$id.tex");
    
    $file = "facture$id.pdf";
    $filename = 'indept-remi.pdf';
    
    header('Content-type: application/pdf');
    header('Content-Disposition: inline; filename="' . $filename . '"');
    header('Content-Transfer-Encoding: binary');
    header('Content-Length: ' . filesize($file));
    header('Accept-Ranges: bytes');
    @readfile($file);
    
    exec("rm facture$id.*");
    
    function recap($json) {
        $nom_fichier = $json['nom'];
        $date_modif = date('d/m/Y', $json['derniere_edition']);
        return "
            \\begin{itemize}
               \\item Nom du fichier : \\textbf{ $nom_fichier }
               \\item Dernière édition : \\textbf{ $date_modif }
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
            $retour .= '\\paragraph{ ' . date("F Y", $mois) . ' }' . detailListe($lignes);
        }
        
        return $retour;
    }
    
    function detailListe($liste) {
        $lignes = '';
        $depense = 0;
        $encaisse = 0;
        $nb_lignes = count($liste);
        
        foreach( $liste as $i => $ligne ) {
            $lignes .= ligneTableau($ligne);
            if( $ligne['montant'] > 0 ) $depense += $ligne['montant'];
            else $encaisse -= $ligne['montant'];
        }
        
        return "
            Dépensé : $depense €, Encaissé : $encaisse €, Entrées : $nb_lignes ~~\\\\~~\\\\
            \\begin{tabularx}{\\textwidth}{| l | c | c | X |}
                \\hline $lignes
            \\end{tabularx}
        ";
    }
    
    function ligneTableau($ligne) {
        $nom = tex_format( $ligne['titre'] );
        $montant = $ligne['montant'];
        $date = date('d/m/Y', $ligne['date']);
        $description = tex_format( $ligne['description'] );
        return " $nom & $montant € & $date & $description \\\\ \\hline ";
    }
    
    function ordreLignes($ligneA, $ligneB) {
        return $ligneA['date'] - $ligneB['date'];
    }
    
    function ordreMois($listeA, $listeB) {
        return $listeA[0]['date'] - $listeB[0]['date'];
    }
    
    function tex_format($str) {
        $str = str_replace('&', '\&', $str);
        return $str;
    }
?>