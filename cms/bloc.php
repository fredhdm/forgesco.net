<?php

include("includes/parametres.php");
include("includes/scripts/bloc.php");

//print_r($_SESSION);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<title>Outil de gestion | Images pour <?php echo(sslashesCMS($_SESSION['page']['Titre'])) ?> (<?php echo(sslashesCMS($_SESSION['page']['Url'])) ?>) | <?php echo(sslashesCMS($_SESSION['admClient'])) ?></title>
<?php include('includes/head.html'); ?>

</head>

<body>
<?php include('includes/entete.php');?>
      <h1 class="couleur_dominante">Outil de gestion</h1>
      <h2><?php echo(sslashesCMS($_SESSION['admClient'])) ?></h2>
      <?php 
						if(!empty($msg)) { 
						?>
      <p><span class="erreur"><?php echo($msg)?></span><br />
        Utilisez le menu de navigation au haut de la page pour gérer une page existante.</p>
      <?php 
						} else {
						?>
      <h3>Association d'un bloc pour <?php echo(sslashesCMS($_SESSION['page']['Titre'])) ?> (<?php echo(sslashesCMS($_SESSION['page']['Url'])) ?>)</h3>
      <div id="formulaire">
        <form action="" method="post" enctype="multipart/form-data" name="bloc" >
          <input name="type" type="hidden"  value="bloc" />
          <input name="id" type="hidden"  value="<?php echo(sslashesCMS($_SESSION['bloc']['Id'])) ?>" />
					<input name="page" type="hidden"  value="<?php echo(sslashesCMS($_SESSION['page']['Id'])) ?>" />
					<input name="action" type="hidden"  value="update" />
					
					<h4><span>Informations générales</span></h4>
					<p>Pour quel hôtel</p>
					
					<?php
					foreach($arrCategorieBloc as $k => $c) {
					?>
						<input name="categorie_bloc" type="radio" class="radio" value="<?php echo($c['id'])?>" <?php echo(($c['id']==$_SESSION['bloc']['CatBloc'] ||  ($k==1 && empty($_SESSION['bloc']['CatBloc'])))?('checked="checked"'):(''))?> /> <?php echo($c['titre'])?><br />
								
					<?php
					} 
					?>
					
					<p>Image</p>
					<input name="nom_fichier" type="file" class="file"/>
					
					
					<?php 
					if(!empty($_SESSION['bloc']['NomFichier'])) { 
					$_SESSION['bloc']['OldNomFichier'] = $_SESSION['bloc']['NomFichier'];
					?>
					<p>Image déjà entrée</p>
					<p><img src="/dynamique/blocs/<?php echo($_SESSION['bloc']['NomFichier']) ?>" width="70" height="70" class="img"/></p>
					<?php } ?>
          
          <h4><span>Français</span></h4>
          <p>Titre</p>
          <input name="titre" type="text" value="<?php echo(sslashesCMS($_SESSION['bloc']['Titre'])) ?>" />
          <p>À partir</p>
          <input name="a_partir" type="text" value="<?php echo(sslashesCMS($_SESSION['bloc']['APartir'])) ?>" />
          <p>Url Détails</p>
          <input name="url_details" type="text" value="<?php echo(sslashesCMS($_SESSION['bloc']['UrlDetails'])) ?>" />
					<p>Url Booking</p>
          <input name="url_booking" type="text" value="<?php echo(sslashesCMS($_SESSION['bloc']['UrlBooking'])) ?>" />
          <h4><span>Anglais</span></h4>
          <p>Titre</p>
          <input name="titre_en" type="text" value="<?php echo(sslashesCMS($_SESSION['bloc']['TitreEn'])) ?>" />
          <p>À partir</p>
          <input name="a_partir_en" type="text" value="<?php echo(sslashesCMS($_SESSION['bloc']['APartirEn'])) ?>" />
          <p>Url Détails</p>
          <input name="url_details_en" type="text" value="<?php echo(sslashesCMS($_SESSION['bloc']['UrlDetailsEn'])) ?>" />
					<p>Url Booking</p>
          <input name="url_booking_en" type="text" value="<?php echo(sslashesCMS($_SESSION['bloc']['UrlBookingEn'])) ?>" />
          <!--input type="submit" value="Envoyer " id="bouton"/-->
					 <p id="bouton" class="bloc"><a href="javascript:document.bloc.submit()"><span><?php echo((empty($_SESSION['bloc']['Id']))?('Ajouter '):('Modifier ')); ?> <i class="fa fa-arrow-circle-o-right fa-lg"></i></span></a></p>
        </form>
      </div>
      <?php 
						}
						?>
      <?php include('includes/footer.php');?>
</body>
</html>