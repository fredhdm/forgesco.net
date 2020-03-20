<?
//*****Contenu dynamique*****//

//*****CONTENU DE LA PAGE*****//
//Selection des photographies de l'entete
$res = mysql_query("SELECT p.*, i.titre as imageTitre, i.titre_en as imageTitre_en, i.titre_referencement as imageRef, i.titre_referencement_en as imageRef_en, i.url as imageUrl, i.url_en as imageUrl_en, i.nom_fichier as imageNomFichier, i.categorie_image
				   FROM page p, image i
				   WHERE p.id=i.page
					 AND i.categorie_image=1
					 AND p.id=" . $idPageAccueil . "	  	  
				  ");	
	
$arrContenu= array();
if(mysql_num_rows($res) != 0){
	while ($d=mysql_fetch_assoc($res))
		$arrContenu[]=$d;
}	

//print_r($arrContenu);



	foreach($arrContenu as $p) { 	
	if($p['categorie_image']==1) {			
			$photoCaroussel .= photoCaroussel('/dynamique/images/',(rawurlencode($p['imageNomFichier'])),$p[getValue('imageTitre',$lng)],$p[getValue('imageRef',$lng)],$p[getValue('imageUrl',$lng)],'',$lng);		
	}
	}
	
	$og_image_facebook = '/images/0_facebook-og-image.jpg';
	
	
	$_SESSION['contenu'] = $arrContenu;
	//echo();
	
	
	//*****BLOC*****//
//Selection des photographies de l'entete
	$res = mysql_query("SELECT p.*, 
	b.*,b.page,b.nom_fichier as blocNomFichier, 
	b.titre as blocTitre, b.url_details as urlDetails,b.url_booking as urlBooking,b.a_partir as aPartirBloc,
	b.titre_en as blocTitre_en, b.url_details_en as urlDetails_en,b.url_booking_en as urlBooking_en,  b.a_partir_en as aPartirBloc_en, 
	cb.*,cb.id,cb.titre as categorieBlocTitre 
	FROM page p,  bloc b, categorie_bloc cb
	WHERE  b.page = p.id 
	AND cb.id = b.categorie_bloc
	 AND p.id=" . $idPageAccueil . "	
	 LIMIT 7 
	");	
	
$arrBloc= array();
if(mysql_num_rows($res) != 0){
	while ($d=mysql_fetch_assoc($res))
		$arrBloc[]=$d;
}	

	



?>