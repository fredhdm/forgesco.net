<?php 
header_remove('Access-Control-Allow-Origin');
header('Access-Control-Allow-Origin: *');  
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');

session_start(); ?>
<?php
//session_destroy();
//session_unset();
unset($_SESSION['sql']);
//DEBUG MODE
if(isset($_REQUEST['debug'])) {
	$_SESSION['debug']=$_REQUEST['debug'];
	//echo($_SESSION['debug']);
}

//echo('allo');
include($_SERVER['DOCUMENT_ROOT'] . '/includes/conn.php');
include($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');

header('Expires: '.gmdate("D, d M Y H:i:s", time()+604800).'GMT');

global $pageActuelle;

//*****Informations relatives à la navigation*****//
$domaineEnCours = (($_SERVER["HTTPS"]=='on')?('https'):('http')) . "://". $_SERVER['HTTP_HOST'];
$urlEnCours = $_SERVER['REQUEST_URI'];

////CMS 2016////
//ID de la section accueil dans le CMS
$idPageAccueil = 1;


//CRÉATION DES MENUS
$res = mysql_query("SELECT  p.*,enfant.id as enfantId, enfant.parent as enfantParent,  
enfant.titre as enfantTitre, enfant.url_prefere as enfantUrlPrefere,
enfant.titre_en as enfantTitre_en, enfant.url_prefere_en as enfantUrlPrefere_en
						FROM page p, page enfant
						WHERE enfant.parent = p.id	
						AND enfant.actif=1 AND p.actif=1						
						ORDER BY enfant.titre_en ASC	
						");	
					
	$arrMenu = array();
	if(mysql_num_rows($res) != 0){
		while ($d=mysql_fetch_assoc($res))
			$arrMenu[]=$d;
	}
	
//CRÉATION DU SOUS MENU DES HÔTELS
$_SESSION['sql']['sqlSousMenuHotel']="SELECT 
p2.id, p2.titre as rootTitre, p3.id as hotelId,  p3.titre as hotelNom, p3.titre_en as hotelNom_en, p3.url_prefere as hotelUrl,p3.url_prefere_en as hotelUrl_en, p3.famille,i.nom_fichier as hotelImage
FROM page p2
inner join page p3
on p3.parent=p2.id
and p3.parent=1
and p3.famille=2
inner join image i
on i.page=p3.id
AND i.categorie_image=3
AND p2.actif=1 and p3.actif=1
AND i.langue = '" . $lng . "'
ORDER BY p3.ordre ASC";

$res = mysql_query($_SESSION['sql']['sqlSousMenuHotel']);	
					
	$arrMenuHotel = array();
	if(mysql_num_rows($res) != 0){
		while ($d=mysql_fetch_assoc($res))
			$arrMenuHotel[]=$d;
	}



	$arrNomsHotels = array(
								'a_partir_de_gahs' => array(
								'id' => 98,
								'fr' => 'Grande Allée Hôtel et Suites',
								'en' => 'Grande Allee Hotel & Suites',
								'phone' => '1800263-1471',
								'couleur' => '7a212e'),
								
									'a_partir_de_ha' => array(
									'id' => 99,
								'fr' => 'Hôtel Acadia',
								'en' => 'Acadia Hotel',
								'phone' => '14186940280',
								'couleur' => '5a5500'),
								
								
									'a_partir_de_hh' => array(
									'id' => 100,								
								'fr' => 'Hôtel L’Ermitage',
								'en' => 'Hôtel L’Ermitage',
								'couleur' => 'c9a600'),
								
									'a_partir_de_hl' => array(
									'id' => 101,
								'fr' => 'Hôtel Louisbourg',
								'en' => 'Hôtel Louisbourg',
								'couleur' => '49615d'),
								
									'a_partir_studio' => array(
									'id' => 133,
								'fr' => 'Studios Nouvelle-France',
								'en' => 'Studios Nouvelle-France',
								'couleur' => '49615d')
	);
	
	
	$arrOptionsHotels = array(
								
								
									99 => array(		
									
								'fr' => 'Hôtel Acadia',
								'en' => 'Hôtel Acadia',
								'couleur' => '5a5500'),
								
								
									100 => array(		
															
								'fr' => 'Hôtel L’Ermitage',
								'en' => 'Hôtel L’Ermitage',
								'couleur' => 'c9a600'),
								
									101 => array(		
									
								'fr' => 'Hôtel Louisbourg',
								'en' => 'Hôtel Louisbourg',
								'couleur' => '49615d'),
								
								98 => array(								
								'fr' => 'Grande Allée Hôtel et Suites',
								'en' => 'Grande Allée Hôtel et Suites',
								'couleur' => '7a212e'),
								
									102 => array(		
									
								'fr' => 'Studios Nouvelle-France',
								'en' => 'Studios Nouvelle-France',
								'couleur' => '49615d')
	);
	
	
	$arrFormulaires = array(	 102,103,104,105,137		);



////CMS 2016////






/////OLD STUFF//////


//ID de la page 404
$id404 = 54;


//Date
date_default_timezone_set('America/Montreal');


?>