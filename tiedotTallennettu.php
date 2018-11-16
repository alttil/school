<?php
require_once "vene.php";
 session_start();
 
 if (isset($_SESSION["alus"])){
 	$vene = $_SESSION["alus"];
 } else {
 	$vene = new Vene();
 }
 unset($_SESSION["alus"]);
 ?>

<!DOCTYPE html>

<html>
<head>
<meta charset="UTF-8">
<title>Venekokoelma</title>

<link rel="stylesheet" type="text/css" href="vene_tyylit.css">
</head> 

<body>
	<header class="otsikko">Veneet</header>
	<nav class="ylapalkki">
		<a href="index.php">Etusivu</a>&nbsp;&nbsp;&nbsp; 
		<a href="lisaaVene.php">Uuden veneen lisääminen</a>&nbsp;&nbsp;&nbsp; 
		<a href="listaaVeneet.php">Veneet&nbsp;&nbsp;&nbsp; 
		<a href="veneAsetukset.php">Asetukset</a>&nbsp;&nbsp;&nbsp;
		<a href="haeVeneJSON.php">Hae vene JSON</a>&nbsp;&nbsp;&nbsp;
		
	</nav>
	
	<h2>Tiedot tallennettu!</h2>

<!--
<?php	
	header("refresh:5; url=index.php?lisatty=kylla&omistaja=" .
	urlencode($vene->getOmistaja()));
	//header("location; url=index.php?lisatty=kylla&omistaja=" .
	//urlencode($vene->getOmistaja()));
	exit;
	?>
	-->
</body>
</html>