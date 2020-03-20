<?
//*****Contenu dynamique*****//

global $sql;

if (isset($_REQUEST['template']) && !empty($_REQUEST['template'])){
	$template = $_REQUEST['template'];
}


if(isset($_REQUEST['p2url']) && !empty($_REQUEST['p2url']) && isset($_REQUEST['p3url']) && !empty($_REQUEST['p3url']) &&  isset($_REQUEST['p4url']) && !empty($_REQUEST['p4url'])) {
	$p2url = $_REQUEST['p2url'];
	$p3url = $_REQUEST['p3url'];
	$p4url = $_REQUEST['p4url'];
	
	
} else if (isset($_REQUEST['p2url']) && !empty($_REQUEST['p2url']) && isset($_REQUEST['p3url']) && !empty($_REQUEST['p3url'])){
	$p2url = $_REQUEST['p2url'];
	$p3url = $_REQUEST['p3url'];
	

$_SESSION['sql']['sqlPrincipal'] = "SELECT 

p2.*, 
p2.url_prefere as urlPreferePrincipal,p2.titre as titreSecondaire, p2.meta_description as descriptionSecondaire, p2.texte as texteSecondaire,
p2.url_prefere_en as urlPreferePrincipal_en,p2.titre_en as titreSecondaire_en, p2.meta_description_en as meta_description_en, p2.texte_en as texteSecondaire_en,
p3.*, 
p3.id as idPrincipal,p3.url_prefere as urlPrefereSecondaire,p3.titre as titrePrincipal, p3.meta_description as descriptionPrincipal, p3.texte as textePrincipal,
p3.titre_en as titrePrincipal_en, p3.url_prefere_en as urlPrefereSecondaire_en,p3.meta_description_en as descriptionPrincipal_en, p3.texte_en as textePrincipal_en,
i.categorie_image,i.titre as imageTitre, i.titre_en as imageTitre_en, i.titre_referencement as imageRef, i.titre_referencement_en as imageRef_en, i.url as imageUrl, i.url_en as imageUrl_en, i.nom_fichier as imageNomFichier
FROM page p2, page p3, image i
WHERE p2." . getValue('url_prefere',$lng) . "= '" . $p2url . "'
AND p3." . getValue('url_prefere',$lng) . "= '" . $p3url . "'
AND p3.parent=p2.id
AND ((i.page = p3.id AND i.categorie_image=1) || (i.page = p2.id AND i.categorie_image=4))
AND p3.actif=1
GROUP BY i.id";


$_SESSION['sql']['sqlChamps'] = "SELECT 
p4.id as idChamps,
c.nom_champs,
c.contenu
FROM  page p3

INNER JOIN page p4
ON p4.parent=p3.id
AND p3." . getValue('url_prefere',$lng) . "= '" . $p2url . "'
AND p4." . getValue('url_prefere',$lng) . "= '" . $p3url . "'


INNER JOIN champs_options_data c
ON c.page=p4.id"
;



	
} else if (isset($_REQUEST['p2url']) && !empty($_REQUEST['p2url'])){	
	$p2url = $_REQUEST['p2url'];
	//PAGE PRINCIPALE

//page qui utilise : accueil hotel
$_SESSION['sql']['sqlPrincipal'] = "SELECT 
p2.*, 
p2.id as idPrincipal, p2.url_prefere as urlPreferePrincipal,p2.titre as titrePrincipal, p2.meta_description as descriptionPrincipal, p2.texte as textePrincipal,
p2.url_prefere_en as urlPreferePrincipal_en,p2.titre_en as titrePrincipal_en, p2.meta_description_en as descriptionPrincipal_en, p2.texte_en as textePrincipal_en,
i.categorie_image,i.titre as imageTitre, i.titre_en as imageTitre_en, i.titre_referencement as imageRef, i.titre_referencement_en as imageRef_en, i.url as imageUrl, i.url_en as imageUrl_en, i.nom_fichier as imageNomFichier
FROM page p2, image i
WHERE p2." . getValue('url_prefere',$lng) . "= '" . $p2url . "'
AND ((i.page = p2.id AND i.categorie_image=1) || (i.page = p2.id AND i.categorie_image=4))
GROUP BY i.id";


$_SESSION['sql']['sqlChamps'] = "SELECT 
p4.id as idChamps,
c.nom_champs,
c.contenu
FROM  page p4, champs_options_data c
WHERE p4." . getValue('url_prefere',$lng) . "= '" . $p2url . "'
AND c.page=p4.id"

;




	
} else {
	//abc - Retour à l'accueil avec un 404.
	//abc - exit.
}


$res = mysql_query($_SESSION['sql']['sqlPrincipal'] );	
	
$arrPrincipal= array();
if(mysql_num_rows($res) != 0){
	while ($d=mysql_fetch_assoc($res))
		$arrPrincipal[]=$d;
}	

$p2 = array('fr'=>$arrPrincipal[0]['urlPreferePrincipal'],'en'=>$arrPrincipal[0]['urlPreferePrincipal_en']);
$p3 = array('fr'=>$arrPrincipal[0]['urlPrefereSecondaire'],'en'=>$arrPrincipal[0]['urlPrefereSecondaire_en']);
$p4 = array('fr'=>$arrPrincipal[0]['urlPrefereTertiaire'],'en'=>$arrPrincipal[0]['urlPrefereTertiaire_en']);

//echo('page1=' . $page1url);

//*****CONTENU DE LA PAGE*****//


//MÉTHODE NORMALE


//RESTE DU CONTENU

//SAVOIR SI C'EST UNE PAGE D'HOTEL OU UN AUTRE TEMPLATE.
if($template=='hotel') {	
	$_SESSION['sql']['sqlSecondaire'] = "SELECT 
p2.*, p2.id as idTertiaire,
p2.url_prefere as urlTertiaire, 
p2.url_prefere_en as urlTertiaire_en, 
p3.*, 
p3.url_prefere as urlSecondaire, p3.titre as titreSecondaire,
p3.url_prefere_en as urlSecondaire_en, p3.titre_en as titreSecondaire_en,
p4.*,
p4.url_prefere as urlPrincipal, p4.titre as titrePrincipal,
p4.url_prefere_en as urlPrincipal_en, p4.titre_en as titrePrincipal_en

FROM page p2

INNER JOIN page p3
ON  p3.parent = p2.id
AND p2." . getValue('url_prefere',$lng) . "='" . $p2url . "'


LEFT JOIN page p4
ON p4.parent=p3.id 
ORDER BY p3.ordre ASC, p4.ordre ASC
"


;





	
	
} else {
	
	$_SESSION['sql']['sqlSecondaire'] ="SELECT 

p2.*, 
p2.titre as titrePrincipal, p2.meta_description as descriptionPrincipal, p2.texte as textePrincipal,
p2.titre_en as titrePrincipal_en, p2.meta_description_en as meta_description_en, p2.texte_en as textePrincipal_en,
p3.*, 
p3.titre as titreItem, p3.meta_description as descriptionItem, p3.texte as texteItem, p3.url_prefere as urlItem,
p3.titre_en as titreItem_en, p3.meta_description_en as descriptionItem_en, p3.texte_en as texteItem_en, p3.url_prefere_en as urlItem_en,
i.categorie_image,i.titre as imageTitre, i.titre_en as imageTitre_en, i.titre_referencement as imageRef, i.titre_referencement_en as imageRef_en, i.url as imageUrl, i.url_en as imageUrl_en, i.nom_fichier as photoItem
FROM page p2, page p3, image i
WHERE p2." . getValue('url_prefere',$lng) . "= '" . $p2url . "'
AND p3.parent=p2.id
AND ((i.page = p3.id AND i.categorie_image=2) )
AND p3.actif=1
GROUP BY i.id";
;


 

	
	
}

$res = mysql_query($_SESSION['sql']['sqlSecondaire']);	
	
$arrSecondaire= array();
if(mysql_num_rows($res) != 0){
	while ($d=mysql_fetch_assoc($res))
		$arrSecondaire[]=$d;
}	





//CHAMPS SUPPLÉMENTAIRES


$res = mysql_query($_SESSION['sql']['sqlChamps']);	
	
$arrChamps= array();
if(mysql_num_rows($res) != 0){
	while ($d=mysql_fetch_assoc($res))
		$arrChamps[]=$d;
}	

//$arrChampsAffichage = array();

//*****	VALEURS DES CHAMPS	SUPPLÉMENTAIRES*****//
	foreach($arrChamps as $k => $c) { 		
		$arrChampsAffichage[$c['idChamps']][$c['nom_champs']] = $c['contenu'];	
		//array_push($arrSecondaire, [$c['nom_champs'],$c['contenu']]);			
	}


	foreach($arrPrincipal as $p) { 
			if($p['categorie_image']==1) {					
			$photoCaroussel .= photoCaroussel('/dynamique/images/',rawurlencode($p['imageNomFichier']),$p[getValue('imageTitre',$lng)],$p[getValue('imageRef',$lng)],$p[getValue('imageUrl',$lng)],'',$lng);
			}
	}
	
	$og_image_facebook = '/dynamique/images/' . $arrSecondaire[0]['photoItem'];
	
	
	//SI AUCUN CONTENU A AFFICHER, ON ENVOIE À LA 404
if(count($arrPrincipal) < 1) {
	 header('HTTP/1.0 404 Not Found');
	header("Location: /" . $lng . "/404");
	exit();
}
	
	
	
	$_SESSION['contenu'] = $arrPrincipal;
	$_SESSION['sqlPrincipal'] = $sqlPrincipal;
	$_SESSION['sqlSecondaire'] = $sqlSecondaire;
	$_SESSION['sqlphoto'] = $sqlPhotos;
	$_SESSION['photoCaroussel'] = $photoCaroussel;
	
	
	



?>