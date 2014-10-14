<?php
    function connection($login, $mdp) {
        $json = file_get_contents($root . "comptes/$login.json");
        if($json != false) {
            $json = json_decode($json, true);
            if($json["passe"] == crypt($mdp, $json["passe"])) {
                $_SESSION["utilisateur"] = $json;
                return true;
            }
        }
        return false;
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
    
    function creerCompte($entree) {
        $entreeMinimum = array("login", "pseudo", "passe", "email");
        $infos = array();
        
        if( file_exists("comptes/".$entree["login"].".json", $json) )
            return false;
        if( $entree["passe"] != $entree["pwd_conf"] )
            return false;
            
        foreach($entreeMinimum as $champ) {
            if( $entree[$champ] != "" )
                $infos[$champ] = $entree[$champ];
            else
                return false;
        }
        $infos["creation_date"] = time();
        
        $infos["passe"] = crypt( $infos["passe"] );
        $json = json_encode($infos, JSON_PRETTY_PRINT);echo "$json";
        file_put_contents("comptes/".$infos["login"].".json", $json);

        return true;
    }
?>