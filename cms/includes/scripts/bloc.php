<?php

//*****Contenu dynamique*****//

//echo($_REQUEST['urlprefere']);



//CE MODULE EST ACTIF SEULEMENT SI UN PARAMETRE DE PAGE EST PASSÉ
if(isset($_REQUEST['pageId'])) {
	
	
	//echo($_REQUEST['pageId']);
	
	//RÉCUPÉRATION DES CATÉGORIES DE BLOC.	
	$res = mysql_query("SELECT *
						FROM categorie_bloc
						ORDER BY titre ASC
						");	
					
	$arrCategorieBloc = array();
	if(mysql_num_rows($res) != 0){
		while ($d=mysql_fetch_assoc($res))
			$arrCategorieBloc[]=$d;
	}
		
	
	
	//POUR QUELLE PAGE ON VEUT AJOUTER OU MODIFIER UNE IMAGE
	//$_SESSION['page']['Id'] = $_REQUEST['pageId'];	
	
	//PATH DE L'IMAGE EXISTANTE OU NON
	$target_dir = "../dynamique/blocs/";
	$target_file =  $target_dir . $_SESSION['bloc']['NomFichier'];
	
	
	//ACTION DU FORMULAIRE IMAGE.
	if(isset($_REQUEST['action'])) {
		
		unset($_SESSION['erreurs']);
		
		//General	
		$_SESSION['bloc']['Id'] = $_REQUEST['id'];
		$_SESSION['bloc']['Page'] = $_REQUEST['page'];
		$_SESSION['bloc']['CatBloc'] = $_REQUEST['categorie_bloc'];
		$_SESSION['bloc']['NomFichier'] = (($_FILES["nom_fichier"]["name"]!='')?(basename('bloc' . $_REQUEST['page'] . '-' . $_FILES["nom_fichier"]["name"])):($_SESSION['bloc']['OldNomFichier']));
		//Francais
		$_SESSION['bloc']['Titre'] = $_REQUEST['titre'];
		$_SESSION['bloc']['APartir'] = $_REQUEST['a_partir'];
		$_SESSION['bloc']['UrlDetails'] = $_REQUEST['url_details'];	
		$_SESSION['bloc']['urlBooking'] = $_REQUEST['url_booking'];	
		//Anglais
		$_SESSION['bloc']['TitreEn'] = $_REQUEST['titre_en'];
		$_SESSION['bloc']['APartirEn'] = $_REQUEST['a_partir_en'];
		$_SESSION['bloc']['UrlDetailsEn'] = $_REQUEST['url_details_en'];	
		$_SESSION['bloc']['urlBookingEn'] = $_REQUEST['url_booking_en'];	
		
		
		
		//TRAVAIL SUR L'IMAGE
			$target_dir = "../dynamique/blocs/";
			$target_file =  $target_dir . $_SESSION['bloc']['NomFichier'];
			$uploadOk = 1;
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
			// Check if image file is a actual image or fake image
			if(empty($_SESSION['bloc']['Id'])) {
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
			if (file_exists($target_file) && empty($_SESSION['bloc']['Id'])) {
					$erreurs[] =  "Désolé, ce fichier existe déja.";
					unset($_SESSION['bloc']['NomFichier']);
					$uploadOk = 0;
			}
			
			
			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" &&  empty($_SESSION['bloc']['Id'])) {
					$erreurs[] =  "Désolé, ce type de fichier n'est pas autorisé. Seuls les fichiers JPG, PNG, JPEG et GIF le sont.";
					$uploadOk = 0;
			}
			
			
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
					$erreurs[] = "Désolé, le fichier n'a pas été transféré.";
			// if everything is ok, try to upload file
			} else {
					if (move_uploaded_file($_FILES["nom_fichier"]["tmp_name"], $target_file) && $_SESSION['bloc']['NomFichier'] != $_SESSION['bloc']['OldNomFichier'] ) {
							
					} else {
						
							//$erreurs[] = "Désolé, il y a eu une erreur inconnue en tentant de téléverser votre image.  Veuillez recommencer.";
					}
			}
		
		
		//SI IL N'Y A PAS EU D'ERREUR LORS DU TRANSFERT DE L'IMAGE
		if(empty($erreurs)) {
			//UPDATE DE LA FICHE IMAGE DÉJA EXISTANTE.
			if(isset($_SESSION['bloc']['Id']) && !empty($_SESSION['bloc']['Id'])) {
			
			
					
				mysql_query(
				
					"UPDATE bloc 
					SET 	
								
					categorie_bloc=" . $_REQUEST['categorie_bloc'] . ",
					nom_fichier='" . $_SESSION['bloc']['NomFichier'] . "',
					
					titre='" . $_REQUEST['titre'] . "',				
					a_partir='" . $_REQUEST['a_partir'] . "', 
					url_details='" . $_REQUEST['url_details'] . "',
					url_booking='" . $_REQUEST['url_booking'] . "',  	
					
					titre_en='" . $_REQUEST['titre_en'] . "',				
					a_partir_en='" . $_REQUEST['a_partir_en'] . "', 
					url_details_en='" . $_REQUEST['url_details_en'] . "',
					url_booking_en='" . $_REQUEST['url_booking_en'] . "'
					
					WHERE id=". $_REQUEST['id']
					
					
					
					);	
					
					$_SESSION['bloc']['Id'] = $_REQUEST['id'];	
				
				//AJOUT DE LA NOUVELLE IMAGE
				} else {
					mysql_query(
					"INSERT INTO bloc
					(		
					page,	
					categorie_bloc,
					nom_fichier,
					
					titre,
					a_partir,
					url_details,	
					url_booking,				
					
					titre_en,
					a_partir_en,
					url_details_en,
					url_booking_en
					)
					VALUES 
					(" . 			 
					$_SESSION['bloc']['Page'] . "," . 
					$_SESSION['bloc']['CatBloc'] . ",'" . 
					$_SESSION['bloc']['NomFichier'] . "','" . 
					
					$_SESSION['bloc']['Titre'] . "','" . 
					$_SESSION['bloc']['APartir'] . "','" . 
					$_SESSION['bloc']['UrlDetails'] . "','" . 
					$_SESSION['bloc']['UrlBooking'] . "','" . 
					
					$_SESSION['bloc']['TitreEn'] . "','" . 
					$_SESSION['bloc']['APartirEn'] . "','" . 
					$_SESSION['bloc']['UrlDetailsEn'] . "','" . 
					$_SESSION['bloc']['UrlBookingEn'] . "')");	
					
					$_SESSION['bloc']['Id'] = mysql_insert_id();	
				
				
				}
				
				
		}
			
				
				$_SESSION['erreurs'] = $erreurs;			
				
			
			/////UN FOIS L'ENREGISTREMENT EFFECTUÉ
			if(mysql_error ($dbh) || !empty($erreurs)) {
				$erreurs[] = mysql_error ($dbh);
				$msg = "Il y a eu une erreur lors de l'enregistremement de votre bloc. Veuillez envoyer l'erreur suivante à <a href=\"mailto:" . $_SESSION['admSupport'] . "\">" . $_SESSION['admSupport'] . "</a>.<br><br>";
				
			foreach($erreurs as $k => $e) {
				$erreur.=($k+1) . ') ' . $e . '<br />';
			}
				
	$msg= $msg . $erreur . "<br />
	<a href=\"/cms/bloc/" . $_SESSION['page']['Id'] . "\"><i class=\"fa fa-arrow-circle-o-left fa-lg\"></i> Retour à la fiche du bloc en cours</a>.<br><br>
	";
				
			}	else {
				
					$msg = "Le bloc " . sslashesCMS($_REQUEST['titre']) . " a été mis à jour ! <br>
	<br>
	<a href=\"/cms/page/" . $_SESSION['page']['UrlPrefere'] . "\"><i class=\"fa fa-arrow-circle-o-left fa-lg\"></i> Revenir à la gestion de la page en cours</a>.<br><br>";
				
			}
							
	
	} else {
		/////SI ON ARRIVE DE LA GESTION DE LA PAGE POUR ASSOCIER UNE NOUVELLE IMAGE
		
		//VIDER LA SESSION BLOC PRÉCÉDENTE.
		if(empty($_SESSION['erreurs'])) {
			//echo('allo');
			unset($_SESSION['bloc']);
		} 
		
		unset($_SESSION['erreurs']);
	}
	
	
	
	//RÉCUPÉRATION DES DONNÉES VENANT DU ID.		
	$res = mysql_query("SELECT  b.*, b.id as blocId, b.titre as blocTitre, b.titre_en as blocTitreEn, p.*
						FROM bloc b, page p
						WHERE b.page = p.id
						AND p.id = " . $_REQUEST['pageId'] . "
						AND b.id = " . $_REQUEST['blocId'] . "
						ORDER BY b.titre ASC
						");	
						
						
					
	$arrBloc = array();
	if(mysql_num_rows($res) != 0){
		while ($d=mysql_fetch_assoc($res))
			$arrBloc[]=$d;
	}
	
	//print_r($arrBloc);
	
	if(empty($arrBloc)) {
		//$msg = "Désolé, aucune page trouvée dans l'outil de gestion.";	
		//header("location:/cms/");		
	} else {	
		
	
	//General	
		$_SESSION['bloc']['Id'] = $arrBloc[0]['blocId'];
		$_SESSION['bloc']['Page'] = $arrBloc[0]['page'];
		$_SESSION['bloc']['CatBloc'] = $arrBloc[0]['categorie_bloc'];
		$_SESSION['bloc']['NomFichier'] = $arrBloc[0]['nom_fichier'];		
		//Francais
		$_SESSION['bloc']['Titre'] = $arrBloc[0]['blocTitre'];
		$_SESSION['bloc']['APartir'] = $arrBloc[0]['a_partir'];
		$_SESSION['bloc']['UrlDetails'] = $arrBloc[0]['url_details'];	
		$_SESSION['bloc']['UrlBooking'] = $arrBloc[0]['url_booking'];	
		//Anglais
		$_SESSION['bloc']['TitreEn'] = $arrBloc[0]['blocTitreEn'];
		$_SESSION['bloc']['APartirEn'] = $arrBloc[0]['a_partir_en'];
		$_SESSION['bloc']['UrlDetailsEn'] = $arrBloc[0]['url_details_en'];	
		$_SESSION['bloc']['UrlBookingEn'] = $arrBloc[0]['url_booking_en'];	
		//unset($_SESSION['bloc']);
	}		
	
	
	
	
	
		
	
	
} else {
	//SI AUCUN PARAMETRE DE PAGE POUR LE MODULE, ON RETOURNE À L'ACCUEIL
	header("location:/cms/");	
}




//echo($_REQUEST['action']);



//print_r($_SESSION['page']);







////OLD STUFF/////

//*****Liste des éléments de l'accueil*****//

	$res = mysql_query("SELECT c.*, s.*
						 FROM categories c,sections s 
						 WHERE s.sections_categories_id = c.categories_id					  
						 AND c.categories_id = 12
						AND s.sections_afficher=1								
						ORDER by s.sections_ordre ASC
						
						
						");	
		
	$arrElements= array();
	if(mysql_num_rows($res) != 0){
		while ($d=mysql_fetch_assoc($res))
			$arrElements[]=$d;
	}	


$eqAnglais = '/en';
$eqFrancais = '/fr';

//*****PHOTOGRAPHIES DE LA PAGE*****//
//Selection des photographies de l'entete
$res = mysql_query("SELECT *
				   FROM photographies
				   WHERE photographies_sections_id=" . $idSectionAccueil . "
				   AND photographies_afficher=2 				  
				   ORDER BY photographies_ordre ASC
					");	
	
$arrPhotosEntete= array();
if(mysql_num_rows($res) != 0){
	while ($d=mysql_fetch_assoc($res))
		$arrPhotosEntete[]=$d;
}	


foreach($arrPhotosEntete as $p) { 	
		$photoCaroussel .= photoCaroussel('/dynamique/photographies/',$p['photographies_id'],'-entete-',$p['photographies_fichier_2'],$p['photographies_keywords' . $lng],$p['photographies_nom' . $lng]);
	  
}



?>