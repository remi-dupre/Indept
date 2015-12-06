var express = require('express');
var bodyParser = require("body-parser");
var session = require('cookie-session');

var comptes = require('./comptes.js');
var fichiers = require('./fichiers.js');
var conversion = require('./conversion.js');
var proxy = require('./proxy.js').proxy;

var app = express();

app.engine('html', require('ejs').renderFile);
app.use(express.static(__dirname + '/public'));
app.use( session({ secret: comptes.sessionSecret }) );
app.use( bodyParser.urlencoded({ extended: false }) );

fichiers.charger();

/* *************** Traitement des requêtes *************** */

app.get('/css/*', proxy('web'));
app.get('/js/*', proxy('web'));
app.get('/fonts/*', proxy('web'));
app.get('/libs/*', proxy('/'));

// Se déconnecter
app.get('/unlogin', function(req, res) {
    req.session = null;
    res.writeHead(302, {
      'Location': "/"
    });
    res.end('Déconnecté');
});

// Ouvrir l'éditeur
app.get('/editeur', function(req, res) {
    res.setHeader('Content-Type', 'text/html');
    res.render('editeur.html', {});
});

// Modifier le fichier
app.post('/fichier/:fichier/modifier', function(req, res) {
    fichiers.modifier(req.params.fichier, JSON.parse(req.body.data), req.session, function(){});
    res.end();
});

// Retourne un fichier en json brut
app.get('/fichier/:fichier/json', function(req, res) {
    res.setHeader('Content-Type', 'application/json');
    fichiers.ouvrir(req.params.fichier, req.session, function(data) {
        res.end( JSON.stringify(data) );
    });
});

// Retourne un fichier en CSV
app.get('/fichier/:fichier/csv', function(req, res) {
    res.setHeader('Content-Type', 'text/csv');
    fichiers.ouvrir(req.params.fichier, req.session, function(data) {
        res.end( conversion.toCSV(data) );
    });
});

// Donne des infos sur l'appli
app.get('/info', function(req, res) {
    res.setHeader('Content-Type', 'application/json');
    var retour = {
        fichiers: null,
        comptes: {}
    };
    var fini = function() {
        return (retour.fichiers !== null);
    };
    
    fichiers.lister(req.session, function(data) {
        retour.fichiers = data;
        if( fini() )
            res.end( JSON.stringify(retour) );
    });
});

// Liste les fichiers accessibles
app.get('/action/lister', function(req, res) {
    res.setHeader('Content-Type', 'application/json');
    fichiers.lister(req.session, function(data) {
        res.end( JSON.stringify(data) );
    });
});

app.post('/*', function(req, res) {
    if( req.body.type == 'login' ) {
        comptes.connection(req.body, req.session, function(succes) {
            if(succes) {
                res.writeHead(302, {
                  'Location': req.path
                });
                res.end('Connection réussis');
            }
            else {
                res.setHeader('Content-Type', 'text/html');
                res.render('login.html', {erreur:true});
            }
        });
    }
});

app.use(function(req, res, next) {
    if( !comptes.estConnecte(req.session) ) {
        res.setHeader('Content-Type', 'text/html');
        res.render('login.html', {'erreur':false});
    }
    else {
        res.setHeader('Content-Type', 'text/html');
        res.render("index.html");
    }
});

app.listen(process.env.PORT);