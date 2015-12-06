function dataToCSV(data) {
    /* Convertis le contenu (format fichier decodé)
     * Entrée : data (type objet)
     * csv : csv (type string)
     */
    var csv = data.nom + ';' + data.derniere_edition + ';' + data.partage + ';' + data.proprietaire + '\n';
    for(var key in data.liste[0]) {
        csv += key + ';';
    }
    for(var i in data.liste) {
        csv += '\n';
        for(var key in data.liste[i]) {
            csv += data.liste[i][key] + ';';
        }
    }
    return csv;
}

exports.toCSV = dataToCSV;