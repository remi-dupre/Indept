/*
 * Fonctions liés aux tableaux :
 *  - Tris
 */
 
 function initTris() {
     /* Initialise tous les évenenements pour les tris */
     
    $(".triable").click(selectionTris);
    $(".table-triable").each(trier);
 }
 
 function selectionTris(e) {
     /* Selectionne la colone de l'élément déclancheur de l'évenement
      * Entrée : e un évenement JQuery
      * Sortie :
          - l'en-tête du tableau est modifiée
          - les paramêtres ordre et sens du tableau sont modifiés */
          
    var element = $( e.target );
    if( element.parents(".triable").length > 0 ) {
        element = $( element.parents(".triable")[0] );
    }
    var tableau = $( element.parents(".table-triable")[0] );
    var index = tableau.find(".triable").index(element);
    
    var ordre = parseInt(tableau.attr("ordre")) || 0;
    var sens = tableau.attr("sens") == "true";
    
    if( index == ordre ) {
        tableau.attr("sens", !sens);
    }
    else {
        tableau.attr("ordre", index);
        tableau.attr("sens", true); // false pour la croissance
    }
    
    trier(tableau);
 }
 
 function trier(tableau) {
     /* Effectue le tris sur un tableau passé en argument
        Entrée : tableau : le tableau a trier, format n'importe quoi
        Sortie : le tableau est modifié */
        
    tableau = $(tableau);
    var ordre = parseInt(tableau.attr("ordre")) || 0;
    var sens = tableau.attr("sens") === "true";
    var element = $( tableau.find(".triable")[ordre] );
    
    // Pour faire Jolis
    var croissant = $('<span class="glyphicon glyphicon-menu-up tris" aria-hidden="true"></span>');
    var decroissant = $('<span class="glyphicon glyphicon-menu-down tris" aria-hidden="true"></span>');
    
    tableau.find(".tris").remove();
    if( sens === false ) {
        croissant.prependTo(element);
    }
    else {
        decroissant.prependTo(element);
    }
        
    // Application du tri
    var selecteur = tableau.attr("selecteur") || "";
    var colone = tableau.find("th").index(element);
    
    var corps = tableau.find("tbody");
    var lignes = corps.find("tr"+selecteur);
    lignes.sort(function(a, b) {
        a = $($(a).find("td")[colone]);
        b = $($(b).find("td")[colone]);
        var texta = a.text().toLocaleLowerCase();
        var textb = b.text().toLocaleLowerCase();
        
        if( !isNaN(parseFloat(texta)) && !isNaN(parseFloat(textb)) ) {
            texta = parseFloat(texta);
            textb = parseFloat(textb);
        }
        var f = "DD/MM/YYYY";
        if( a.hasClass("time-date") && b.hasClass("time-date") ) {
            console.log("daniel ! ");
            texta = moment(texta, f).valueOf();
            textb = moment(textb, f).valueOf();
        }
        
        if(sens) return texta > textb;
        else     return textb > texta;
    }).appendTo(corps);
 }