<?php
    session_start();
    $root = "";
    require_once("php/comptes.php");
    require_once("php/fichiers.php");
    
    if( isset($_SESSION["utilisateur"]) ){
        header("Location: index.php");
        return;
    }

    if( isset($_POST["username"]) && isset($_POST["password"]) ) {
        if( connection($_POST["username"], $_POST["password"]) ) {
            header("Location: index.php");
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
        <link rel="icon" href="css/images/icone.png">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" charset="utf-8" >
        
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/ripples.min.css">
        <link rel="stylesheet" href="css/material-wfont.min.css">
        <link rel="stylesheet" href="css/login.min.css">
    </head>
    
    <body>
        <div class="container form-signin well well-lg">
          <form method="POST" action="login.php">
            <?php if($erreur) { ?>
                <div class="alert alert-danger" role="alert">Le nom d'utilisateur / mot de passe entré est <strong>invalide</strong></div>
            <?php } ?>
            <h2 class="form-signin-heading">Connection requise</h2>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="mdi-action-account-circle"></i></span>
                    <input type="text" name="username" class="form-control floating-label input-lg" placeholder="Nom d'utilisateur" required autofocus>
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="mdi-action-lock"></i></span>
                    <input type="password" name="password" class="form-control floating-label input-lg" placeholder="Mot de passe" required>
                </div>
            </div>
            <div class="form-group">
                <button class="btn btn-primary btn-block" type="submit" name="login">Connection</button>
            </div>
          </form>
          <div class="form-footer">
              <a href="inscription.php" class="btn btn-info btn-flat">S'inscrire</a>
          </div>
        </div>
        
    	<script src="js/jquery.min.js"></script>
    	<script src="js/ripples.min.js"></script>
    	<script src="js/material.min.js"></script>
    	<script> $(function(){ $.material.init(); });</script>
    </body>
</html>
