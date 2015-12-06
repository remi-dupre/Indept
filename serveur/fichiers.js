var fs = require('fs');
var comptes = require('./comptes');

var path_fichiers = '../fichiers/';

function droit(fichier, session, callback) {
    /* Vérifie les droits de l'utilisateur connecté (ou non) sur le fichier
     * Entrées :
     *  - fichier : le fichier à lire (pas de chemin relatif)
     *  - session : la session courante
     * Appel callback(droit) :
     *  - droit == 0 : ne peut pas lire le fichier
     *  - droit == 1 : peut lire le fichier
     *  - droit == 2 : peut lire et écrire le fichier
     */
    fs.readFile(path_fichiers + fichier, 'utf-8', function(err, data) {
        if(err) {
            console.log(err);
            callback(0);
        }
        else {
            data = JSON.parse(data);
            if( !comptes.estConnecte(session) || session.login !== data.proprietaire ) {
                if( data.partage === 'public' ) callback(1);
                else callback(0);
            }
            else callback(2);
        }
    });
}

function ouvrir(fichier, session, callback) {
    /* Ouvre le fichier
     * Entrées :
     *  - fichier : le fichier à lire (pas de chemin relatif)
     *  - session : la session courante
     * Appel callback(contenu) (déjà parsé)
     */
    droit(fichier, session, function(droits) {
        if(droits == 0) {
            console.log("Pas de droits sur le fichier " + fichier);
            callback({});
        }
        else {
            fs.readFile(path_fichiers + fichier, 'utf-8', function(err, data) {
                if(err) console.log(err);
                else {
                    data = JSON.parse(data);
                    callback(data);
                }
            });
        }
    });
}

function lister(session, callback) {
    /* Retourne la liste des fichiers accessibles par l'utilisateur courrant
     * Appel callback(fichiers) où fichiers est un array :
     *  - fichier : le fichier
     *  - nom : le nom à afficher
     *  - proprio : true si on a les droits d'écriture
     */
    var retour = [];
    var traitement = 1; // Quand il vaut 0 c'est que c'est terminé
    fs.readdir(path_fichiers, function(err, files) {
        if(err) console.log(err);
        else {
            for(var f in files) {
                droit(files[f], session, function(droit) {
                    if(droit >= 1) {
                        traitement++;
                        ouvrir(files[f], session, function(fdata) {
                            traitement--;
                            retour.push({
                                fichier: files[f],
                                nom: fdata.nom,
                                proprio: droit === 2
                            });
                            if(traitement == 0) {
                                callback(retour);
                            }
                        });
                    }
                });
            }
            traitement--;
        }
    });
}

/* *** Fonctions d'administration *** */

function update(fichier, callback) {
    /* Verifie la version du format de fichier
     * Si le fichier est obsolete, effectue la mise a jours
     * Sortie : appel callback :
     *  - true si le fichier est modifie
     */
    fs.readFile(path_fichiers + fichier, 'utf-8', function(err, data) {
        if(err) console.log(err);
        else {
            data = JSON.parse(data);
            if ( typeof data.version === "undefined" ) {
                // Version 0
                data.minid = 0;
                for(var l in data.liste) {
                    data.liste[l].id = data.minid;
                    data.minid++;
                }
                data.version = 1;
            }
            else { // Aucune modification
                callback(false);
                return;
            }
            fs.writeFile(path_fichiers + fichier, JSON.stringify(data), function (err) {
                if (err) console.log(err);
                callback(true);
            });
        }
    });
}

function chargerFichers() {
    /* Effectue un listing des fichiers
     * Les update si necessaire
     */
    fs.readdir(path_fichiers, function(err, files) {
        if(err) console.log(err);
        else {
            console.log(files.length + " fichiers");
            for(var f in files) {
                fichier = files[f];
                fs.readFile(path_fichiers + fichier, 'utf-8', function(err, data) {
                    if(err) console.log(err);
                    else {
                        data = JSON.parse(data);
                        console.log(fichier + " - " + data.nom + " : " + data.proprietaire);
                        update(fichier, function(change) {
                            if( change ) console.log(fichier + " a été mis à jours");
                        });
                    }
                });
            }
        }
    });
}

exports.charger = chargerFichers;
exports.ouvrir = ouvrir;
exports.lister = lister;