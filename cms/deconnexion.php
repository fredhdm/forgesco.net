<?php
include("includes/parametres.php");
session_destroy();
session_unset();
unset($_SESSION);
header("Location:/cms/index.php");
?>