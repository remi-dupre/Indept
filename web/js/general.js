/*
 * Fonctions générales liées à la page
 */

/// Retourne le contenu de l'ancre
function ancre() {
    var hash = window.location.hash;
    hash = hash.substring(1, hash.length);
    return hash;
}

/// Vérifie que l'array passé en argument est de type erreur
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

/// Calcul un arrondis aux dixièmes
function arrondis(nombre) {
    return Math.round(nombre * 100) / 100;
}

function ranger(liste) {
    /* Compte les occurences
     * Entrée : une liste d'éléments quelconques
     * Sortie : une liste des éléments par ordre croissant du nombre d'occurence
     */
     
    var occurences = {};
    var elements = [];
    for(var i in liste) {
        if(!occurences[liste[i]]) {
            occurences[liste[i]] = 0;
            elements.push(liste[i]);
        }
        occurences[liste[i]]++;
    }
    elements.sort(function(a, b) {
        return occurences[b] - occurences[a];
    });
    return elements;
}