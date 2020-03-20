<?php

//*****Contenu dynamique*****//

//echo($_REQUEST['urlprefere']);

if(isset($_REQUEST['delete']) && !empty($_REQUEST['delete'])) {
		mysql_query("DELETE FROM image  WHERE id = " . $_REQUEST['image'] . ' LIMIT 1');
		header('location:/cms/page/' . $_SESSION['image']['Page']);
		exit;
	}

//CE MODULE EST ACTIF SEULEMENT SI UN PARAMETRE DE PAGE EST PASSÉ
if(isset($_REQUEST['pageId'])) {
	
	
	//echo($_REQUEST['pageId']);
	
	//RÉCUPÉRATION DES CATÉGORIES D'IMAGES.	
	$res = mysql_query("SELECT *
						FROM categorie_image
						ORDER BY titre ASC
						");	
					
	$arrCategorieImage = array();
	if(mysql_num_rows($res) != 0){
		while ($d=mysql_fetch_assoc($res))
			$arrCategorieImage[]=$d;
	}
		
	
	
	//POUR QUELLE PAGE ON VEUT AJOUTER OU MODIFIER UNE IMAGE
	//$_SESSION['page']['Id'] = $_REQUEST['pageId'];	
	
	//PATH DE L'IMAGE EXISTANTE OU NON
	$target_dir = "../dynamique/images/";
	$target_file =  $target_dir . $_SESSION['image']['NomFichier'];
	
	
	//ACTION DU FORMULAIRE IMAGE.
	if(isset($_REQUEST['action'])) {
		
		unset($_SESSION['erreurs']);
		
		//General	
		$_SESSION['image']['Id'] = $_REQUEST['id'];
		$_SESSION['image']['Page'] = addslashes($_REQUEST['page']);
		$_SESSION['image']['CatImage'] = $_REQUEST['categorie_image'];
		$_SESSION['image']['Langue'] = $_REQUEST['langue'];
		$_SESSION['image']['NomFichier'] = (($_FILES["nom_fichier"]["name"]!='')?(basename('page' . $_REQUEST['page'] . '-' . $_FILES["nom_fichier"]["name"])):($_SESSION['image']['OldNomFichier']));
		//Francais
		$_SESSION['image']['Titre'] = addslashes($_REQUEST['titre']);
		$_SESSION['image']['TitreReferencement'] = addslashes($_REQUEST['titre_referencement']);
		$_SESSION['image']['Url'] = $_REQUEST['url'];	
		//Anglais
		$_SESSION['image']['TitreEn'] = addslashes($_REQUEST['titre_en']);
		$_SESSION['image']['TitreReferencementEn'] = addslashes($_REQUEST['titre_referencement_en']);
		$_SESSION['image']['UrlEn'] = $_REQUEST['url_en'];	
		
		
		
		//TRAVAIL SUR L'IMAGE
			$target_dir = "../dynamique/images/";
			$target_file =  $target_dir . $_SESSION['image']['NomFichier'];
			$uploadOk = 1;
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
			// Check if image file is a actual image or fake image
			if(empty($_SESSION['image']['Id'])) {
					$check = getimagesize($_FILES["nom_fichier"]["tmp_name"]);
					if($check !== false ) {
							//echo "File is an image - " . $check["mime"] . ".";
							$uploadOk = 1;
					} else {
							//echo "File is not an image.";
							$uploadOk = 0;
					}
			}
					
		//	echo($target_file);
			
			// Check if file already exists
			if (file_exists($target_file) && empty($_SESSION['image']['Id'])) {
					$erreurs[] =  "Désolé, ce fichier existe déja.";
					unset($_SESSION['image']['NomFichier']);
					$uploadOk = 0;
			}
			
			
			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" &&  empty($_SESSION['image']['Id'])) {
					$erreurs[] =  "Désolé, ce type de fichier n'est pas autorisé. Seuls les fichiers JPG, PNG, JPEG et GIF le sont.";
					$uploadOk = 0;
			}
			
			
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
					$erreurs[] = "Désolé, le fichier n'a pas été transféré.";
			// if everything is ok, try to upload file
			} else {
					if (move_uploaded_file($_FILES["nom_fichier"]["tmp_name"], $target_file) && $_SESSION['image']['NomFichier'] != $_SESSION['image']['OldNomFichier'] ) {
							
					} else {
						
							//$erreurs[] = "Désolé, il y a eu une erreur inconnue en tentant de téléverser votre image.  Veuillez recommencer.";
					}
			}
		
		
		//SI IL N'Y A PAS EU D'ERREUR LORS DU TRANSFERT DE L'IMAGE
		if(empty($erreurs)) {
			//UPDATE DE LA FICHE IMAGE DÉJA EXISTANTE.
			if(isset($_SESSION['image']['Id']) && !empty($_SESSION['image']['Id'])) {
			
			
					
				mysql_query(
				
					"UPDATE image 
					SET 	
								
					categorie_image=" . $_REQUEST['categorie_image'] . ",
					langue='" . $_REQUEST['langue'] . "',
					nom_fichier='" . $_SESSION['image']['NomFichier'] . "',
					
					titre='" . $_SESSION['image']['Titre'] . "',				
					titre_referencement='" . $_SESSION['image']['TitreReferencement'] . "', 
					url='" . $_SESSION['image']['Url'] . "', 	
					
					titre_en='" . $_SESSION['image']['TitreEn'] . "',				
					titre_referencement_en='" . $_SESSION['image']['TitreReferencementEn'] . "', 
					url_en='" . $_SESSION['image']['UrlEn'] . "'	
					
					WHERE id=". $_REQUEST['id']
					
					
					
					);	
					
					$_SESSION['image']['Id'] = $_REQUEST['id'];	
				
				//AJOUT DE LA NOUVELLE IMAGE
				} else {
					mysql_query(
					"INSERT INTO image
					(		
					page,	
					categorie_image,
					langue,
					nom_fichier,
					
					titre,
					titre_referencement,
					url,				
					
					titre_en,
					titre_referencement_en,
					url_en
					)
					VALUES 
					(" . 			 
					$_SESSION['image']['Page'] . "," . 
					$_SESSION['image']['CatImage'] . ",'" . 
					$_SESSION['image']['Langue'] . "','" . 
					$_SESSION['image']['NomFichier'] . "','" . 
					
					$_SESSION['image']['Titre'] . "','" . 
					$_SESSION['image']['TitreReferencement'] . "','" . 
					$_SESSION['image']['Url'] . "','" . 
					
					$_SESSION['image']['TitreEn'] . "','" . 
					$_SESSION['image']['TitreReferencementEn'] . "','" .
					$_SESSION['image']['UrlEn'] . "')");	
					
					$_SESSION['image']['Id'] = mysql_insert_id();	
				
				
				}
				
				
								
				
				
		}
			
				
				$_SESSION['erreurs'] = $erreurs;
				
				
			
			/////UN FOIS L'ENREGISTREMENT EFFECTUÉ
			if(mysql_error ($dbh) || !empty($erreurs)) {
				$erreurs[] = mysql_error ($dbh);
				$msg = "Il y a eu une erreur lors de l'enregistremement de votre image. Veuillez envoyer l'erreur suivante à <a href=\"mailto:" . $_SESSION['admSupport'] . "\">" . $_SESSION['admSupport'] . "</a>.<br><br>";
				
			foreach($erreurs as $k => $e) {
				$erreur.=($k+1) . ') ' . $e . '<br />';
			}
				
	$msg= $msg . $erreur . "<br />
	<a href=\"/cms/image/" . $_SESSION['page']['Id'] . "\"><i class=\"fa fa-arrow-circle-o-left fa-lg\"></i> Retour à la fiche de l'image</a>.<br><br>
	";
				
			}	else {
				
					$msg = "L'image " . sslashesCMS($_REQUEST['titre']) . " a été mise à jour ! <br>
	<br>
	<a href=\"/cms/page/" . $_SESSION['page']['UrlPrefere'] . "\"><i class=\"fa fa-arrow-circle-o-left fa-lg\"></i> Revenir à la gestion de la page en cours</a>.<br><br>";
				
			}
							
	
	
	
	
	} else {
		/////SI ON ARRIVE DE LA GESTION DE LA PAGE POUR ASSOCIER UNE NOUVELLE IMAGE
		
		//VIDER LA SESSION IMAGE PRÉCÉDENTE.
		if(empty($_SESSION['erreurs'])) {
			//echo('allo');
			unset($_SESSION['image']);
		} 
		
		unset($_SESSION['erreurs']);
	}
	
	
	
	
	//RÉCUPÉRATION DES DONNÉES VENANT DU ID.		
	$res = mysql_query("SELECT  i.*, i.id as imageId, i.titre as imageTitre, i.titre_en as imageTitreEn, p.*
						FROM image i, page p
						WHERE i.page = p.id
						AND p.id = " . $_REQUEST['pageId'] . "
						AND i.id = " . $_REQUEST['imageId'] . "
						ORDER BY i.titre ASC
						");	
					
	$arrImage = array();
	if(mysql_num_rows($res) != 0){
		while ($d=mysql_fetch_assoc($res))
			$arrImage[]=$d;
	}
	
	if(empty($arrImage)) {
		//$msg = "Désolé, aucune page trouvée dans l'outil de gestion.";	
		//header("location:/cms/");		
	} else {	
		
	
	//General	
		$_SESSION['image']['Id'] = $arrImage[0]['imageId'];
		$_SESSION['image']['Page'] = $arrImage[0]['page'];
		$_SESSION['image']['CatImage'] = $arrImage[0]['categorie_image'];
		$_SESSION['image']['Langue'] = $arrImage[0]['langue'];
		$_SESSION['image']['NomFichier'] = $arrImage[0]['nom_fichier'];		
		//Francais
		$_SESSION['image']['Titre'] = $arrImage[0]['imageTitre'];
		$_SESSION['image']['TitreReferencement'] = $arrImage[0]['titre_referencement'];
		$_SESSION['image']['Url'] = $arrImage[0]['url'];	
		//Anglais
		$_SESSION['image']['TitreEn'] = $arrImage[0]['imageTitreEn'];
		$_SESSION['image']['TitreReferencementEn'] = $arrImage[0]['titre_referencement_en'];
		$_SESSION['image']['UrlEn'] = $arrImage[0]['url_en'];	
	
		//unset($_SESSION['image']);
	}		
	
	
	
	
	
		
	
	
} else {
	//SI AUCUN PARAMETRE DE PAGE POUR LE MODULE, ON RETOURNE À L'ACCUEIL
	header("location:/cms/");	
}




//echo($_REQUEST['action']);



//print_r($_SESSION['page']);





?>