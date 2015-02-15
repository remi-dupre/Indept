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

    <title class="doc_info nom">Lecteur de fichier dette</title>
    
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/nprogress.min.css">
    <link rel="stylesheet" href="css/home.min.css">
  </head>

  <body>
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="dropdown-toggle navbar-brand" data-toggle="dropdown"><span class="glyphicon glyphicon-file"></span> Indept - Accueil</a>
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
            <h2>Bienvenue sur Indept</h2>
            <p>
                Depuis cette page vous pouvez accèder à vos différents fichiers.
                Certaines opérations de contrôles seront aussi proposées.
            </p>
        </div>
    </div>
    
    <div class="container">
        <div class="row" id="liste-fichiers">
            <div class="col-md-4 model container-carte">
                <div class="carte">
                    <h2 class="file-info nom">Nom du fichier</h2>
                    <p>Dernière modification <span class="file-info derniere_modif">il y a 30 minutes</span></p>
                    <ul class="list-group borderless">
                        <li class="list-group-item">
                          <span class="glyphicon glyphicon-fire"></span>
                          <span class="description">Dépenses totales</span>
                          <span class="euro valeur file-info total toujours">0</span>
                        </li>
                        <li class="list-group-item">
                          <span class="glyphicon glyphicon-stats"></span>
                          <span class="description">Moyenne par mois</span>
                          <span class="euro valeur file-info total mois">0</span>
                        </li>
                        <li class="list-group-item">
                          <span class="glyphicon glyphicon-th-list"></span>
                          <span class="description">Nombre de lignes</span>
                          <span class="valeur file-info lignes">0</span>
                        </li>
                        <li class="list-group-item">
                          <span class="glyphicon glyphicon-sunglasses"></span>
                          <span class="description">Mot fréquent</span>
                          <span class="valeur file-info mot">Daniel</span>
                        </li>
                    </ul>
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
	<script src="js/home.min.js"></script>
	<script src="js/nprogress.min.js"></script>
	
	<script src="js/moment.min.js"></script> <!-- http://momentjs.com/ -->
	<script>
	  moment.locale("fr");
	</script>
  </body>
</html>