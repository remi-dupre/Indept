/*
 * Fonctions générales liées à la page
 */

/// Retourne le contenu de l'ancre
function ancre() {
    var hash = window.location.hash;
    hash = hash.substring(1, hash.length);
    return hash;
}

function isErreur(array) {
    return typeof array.titre !== "undefined" && typeof array.contenu !== "undefined" && typeof array.type !== "undefined" && typeof array.from !== "undefined" ;
}

/// Ajoute une erreur à la liste
function erreur(info) {
    var message = $("#liste-alertes div:first").clone().show().addClass("rm_on_file_change");
    message.find(".titre-alerte").text(info.titre);
    message.find(".contenu-alerte").text(info.contenu);
    message.appendTo("#liste-alertes");
}