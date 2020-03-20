<?php

//*****Contenu dynamique*****//




//INFO GÉNÉRALES
if(empty($_SESSION['firstTime'])) {
	
	$res = mysql_query("SELECT *
						FROM administration
						LIMIT 1												
						");	
					
	$arrAdministration = array();
	if(mysql_num_rows($res) != 0){
		while ($d=mysql_fetch_assoc($res))
			$arrAdministration[]=$d;
	}
	
	$_SESSION['login'] = false;
	$_SESSION['firstTime'] = true;
	$_SESSION['admClient'] = $arrAdministration[0]['client'];
	$_SESSION['admLogo'] = $arrAdministration[0]['logo'];
	$_SESSION['admCouleur'] = $arrAdministration[0]['couleur_dominante'];
	$_SESSION['admSite'] = $arrAdministration[0]['site_internet'];
	$_SESSION['admSupport'] = $arrAdministration[0]['courriel_support'];
	$_SESSION['admLogo'] = $arrAdministration[0]['logo'];
	$_SESSION['admLogo'] = $arrAdministration[0]['logo'];
	
}


//IDENTIFICATION
if(isset($_REQUEST['type']) && $_REQUEST['type']=='login') {
	$_SESSION['loginCourriel'] = $_REQUEST['courriel'];
	$motdepasse = $_REQUEST['motdepasse'];
	
	$res = mysql_query("SELECT *
						FROM utilisateur
						WHERE courriel = '" . $_SESSION['loginCourriel']  . "'
						AND motdepasse = '" .  $motdepasse . "'
						LIMIT 1									
						");	
					
	$arrLogin = array();
	if(mysql_num_rows($res) != 0){
		while ($d=mysql_fetch_assoc($res))
			$arrLogin[]=$d;
	}
	
	
	if(empty($arrLogin)) {
		$msg = "Désolé, aucun utilisateur n'a été trouvé avec ces informations, veuillez recommencer.";
		$_SESSION['login'] = false;
	} else {
		$_SESSION['login'] = true;
		$_SESSION['loginNom'] = $arrLogin[0]['nom'];
		$_SESSION['loginPouvoir'] = $arrLogin[0]['pouvoir'];
		
	}
	
	
	
}



//print_r($_SESSION);







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