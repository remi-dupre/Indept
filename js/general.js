function erreur(info) {
    var message = $("#liste-alertes div:first").clone().show().addClass("rm_on_file_change");
    message.find(".titre-alerte").text(info.titre);
    message.find(".contenu-alerte").text(info.contenu);
    message.appendTo("#liste-alertes");
}