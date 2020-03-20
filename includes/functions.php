<?php





function StripAccents($string)
{
    $string = mb_strtolower($string, 'UTF-8');
    $generateLink = str_replace(
        array(
            'à', 'â', 'ä', 'á', 'ã', 'å',
            'î', 'ï', 'ì', 'í', 
            'ô', 'ö', 'ò', 'ó', 'õ', 'ø', 
            'ù', 'û', 'ü', 'ú', 
            'é', 'è', 'ê', 'ë', 
            'ç', 'ÿ', 'ñ', 
				' ', '!', '?', '/', '(', ')', '$', ':',  '%',  '#',  '\'',  '"',  '|', ',',
        ),
        array(
            'a', 'a', 'a', 'a', 'a', 'a', 
            'i', 'i', 'i', 'i', 
            'o', 'o', 'o', 'o', 'o', 'o', 
            'u', 'u', 'u', 'u', 
            'e', 'e', 'e', 'e', 
            'c', 'y', 'n', 
				'-', '-', '-', '-', '-', '-', '-', '-',  '-',  '-',  '-',  '-', '-', '-', 
        ),
        $string
    );
 
     $arrGenerateLink = array();
	 $arrGenerateLink = explode('-',$generateLink);
	 foreach($arrGenerateLink as $key => $link) { 
        if(empty($link)) { 
          unset($arrGenerateLink[$key]); 
        } 
      } 
      $arrGenerateLink = array_values($arrGenerateLink); 
     
	 
	 $generateLink = '';
	 foreach ($arrGenerateLink as $link) {
		
		$generateLink = $generateLink . $link . '-'; 
		
	 }
	 $generateLink = strtolower(substr($generateLink,0,strlen($generateLink)-1));
	 
	 return $generateLink;      
}



function sslashes($string,$message='Ce texte apparaît car rien n\'est entré dans le CMS. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam quis malesuada arcu, sed pulvinar metus. Nullam eu venenatis dui. Morbi varius mollis enim ac rhoncus.') {
	$debug=false;
	$newString = stripslashes($string);
	if($espace==1) {
		$newString = str_replace(' ','&nbsp;',$newString);
	}
	return ((empty($newString) && $debug )?('<i style="background-color:red; color:white; padding:0 10px;">' . $message . '</i>'):($newString));
}

function formatDate($string,$ln='fr') {
	$arrMois = array(1=>"janvier","février","mars","avril","mai","juin","juillet","août","septembre","octobre","novembre","décembre");
$arrMoisEn = array(1=>"January","February","March","April","May","June","July","August","September","October","November","December");

	$arrDate = explode('-',$string);
	$jour = $arrDate[2];
	$annee = $arrDate[0];
	
	if($arrDate[1] < 10) {
		
		$chiffreMois = substr($arrDate[1],1,1);
	} else {
		$chiffreMois = $arrDate[1];
	}
	
	//$mois = 'décembre';
	if($ln=='fr') {
		$mois = $arrMois[$chiffreMois];
		return $jour . ' ' . $mois . ' ' . $annee;
	} else {
		$mois = $arrMoisEn[$chiffreMois];
		return $mois . ' ' . $jour . ', '  . $annee;
	}
}

function removeBreakLines ($input) {
	$output = str_replace(array("\r\n", "\r"), "\n", $input);
	$lines = explode("\n", $output);
	$new_lines = array();
	
	foreach ($lines as $i => $line) {
		if(!empty($line))
			$new_lines[] = trim($line);
	}
	return implode($new_lines);
}

function photoCategorie($id,$nom,$dir,$suff,$template) {
	//Détection de l'image de présentation de la section
	//echo('/' . $dir . '/' . $id . '-' .  $suff . '-' . $nom);
	if(is_file($dir . '/' . $id . '-' .  $suff . '-' . $nom)) { 
		$photoCategorie = '/' . $dir . '/' . $id . '-' .  $suff . '-' . $nom;
	} else {
		$photoCategorie = $template;
	}
	
	echo ($photoCategorie);
}



//Pour les photos en entête
function photoCaroussel($path,$fichier,$titre,$referencement,$url,$nophoto='/dynamique/images/0_image_temporaire.png',$lng='') {
		//$photoCaroussel = '';	
		
		$visibilityTitle = (($titre=='')?('style="display:none;"'):(''));
		
		return '<div class="slide" style="background-image:url(' . $path . $fichier .');"><div class="slide-container"><div class="slide-content"><div id="slider_info"><span><h4 ' . $visibilityTitle . '>' . $titre . '</h4><div id="calltoaction"' . ((empty($url))?('style="display:none;"'):('')) . '><a href="' . $url . '" title="' . $referencement . '">' . (($lng=='fr')?('Plus  d\'informations'):('More details')) . ' <i class="fa fa-chevron-right"></i></a></span></div></div></div></div></div>';	
		
}

//Pour les photos des chambres
function photoCarousselChambres($path,$fichier,$titre,$referencement,$url,$nophoto='/dynamique/images/0_image_temporaire.png',$lng='') {
		//$photoCaroussel = '';	
		return '<div class="slide" style="background-image:url(' . $path . $fichier .');"><div class="slide-container"><div class="slide-content"><div id="slider_info"><span><h4>' . $titre . '</h4><div id="calltoaction"' . ((empty($url))?('style="display:none;"'):('')) . '><a href="' . $url . '" title="' . $referencement . '">' . (($lng=='fr')?('Plus  d\'informations'):('More details')) . ' <i class="fa fa-chevron-right"></i></a></span></div></div></div></div></div>';	
		
}


//Pour afficher du contenu s'il est entré dans la BD
function showIfContent($fieldToCheck,$ifTrueBefore,$ifTrueAfter,$ifFalse) {
	return ((!empty($fieldToCheck))?($ifTrueBefore . sslashes($fieldToCheck) . $ifTrueAfter):($ifFalse));
}


function pluriel($string,$nb,$if,$not) {
	echo ((count($string)>$nb)?('s'):(''));
}

function sousMenuSite($dataMenu,$id,$lng='fr') {
	
	$codeHTML = '';
	foreach($dataMenu as $m) {	
												if($m['id']==$id) {
													$enfantEnCours = $m['enfantId'];
													
													$codeHTML .= '<li><a href="/' . $lng  . '/' . $m[getValue('url_prefere',$lng)]  . '/' . $m[getValue('enfantUrlPrefere',$lng)]  . '" title="' . $m[getValue('enfantTitre',$lng)] . '"><i class="fa fa-chevron-right"></i>' . $m[getValue('enfantTitre',$lng)] . '</a></li>';
											
													/*foreach($dataMenu as $n) {	
															if($m['enfantId']==$n['enfantParent']) {															
														
											
											$codeHTML .= '<li><a href="/cms/page/' . $n['enfantId'] . '">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $n['enfantTitre'] . '</a></li>';
											
																						
												
												}
										}*/
																		
												$parentEnCours = $m['parent'];
												}
										}


echo($codeHTML);

}


												
												

function sousMenuHotel($dataMenu,$nomHotels,$lng='fr') {
	
	$codeHTML = '';
	foreach($dataMenu as $m) {	
	
					$key = array_search($m['hotelId'], array_column($nomHotels,'id'));
					if(!empty($key) || $key===0) {
	
	
	
	$codeHTML .= '<li><a href="/' . $lng  . '/' . $m[getValue('hotelUrl',$lng)]  . '" title="' . $m[getValue('hotelNom',$lng)] . '"><i class="fa fa-chevron-right"></i>' . sslashes($m[getValue('hotelNom',$lng)]) . '</a></li>';
	
					}
										
}

echo($codeHTML);

}



function getHotel($arrNomsHotels,$nom_champs,$element) {
	
	
	
	return($arrNomsHotels[$nom_champs][$element]);
	
	
	
}

function getPhoto($array,$categorie) {
	
		foreach($array as $a) {
			if($a['categorie_image']==$categorie) {
				return $a['imageNomFichier'];
			}
		}	
	
	
	
}


//POUR RETIRER LE _fr DES nom de variable.
function getValue($value,$lng) {

	if($lng == 'fr') {
		//echo($lng);
		//return trim($value,$lng);
		return $value;
	} else if($lng=='') {
		return $value;
		echo($value);
	} else {
		return $value . '_' . $lng;
	}
	//echo($value . '_' . $lng);
}


function formatPhone($number,$type) {
	
		$number = StripAccents($number);
		$arrNumber = explode('-',$number);
		$number = '';
		foreach($arrNumber as $n) {
			$number .= $n;
		}
		//echo($number);
		
		$arrNumber = str_split($number);
		if(count($arrNumber) < 11) {
			$html =  'Le numéro doit comporter 11 chiffres.';
		} else {
			$link = '+' . $arrNumber[0] .   $arrNumber[1] . $arrNumber[2] . $arrNumber[3] . $arrNumber[4] . $arrNumber[5] . $arrNumber[6]  . $arrNumber[7] . $arrNumber[8] . $arrNumber[9] . $arrNumber[10];
		
		$formatNumber = $arrNumber[0] . ' (' .  $arrNumber[1] . $arrNumber[2] . $arrNumber[3] . ') ' . $arrNumber[4] . $arrNumber[5] . $arrNumber[6] . '-' . $arrNumber[7] . $arrNumber[8] . $arrNumber[9] . $arrNumber[10];
		$visible = ((empty($visible))?($formatNumber):($visible));
		
		
		
		
			//$html = '<a href="tel:' . $link .'" title="' . $title . '" class="' . $class . '"><span class="hidden">' . $formatNumber . '</span>' . $visible . '</a>';
			
			$html = array('link'=>$link,'format'=>$formatNumber);
			
		}
		
	
		
		//print_r($html);
		
		return ($html[$type]);
	
}

function getEquivalentPage($p2='',$p3='',$p4='',$lng='') {
	return ('/' . $lng  .  ((!empty($p2))?( '/' . $p2):('')) . ((!empty($p3))?( '/' . $p3):('')). ((!empty($p4))?( '/' . $p4):('')));
	
}


function ifNotEmpty($fieldToCheck,$yes,$no) {
}


function getPackagesLink($data,$id,$url,$a_partir,$titre,$lng,$arrNomsHotels,$arrChampsAffichage,$class='',$action='') {
	
	$newurl = (($arrChampsAffichage[$data['id']][getValue($url,$lng)]=='phone')?('tel:' . getHotel($arrNomsHotels,$a_partir,'phone')):($arrChampsAffichage[$data['id']][getValue($url,$lng)]));
	//echo('test=' . $url);
	if($lng=='fr') {
		$titrePhone = 'Appeler pour réserver ';
		$titreOnline = 'Réservez en ligne ';
		$htmlPhone = 'Appeler à  ';
		$htmlOnline = 'Réservez à ';
		
	} else if($lng=='en') {
		$titrePhone = 'Call to book ';
		$titreOnline = 'Book online ';
		$htmlPhone = 'Call  ';
		$htmlOnline = 'Book  ';
	}
	
	
	$codeHtml = '';
	//$codeHtml .= formatPhone(getHotel($arrNomsHotels,$a_partir,'phone'),((=='phone')?($titrePhone):($titreOnline)) . sslashes($data[getValue($titre,$lng)]),'','' . (($arrChampsAffichage[$data['id']][getValue($url,$lng)]=='phone')?('show ga_data'):('')) . '') . '<a href="' . $newurl . '" title="' . (($arrChampsAffichage[$data['id']][getValue($url,$lng)]=='phone')?($titrePhone):($titreOnline)) . sslashes($data[getValue($titre,$lng)]) . '" target="_blank" class="' . (($arrChampsAffichage[$data['id']][getValue($url,$lng)]=='phone')?($class):('')). '">' . (($arrChampsAffichage[$data['id']][getValue($url,$lng)]=='phone')?($htmlPhone):($htmlOnline)) . ' <br /> <strong>' . getHotel($arrNomsHotels,$a_partir,$lng) . '</strong></a>';
	
	
	if($arrChampsAffichage[$data['id']][getValue($url,$lng)]=='phone') {
		$codeHtml .= '<a href="tel:' . formatPhone(getHotel($arrNomsHotels,$a_partir,'phone'),'link') . '"  ' . gaGiveAttributes('ga_track toggleSpan','Téléphone',$action,'Réserver ' .  getHotel($arrNomsHotels,$a_partir,$lng) . ' : ' .  sslashes($data[getValue($titre,$lng)]),$lng) . '>
																		<span>
																				' . formatPhone('1 800 263-1471','format') . '
																				<br><strong>' . getHotel($arrNomsHotels,$a_partir,$lng) . '</strong>
																		</span>
																		
																		<span>
																				' . $htmlPhone . ' 
																				<br><strong>' . getHotel($arrNomsHotels,$a_partir,$lng) . '
																				</strong>
																		</span>
																			
																		
																</a>
														';
	} else  {
			$codeHtml .= '<a href="' . $arrChampsAffichage[$data['id']][getValue($url,$lng)] . '" target="_blank" ' . gaGiveAttributes('ga_track','Lien',$action,'Réserver ' .  getHotel($arrNomsHotels,$a_partir,$lng) . ' : ' .  sslashes($data[getValue($titre,$lng)]),$lng) . '>
																		<span>
																				' . formatPhone('1 800 263-1471','format') . '
																		</span>
																		
																		<span>
																				' . $htmlOnline . ' 
																				<br><strong>' . getHotel($arrNomsHotels,$a_partir,$lng) . '
																				</strong>
																		</span>
																			
																		
																</a>
														';
	}
	
	
	
	
	
	return $codeHtml;
}


function gaGiveAttributes($class,$categorie,$action,$lable,$lng) {
	return (' class="' . $class . '" title="' . $categorie . ' / ' . $action  . ' / ' . $lable . ' / ' . strtoupper($lng) . '"');
}


?>