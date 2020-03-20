<?php

include("includes/parametres.php");
include("includes/scripts/index.php");



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<? include('includes/head.html'); ?>
<title>Outil de gestion |<?php echo(sslashesCMS($_SESSION['admClient'])) ?></title>

</head>

<body>
<?php include('includes/entete.php');?>
						
						<h1 class="couleur_dominante">Outil de gestion</h1>
						<h2><?php echo(sslashesCMS($_SESSION['admClient'])) ?></h2>
						
						
						<?php 
						if(!$_SESSION['login']) { 
						?>
						
						<?php 
						if(!empty($msg)) { 
						?>
						<p class="erreur"><?php echo($msg)?></p>
						<?php 
						}
						?>
						<p>Entrez les informations d'identification qui vous ont été remises pour gérer les sections du site Internet <?php echo(sslashesCMS($_SESSION['admSite'])) ?></p>
				
				
						<div id="formulaire"><form action="/cms/" method="post" enctype="application/x-www-form-urlencoded" name="login" >
						<input name="type" type="hidden" id="type" value="login" />
						<input name="courriel" type="text" id="courriel" placeholder="Courriel" />
							<input name="motdepasse" type="password" id="motdepasse" placeholder="Mot de passe" />	
							<input type="submit" value="Envoyer »" id="bouton"/>
						</form></div>
						
						
						<?php 
						} else { 
						?>
						<p>Bienvenue <?php echo(sslashesCMS($_SESSION['loginNom'])) ?> !</p>
						<?php 
						}
						?>
						
						<?php include('includes/footer.php');?>
				
</body>
</html>