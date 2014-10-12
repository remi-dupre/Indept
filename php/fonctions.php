<?php
    function minEntrees($array, $entrees) {
        // Verifie que le minimum de champs existe dans un tableau
        foreach( $entrees as $i => $val ) {
            if( !isset($array[$val]) || empty($array[$val]) || is_null($array[$val]) ) {
                return false;
            }
        }
        return true;
    }
?>