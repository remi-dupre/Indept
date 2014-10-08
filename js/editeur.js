var contenu = {};   // Le contenu du json
var fichiers = {};
var comptes = {};

function ancre() {
    var ancre = window.location.hash;
    ancre = ancre.substring(1,ancre.length);
    return ancre;
}

function envoyer() {
    $("#envoyer").removeClass("btn-danger btn-success").attr("disabled", true);
    $.ajax({
        type: "GET",
        url: "fonctions/fichier.php?f=" + ancre() + "&content=" + JSON.stringify(contenu, null, "\t"),
        dataType: "text"
    }).success(function(){
        $("#envoyer").addClass("btn-success").attr("disabled", false);
    }).error(function(){
        $("#envoyer").addClass("btn-danger").attr("disabled", false);
    });
}

function ouvrir(fichier) {
	$.getJSON(fichier, function(json) {
	    contenu = json.contenu;
	    fichiers = json.fichiers;
	    comptes = json.comptes;
	    
	    $(".rm_on_file_change").remove();
	    
	    lire(contenu);
	    for(var i in fichiers) {
	        var element = $("<li><a></a></li>").addClass("rm_on_file_change");
	        element.find("a").text(fichiers[i].nom).attr("href", "#" + fichiers[i].fichier);
	        element.appendTo("#liste_fichiers");
            $("#liste_fichiers>li>a").click(function(e){
                ouvrir("fonctions/fichier.php?f=" + $(e.currentTarget).attr("href").split("#")[1]);
            });
	    }
	});
	$("#recherche").val("");
}

function lire(json) {
	for(var key in json) {
		console.inf(key + " : " + json[key]);
		$(".doc_info." + key).text(json[key]);
	}
	$(".doc_info.receveur_pseudo").text(comptes[json.receveur]);
	$(".doc_info.donneur_pseudo").text(comptes[json.donneur]);
	$(".dl.json").attr("href", "fonctions/fichier.php?raw=json&f=" + ancre());
	$(".dl.csv").attr("href", "fonctions/fichier.php?raw=csv&f=" + ancre());
	
	for(var i in json.liste) {
		lireLigne(json.liste[i]);
	}
	
	changerDates();
}

function lireLigne(ligneJson) {
	var ligne = $("#liste>tr:first").clone().show().addClass("rm_on_file_change ligne_info");
	for(var key in ligneJson) {
		ligne.find(".doc_info.liste-" + key).text(ligneJson[key]);
	}
	
	if(ligneJson.refuse === true)
	    ligne.addClass("danger");
	else if(ligneJson.montant < 0)
	    ligne.addClass("success");
	
	var iconeRefuse = $("<span class='glyphicon'</span>");
	if(ligneJson.refuse === true)
	    iconeRefuse.addClass("glyphicon-remove-sign");
	else
	    iconeRefuse.addClass("glyphicon-ok-sign");
	iconeRefuse.appendTo(ligne.find(".doc_info.status_icone"));
	    
	ligne.appendTo("#liste");
}

function ajouterLigne() {
    var ligne = $("#ligne_ajout");
    
    ligne.find("input.liste-date").datepicker({
        dateFormat: "dd/mm/yy",
        beforeShow: function() {
            setTimeout(function(){
                $("#ui-datepicker-div").css("z-index", 99999999999);
            }, 0);
        }
    });
    
    $("#ajouter_ligne").attr("disabled", true);
    ligne.show();
    $($(".input_ligne")[0]).focus();
}

function inserer() {
    var d = $("#ligne_ajout .liste-date").val().split("/");
    var timestamp = new Date(d[2], d[1]-1, d[0]);
    
    var ligne = {
        titre : $("#ligne_ajout .liste-titre").val(),
        date : timestamp/1000,
        montant : parseFloat( $("#ligne_ajout .liste-montant").val() ),
        description : $("#ligne_ajout .liste-description").val()
    };
    
    contenu.liste.unshift(ligne);
    
    $(".ligne_info").remove();
    lire(contenu);
    filtrer();
    
    $("#ajouter_ligne").attr("disabled", false);
    $("#ligne_ajout").hide();
    
    console.info("Ajout de ligne : ") ; console.info(ligne);
    envoyer();
}

function filtrer() {
    $("#liste>tr").each(function(i, e) {
        if(i > 1) { //Elimine la ligne de model et d'ajout
            var recherche = $("#recherche").val().toUpperCase();
            if( $(e).text().toUpperCase().indexOf(recherche) == -1)
                $(e).hide();
            else
                $(e).show();
        }
    });
}

function changerDates() {
    $(".time-date").each(function(i, e){
        var timestamp = parseInt($(e).text());
        if(!isNaN(timestamp)) {
            var date = new Date(timestamp*1000);
            $(e).text(date.toLocaleDateString());
            $(e).attr("title",date.toDateString());
        }
    });
}

$(document).ready(function() {
    ouvrir("fonctions/fichier.php?f=" + ancre());
    
    $("#ajouter_ligne").attr("disabled", false);
    $("#fenDl").modal({show : false});
    $("#btnDl").click(function(){ $("#fenDl").modal("show") });
    
    $("#recherche").keyup(filtrer);
    $("#ajouter_ligne").click(ajouterLigne);
    $("#envoyer").click(envoyer);
    
    $("#inserer").click(inserer);
    $("#ligne_ajout input").keypress(function(e){
        if(e.which == 13)
            inserer();
    });
});