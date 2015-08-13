var express = require('express');
var bodyParser = require("body-parser");
var session = require('cookie-session');

var comptes = require('./comptes.js');
var proxy = require('./proxy.js').proxy;

var app = express();

app.engine('html', require('ejs').renderFile);
app.use(express.static(__dirname + '/public'));
app.use( session({ secret: comptes.sessionSecret }) );
app.use( bodyParser.urlencoded({ extended: false }) );

/* *************** Traitement des requêtes *************** */

app.get('/css/*', proxy('web'));
app.get('/js/*', proxy('web'));
app.get('/fonts/*', proxy('web'));
app.get('/libs/*', proxy('/'));

app.get('/unlogin', function(req, res) {
    req.session = null;
    res.writeHead(302, {
      'Location': "/"
    });
    res.end('Déconnecté');
});

app.post('/*', function (req, res) {
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