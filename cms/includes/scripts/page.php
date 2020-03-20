<?php

//*****Contenu dynamique*****//

//echo($_REQUEST['urlprefereP']);

//RETIRER LES INFOS DE SESSION DE LA DERNIERE IMAGE GÉRÉE
unset($_SESSION['image']);
unset($_SESSION['bloc']);



//SI ON EST EN MODE ÉDITION D'UNE PAGE
if(isset($_REQUEST['urlprefereP'])) {
	
	if(isset($_REQUEST['champs']) && !empty($_REQUEST['champs'])) {
			mysql_query("DELETE FROM champs_options  WHERE id = " . $_REQUEST['champs'] . " LIMIT 1");
			header('location:/cms/page/' . $_REQUEST['urlprefereP'] . '#speciaux');
			exit;
		}
	
	
	if(isset($_REQUEST['delete']) && !empty($_REQUEST['delete'])) {
		
		
		
		//Copier les données effacées dans une nouvelle table
		mysql_query(
					"INSERT INTO page_backup
					(		
					id,
					famille,
					famille_max,	
					parent,
					bloc_supplementaire,					
					image,
					ordre,
					actif,
					
					url_prefere,
					titre,
					sous_titre,	
					meta_description,		
					description,
					texte,
					
					url_prefere_en,
					titre_en,
					sous_titre_en,	
					meta_description_en,		
					description_en,
					texte_en
					)
					VALUES 
					(" . 	
					$_SESSION['page']['Id']		 . "," . 
					$_SESSION['page']['Famille'] . "," . 
					$_SESSION['page']['FamilleMax'] . "," . 
					$_SESSION['page']['Parent'] . ",'" . 					
					$_SESSION['page']['Bloc'] . "','" . 
					$_SESSION['page']['Image'] . "'," . 
					$_SESSION['page']['Ordre'] . "," .
					$_SESSION['page']['Actif'] . ",'" . 
					
					$_SESSION['page']['Url'] . "','" . 
					$_SESSION['page']['Titre'] . "','" . 
					$_SESSION['page']['SousTitre'] . "','" . 
					$_SESSION['page']['MetaDescription'] . "','" . 
					$_SESSION['page']['Description'] . "','" . 
					$_SESSION['page']['Texte'] . "','" . 
					
					$_SESSION['page']['UrlEn'] . "','" . 
					$_SESSION['page']['TitreEn'] . "','" . 
					$_SESSION['page']['SousTitreEn'] . "','" . 
					$_SESSION['page']['MetaDescriptionEn'] . "','" . 
					$_SESSION['page']['DescriptionEn'] . "','" . 
					$_SESSION['page']['TexteEn'] . "')");	
					
					
		
		
		mysql_query("DELETE FROM page  WHERE id = " . $_REQUEST['urlprefereP']);
		header('location:/cms');
	}
	
	
	$_SESSION['page']['UrlPrefere'] = $_REQUEST['urlprefereP'];
	
	$_SESSION['infoAjoutPage']['UrlPrefere'] = $_REQUEST['urlprefereP'];
		
			
			
			
			
//DANS LE FICHIER HTACCESS, LORSQU'ON AJOUTE UN ENFANT À UN PARENT
if(isset($_REQUEST['parentId']) && isset($_GET['famille'])) {
	
	
	
	unset($_SESSION['page']);
	
	$_SESSION['page']['Parent'] = $_REQUEST['parentId'];
	$_SESSION['page']['NiveauNouvellePage'] = $_GET['famille']+1;
	
		
		
	$debug['htaccess']='ajout enfant';
	
	
	
} else {

unset($_SESSION['page']['Parent']);
unset($_SESSION['page']['Famille']);
unset($_SESSION['page']['NiveauNouvellePage']);
unset($_SESSION['page']['FamilleMax']);
unset($_SESSION['FamilleMax']);
	
	
	
		
		
}


//SAVOIR S'IL Y A DES OPTIONS 
$optionsRegulieresSQL = "SELECT  page2.*, page3.*, page4.*, c.*
								FROM  page page2, page page3, page page4, champs_options c
								WHERE c.famille = page4.famille
								AND page4.parent = page3.id
								AND page3.parent = page2.id
								AND c.parent = page2.id
								AND page4.id = " . $_REQUEST['urlprefereP'] . "
								ORDER by c.ordre ASC";
								
$optionsAjoutEnfantSQL = "SELECT  page2.*, page3.*, c.*
								FROM  page page2, page page3,  champs_options c
								WHERE c.famille = " . $_SESSION['page']['NiveauNouvellePage'] . "
								
								AND page3.parent = page2.id
								AND c.parent = page2.id
								AND page3.id = " . $_REQUEST['urlprefereP'] . "
								ORDER by c.ordre ASC";
$sql='';
$sql = ((!empty($_SESSION['page']['NiveauNouvellePage']))?($optionsAjoutEnfantSQL):($optionsRegulieresSQL));

//EST CE QU'IL Y A DES OPTIONS LIÉES À CETTE PAGE?	
		$res = mysql_query($sql);	
								
								
		$debug['ChampsOptionsDebutFred'] = ($sql);	
							
			$arrChampsOptionsGeneraux = array();
			if(mysql_num_rows($res) != 0){
				while ($d=mysql_fetch_assoc($res))
					$arrChampsOptionsGeneraux[]=$d;
			}
			
			
			
			
			//S'il n'y a rien au niveau 4, on va voir au niveau 3
			if(empty($arrChampsOptionsGeneraux)) {
				
				$sql='';

$sql = "SELECT  page2.*,  c.*
								FROM  page page2, champs_options c
								WHERE c.famille = " . $_SESSION['page']['NiveauNouvellePage'] . "
								AND c.parent = page2.id
								AND page2.id = " . $_REQUEST['urlprefereP'] . "
								ORDER by c.ordre ASC";
								

$res = mysql_query($sql);	
$debug['ChampsOptionsLinkPageFred'] = ($sql);	

$optionsRegulieresSQL = "SELECT  page2.*, page3.*, c.*, c.parent as champsParent
								FROM  page page2, page page3, champs_options c
								WHERE c.famille = page3.famille								
								AND page3.parent = page2.id
								AND c.parent = page2.id
								AND page3.id = " . $_REQUEST['urlprefereP'] . "
								ORDER by c.ordre ASC";
								
$optionsAjoutEnfantSQL = "SELECT  page2.*,  c.*
								FROM  page page2, champs_options c
								WHERE c.famille = " . $_SESSION['page']['NiveauNouvellePage'] . "
								AND c.parent = page2.id
								AND page2.id = " . $_REQUEST['urlprefereP'] . "
								ORDER by c.ordre ASC";
$sql='';
$sql = ((!empty($_SESSION['page']['NiveauNouvellePage']))?($optionsAjoutEnfantSQL):($optionsRegulieresSQL));

//EST CE QU'IL Y A DES OPTIONS LIÉES À CETTE PAGE?	
		$res = mysql_query($sql);	
								
								
		$debug['ChampsOptionsDebutFred2'] = ($sql);	
							
			$arrChampsOptionsGeneraux = array();
			if(mysql_num_rows($res) != 0){
				while ($d=mysql_fetch_assoc($res))
					$arrChampsOptionsGeneraux[]=$d;
			}
				
				
	}
		
		//print_r($arrChampsOptionsGeneraux);	
	
	
	//RÉCUPÉRATION DES DONNÉES VENANT DU URL PRÉFÉRÉ.	
	$sql='';
	if(!empty($_SESSION['page']['Parent'])) {
		
		
		
		$sql = " AND parent = " . $_SESSION['page']['Parent'] . " ";
	} 
	
	
	$res = mysql_query("SELECT *
						FROM page
						WHERE id = " . $_REQUEST['urlprefereP']  . "	
						" . $sql . "					
						LIMIT 1									
						");	
					
	$arrGestion = array();
	if(mysql_num_rows($res) != 0){
		while ($d=mysql_fetch_assoc($res))
			$arrGestion[]=$d;
	}
	
	$debug['loadingFred']="SELECT *
						FROM page
						WHERE id = " . $_REQUEST['urlprefereP']  . "	
						" . $sql . "					
						LIMIT 1									
						";
	
	if(empty($arrGestion) && empty($_SESSION['page']['Parent'])) {
		$msg = "Désolé, aucune page trouvée dans l'outil de gestion.";	
		unset($_SESSION['page']);	
	} else {	
		//General	
		$_SESSION['page']['Id'] = htmlentities($arrGestion[0]['id']);
		$_SESSION['page']['Famille'] = ((!empty($_SESSION['page']['NiveauNouvellePage']))?($_SESSION['page']['NiveauNouvellePage']):(htmlentities($arrGestion[0]['famille'])));
			$_SESSION['page']['FamilleMax'] = ((!empty($_SESSION['page']['FamilleMax']))?($_SESSION['page']['FamilleMax']):(htmlentities($arrGestion[0]['famille_max'])));
		$_SESSION['page']['Parent'] = ((!empty($_SESSION['page']['Parent']))?($_SESSION['page']['Parent']):(htmlentities($arrGestion[0]['parent'])));
		
		$_SESSION['page']['Bloc'] = ((empty($arrGestion[0]['bloc_supplementaire']))?(2):(htmlentities($arrGestion[0]['bloc_supplementaire'])));
		$_SESSION['page']['Image'] = ((empty($arrGestion[0]['image']))?(1):(htmlentities($arrGestion[0]['image'])));
		
		$_SESSION['page']['Ordre'] = htmlentities($arrGestion[0]['ordre']);
		$_SESSION['page']['Actif'] = htmlentities($arrGestion[0]['actif']);
		//Francais
		$_SESSION['page']['Url'] = htmlentities($arrGestion[0]['url_prefere']);
		$_SESSION['page']['Titre'] = htmlentities($arrGestion[0]['titre']);
		$_SESSION['page']['SousTitre'] = htmlentities($arrGestion[0]['sous_titre']);
		$_SESSION['page']['MetaDescription'] = htmlentities($arrGestion[0]['meta_description']);
		$_SESSION['page']['Description'] = htmlentities($arrGestion[0]['description']);
		$_SESSION['page']['Texte'] = htmlentities($arrGestion[0]['texte']);
		//Anglais
		$_SESSION['page']['UrlEn'] = htmlentities($arrGestion[0]['url_prefere_en']);
		$_SESSION['page']['TitreEn'] = htmlentities($arrGestion[0]['titre_en']);
		$_SESSION['page']['SousTitreEn'] = htmlentities($arrGestion[0]['sous_titre_en']);
		$_SESSION['page']['MetaDescriptionEn'] = htmlentities($arrGestion[0]['meta_description_en']);
		$_SESSION['page']['DescriptionEn'] = htmlentities($arrGestion[0]['description_en']);
		$_SESSION['page']['TexteEn'] = htmlentities($arrGestion[0]['texte_en']);
		
		
		//RÉCUPÉRATION	DES CHAMPS OPTIONNELS DE CETTE PAGE SI ON EST EN MODE ÉDITION	
	$res = mysql_query("SELECT  page2.*, page3.*, page4.*, c.*, d.*
								FROM  page page2, page page3, page page4, champs_options c, champs_options_data d
								WHERE d.page=page4.id
								AND c.famille = page4.famille
								AND page4.parent = page3.id
								AND page3.parent = page2.id
								AND c.parent = page2.id
								AND d.nom_champs = c.nom_champs
								AND page4.id = " . $_SESSION['page']['Id']
								);	
								
								
								$debug['arrChampsOptionsÉditionSQLFred'] = ("SELECT  page2.*, page3.*, page4.*, c.*, d.*
								FROM  page page2, page page3, page page4, champs_options c, champs_options_data d
								WHERE d.page=page4.id
								AND c.famille = page4.famille
								AND page4.parent = page3.id
								AND page3.parent = page2.id
								AND c.parent = page2.id
								AND d.nom_champs = c.nom_champs
								AND page4.id = " . $_SESSION['page']['Id']);	
							
			$arrChampsOptionsEntrees = array();
			if(mysql_num_rows($res) != 0){
				while ($d=mysql_fetch_assoc($res))
					$arrChampsOptionsEntrees[]=$d;
			}
			
			//S'il n'y a pas de champs, on vérifie qu'il n'y en a pas au niveau précédent
			if(empty($arrChampsOptionsEntrees)) {
				
				
				$res = mysql_query("SELECT  page3.*, page4.*, c.*, d.*
								FROM   page page3, page page4, champs_options c, champs_options_data d
								WHERE d.page=page4.id
								AND c.famille = page4.famille
								AND page4.parent = page3.id
								
								AND c.parent = page3.id
								AND d.nom_champs = c.nom_champs
								AND page4.id = " . $_SESSION['page']['Id']
								);	
								
								
								$debug['arrChampsOptionsÉditionSQLFred'] = ("SELECT  page3.*, page4.*, c.*, d.*
								FROM   page page3, page page4, champs_options c, champs_options_data d
								WHERE d.page=page4.id
								AND c.famille = page4.famille
								AND page4.parent = page3.id
								
								AND c.parent = page3.id
								AND d.nom_champs = c.nom_champs
								AND page4.id = " . $_SESSION['page']['Id']);	
								
								$arrChampsOptionsEntrees = array();
			if(mysql_num_rows($res) != 0){
				while ($d=mysql_fetch_assoc($res))
					$arrChampsOptionsEntrees[]=$d;
			}
				
				
			}
			

			//OPTIONS
	foreach($arrChampsOptionsEntrees as $champs => $value) {
			$_SESSION['page'][$value['nom_champs']] = htmlentities($value['contenu']);
			$debug['arrChampsOptionsEntrees'] = $value['nom_champs']  . "=>" .  $value['contenu'];
		}
	
		
	}		
	
	
	
	
	
	
				
			
	
		
	
	
	//SI UN MODULE EST DEMANDÉ, ON ENREGISTRE LES DONNÉES ET ON REDIRIGE VERS LA BONNE PAGE.
	if(isset($_REQUEST['action'])) {
		//QUELLE ACTION EST DEMANDÉE VENANT DU FORMULAIRE (ENFANT, BLOC, IMAGE, UPDATE RÉGULIER)
		$_SESSION['page']['Module'] = $_REQUEST['action'];
		
		$debug['Action'] = $_REQUEST['action'] ;
		
						
		

		//General	
		$_SESSION['page']['Id'] = addslashes($_REQUEST['id']);
		$_SESSION['page']['Famille'] = addslashes($_REQUEST['famille']);
		$_SESSION['page']['FamilleMax'] = addslashes($_REQUEST['famille_max']);
		$_SESSION['FamilleMax']=$_SESSION['page']['FamilleMax'];
		
		$_SESSION['page']['Parent'] = addslashes($_REQUEST['parent']);
		$_SESSION['page']['Bloc'] = addslashes($_REQUEST['bloc_supplementaire']);
		$_SESSION['page']['Image'] = addslashes($_REQUEST['image']);
		$_SESSION['page']['Ordre'] = addslashes($_REQUEST['ordre']);
		$_SESSION['page']['Actif'] = addslashes($_REQUEST['actif']);
		//Francais
		$_SESSION['page']['Url'] = ((empty($_REQUEST['url_prefere']))?(stripAccents(addslashes($_REQUEST['titre']))):(addslashes($_REQUEST['url_prefere'])));
		$_SESSION['page']['Titre'] = addslashes($_REQUEST['titre']);
		$_SESSION['page']['SousTitre'] = addslashes($_REQUEST['sous_titre']);
		$_SESSION['page']['MetaDescription'] = addslashes($_REQUEST['meta_description']);
		$_SESSION['page']['Description'] = addslashes($_REQUEST['description']);
		$_SESSION['page']['Texte'] = addslashes($_REQUEST['texte']);
		//Anglais
		$_SESSION['page']['UrlEn'] = ((empty($_REQUEST['url_prefere_en']))?(stripAccents(addslashes($_REQUEST['titre_en']))):(addslashes($_REQUEST['url_prefere_en'])));
		$_SESSION['page']['TitreEn'] = addslashes($_REQUEST['titre_en']);
		$_SESSION['page']['SousTitreEn'] = addslashes($_REQUEST['sous_titre_en']);
		$_SESSION['page']['MetaDescriptionEn'] = addslashes($_REQUEST['meta_description_en']);
		$_SESSION['page']['DescriptionEn'] = addslashes($_REQUEST['description_en']);
		$_SESSION['page']['TexteEn'] = addslashes($_REQUEST['texte_en']);
			
				//print_r($arrChampsOptionsGeneraux);	
			
		//OPTIONS
	foreach($arrChampsOptionsGeneraux as $champs => $value) {
			$_SESSION['page'][$value['nom_champs'] ] = addslashes($_REQUEST[$value['nom_champs']]);
			
		}
		
		
	
		
		
		
		if(!empty($_SESSION['page']['Id'])) {
			
			
		$debug['UpdateDePage'] = 'oui' ;
			
			//echo('allo');
			
			
		//UPDATE DE LA TABLE PAGE
			mysql_query(
			
				"UPDATE page 
				SET 	
							
				famille=" . addslashes($_SESSION['page']['Famille']) . ",
				famille_max=" . addslashes($_SESSION['page']['FamilleMax']) . ",
				parent=" . ((empty($_SESSION['page']['Parent']))?(0):(addslashes($_SESSION['page']['Parent']))) . ",
				bloc_supplementaire=" . ((empty($_SESSION['page']['Bloc']))?(2):(addslashes($_SESSION['page']['Bloc']))) . ",
				image=" . ((empty($_SESSION['page']['Image']))?(0):(addslashes($_SESSION['page']['Image']))) . ",
				ordre=" . addslashes($_SESSION['page']['Ordre']) . ", 
				actif=" . addslashes($_SESSION['page']['Actif']) . ", 
				
				url_prefere='" . addslashes($_SESSION['page']['Url']) . "', 
				titre='" . addslashes($_SESSION['page']['Titre']) . "', 	
				sous_titre='" . addslashes($_SESSION['page']['SousTitre']) . "', 
				meta_description='" . addslashes($_SESSION['page']['MetaDescription']) . "', 
				description='" . addslashes($_SESSION['page']['Description']) . "', 
				texte='" . addslashes($_SESSION['page']['Texte']) . "', 
				
				url_prefere_en='" . addslashes($_SESSION['page']['UrlEn']) . "', 			
				titre_en='" . addslashes($_SESSION['page']['TitreEn']) . "',
				sous_titre_en='" . addslashes($_SESSION['page']['SousTitreEn']) . "',								
				meta_description_en='" . addslashes($_SESSION['page']['MetaDescriptionEn']) . "', 
				description_en='" . addslashes($_SESSION['page']['descriptionEn']) . "', 	
				texte_en='" . addslashes($_SESSION['page']['TexteEn']) . "'
				
				WHERE id=". $_SESSION['page']['Id']
				
				);	
				
				
				
				
				
				
		//AJOUT DE LA NOUVELLE PAGE
				} else {
					
					$debug['AjouteDePage'] = 'oui' ;	
					
					
					
					mysql_query(
					"INSERT INTO page
					(		
					famille,
					famille_max,	
					parent,
					bloc_supplementaire,					
					image,
					ordre,
					actif,
					
					url_prefere,
					titre,
					sous_titre,	
					meta_description,		
					description,
					texte,
					
					url_prefere_en,
					titre_en,
					sous_titre_en,	
					meta_description_en,		
					description_en,
					texte_en
					)
					VALUES 
					(" . 			 
					$_SESSION['page']['Famille'] . "," . 
					$_SESSION['page']['FamilleMax'] . "," . 
					$_SESSION['page']['Parent'] . ",'" . 					
					$_SESSION['page']['Bloc'] . "','" . 
					$_SESSION['page']['Image'] . "'," . 
					$_SESSION['page']['Ordre'] . "," .
					$_SESSION['page']['Actif'] . ",'" . 
					
					$_SESSION['page']['Url'] . "','" . 
					$_SESSION['page']['Titre'] . "','" . 
					$_SESSION['page']['SousTitre'] . "','" . 
					$_SESSION['page']['MetaDescription'] . "','" . 
					$_SESSION['page']['Description'] . "','" . 
					$_SESSION['page']['Texte'] . "','" . 
					
					$_SESSION['page']['UrlEn'] . "','" . 
					$_SESSION['page']['TitreEn'] . "','" . 
					$_SESSION['page']['SousTitreEn'] . "','" . 
					$_SESSION['page']['MetaDescriptionEn'] . "','" . 
					$_SESSION['page']['DescriptionEn'] . "','" . 
					$_SESSION['page']['TexteEn'] . "')");	
					
					$_SESSION['page']['Id'] = mysql_insert_id();	
				
				$arrErreur = array();
				array_push($arrErreur,mysql_error ($dbh));
				
					//AJOUT AUTOMATIQUE D'UNE IMAGE TEMPORAIRE
					mysql_query(
						"INSERT INTO image
						(		
						page,	
						categorie_image,
						nom_fichier,
						
						titre,			
						
						titre_en
						
						)
						VALUES 
						(" . 			 
						$_SESSION['page']['Id'] . ",
						1,'0_image_temporaire.png','" . 
						
						$_SESSION['page']['Titre'] . "','" . 
						
						$_SESSION['page']['TitreEn'] . "'),
						
						(" . 			 
						$_SESSION['page']['Id'] . ",
						2,'0_image_temporaire.png','" . 
						
						$_SESSION['page']['Titre'] . "','" . 
						
						$_SESSION['page']['TitreEn'] . "')"
					);	
					
					
				array_push($arrErreur,mysql_error ($dbh));
				
				}
			
			
				if(!empty($arrChampsOptionsGeneraux)) {
						$sqlInsert = '';
						foreach($arrChampsOptionsGeneraux as $champs => $value) {
							$sqlInsert .= "(" . $_SESSION['page']['Id'] . ",'" . $value['nom_champs'] . "','" . $_SESSION['page'][$value['nom_champs']] . "'),";
						}
						$sqlInsert= trim($sqlInsert,",");		
						
						$sqlUpdate = '';
						foreach($arrChampsOptionsGeneraux as $champs => $value) {
							$sqlUpdate = "contenu=VALUES(contenu)";
						}
						$sqlUpdate= trim($sqlUpdate,",");		
						
						//$sqlUpdate = 'contenu=' . $sqlUpdate;
						
						
						$debug['Insert']=(					
							"INSERT INTO champs_options_data
								(page, nom_champs, contenu)
							VALUES
							 " . $sqlInsert . "
							ON DUPLICATE KEY UPDATE " . 
							$sqlUpdate
						
						);
						
						mysql_query("INSERT INTO champs_options_data
								(page, nom_champs, contenu)
							VALUES
							 " . $sqlInsert . "
							ON DUPLICATE KEY UPDATE " . 
							$sqlUpdate);
				
				}
				
				array_push($arrErreur,mysql_error ($dbh));
			
		
	//OPTIONS
	foreach($arrChampsOptionsEntrees as $champs => $value) {
		
			unset($_SESSION['page'][$value['nom_champs']]);
			
		}
				
				
		if(mysql_error ($dbh)) {
			$erreur = '';
			foreach($arrErreur as $e) {
				$erreur .= $e . '<br><br>';
			}
			$msg = "Il y a eu une erreur lors de l'enregistremement de votre page. Veuillez envoyer l'erreur suivante à <a href=\"mailto:" . $_SESSION['admSupport'] . "\">" . $_SESSION['admSupport'] . "</a>.<br><br>
" . $erreur . "<br>
<br>
<a href=\"/cms/page/" . $_SESSION['page']['UrlPrefere'] . "\"><i class=\"fa fa-arrow-circle-o-left fa-lg\"></i> Retour à la page précédente</a>.<br><br>
";
			
		}	else {
			if($_SESSION['page']['Module'] != 'update') {
				if($_SESSION['page']['Module']=='enfant') {
					header("location:/cms/page/" . $_SESSION['page']['UrlPrefere'] . "/" . $_SESSION['page']['Id'] . "/" . $_SESSION['page']['Famille']);	
				} else {
					header("location:/cms/" . $_SESSION['page']['Module'] . "/" . $_SESSION['page']['Id']);	
				}
						
			} else {
				$msg = "La page " . sslashesCMS($_SESSION['page']['Titre']) . " (" . sslashesCMS($_SESSION['page']['Url']) . ") a été mise à jour ! <br>
<br>
<a href=\"/cms/page/" . $_REQUEST['urlprefereP'] . "\"><i class=\"fa fa-arrow-circle-o-left fa-lg\"></i> Revenir à la gestion de la page précédente</a>.<br><br>";
			}
		}
	}
	
	
	
	
	
	
	//RÉCUPÉRATION	DES IMAGES ENTRÉES	
	$res = mysql_query("SELECT  i.*, i.id as imageId, i.titre as imageTitre, p.*, p.id as pageId, c.*
						FROM image i, page p, categorie_image c
						WHERE i.page = p.id
						AND p.id = " . $_SESSION['page']['Id'] . "
						AND c.id = i.categorie_image
						ORDER BY i.categorie_image ASC, i.langue ASC, i.titre ASC
						");	
					
	$arrImage = array();
	if(mysql_num_rows($res) != 0){
		while ($d=mysql_fetch_assoc($res))
			$arrImage[]=$d;
	}
	
	//RÉCUPÉRATION	DES BLOC ENTRÉES	
	$res = mysql_query("SELECT  b.*, b.id as blocId, b.titre as blocTitre, p.*,p.id as pageId, c.*
						FROM bloc b, page p, categorie_bloc c
						WHERE b.page = p.id
						AND p.id = " . $_SESSION['page']['Id'] . "
						AND c.id = b.categorie_bloc
						ORDER BY b.categorie_bloc ASC, b.titre ASC
						");	
					
	$arrBloc = array();
	if(mysql_num_rows($res) != 0){
		while ($d=mysql_fetch_assoc($res))
			$arrBloc[]=$d;
	}
	
	//RÉCUPÉRATION	DES PARENTS ENTRÉES	
	$res = mysql_query("SELECT  p.*,  enfant.titre as enfantTitre, enfant.sous_titre as enfantSousTitre, enfant.*, enfant.id as enfantId, enfant.url_prefere as enfantUrlPrefere,i.*
						FROM page p, page enfant, image i
						WHERE enfant.parent = p.id
						AND i.page = enfant.id						
						AND p.id = " . $_SESSION['page']['Id'] . "
						AND p.parent >0
						GROUP BY i.page
						ORDER BY enfant.titre ASC
						");	
					
	$arrEnfant = array();
	if(mysql_num_rows($res) != 0){
		while ($d=mysql_fetch_assoc($res))
			$arrEnfant[]=$d;
	}
	
	
	
		
}





?>