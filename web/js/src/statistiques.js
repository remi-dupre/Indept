/* 
 * Etudie un fichier indept pour en retourner des caractéristiques statistiques
 */

function statistiques(contenu) {
    /* Calcul des statistiques d'un fichier
     * Entrée :
     *  - contenu : L'array associé aux données du fichier
     * Sortie : (array)
     *  - mois :
     *     - "un mois quelconque"
     *        --> voir calculsSurListe(...)
     *  - total
     *        --> voir calculsSurListe(...)
     *  - moyenne : (moyenne / mois)
     *        --> voir calculsSurListe(...) (depense, gain , total)
     */
     
     
     var statsTotal = calculsSurListe(contenu.liste);
     var listeMois = classerParMois(contenu.liste);
     var statsMois = {};
     for(var mois in listeMois) {
         statsMois[mois] = calculsSurListe(listeMois[mois]);
     }
     
     var nbMois = Object.keys(listeMois).length;
     var statsMoyenne = {
         depense : arrondis( statsTotal.depense / nbMois ),
         gain : arrondis( statsTotal.gain / nbMois ),
         total : arrondis( statsTotal.total / nbMois )
     };
     
     var stats = {
         mois : statsMois,
         moyenne : statsMoyenne,
         total : statsTotal
     };
     return stats;
}

function calculsSurListe(liste) {
    /* Donne les calculs sur une liste donnée
     * Entrée : une liste de lignes
     * Sortie : (array)
     *   - depense
     *   - gain
     *   - total
     */
     
    var stats = {
        depense:0 , gain:0 , total:0 ,
        grosseDepense : {},
        grosGain : {},
        mot : ""
    };
    var texte = "";
    for(var i in liste) {
        if( !liste[i].refuse) {
            var val = arrondis(liste[i].montant);
            stats.total += val;
            if( val > 0 ) stats.depense += val;
            else stats.gain += Math.abs(val);
        }
        texte += " " + liste[i].titre.toLowerCase() + " " + liste[i].description.toLowerCase();
    }
    for(i in stats) { // Arrondis des valeurs numériques
        stats[i] = arrondis(stats[i]);
    }
    
     
    liste.sort(function(a, b) {
        if(a.refuse) return 1;
        else if(b.refuse) return -1;
        
        return b.montant - a.montant;
    });
    
    var motsTries = ranger(texte.split(" "));
    motsTries = motsTries.filter(function(mot){
        return mot.length > 3;
    });
    stats.mot = motsTries[0];
    
    if( liste.length > 0 && liste[0].montant > 0 ) stats.grosseDepense = liste[0];
    else stats.grosseDepense = {montant:0};
    if( liste.length > 0 && liste[liste.length-1].montant < 0 ) stats.grosGain = liste[liste.length-1];
    else stats.grosGain = {montant:0};
    
    return stats;
}

function classerParMois(liste) {
    /* Sépare les différents éléments de contenu.liste
     * Entrée :
     *  - contenu : une liste de lignes
     * Sortie :
     *  - listeClassee : un array dans lequel les elements de liste sont rangés par mois
     */
    
    var listeClassee = {};
    listeClassee[mois(moment().unix())] = []; // Toujours quelque chose sur le mois courrant
    for (var i in liste) {
        var date = mois(liste[i].date);
        
        if(listeClassee[date] === undefined) {
            listeClassee[date] = [];
        }
        listeClassee[date].push(liste[i]);
    }
    return listeClassee;
}

function mois(date) {
    /* Retourne la valeur du mois de la date entrée
     * Entrée :
     *  - date : la date à étudier (timestamp)
     * Sortie :
     *  - mois : la valeur du mois
     */
     
    date = moment.unix(date);
    return date.year()*100 + date.month();
}