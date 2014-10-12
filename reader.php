<?php
  session_start();
  if( !isset($_SESSION["utilisateur"]) ) {
    header("Location: login.php");
    return;
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title class="doc_info nom">Lecteur de fichier dette</title>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/dot-luv/jquery-ui.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/global.css" rel="stylesheet">
    <link href="css/editeur.css" rel="stylesheet">
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
          <a class="dropdown-toggle navbar-brand doc_info nom" data-toggle="dropdown">Fichier</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav" ><li class="dropdown ">
            <a href="#" class="dropdown-toggle navbar-brand" data-toggle="dropdown"><strong class="caret"></strong></a>
            <ul class="dropdown-menu" role="menu" id="liste_fichiers">
              <!-- Liste des fichiers ouvrables -->
              <li class="divider"></li>
              <li><a data-toggle="modal" data-target="#fenCreer"><span class="glyphicon glyphicon-plus"></span> Créer un fichier</a></li>
            </ul>
          </li></ul>
          <ul class="nav navbar-nav navbar-right">
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
       

    <div class="col-md-10 col-md-offset-1 main">
      <h1 class="page-header"> Dettes de <em class="doc_info receveur_pseudo"></em> à <em class="doc_info donneur_pseudo"></em> </h1>
      
      <div id="liste-alertes">
        <div class="alert alert-danger" role="alert" style="display: none;">
          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <strong class="titre-alerte">Alerte !</strong> 
          <span class="contenu-alerte">Message d'erreur</span>
        </div>
      </div>
      
      <div class="panel panel-info">
        <div class="panel-heading doc_info nom">Informations</div>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th colspan=2>Mois</th>
              <th colspan=3>Total</th>
            </tr>
            <tr>
              <th class="col-md-2 doc_info donneur_pseudo">Payé</th>
              <th class="col-md-2 doc_info receveur_pseudo">Dépensé</th>
              <th class="col-md-2 doc_info donneur_pseudo">Payé</th>
              <th class="col-md-2 doc_info receveur_pseudo">Dépensé</th>
              <th class="col-md-2">Total</th>
            </tr>
          </thead>
          <tr>
            <td class="stats mois depense">0 €</td>
            <td class="stats mois rembourse">0 €</td>
            <td class="stats tout depense">0 €</td>
            <td class="stats tout rembourse">0 €</td>
            <td class="stats total">0 €</td>
          </tr>
        </table>
      </div>
      
      <button id="ajouter_ligne" type="button" class="btn btn-primary btn-sm" ><span class="glyphicon glyphicon-plus"></span> Ajouter</button>
      <button id="envoyer" type="button" class="btn btn-success btn-sm" ><span class="glyphicon glyphicon-upload"></span> Enregistrer</button>

      <div class="table-responsive">
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th class="col-md-2">Titre</th>
              <th class="col-md-1">Montant</th>
              <th class="col-md-1">Date</th>
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
              <label for="donneur" class="col-sm-2 control-label">Donneur</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="donneurFichier" placeholder="Personne avec qui partager le fichier">
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

	<script src="js/jquery.min.js"></script>
	<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/general.js"></script>
	<script src="js/editeur.js"></script>

  </body>
</html>