/*!
 * editeur.min.js
 * Fonctions nécessaires à l'édition / à la lecture d'un fichier
 *  - Composé de editeur.js, stats.js, general.js et tables.js
 *  - Requiere Jquery
 */

var contenu = {}; // Contenu du fichier
var fichiers = {}; // Liste des fichiers de l'utilisateur
var comptes = {}; // Liste des utilisateurs

$(document).ready(function() {
    // Récupère les infos globales
    $.getJSON('info', function(json) {
        fichiers = json.fichiers;
        comptes = json.comptes;

        for (var i in fichiers) {
            var element = $("<li><a></a></li>").addClass("rm_on_file_change");
            element.find("a").text(fichiers[i].nom).attr("href", "#" + fichiers[i].fichier);
            element.prependTo("#liste_fichiers");
        }
        
        $("#liste_fichiers>li>a:not(:last)").click(function(e) {
            ouvrir("fichier/" + $(e.currentTarget).attr("href").split("#")[1] + "/get");
        });
    });
    ouvrir("fichier/" + ancre() + "/json");

    $("#ajouter_ligne").attr("disabled", false);

    $("#recherche").keyup(filtrer);
    $("#ajouter_ligne").click(ajouterLigne);
    $("#envoyer").click(envoyer);
    $("#creerFichier").click(creer);

    $("#inserer").click(inserer);
    $("#ligne_ajout input").keypress(function(e) {
        if (e.which == 13)
            inserer();
    });
    
    initTris();
});

/* ********** Fonctions AJAX ********** */

/// Créer un nouveau fichier
function creer() {
    var info = {
        nom: $("#nomFichier").val(),
        partage: $("#priveFichier").is(":checked") ? "prive" : "public"
    };

    $.ajax({
        type: "GET",
        url: "fonctions/fichier.php?add=" + JSON.stringify(info),
        dataType: "text"
    }).success(function(fichier) {
        if( isErreur(JSON.parse(fichier, true)) ) {
            erreur(JSON.parse(fichier, true));
        }
        else {
            window.location.hash = "#" + fichier;
            ouvrir("fonctions/fichier.php?f=" + fichier);
        }
    }).error(function() {
        erreur({
            titre: "Echec de comunication avec le serveur.",
            contenu: "L'envoit des données au serveur a échoué. Réessayez plus tard."
        });
    });

    $("#fenCreer").modal("hide");
}

/// Récupérer un fichier
function ouvrir(fichier) {
    NProgress.start();
    $.getJSON(fichier, function(json) {
        contenu = json;
        $(".rm_on_file_change").remove();
        lire(contenu);
        NProgress.done();
    });
    $("#recherche").val("");
}

/// Envoyer le fichier courant
function envoyer() {
    $("#envoyer").removeClass("btn-danger btn-success").attr("disabled", true);
    $.ajax({
        type: "POST",
        url: "fichier.php?f=" + ancre(),
        data: "content=" + encodeURIComponent(JSON.stringify(contenu)),
        dataType: "text"
    }).success(function() {
        $("#envoyer").addClass("btn-success").attr("disabled", false);
    }).error(function() {
        $("#envoyer").addClass("btn-danger").attr("disabled", false);
        erreur({
            titre: "Echec de l'enregistrement !",
            contenu: "Impossible de comuniquer les modifications au serveur"
        });
    });
}

/* ********** Edition JSON ********** */

/// Insere une ligne dans le JSON
function inserer() {
    var d = $("#ligne_ajout .liste-date").val().split("/");
    var timestamp = new Date(d[2], d[1] - 1, d[0]);

    var ligne = {
        titre: $("#ligne_ajout .liste-titre").val(),
        date: timestamp / 1000,
        montant: parseFloat($("#ligne_ajout .liste-montant").val()),
        description: $("#ligne_ajout .liste-description").val(),
        createur: comptes.actuel
    };

    contenu.liste.unshift(ligne);

    actualiser();
    envoyer();

    $("#ajouter_ligne").attr("disabled", false);
    $("#ligne_ajout").hide();

    console.info("Ajout de ligne : ");
    console.info(ligne);
}

/* ********** Modification page ********** */

/// Affiche la ligne-formulaire au début de la liste
function ajouterLigne() {
    var ligne = $("#ligne_ajout");
    ligne.find("input.liste-date").bootstrapMaterialDatePicker({
        format: 'DD/MM/YYYY',
        lang: 'fr',
        time: false,
        cancelText: 'ANNULER'
    });
    ligne.find("input.liste-date").bootstrapMaterialDatePicker('setDate', moment());

    $("#ajouter_ligne").attr("disabled", true);
    ligne.show();
    $($(".input_ligne")[0]).focus();
}

/// Actualiser la page suite à une modification du JSON
function actualiser() {
    $(".ligne_info").remove();
    lire(contenu);
    filtrer();
}

/// Modifie la page par rapport à un nouveau JSON
function lire(json) {
    $(".doc_info.nom").text(json.nom);
    $(".doc_info.proprietaire_pseudo").text(comptes[json.proprietaire]);
    $(".dl.json").attr("href", "fonctions/fichier.php?raw=json&f=" + ancre());
    $(".dl.csv").attr("href", "fonctions/fichier.php?raw=csv&f=" + ancre()); 

    for (var j = 0 ; j < json.liste.length ; j++) {
        lireLigne(json.liste[j]);
        $("#liste .ligne_info:last").attr("ligne", j);
    }
    majStats();
    changerDates();
    $(".tt").tooltip();
    filtrer();
}

/// Ajoute une ligne
function lireLigne(ligneJson) {
    var ligne = $("#liste>tr:first").clone().show().addClass("rm_on_file_change ligne_info");
    for (var key in ligneJson) {
        ligne.find(".doc_info.liste-" + key).text(ligneJson[key]);
    }

    if (ligneJson.refuse === true)
        ligne.addClass("danger");
    else if (ligneJson.montant < 0)
        ligne.addClass("success");
    
    ligne.find(".icone_tr .refuse").click(refuser);
    ligne.find(".icone_tr .glyphicon-trash").click(supprimer);

    ligne.appendTo("#liste");
}

// Inverse l'attribut refuse sur la ligne déclanchée par l'evenement
function refuser(e) {
    var ligne = parseInt($(e.target).parent().parent().attr("ligne"));
    contenu.liste[ligne].refuse = !contenu.liste[ligne].refuse;

    actualiser();
    envoyer();
}

// Supprime la ligne déclanchant l'évenement
function supprimer(e) {
    var ligne = parseInt($(e.target).parent().parent().attr("ligne"));
    contenu.liste.splice(ligne,1);

    actualiser();
    envoyer();
}

function majStats() {
    /* Update l'affichage des stats
     * Entrée : lis la variable contenu
     * Sortie : la page (en particulier l'en-tête est modifiée)
     */
     
    var stats = statistiques(contenu);
    var ceMois = mois(moment().unix());
    
    $(".stats.tout.total").text(stats.total.total);
    $(".stats.tout.depense").text(stats.total.depense);
    $(".stats.tout.gain").text(stats.total.gain);
    $(".stats.mois.depense").text(stats.mois[ceMois].depense);
    $(".stats.mois.gain").text(stats.mois[ceMois].gain);
    
    $(".stats.date_modif").text(moment.unix(contenu.derniere_edition).fromNow());
    $(".stats.tout.mot").text(stats.total.mot);
    
    $(".stats.grosse_depense.mois").text(stats.mois[mois(moment().unix())].grosseDepense.montant + " €");
    $(".stats.grosse_depense.tout").text(stats.total.grosseDepense.montant + " €");
    $(".stats.gros_gain.mois").text(Math.abs(stats.mois[mois(moment().unix())].grosGain.montant) + " €");
    $(".stats.gros_gain.tout").text(Math.abs(stats.total.grosGain.montant) + " €");
    
    $(".stats.moyenne.depense").text(stats.moyenne.depense + " €");
}

/// Applique les filtres au tableau
function filtrer() {
    trier($(".table-triable")[0]);
    $("#liste>tr").each(function(i, e) {
        if (i > 1) { //Elimine la ligne de model et d'ajout
            var recherche = $("#recherche").val().toUpperCase();
            var texte = $(e).text().toUpperCase();


            if (texte.indexOf(recherche) == -1)
                $(e).hide();
            else
                $(e).show();
        }
    });
}

/// Remplacer les dates sous forme de timestamp par des vrais dates
function changerDates() {
    $(".time-date").each(function(i, e) {
        var timestamp = parseInt($(e).text());
        if (!isNaN(timestamp)) {
            $(e).text(moment(timestamp*1000).format("DD/MM/YYYY"));
        }
    });
}