/*!
 * Gestion de la page d'accueil
 */
 
var fichiers = {};
var fichiersRecus = 0;

$(document).ready(function() {
    NProgress.start();
    $.getJSON("action/lister", function(json) {
        fichiers = json;
        NProgress.set(0.3);
        if(fichiers.length === 0) NProgress.done();
        for( var i in fichiers ) {
            $.getJSON("fichier/" + fichiers[i].fichier + "/json", lire);
        }
    });
    
    $("#quickadd>i").click(function(){
        if( !$("#quickadd").hasClass("expend") ) {
            $("#quickadd").addClass("expend");
        }
    });
    
    $("#quickadd>.expendable-content .expendable-close").click(function(){
            $("#quickadd").removeClass("expend");
    });
});

function lire(json) {
    /* Lis le json donné et crée la carte associée
     * Entrée : un array
     * Sortie : la page est modifiée
     */
    NProgress.inc(0.6/fichiers.length);
    fichiersRecus++;
    if(fichiersRecus == fichiers.length) NProgress.done();
    
    var stats = statistiques(json);
    var element = $(".container-carte.model").clone().removeClass("model");
    
    var fichier = "";
    for( var i in fichiers ) {
        if( json.nom == fichiers[i].nom ) {
            fichier = fichiers[i].fichier;
        }
    }
    element.attr("href", "reader.php#"+fichier);
    element.click(function(e){
        window.open($($(e.target).parents(".container-carte")).attr("href"), "_self");
    });
    
    element.find(".file-info.nom").text(json.nom);
    element.find(".file-info.derniere_modif").text(moment(json.derniere_edition*1000).fromNow());
    element.find(".file-info.total.toujours").text(stats.total.total);
    element.find(".file-info.total.mois").text(stats.moyenne.total);
    element.find(".file-info.lignes").text(json.liste.length);
    element.find(".file-info.mot").text(stats.total.mot);
    
    $("#liste-fichiers").append(element);
    $.material.ripples();
}