<!--FOOTER-->
					</section>
		</div>
		<footer>
			<div id="media_sociaux">
				
				<p><a href="https://www.facebook.com/Forgescom-128228823898762/" title="Facebook" target="_blank"><i class="fa fa-facebook-square fa-2x"></i></a></p>
		</div>
			<div id="hotels_ensemble">
				<div>
							<p>Forgescom<br />
Jean Pichette, CPA, CMA</p>
							<p>209-985 Route des Rivières,<br />
Lévis, Qc G7A 0P6<br />
								Courriel : <strong><a href="mailto:jpsim@videotron.ca" title="Forgescom">jpsim@videotron.ca</a></strong><br />
								Téléphone : <a href="tel:<?php echo(formatPhone('14184963727','link')) ?>" title="Téléphone"><?php echo(formatPhone('14184963727','format')) ?></a><br />
								Cellulaire : <a href="tel:<?php echo(formatPhone('1418 561-5416','link')) ?>" title="Cellulaire"><?php echo(formatPhone('1418 561-5416','format')) ?></a><br />
								Fax : <a href="tel:<?php echo(formatPhone('1418 496-3747','link')) ?>" title="Fax"><?php echo(formatPhone('1418 496-3747','format')) ?></a></p>
					</div>
					
					


					
					
					
		</div>
		
	</footer>
	</div>

<?php
unset($_SESSION['formulaire']);
if($_SESSION['debug']=='true') {
	//echo($_SESSION['debug']);
	?>

<br><br>
<?php




//print_r($_SESSION);
echo('<strong>LES SQL EN SESSION</strong><br>');
foreach($_SESSION['sql'] as $k =>$value) {
	echo('<strong style="font-size:1em;">' . $k . '</strong><br>');
	echo($value. '<br><br>');
	
	
}

echo('<strong>sqlPrincipal</strong><br>');
print_r($_SESSION['sqlPrincipal']);

echo('<br><br>');

echo('<strong>sqlSecondaire</strong><br>');
print_r($_SESSION['sqlSecondaire']);

echo('<br><br>');

echo('<strong>sqlChamps</strong><br>');
print_r($_SESSION['sqlChamps']);

echo('<br><br>');

echo('<strong>SQL PHOTOS</strong><br>');
echo($_SESSION['sqlphoto']);

echo('<br><br>');

echo('<strong>PHOTOCAROUSSEL</strong><br>');
echo($_SESSION['photoCaroussel']);

echo('<br><br>');

//print_r($_SESSION);
echo('<strong>DEBUG</strong><br>');
foreach($_SESSION['contenu'] as $k =>$value) {
	echo('<strong style="font-size:3em;">ARRAY ' . $k . '</strong><br>');
	foreach($value as $j =>$s) {
		echo('<strong>' . $j. '</strong>=>' . $s . '<br>');
	}
	echo('<br><br>');
}


echo('<strong>SCRIPT ACTUEL</strong><br>');

	
		echo('<strong>' . $_SERVER['SCRIPT_FILENAME'] . '</strong>'  . '<br>');

	echo('<br><br>');




//print_r($arrMenu);
?>



<?php
}
?>
<!--//FOOTER//-->
