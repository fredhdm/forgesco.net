<?php

include("includes/parametres.php");
include("includes/scripts/page.php");

//print_r($_SESSION);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Outil de gestion |<?php echo(sslashesCMS($_SESSION['admClient'])) ?></title>
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
						<h3><?php echo((empty($_SESSION['page']['Id']))?('Ajout d\'une nouvelle page enfant de ' . sslashesCMS($_SESSION['page']['UrlPrefere'])):('Modification à la page ' . sslashesCMS($_SESSION['page']['Titre']) . ' (' . sslashesCMS($_SESSION['page']['Url']) . ')')) ?> </h3>
						<div id="formulaire">
								<form action="" method="post" enctype="application/x-www-form-urlencoded" name="page" >
										<input name="type" type="hidden"  value="page" />
										<input name="id" type="hidden"  value="<?php echo(sslashesCMS($_SESSION['page']['Id'])) ?>" />
										<input name="action" type="hidden" id="action"  value="update" />
										<input name="parent" type="hidden" id="action"  value="<?php echo($_SESSION['page']['Parent']) ?>" />
										
										<?php 
										if(($_SESSION['page']['Bloc']==1 || $_SESSION['page']['Image']==1 ) && 1==2) { 
										?>
										<h4><span>Options supplémentaires</span></h4>
										<?php 
											if($_SESSION['page']['Bloc']==1) { 
											?>
										<p id="bouton"><a href="javascript:addModule('bloc');"><span>Ajouter un bloc spécial <i class="fa fa-arrow-circle-o-right fa-lg"></i></span></a></p>
										<?php 
											} 
											?>
										<?php 
											if($_SESSION['page']['Image']==1) { 
											?>
										<p id="bouton"><a href="javascript:addModule('image');"><span>Ajouter une image <i class="fa fa-arrow-circle-o-right fa-lg"></i></span></a></p>
										<?php 
											} 
											?>
										<?php 
										} 
										?>
										
										<?php 
											if($_SESSION['page']['Famille']<$_SESSION['page']['FamilleMax'] && $_SESSION['page']['Famille']>0) { 
											?>
									<p id="bouton"><a href="javascript:addModule('enfant');"><span>Ajouter un utilisateur <i class="fa fa-arrow-circle-o-right fa-lg"></i></span></a></p>
										<?php 
											} 
											?>
											
											<?php 
											if($_SESSION['page']['Id'] && $_SESSION['page']['Id']!=252) { 
											?>
									<p id="bouton" class="alerte"><a href="/cms/delete/page/<?php echo(sslashes($_SESSION['page']['Id'])) ?>" onclick="return confirmSubmit('PAGE : <?php echo(sslashes($_SESSION['page']['Titre'])) ?>');"><span>Supprimer cette page <i class="fa fa-exclamation-triangle  fa-lg"></i></span></a></p>
										<?php 
											} 
											?>
										
										
										
										<div style="display:none;"><h4><span>Administration</span></h4>
										<?php 
										if($_SESSION['loginPouvoir']==1) { 
										?>
										
										<p>Type de page</p>
										<select name="famille" >
												<option value="1" <?php echo(($_SESSION['page']['Famille']==1)?('selected="selected"'):('')) ?>>Maître</option>
												<option value="2" <?php echo(($_SESSION['page']['Famille']==2)?('selected="selected"'):('')) ?>>Niveau 2</option>
												<option value="3" <?php echo(($_SESSION['page']['Famille']==3)?('selected="selected"'):('')) ?>>Niveau 3</option>
												<option value="4" <?php echo(($_SESSION['page']['Famille']==4)?('selected="selected"'):('')) ?>>Niveau 4</option>
										</select>
										
										
										<p>Niveau d'enfants max</p>
										<input name="famille_max" type="text"  value="<?php echo((!empty($_SESSION['FamilleMax']))?($_SESSION['FamilleMax']):(sslashesCMS($_SESSION['page']['FamilleMax'])))?>"/>
										
										<p>Bloc supplémentaires permis ? </p>
										<input name="bloc_supplementaire" type="radio"  class="radio" value="1" <?php echo(($_SESSION['page']['Bloc']==1)?('checked="checked"'):('')) ?>/>
										Oui
										<input type="radio" name="bloc_supplementaire" value="2" class="radio" <?php echo(($_SESSION['page']['Bloc']==2)?('checked="checked"'):('')) ?>/>
										Non
										<p>Besoin d'images ?</p>
										<input type="radio" name="image" value="1"  class="radio" <?php echo(($_SESSION['page']['Image']==1)?('checked="checked"'):('')) ?>/>
										Oui
										<input type="radio" name="image" value="2" class="radio" <?php echo(($_SESSION['page']['Image']==2)?('checked="checked"'):('')) ?>/>
										Non
										
										<?php 
										} else {
											?>
											<input name="famille" type="hidden" id="action"  value="<?php echo($_SESSION['page']['Famille']) ?>" />
											
										<input name="famille_max" type="hidden" id="action"  value="<?php echo((!empty($_SESSION['FamilleMax']))?($_SESSION['FamilleMax']):(sslashesCMS($_SESSION['page']['FamilleMax'])))?>" />
											
											<input name="bloc_supplementaire" type="hidden" id="action"  value="<?php echo($_SESSION['page']['Image']) ?>" />
											<input name="image" type="hidden" id="action"  value="<?php echo($_SESSION['page']['Image']) ?>" />
											
											<?php
										}
										?>
										
										<p>Url préféré français</p>
										<input name="url_prefere" id="upf" type="text"  value="<?php echo(sslashesCMS($_SESSION['page']['Url'])) ?>" readonly="readonly"/>
										<p>Url préféré anglais</p>
										<input name="url_prefere_en" id="upe" type="text"  value="<?php echo(sslashesCMS($_SESSION['page']['UrlEn'])) ?>" readonly="readonly"/>
										<p>Attention, si vous modifiez les URL préférés, certains liens qui dirigeaient vers cette page risquent de cesser de fonctionner.</p>
										<p id="bouton" style="margin-bottom:20px;"><a href="javascript:activerUrlPreferes();"><span>Modifier les URL préférés <i class="fa fa-arrow-circle-o-right fa-lg"></i></span></a></p>
										
										<p>Ordre d'apparition</p>
										<input name="ordre" type="text" value="<?php echo(empty($_SESSION['page']['Ordre'])?(5):(sslashesCMS($_SESSION['page']['Ordre']))) ?>" maxlength="3" />
										
										
										<p>Afficher cette page</p>
										<input type="radio" name="actif" value="1"  class="radio" <?php echo(($_SESSION['page']['Actif']==1 || empty($_SESSION['page']['Actif']))?('checked="checked"'):('')) ?>/>
										Oui
										<input type="radio" name="actif" value="2" class="radio" <?php echo(($_SESSION['page']['Actif']==2)?('checked="checked"'):('')) ?>/>
										Non</div>
										
										<div <?php echo(($_SESSION['page']['Id']!=252)?(''):('style="display:none;"')) ?> ><h4><span>Français</span></h4>
										<p>Nom</p>
										<input name="titre" type="text" value="<?php echo(sslashesCMS($_SESSION['page']['Titre'])) ?>" />
										<p>Courriel</p>
										<input name="sous_titre" type="text" value="<?php echo(sslashesCMS($_SESSION['page']['SousTitre'])) ?>" />
										<p>Mot de passe</p>
										
										
										<input name="meta_description" type="text" value="<?php echo(sslashesCMS($_SESSION['page']['MetaDescription'])) ?>" /></div>
										
										
										
									
									<?php 
											if(!empty($arrChampsOptionsGeneraux)) { 
											?>
									<h4><span>Champs spéciaux français</span></h4>
									
										<?php 
										
										//print_r($arrChampsOptionsGeneraux);
										
										foreach($arrChampsOptionsGeneraux as $c) {
											if(!strpos($c['nom_champs'],'_en')) {
											?>
									
										<p><?php echo(sslashesCMS($c['label'])) ?></p>
											
											<?php if($c['type_champs']=='textarea') { ?>
											
											<textarea name="<?php echo(sslashesCMS($c['nom_champs'])) ?>" id="<?php echo(sslashesCMS($c['nom_champs'])) ?>"><?php echo(sslashesCMS($_SESSION['page'][$c['nom_champs']])) ?></textarea>
										<script>
										// Replace the <textarea id="editor1"> with a CKEditor
										// instance, using default configuration.
										//CKEDITOR.replace( 'texte' );
										
										var editor = CKEDITOR.replace('<?php echo(sslashesCMS($c['nom_champs'])) ?>');
										CKFinder.setupCKEditor(editor);
										
										
										
									</script>
											
											
											<?php } else if($c['type_champs']=='input') { ?>
											<input name="<?php echo(sslashesCMS($c['nom_champs'])) ?>" type="text" value="<?php echo(sslashesCMS($_SESSION['page'][$c['nom_champs']])) ?>" />
										<?php } ?>
										
									
									<?php 
											}
										}
											?>
									
									
										<?php 
											}
											?>
										
									
									<div style="display:none;">
										<!--//////////// IMAGES ENTRÉES /////////-->
									
										<?php 
											if(!empty($arrImage)) { 
											?>
										<h4><span>IMAGES DÉJA ENTRÉES CLASSÉES PAR EMPLACEMENT/NOM DE L'IMAGE</span></h4>
										<div>
										<?php
										 $categorie_image='';
										 $langue='';
										 foreach($arrImage as $i) {
										// echo('cat=' . $i['categorie_image']);
											 if($categorie_image !=$i['categorie_image']) {
												 echo('<h5 class="couleur_dominante"><span><i class="fa fa-arrow-circle-o-down"></i>&nbsp;' . sslashesCMS($i['titre']) . '</span></h5>');
												
												 
											 }
											  if($langue != $i['langue']) {
												 echo('<h6 class="couleur_dominante"><span><i class="fa fa-arrow-circle-o-down"></i>&nbsp;' . sslashesCMS($i['langue']) . '</span></h6>');
												 
										 }
											 ?>
										<div id="thumbnail_content">
												<div id="lien"><a href="/cms/image/<?php echo($i['pageId']) ?>/<?php echo($i['imageId']) ?>" title="<?php echo(sslashesCMS($i['imageTitre'])) ?>"><img src="/images/0_spacer.gif" width="2" height="2" alt="<?php echo(sslashesCMS($i['imageTitre'])) ?>"/></a></div>
												<div id="thumbnail" style="background-image:url(/dynamique/images/<?php echo(rawurlencode($i['nom_fichier'])) ?>);"></div>
												<div id="info">
														<p><strong><?php echo(sslashesCMS($i['imageTitre'])) ?></strong><br />
																<?php echo(sslashesCMS($i['url'])) ?> </p>
												</div>
										</div>
										<?php 
											$langue = $i['langue'];
											$categorie_image = $i['categorie_image'];
										} 
										?></div>
										<?php 
										} 
										?>
										
										
										<!--//////////// BLOC ENTRÉS /////////-->
										<?php 
											if(!empty($arrBloc)) { 
											?>
										<h4><span>BLOCS DÉJA ENTRÉS CLASSÉS PAR EMPLACEMENT/NOM DU BLOC</span></h4>
										<div><!--
										<?php
										 $categorie_bloc='';
										 foreach($arrBloc as $i) {
											 if($categorie_bloc !=$i['categorie_bloc']) {
												 echo('<h5 class="couleur_dominante"><span><i class="fa fa-arrow-circle-o-down"></i>&nbsp;' . sslashesCMS($i['titre']) . '</span></h5>');
											 }
											 ?>
										--><div id="thumbnail_content">
												<div id="lien"><a href="/cms/bloc/<?php echo($i['pageId']) ?>/<?php echo($i['blocId']) ?>" title="<?php echo(sslashesCMS($i['blocTitre'])) ?>"><img src="/images/0_spacer.gif" width="2" height="2" alt="<?php echo(sslashesCMS($i['blocTitre'])) ?>"/></a></div>
												<div id="thumbnail" style="background-image:url(/dynamique/blocs/<?php echo(rawurlencode($i['nom_fichier'])) ?>);"></div>
												<div id="info">
														<p><strong><?php echo(sslashesCMS($i['blocTitre'])) ?></strong><br />
																<?php echo(sslashesCMS($i['url_details'])) ?> </p>
												</div>
										</div><!--
										<?php 
											$categorie_bloc = $i['categorie_bloc'];
										} 
										?>--></div>
										<?php 
										} 
										?></div>
										
										<!--//////////// PAGES ENFANTS ENTRÉES /////////-->
										<?php 
											if(!empty($arrEnfant)) { 
											?>
										<h4><span>PAGES LIÉES DÉJA ENTRÉS CLASSÉS PAR NOM</span></h4>
										<div class="arbre">
										
										
										<div id="thumbnail_content">
												
												
												<div id="info">
														<p><strong>Cette page : <?php echo(sslashesCMS($_SESSION['page']['Titre'])) ?></strong><br />
<?php echo(sslashesCMS($_SESSION['page']['MetaDescription'])) ?><br />
</p>
												</div>
										</div>
										
										
										<!--
										<?php
										
										 foreach($arrEnfant as $i) {											
											 ?>
										--><div id="thumbnail_content">
												<div id="lien"><a href="/cms/page/<?php echo($i['enfantId']) ?>" title="<?php echo(sslashesCMS($i['enfantTitre'])) ?>"><img src="/images/0_spacer.gif" width="2" height="2" alt="<?php echo(sslashesCMS($i['enfantTitre'])) ?>"/></a></div>
												<div id="thumbnail" style="background-image:url(/dynamique/images/<?php echo(rawurlencode($i['nom_fichier'])) ?>);"></div>
												<div id="info">
														<p><strong><?php echo(sslashesCMS($i['enfantTitre'])) ?></strong><br />
<?php echo(sslashesCMS($i['enfantSousTitre'])) ?><br />
<a href="/cms/page/<?php echo($i['enfantId']) ?>">Éditer</a> </p>
												</div>
										</div><!--
										<?php 
											
										} 
										?>--></div>
										<?php 
										} 
										?>
										
										
										<?php 
										if(($_SESSION['page']['Bloc']==1 || $_SESSION['page']['Image']==1 )  && 1==2) { 
										?>
										<h4><span>Options supplémentaires</span></h4>
										<?php 
											if($_SESSION['page']['Bloc']==1) { 
											?>
										<p id="bouton"><a href="javascript:addModule('bloc');"><span>Ajouter un bloc spécial <i class="fa fa-arrow-circle-o-right fa-lg"></i></span></a></p>
										<?php 
											} 
											?>
										<?php 
											if($_SESSION['page']['Image']==1) { 
											?>
										<p id="bouton"><a href="javascript:addModule('image');"><span>Ajouter une image <i class="fa fa-arrow-circle-o-right fa-lg"></i></span></a></p>
										<?php 
											} 
											?>
										<?php 
										} 
										?>
										
										<?php 
											if($_SESSION['page']['Famille']<$_SESSION['page']['FamilleMax'] && $_SESSION['page']['Famille']>0) { 
											?>
									<p id="bouton"><a href="javascript:addModule('enfant');"><span>Ajouter un utilisateur <i class="fa fa-arrow-circle-o-right fa-lg"></i></span></a></p>
										<?php 
											} 
											?>
											
											<?php 
											if($_SESSION['page']['Id']  && $_SESSION['page']['Id']!=252) { 
											?>
									<p id="bouton" class="alerte"><a href="/cms/delete/page/<?php echo(sslashes($_SESSION['page']['Id'])) ?>" onclick="return confirmSubmit('PAGE : <?php echo(sslashes($_SESSION['page']['Titre'])) ?>');"><span>Supprimer cette page <i class="fa fa-exclamation-triangle  fa-lg"></i></span></a></p>
										<?php 
											} 
											?>
										
										
										
										<input type="submit" value="Enregistrer »" id="bouton" class="bloc"/>
								</form>
						</div>
						<?php 
						}
						?>
						<?php include('includes/footer.php');?>
</body>
</html>