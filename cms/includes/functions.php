<?php

function sousMenuCMS($dataMenu,$id,$actif=1) {
	$codeHTML = '';
	foreach($dataMenu as $m) {	
												if($m['id']==$id) {
														
													$enfantEnCours = $m['enfantId'];
													$codeHTML .= '<li><a href="/cms/page/' . $m['enfantId'] . '" class="parent"><i class="fa fa-arrow-circle-down"></i> ' . $m['enfantTitre'] . '</a></li>';
											
													foreach($dataMenu as $n) {	
													
															if($m['enfantId']==$n['enfantParent']) {		
															
																	if($n['enfantActif']==$actif) {													
														
											
											$codeHTML .= '<li><a href="/cms/page/' . $n['enfantId'] . '"  class="enfant">' . $n['enfantTitre'] . '</a></li>';
											
														
																	}
												
												}
										}
																		
												$parentEnCours = $m['parent'];
												}
										}


echo($codeHTML);

}


function sslashesCMS($string,$espace=0) {
	$newString = stripslashes($string);
	if($espace==1) {
		$newString = str_replace(' ','&nbsp;',$newString);
	}
	return $newString;
}



?>