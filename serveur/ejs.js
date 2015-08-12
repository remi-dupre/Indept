var EJS = require('ejs');
var fs = require('fs');

function ouvrirAsync(fichier, data, callback) {
    fs.readFile(fichier, function(err, str) {
        if(err) console.log(err);
        else {
            var contenu = EJS.render(str.toString(), data);
            callback(contenu);
        }
    });
}

function ouvrir(res, fichier, data) {
    ouvrirAsync(fichier, data, function(data) {
        res.end(data);
    });
}

exports.ejs = EJS;
exports.ouvrir = ouvrir;