<?php

include("includes/parametres.php");
include("includes/scripts/image.php");

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
      <h3>Association d'une image pour <?php echo(sslashesCMS($_SESSION['page']['Titre'])) ?> (<?php echo(sslashesCMS($_SESSION['page']['Url'])) ?>)</h3>
      <div id="formulaire">
        <form action="" method="post" enctype="multipart/form-data" name="image" >
          <input name="type" type="hidden"  value="image" />
          <input name="id" type="hidden"  value="<?php echo(sslashesCMS($_SESSION['image']['Id'])) ?>" />
					<input name="page" type="hidden"  value="<?php echo(sslashesCMS($_SESSION['page']['Id'])) ?>" />
					<input name="action" type="hidden"  value="update" />
					
					<h4><span>Informations générales</span></h4>
					<p>Catégorie d'image</p>
					
					<?php
					foreach($arrCategorieImage as $k => $c) {
					?>
						<input id="<?php echo($c['titre'])?>" name="categorie_image" type="radio" class="radio" value="<?php echo($c['id'])?>" <?php echo(($c['id']==$_SESSION['image']['CatImage'] ||  ($k==1 && empty($_SESSION['image']['CatImage'])))?('checked="checked"'):(''))?> /> <label for="<?php echo($c['titre'])?>"><?php echo($c['titre'])?> (<?php echo($c['dimensions'])?>)</label><br /><br />
								
					<?php
					} 
					?>
					
					<p>Langue de l'image</p>
					
					
						<input id="fr" name="langue" type="radio" class="radio" value="fr" <?php echo(('fr'==$_SESSION['image']['Langue'] ||  ( empty($_SESSION['image']['Langue'])))?('checked="checked"'):(''))?> /> <label for="fr">Français</label><br />
						<input id="en" name="langue" type="radio" class="radio" value="en" <?php echo(('en'==$_SESSION['image']['Langue'] )?('checked="checked"'):(''))?> /> <label for="en">Anglais</label><br /><br />
								
				
					
					<p>Image</p>
					<input name="nom_fichier" type="file" class="file"/>
					
					
					<?php 
					if(!empty($_SESSION['image']['NomFichier'])) { 
					$_SESSION['image']['OldNomFichier'] = $_SESSION['image']['NomFichier'];
					?>
					<p>Image déjà entrée</p>
					<p><img src="/dynamique/images/<?php echo($_SESSION['image']['NomFichier']) ?>" width="70" height="70" class="img"/></p>
					<?php } ?>
          
          <h4><span>Français</span></h4>
          <p>Titre</p>
          <input name="titre" type="text" value="<?php echo(sslashesCMS($_SESSION['image']['Titre'])) ?>" />
          <p>Titre référencement</p>
          <input name="titre_referencement" type="text" value="<?php echo(sslashesCMS($_SESSION['image']['TitreReferencement'])) ?>" />
          <p>Url</p>
          <input name="url" type="text" value="<?php echo(sslashesCMS($_SESSION['image']['Url'])) ?>" />
          <h4><span>Anglais</span></h4>
          <p>Titre</p>
          <input name="titre_en" type="text" value="<?php echo(sslashesCMS($_SESSION['image']['TitreEn'])) ?>" />
          <p>Titre référencement</p>
          <input name="titre_referencement_en" type="text" value="<?php echo(sslashesCMS($_SESSION['image']['TitreReferencementEn'])) ?>" />
          <p>Url</p>
          <input name="url_en" type="text" value="<?php echo(sslashesCMS($_SESSION['image']['UrlEn'])) ?>" />
          <!--input type="submit" value="Envoyer " id="bouton"/-->
					 <p id="bouton" class="bloc"><a href="javascript:document.image.submit()"><span><?php echo((empty($_SESSION['image']['Id']))?('Ajouter '):('Modifier ')); ?> <i class="fa fa-arrow-circle-o-right fa-lg"></i></span></a></p>
                     
                     <?php 
											if($_SESSION['image']['Id']) { 
											?>
									<p id="bouton" class="alerte"><a href="/cms/delete/image/<?php echo(sslashes($_SESSION['image']['Page'])) ?>/<?php echo(sslashes($_SESSION['image']['Id'])) ?>" onclick="return confirmSubmit('IMAGE : <?php echo(sslashes($_SESSION['image']['Titre'])) ?>');"><span>Supprimer cette image <i class="fa fa-exclamation-triangle  fa-lg"></i></span></a></p>
										<?php 
											} 
											?>
                     
        </form>
      </div>
      <?php 
						}
						?>
      <?php include('includes/footer.php');?>
</body>
</html>