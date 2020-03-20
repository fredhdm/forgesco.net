<?php
session_start();
$pageActuelle = basename($_SERVER['SCRIPT_FILENAME'],'.php');


if(!$_SESSION['login'] && $pageActuelle != 'index') {
	header('Location:/cms');
	exit();	
}

include($_SERVER['DOCUMENT_ROOT'] . "/includes/parametres.php");
include($_SERVER['DOCUMENT_ROOT'] . "/cms/includes/functions.php");


//CRÉATION DES MENUS
$res = mysql_query("SELECT  p.*,enfant.id as enfantId, enfant.parent as enfantParent,  enfant.titre as enfantTitre, enfant.url_prefere as enfantUrlPrefere, enfant.actif as enfantActif
						FROM page p, page enfant
						WHERE enfant.parent = p.id				
						
						ORDER BY enfant.titre ASC	
						");	
					
	$arrMenu = array();
	if(mysql_num_rows($res) != 0){
		while ($d=mysql_fetch_assoc($res))
			$arrMenu[]=$d;
	}
	
	//print_r($arrMenu);


?>