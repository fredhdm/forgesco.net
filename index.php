<?php $lng='fr'; ?>
<?php include('includes/parametres.php'); ?>
<?php include('includes/scripts/index.php'); ?>
<?php
$pageActuelle='index';


//*****Contenu dynamique de la page*****//
$pageTitre = sslashes($arrContenu[0]['titre']);
$pageMetaDescription = sslashes($arrContenu[0]['meta_description']);
$pageTexte = sslashes($arrContenu[0]['texte']);





//IDENTIFICATION
if(isset($_REQUEST['type']) && $_REQUEST['type']=='login') {
	$_SESSION['loginCourriel'] = $_REQUEST['courriel'];
	$motdepasse = $_REQUEST['motdepasse'];
	
	$res = mysql_query("SELECT *
						FROM page
						WHERE sous_titre = '" . $_SESSION['loginCourriel']  . "'
						AND meta_description = '" .  $motdepasse . "'
						LIMIT 1									
						");	
					
	$arrLogin = array();
	if(mysql_num_rows($res) != 0){
		while ($d=mysql_fetch_assoc($res))
			$arrLogin[]=$d;
	}
	
	
	//print_r($arrLogin);
	
	if(empty($arrLogin)) {
		$msg = "Désolé, aucun utilisateur n'a été trouvé avec ces informations, veuillez recommencer.";
		$_SESSION['login'] = false;
	} else {
		$_SESSION['login'] = true;
		$_SESSION['loginNom'] = $arrLogin[0]['titre'];
			$_SESSION['loginCourriel'] = $arrLogin[0]['sous_titre'];
		$_SESSION['loginPouvoir'] = $arrLogin[0]['pouvoir'];
		
	}
	
	
	
}

//*****FORMULAIRE D'ENVOI*****//
if($_REQUEST['envoi']=='document') {
	
	$type = $_REQUEST['type'];
	$nom = 	$_REQUEST['nom'];
	$courriel = 	$_REQUEST['courriel'];
	$message = 	$_REQUEST['message']; 
	
	

	
	$nomfichier = basename($_FILES["nomfichier"]["name"]);
	
	$arrMandatory = array('message');
	
	foreach($_REQUEST as $k => $r) {
		//echo(in_array($k,$arrMandatory));
		if(empty($r) && in_array($k,$arrMandatory)) {
			$erreurs[] = 'Le champs ' . $k . ' est obligatoire.';
		}
	}
	
//	print_r($_REQUEST);
	//TRAVAIL SUR L'IMAGE
	
	if(!empty(	$nomfichier)) {
	
			$target_dir = "dynamique/documents/";
			$unique = date('Y-m-d') . '-' . StripAccents($nom) . '-';
			$target_file =  $target_dir .  $unique . $nomfichier ;
			$uploadOk = 1;
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
			// Check if image file is a actual image or fake image
		
					//$check = getimagesize($_FILES["nom_fichier"]["tmp_name"]);
					//if($check !== false ) {
							//echo "File is an image - " . $check["mime"] . ".";
							$uploadOk = 1;
					//} else {
							//echo "File is not an image.";
							//$uploadOk = 0;
					//}
			//echo('type' . $target_file);
					
		//	echo($target_file);
			
			// Check if file already exists
			if (file_exists($target_file)) {
					$erreurs[] =  "Désolé, ce fichier existe déja.";
				$uploadOk = 0;
			}
			
			
			// Allow certain file formats
			if($imageFileType != "pdf" && $imageFileType != "doc"  && $imageFileType != "docx" && $imageFileType != "jpeg"
			&& $imageFileType != "jpg" ) {
					$erreurs[] =  "Désolé, ce type de fichier n'est pas autorisé. Seuls les fichiers PDF, DOC(WORD) ET JPG le sont.";
					$uploadOk = 0;
			}
			
			
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
					$erreurs[] = "Désolé, le fichier n'a pas été transféré.";
			// if everything is ok, try to upload file
			} else {
					if (move_uploaded_file($_FILES["nomfichier"]["tmp_name"], $target_file) ) {
							
					} else {
						
							//$erreurs[] = "Désolé, il y a eu une erreur inconnue en tentant de téléverser votre image.  Veuillez recommencer.";
					}
			}
	
	}
		
		if(empty($erreurs)) {
			$addContent = true;
		} 
		
		//print_r($erreurs);
	
		//Détection si on veut updater le data ou écrire du nouveau data
		if($addContent) {		
			
			$newId = rand(0,99999999999);	
			
			
			
			
			$msg = "Nous avons bien recu votre document";
			
			
			
			//Envoi d'un avis à l'admin
			//require_once("../lib/html_mime_mail/htmlMimeMail.php");
			
		
				
		
			$subject = "Document recu de " . $nom;						
			$host = "mail.forgesco.net";
			$username = "info@forgesco.net";
			$password = "info$$321";
		//	$adminMail = 'info@escaliersnormandlaterreur.com';
		$adminMail = 'jpsim@videotron.ca';
		//$adminMail = 'fbergeron@2t3m.ca';
			$adminName = 'Jean Pichette';
			
			$text.="Bonjour, vous avez recu un document avec les informations suivantes : <br />
";
			
			foreach($_POST as $k => $p) {
				
				$text .= '<strong style="text-transform:uppercase;">' . $k . '</strong>' . ':' . $p . '<br/>';
				
			}
			
			if(!empty($nomfichier)) {
			$text.='Vous pouvez telecharger le document (s\'il y a lieu) en cliquant ici : <a href="'. $domaineEnCours. '/' . $target_file . '">' .  $domaineEnCours. '/' . $target_file . '</a>';
			}
			
			 require_once('Rmail/Rmail.php');
			$mail = new Rmail();
			$mail->setFrom($nom . "<" . $courriel . ">");
			$mail->setSubject($subject);
			$mail->setHtml($text);			
			$mail->setReturnPath($courriel);
			//$mail->setBcc($courriela);
			$mail->setTextCharset('UTF-8');
			$mail->setHtmlCharset('UTF-8');
			$mail->setHeadCharset('UTF-8');
			
			$mail->setSMTPParams($host,"587","HELO Forgescom",true,$username,$password);
	
			
			
			//$result = $mail->send(array($contactEmail)); ne pas envoyer le courriel au contact immédiatement.
			$result = $mail->send(array($adminMail));
			
			
		} 
	
	
} 


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
	<meta charset="UTF-8">
	<title><?php echo($pageTitre) ?></title>	
	<meta name="DESCRIPTION" content="<?php echo($pageMetaDescription) ?>" />
	<?php include($_SERVER['DOCUMENT_ROOT'] . '/includes/head.html'); ?>
	</head>

	<body class="accueil">
	<?php include($_SERVER['DOCUMENT_ROOT'] . '/includes/entete.php'); ?>










							
							<div id="contenu">
								<div id="texte">
								
								
							
			
				<?php 
						if(!$_SESSION['login']) { 
						?>
						<?php echo($pageTexte) ?>
						<?php 
						if(!empty($msg)) { 
						?>
						<p class="erreur"><?php echo($msg)?></p>
						<?php 
						}
						?>
					
				
				
						<form action="/fr" method="post" enctype="application/x-www-form-urlencoded" name="login" >
						<input name="type" type="hidden" id="type" value="login" />
						<input name="courriel" type="text" id="courriel" placeholder="Courriel*" />
							<input name="motdepasse" type="password" id="motdepasse" placeholder="Mot de passe*" />	
							<input type="submit" value="Envoyer »" class="submit"/>
						</form>
						
						
						<?php 
						} else { 
						?>
						<h1>Identification réussie !</h1>
						<h2>Bienvenue <?php echo(sslashes($_SESSION['loginNom'])) ?> !</h2>
						<p>Veuillez indiquer la nature du message et joindre votre fichier qui sera transmis.</p>
						
						
						
							<?php if(empty($msg)) { ?>
<p <?php echo((count($erreurs)>0)?('style="display:block;"'):('style="display:none;"')) ?>>
	Corriger les erreurs suivantes : <br/>
	<?php foreach($erreurs as $e) { ?>

	
	<?php echo($e) ?>	<br />
	
	
	<?php } ?>
</p>

<form id="form" name="form" method="post" action="/fr" enctype="multipart/form-data">
		<input name="envoi" type="hidden" value="document" /> 
		<input name="nom" type="hidden" value="<?php echo($_SESSION['loginNom']) ?>" /> 
		<input name="courriel" type="hidden" value="<?php echo($_SESSION['loginCourriel']) ?>" />        
		


<textarea placeholder="Message" name="message"><?php echo($message) ?></textarea>
<p>Document facultatif à joindre (PDF,DOC,JPG)</p>
					<input name="nomfichier" type="file" class="file"/>
<input type="submit" value="Envoyer" class="submit"/>

</form>

<?php } else { ?>
<p><?php echo($msg) ?></p>
<?php } ?>
			
						
						
						<?php 
						}
						?>
			
								
								
</div>
							
						</div>
					<?php include($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'); ?>
					
					
</body>
</html>