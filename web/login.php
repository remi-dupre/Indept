<?php
    session_start();
    $root = "";
    require_once("php/comptes.php");
    require_once("php/fichiers.php");
    
    if( isset($_SESSION["utilisateur"]) ){
        header("Location: reader.php");
        return;
    }

    if( isset($_POST["username"]) && isset($_POST["password"]) ) {
        if( connection($_POST["username"], $_POST["password"]) ) {
            header("Location: reader.php#remi-1");
            return;
        }
        else
            $erreur = true;
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>InDept - Connection</title> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0" charset="utf-8" >
        
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/login.min.css">
    </head>
    
    <body>
        <div class="container form-signin">
          <form method="POST" action="login.php">
            <?php if($erreur) { ?>
                <div class="alert alert-danger" role="alert">Le nom d'utilisateur / mot de passe entré est <strong>invalide</strong></div>
            <?php } ?>
            <h2 class="form-signin-heading">Connection requise</h2>
            <input type="text" name="username" class="form-control" placeholder="Nom d'utilisateur" required autofocus>
            <input type="password" name="password" class="form-control" placeholder="Mot de passe" required>
            <input class="btn btn-lg btn-primary btn-block" type="submit" name="login" value="Connection" />
          </form>
          <div class="form-footer">
              <a href="inscription.php">S'inscrire</a>
          </div>
        </div>
        <div id="footer">
            <span class="glyphicon glyphicon-copyright-mark"></span>
            Rémi Dupré - 
            <a href="https://github.com/remi100756/Indept">Github</a>
        </div>
    </body>
</html>
