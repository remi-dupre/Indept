<?php
    function connection($login, $mdp) {
        $json = file_get_contents($root . "comptes/$login.json");
        if($json != false) {
            $json = json_decode($json, true);
            if($json["passe"] == $mdp) {
                $_SESSION["utilisateur"] = $json;
                return true;
            }
        }
        return false;
    }
?>