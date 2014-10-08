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
        <link rel="stylesheet" href="css/signin.css">
    </head>
    
    <body>
        <div class="container form-signin">
        <?php echo $erreurMsg; ?>
          <form method="POST" action="inscription.php">
            <h2 class="form-signin-heading">Inscription</h2>
            <input type="text" name="login" class="form-control" placeholder="Identifiant" required autofocus>
            <input type="text" name="pseudo" class="form-control" placeholder="Nom apparent" required>
            <br />
            <input type="password" name="passe" class="form-control" placeholder="Mot de passe" required>
            <input type="password" name="pwd_conf" class="form-control" placeholder="Verification mot de passe" required>
            <br />
            <input type="email" name="email" class="form-control" placeholder="Adresse e-mail" required>
            <input class="btn btn-lg btn-primary btn-block" type="submit" name="inscription" value="Connection" />
          </form>
          <div class="form-footer">
              <a href="login.php">Déjà inscrit</a>
          </div>
          <br />
          <div class="alert alert-warning" role="alert"><strong>En vous inscrivant vous faites confiance a votre hebergeur.</strong> Seul votre mot de passe est protègé.</div>
        </div>
    </body>
</html>
