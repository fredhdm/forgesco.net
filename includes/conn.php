<?php

//DEV
//$dbh=mysql_connect ("localhost", "u2t3mca_dev", "2t3mdev__321") or die ('Impossible de se connecter  sur la base de données  pour la raison suivante: ' . mysql_error());
//mysql_set_charset('utf8', $dbh);
//mysql_select_db ("u2t3mca_hnf");

//PROD
$dbh=mysql_connect ("localhost", "forgesco_user", "site__321") or die ('Impossible de se connecter  sur la base de données  pour la raison suivante: ' . mysql_error());
mysql_set_charset('utf8', $dbh);
mysql_select_db ("forgesco_site");



?>
