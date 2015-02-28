<?php
    require_once("php/comptes.php");
    
    if( isset($_POST["inscription"]) ) {
        if( creerCompte($_POST) ) {
            header ("location: login.php");
            return;
        }
        else $erreurMsg = '<div class="alert alert-danger" role="alert">Inscription annulée</div>';
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>InDept - Inscription</title> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0" charset="utf-8" >
        
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/ripples.min.css">
        <link rel="stylesheet" href="css/material-wfont.min.css">
        <link rel="stylesheet" href="css/login.min.css">
    </head>
    
    <body>
        <div class="container form-signin well well-lg">
        <?php echo $erreurMsg; ?>
          <form method="POST" action="inscription.php">
            <h2 class="form-signin-heading">Inscription</h2>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="mdi-action-account-circle"></i></span>
                    <input type="text" name="login" class="form-control floating-label" placeholder="Identifiant" required autofocus>
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="mdi-action-perm-identity"></i></span>
                    <input type="text" name="pseudo" class="form-control floating-label" placeholder="Nom apparent" required>
                </div>
            </div>
            <br />
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="mdi-action-lock"></i></span>
                    <input type="password" name="passe" class="form-control floating-label" placeholder="Mot de passe" required>
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="mdi-action-lock"></i></span>
                    <input type="password" name="pwd_conf" class="form-control floating-label" placeholder="Verification mot de passe" required>
                </div>
            </div>
            <br />
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="mdi-communication-email"></i></span>
            <input type="email" name="email" class="form-control floating-label" placeholder="Adresse e-mail" required>
                </div>
            </div>
            <button class="btn btn-lg btn-primary btn-block" type="submit" name="inscription">S'inscrire</button>
          </form>
          <div class="form-footer">
              <a href="login.php" class="btn btn-info btn-flat">Déjà inscrit</a>
          </div>
          <br />
          <div class="alert alert-warning" role="alert"><strong>En vous inscrivant vous faites confiance a votre hebergeur.</strong> Seul votre mot de passe est protègé.</div>
        </div>
        </div>
        
    	<script src="js/jquery.min.js"></script>
    	<script src="js/ripples.min.js"></script>
    	<script src="js/material.min.js"></script>
    	<script> $(function(){ $.material.init(); }); </script>
    </body>
</html>
