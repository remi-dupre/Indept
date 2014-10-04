function ouvrir(fichier) {
	$.getJSON(fichier, function(json) {
		for(var key in json) {
			console.inf(key + " : " + json[key]);
			$(".doc_info." + key).text(json[key]);
		}
		for(var i in json.liste) {
			var ligne = $("#liste>tr:first").clone().show();
			for(var key in json.liste[i]) {
				ligne.find(".doc_info.liste-" + key).text(json.liste[i][key]);
			}
			
			if(json.liste[i].montant < 0)
			    ligne.addClass("success");
			else if(json.liste[i].montant > 50)
			    ligne.addClass("danger");
			    
			ligne.appendTo("#liste");
		}
		
		$("#recherche").val("");
		changerDates();
	});
}

function filtrer() {
    $("#liste>tr").each(function(i, e) {
        if(i > 0) {
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
    ouvrir("example.json");
    
    $("#recherche").keyup(function(){
        filtrer();
    });
});