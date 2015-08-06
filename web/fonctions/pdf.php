<?php
    require_once("../php/fichiers.php");
    require_once("../php/latex.php");
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
?>