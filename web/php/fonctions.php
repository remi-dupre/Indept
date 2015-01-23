<?php
    // Verifie que le minimum de champs existe dans un tableau
    function minEntrees($array, $entrees) {
        foreach( $entrees as $i => $val ) {
            if( !isset($array[$val]) || empty($array[$val]) || is_null($array[$val]) ) {
                return false;
            }
        }
        return true;
    }
    
    // Crée un array de type erreur
    function erreur( $titre = "Erreur", $description = "Une erreur indéterminée a eu lieu.", $type = "danger", $from="php") {
        return array(
            "titre" => $titre,
            "contenu" => $description,
            "type" => $type,
            "from" => $from,
			"element" => "erreur"
        );
    }
    
    // Vérifie que l'array passé en argument est une erreur
    function isErreur( $array ) {
        $corps = array("titre", "contenu", "type", "from", "element");
        if(minEntrees($array, $corps)) {
			return $array["element"] == "erreur";
		}
		return false;
    }
?>