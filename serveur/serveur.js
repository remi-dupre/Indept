var express = require('express');
var bodyParser = require("body-parser");
var session = require('cookie-session');

var comptes = require('./comptes.js');
var proxy = require('./proxy.js').proxy;
var ejs = require('./ejs');

var app = express();

app.use( session({ secret: comptes.sessionSecret }) );
app.use( bodyParser.urlencoded({ extended: false }) );

app.get('/css/*', proxy);
app.get('/js/*', proxy);
app.get('/fonts/*', proxy);

app.post('/', function (req, res) {
    if( req.body.type == 'login' ) {
        comptes.connection(req.body, req.session, function(succes) {
            res.setHeader('Content-Type', 'text/html');
            if(succes)
                res.sendFile("index.html", {'root': '../web'});
            else
                ejs.ouvrir(res, '../web/login.html', {erreur:true});
        });
    }
});

app.use(function(req, res, next) {
    if( !comptes.estConnecte(req.session) ) {
        res.setHeader('Content-Type', 'text/html');
        ejs.ouvrir(res, '../web/login.html', {'erreur':false});
    }
    else {
        res.setHeader('Content-Type', 'text/html');
        res.sendFile("index.html", {'root': '../web'});
    }
});

app.listen(process.env.PORT);