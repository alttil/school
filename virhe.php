<?php
session_start();

//jos istunnossa on alus
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
		<a href="listaaVeneet.php">Veneet</a>&nbsp;&nbsp;&nbsp; 
		<a href="veneAsetukset.php">Asetukset</a>&nbsp;&nbsp;&nbsp;
		
	</nav>
	
<?php
	if (isset($_GET["virhe"])) {
	$virhe = $_GET["virhe"];
	@$sivu = $_GET["sivu"];
	}
	else {
	$virhe = "Tuntematon virhe";
	$sivu = "Eu tieto";
	
	}
	
	print("<p><b>$sivu</b>: $virhe</p>");

?>

<p>Siirrytään etusivulle viiden sekunnin kuluttua</p>

</body>
</html>
<?php
	header("refresh:5; url=index.php?virhe=kylla");
	exit;
?>