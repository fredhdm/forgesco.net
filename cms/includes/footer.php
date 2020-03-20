</section>
		</div>
		<footer>
				<div id="menu">
						<ul>
								<li><a href="<?php echo(sslashesCMS($_SESSION['admSite'])) ?>" target="_blank">Aller au site Internet</a></li>
								<li><a href="#big_wrapper">Retour en haut de la page</a></li>
								<li><a href="/cms/deconnexion">Déconnexion</a></li>
						</ul>
				</div>
				<div id="copyright">
						<p><a href="http://www.2t3m.ca" target="_blank">Outil de gestion propulsé par 2t3m.ca</a></p>
				</div>
		</footer>
</div>

<?php
if($_SESSION['debug']=='true') {
	?>

<br><br>
<?php
//print_r($_SESSION);
echo('<strong>DEBUG</strong><br>');
foreach($debug as $k =>$s) {
	echo($k . '=>' . $s . '<br><br>
<br>
');
}



?>
<br><br>

<?php
//print_r($_SESSION);
echo('<strong>GÉNÉRAL</strong><br>');
foreach($_SESSION as $k =>$s) {
	echo($k . '=>' . $s . '<br>');
}



?>

<br><br>

<?php
//print_r($_SESSION);
echo('<strong>PAGE</strong><br>');
foreach($_SESSION['page'] as $k =>$s) {
	echo($k . '=>' . $s . '<br>');
}



?><br><br>


<?php
//print_r($_SESSION);
echo('<strong>IMAGE</strong><br>');
foreach($_SESSION['image'] as $k =>$s) {
	echo($k . '=>' . $s . '<br>');
}



?>
<br><br>
<?php
//print_r($_SESSION);
echo('<strong>BLOC</strong><br>');
foreach($_SESSION['bloc'] as $k =>$s) {
	echo($k . '=>' . $s . '<br>');
}



?>

<br><br>
<?php
//print_r($_SESSION);
echo('<strong>REQUEST</strong><br>');
foreach($_REQUEST as $k =>$s) {
	echo($k . '=>' . $s . '<br>');
}



?>
<br><br>
<?php
//print_r($_SESSION);
echo('<strong>FILES</strong><br>');
foreach($_FILES as $k =>$s) {
	echo($k . '=>' . $s . '<br>');
}



?>
<br><br>
<?php
//print_r($_SESSION);
echo('<strong>ERREURS</strong><br>');
foreach($erreurs as $k =>$s) {
	echo($k . '=>' . $s . '<br>');
}

	print_r($arrChampsOptions);

?>



<?php
}
?>