<?php
  session_start();
  if( !isset($_SESSION["utilisateur"]) ) {
    header("Location: login.php");
    return;
  }
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title class="doc_info nom">Indept</title>
    <link rel="icon" href="css/images/icone.png">
    
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/ripples.min.css">
    <link rel="stylesheet" href="css/material-wfont.min.css">
    <link rel="stylesheet" href="css/nprogress.min.css">
    <link rel="stylesheet" href="css/home.min.css">
  </head>

  <body>
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="dropdown-toggle navbar-brand"><span class="glyphicon glyphicon-home"></span> Indept - Accueil</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#">Profil</a></li>
            <li><a href="unlogin.php">Déconnection</a></li>
          </ul>
        </div>
      </div>
    </div> <!-- Navbar -->
    
    <div class="jumbotron">
        <div class="container">
            <h2>Bienvenue dans Indept</h2>
            <p>
              Depuis cette page vous pouvez acceder à vos différents fichiers.
            </p>
        </div>
    </div>
    
    <div class="container">
        <div class="row" id="liste-fichiers">
            <div class="col-md-4 model container-carte">
                <div class="panel panel-success carte withripple"> <!-- carte -->
                  <div class="panel-heading">
                    <h2 class="file-info nom">Nom du fichier</h2>
                  </div>
                  <div class="panel-body">
                    <p class="text-info">Dernière modification <span class="file-info derniere_modif">il y a ...</span></p>
                    <ul class="list-group list-sm">
                        <li class="list-group-item">
                          <div class="row-action-primary">
                            <i class="glyphicon glyphicon-fire"></i>
                          </div>
                          <div class="row-content">
                              <div class="least-content euro file-info total toujours">...</div>
                              <p class="list-group-item-text">Dépenses totales</p>
                          </div>
                        </li>
                        <li class="list-group-item">
                          <div class="row-action-primary">
                            <i class="glyphicon glyphicon-stats"></i>
                          </div>
                          <div class="row-content">
                              <div class="least-content euro file-info total mois">...</div>
                              <p class="list-group-item-text">Moyenne par mois</p>
                          </div>
                        </li>
                        <li class="list-group-item">
                          <div class="row-action-primary">
                            <i class="glyphicon glyphicon-th-list"></i>
                          </div>
                          <div class="row-content">
                              <div class="least-content file-info lignes">...</div>
                              <p class="list-group-item-text">Nombre de lignes</p>
                          </div>
                        </li>
                        <li class="list-group-item">
                          <div class="row-action-primary">
                            <i class="glyphicon glyphicon-sunglasses"></i>
                          </div>
                          <div class="row-content">
                              <div class="least-content valeur file-info mot">...</div>
                              <p class="list-group-item-text">Mot fréquent</p>
                          </div>
                        </li>
                    </ul>
                  </div>
                </div>
            </div>
        </div>
    </div>
      
    <!-- Affichage des alertes -->    
    <div id="liste-alertes">
      <div class="alert alert-danger" role="alert" style="display: none;">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <strong class="titre-alerte">Alerte !</strong> <br />
        <span class="contenu-alerte">Message d'erreur</span>
      </div>
    </div>

	<script src="js/jquery.min.js"></script> <!-- jquery 1.11.1 -->
	
	<script src="js/bootstrap.min.js"></script>
	<script src="js/ripples.min.js"></script>
	<script src="js/material.min.js"></script>
	
	<script src="js/home.min.js"></script>
	<script src="js/nprogress.min.js"></script>
	
	<script src="js/moment.min.js"></script> <!-- http://momentjs.com/ -->
	
	<script>
	  moment.locale("fr");
	</script>
	<script>
	  $(function(){
	    $.material.init()
	    $.material.ripples(".navbar");
	  });
	</script>
  </body>
</html>