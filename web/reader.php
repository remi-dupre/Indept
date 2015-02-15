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

    <link rel="stylesheet" href="css/jquery-ui.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/nprogress.min.css">
    <link rel="stylesheet" href="css/editeur.min.css">
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
          <a class="dropdown-toggle navbar-brand" data-toggle="dropdown"><span class="glyphicon glyphicon-file"></span> Indept - Lecteur</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Ouvrir<span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu" id="liste_fichiers">
                <!-- Liste des fichiers ouvrables -->
                <li class="divider"></li>
                <li><a data-toggle="modal" data-target="#fenCreer"><span class="glyphicon glyphicon-plus"></span> Créer un fichier</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Fichier<span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a data-toggle="modal" data-target="#fenDl">Enregistrer / Exporter le fichier</a></li>
                <li><a data-toggle="modal" data-target="#fenShare">Partager</a></li>
                <li class="divider"></li>
                <li><a href="#">Configuration du fichier</a></li>
              </ul>
            </li>
            <li><a href="#">Profil</a></li>
            <li><a href="unlogin.php">Déconnection</a></li>
          </ul>
          <span class="navbar-form navbar-right">
            <input id="recherche" type="text" class="form-control" placeholder="Filtrer ...">
          </span>
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
       

    <div class="col-md-10 col-md-offset-1 main">
      <h1 class="page-header"><span class="doc_info nom">Titre</span> <small><em class="doc_info proprietaire_pseudo"></em></small> </h1>
      <div class="row"> <!-- Bloc des statistiques -->
        <div class="col-md-7 container"> <!-- Container Colone 1 -->
          <div class="panel panel-info"> <!-- Tableau des statistiques -->
            <div class="panel-heading">Statistiques sur le mois et depuis toujours</div>
            <div class="table-responsive"> <!-- table-responsive --> 
              <table class="table table-bordered table-stats">
                <thead>
                  <tr>
                    <th colspan=2>Mois</th>
                    <th colspan=3>Total</th>
                  </tr>
                  <tr>
                    <th class="col-md-2 doc_info">Dépensé</th>
                    <th class="col-md-2 doc_info">Encaissé</th>
                    <th class="col-md-2 doc_info">Dépensé</th>
                    <th class="col-md-2 doc_info">Encaissé</th>
                    <th class="col-md-2">Total</th>
                  </tr>
                </thead>
                <tr>
                  <td class="stats mois depense">0</td>
                  <td class="stats mois gain">0</td>
                  <td class="stats tout depense">0</td>
                  <td class="stats tout gain">0</td>
                  <td class="stats tout total">0</td>
                </tr>
              </table>
            </div> <!-- table-responsive -->
          </div> <!-- Tableau des statistiques -->
        </div> <!-- Container Colone 1 -->
        <div class="col-md-5 container"> <!-- Container Colone 2 -->
          <ul class="list-group borderless stats">
            <li class="list-group-item">
              <span class="glyphicon glyphicon glyphicon-stats"></span>
              <span class="description">Moyenne par mois</span>
              <span class="valeur stats moyenne depense">0 €</span>
            </li>
            <li class="list-group-item">
              <span class="glyphicon glyphicon-time"></span>
              <span class="description">Dernière modification</span>
              <span class="valeur stats date_modif">12/12/12</span>
            </li>
            <li class="list-group-item">
              <span class="glyphicon glyphicon-euro"></span>
              <span class="description">Plus grosse dépense du mois</span>
              <span class="valeur stats grosse_depense mois">0 €</span>
              <div class="popover" role="tooltip">
                <div class="arrow"></div>
                <h3 class="popover-title">Plus gros évenements</h3>
                <div class="popover-content"><ul class="list-group borderless">
                  <li class="list-group-item">
                    <span class="description">Grosse dépense</span>
                    <span class="valeur stats tout grosse_depense"></span>
                  </li>
                  <li class="list-group-item">
                    <span class="description">Gros gain</span>
                    <span class="valeur stats tout gros_gain"></span>
                  </li>
                  <li class="list-group-item">
                    <span class="description">Grosse dépense du mois</span>
                    <span class="valeur stats mois grosse_depense"></span>
                  </li>
                  <li class="list-group-item">
                    <span class="description">Gros gain du mois</span>
                    <span class="valeur stats mois gros_gain"></span>
                  </li>
                </ul></div>
              </div>
            </li>
            <li class="list-group-item">
              <span class="glyphicon glyphicon-sunglasses"></span>
              <span class="description">Mot le plus courrant</span>
              <span class="valeur stats mot tout">...</span>
            </li>
          </ul>
        </div> <!-- Container Colone 2 -->
      </div> <!-- Bloc des statistiques -->
      
      <div class="btn-group"> <!-- Liste des boutons -->
        <button id="ajouter_ligne" type="button" class="btn btn-primary btn-sm" >
          <span class="glyphicon glyphicon-plus"></span> Ajouter
        </button>
      </div>
      <div class="btn-group right"> <!-- Liste des boutons -->
        <button id="envoyer" type="button" class="btn btn-success btn-sm" >
          <span class="glyphicon glyphicon-upload"></span> Enregistrer
        </button>
      </div>
      
      <div class="table-responsive">
        <table class="table table-striped table-hover table-triable" selecteur=".ligne_info" ordre="2" sens="false">
          <thead>
            <tr>
              <th class="col-md-2 triable">Titre</th>
              <th class="col-md-1 triable">Montant</th>
              <th class="col-md-1 triable">Date</th>
              <th class="col-md-7">Description</th>
              <th class="col-md-1 icone_tr">#</th>
            </tr>
          </thead>
          <tbody id="liste">
            <!-- Ligne de référence -->
            <tr style="display:none">
              <td class="doc_info liste-titre">Titre</td>
              <td class="montant"> <span class="doc_info liste-montant">Montant</span><em> €</em> </td>
              <td class="doc_info liste-date time-date">Date</td>
              <td class="doc_info liste-description">Description</td>
              <td class="doc_info status_icone icone_tr">
                <span class="glyphicon glyphicon-trash tt" title="Supprimer la ligne" data-placement="left"></span>
                <span class="glyphicon glyphicon-ok-sign refuse tt" title="Valider la demande" data-placement="left"></span>
                <span class="glyphicon glyphicon-remove-sign refuse tt" title="Refuser la demande" data-placement="left"></span>
                <span class="glyphicon glyphicon-info-sign"></span>
              </td>
            </tr>
            <!-- Ligne d'ajout de champ -->
            <tr style="display:none" id="ligne_ajout">
              <td> <input type="text" class="input_ligne liste-titre" placeholder="Titre" /> </td>
              <td> <input type="number" class="input_ligne liste-montant" placeholder="en €" /> </td>
              <td> <input type="text" class="input_ligne liste-date" placeholder="jj/mm/yyyy" /> </td>
              <td> <input type="text" class="input_ligne liste-description" placeholder="Commentaire supplémentaires" /> </td>
              <td class="doc_info icone_tr">
                <button id="inserer" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-ok"></span></button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

  <!-- Fenêtres modales -->

  <!-- Exportation -->
  <div class="modal fade" id="fenDl" >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <h4 class="modal-title">Télécharger / importer les données</h4>
        </div>
        <div class="modal-body">
          <p><a class="dl json" download="dept.json">Télécharger au format JSON</a></p>
          <p><a class="dl csv" download="dept.csv">Télécharger au format CSV</a> - pour importer dans excel ou d'autres logiciels</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Partage -->
  <div class="modal fade" id="fenShare" >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <h4 class="modal-title">Partager ce fichier</h4>
        </div>
        <div class="modal-body">
          <p>Pour l'instant seul deux personnes peuvent modifier le fichier. Si le fichier est publique, vous pouvez donner le lien à quelqu'un qui doit néanmoins créer un compte.</p>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Création d'un nouveau fichier  -->
  <div class="modal fade" id="fenCreer" >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <h4 class="modal-title">Ajouter un fichier</h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" role="form">
            <div class="form-group">
              <label for="nomFichier" class="col-sm-2 control-label">Nom</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="nomFichier" placeholder="Nom du fichier">
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" id="priveFichier"> Fichier privé
                  </label>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <button id="creerFichier" class="btn btn-primary">Créer le fichier</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Le modèle des bulles sur les lignes -->
  <div class="popover model" role="tooltip">
    <div class="arrow"></div>
    <h3 class="popover-title"><strong class="titre"></strong> : <span class="montant"></span> €</h3>
    <div class="popover-content">
      <em>Par <span class="createur">?</span> le <span class="date"></span></em
      <br />
      <div class="description"></div>
    </div>
  </div>

	<script src="js/jquery.min.js"></script> <!-- jquery 1.11.1 -->
	<script src="js/jquery-ui.min.js"></script> <!-- http://jqueryui.com/download/ : Core + Datepicker , theme Dot Luv -->
	<script src="js/bootstrap.min.js"></script>
	<script src="js/nprogress.min.js"></script>
	<script src="js/editeur.min.js"></script>
	
	<script src="js/moment.min.js"></script> <!-- http://momentjs.com/ -->
	<script>
	  moment.locale("fr");
	</script>

  </body>
</html>