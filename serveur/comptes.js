var bcrypt = require('bcrypt');
var fs = require('fs');

function randPass(taille) {
    /* Génère une chaine de caractère aléatoire */
    taille = taille || 15;
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for (var i = 0; i < taille; i++)
        text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
}

function estConnecte(session) {
    /* Vérifie que l'utilisateur est connecté
     *  - Sortie : S'il n'est pas connecté, retourne false, sinon true
     *  - Entrée : la session
     */
    return typeof session.login !== 'undefined';
}

function connection(infos, session, callback) {
    /* Connecte l'utilisateur
     * Entrées :
     *  - infos : les infos de connection ('login', 'passe')
     *  - session : la session à modifier
     * Sortie :
     *  - true si la connection est réussie
     */
    callback = callback || function(){};
    fs.readFile('../comptes/' + infos.login + '.json', function(err, data) {
        if(err) {
            console.log(err);
            callback(false);
        }
        else {
            var infosUtilisateur = JSON.parse(data);
            bcrypt.compare(infos.passe, infosUtilisateur.passe, function(err, res) {
                if(err) {
                    console.log(err);
                    callback(false);
                }
                else {
                    if(res) { // On a réussis à se connecter
                        session.login = infosUtilisateur.login;
                        session.pseudo = infosUtilisateur.pseudo;
                        session.email = infosUtilisateur.email;
                    }
                    callback(res);
                }
            });
        }
    });
}

function creerCompte(login, pseudo, passe, email, callback) {
    callback = callback || function(){};
    bcrypt.hash(passe, 10, function(err, hash) {
        if(err) console.log(err);
        else {
            var json = JSON.stringify({
                'login': login,
                'pseudo': pseudo,
                'passe': hash,
                'email': email
            }, null, 2);
            
            fs.mkdir('../comptes', function(err) {
                if(err && err !== 'EEXIST')
                    console.log('EEXIST');
                else {
                    fs.writeFile('../comptes/' + login + '.json', json, function(err) {
                        if (err)
                            console.log(err);
                        else callback();
                    });
                }
            });
        }
    });
}

exports.sessionSecret = randPass(30);
exports.creerCompte = creerCompte;
exports.connection = connection;
exports.estConnecte = estConnecte;