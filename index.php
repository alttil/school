<!DOCTYPE html>

<html>
<head>
<meta charset="UTF-8">
<title>Venekokelma</title>
<link rel="stylesheet" type="text/css" href="vene_tyylit.css">
</head>
 
<body>

	<header class="otsikko">VENEKOKOELMA</header>

	<nav class="ylapalkki">
		Etusivu &nbsp;&nbsp;&nbsp; 
		<a href="lisaaVene.php">Uuden veneen lisääminen</a>&nbsp;&nbsp;&nbsp;
		<a href="listaaVeneet.php">Veneet</a>&nbsp;&nbsp;&nbsp;
		<a href="veneAsetukset.php">Asetukset</a>&nbsp;&nbsp;&nbsp;
		<a href="haeVeneJSON.php">Hae vene JSON</a>&nbsp;&nbsp;&nbsp;
	</nav>

	


	
	<div id="tervetuloa">
	<?php
	if (isset($_COOKIE["omistaja"]) && isset($_COOKIE["aika"])){
	print("Tervetuloa " . $_COOKIE["omistaja"] .
	" " . $_COOKIE["aika"] . ".");
	}
	?>
	<br>
	
	</div>
	
	
	<div id="ekaOtsikko">
		<h1>Tässä vene kokoelmani</h1>
	<!--
	<?php
	if (isset($_COOKIE["alus"]) && isset($_COOKIE["aika"])){
	print("Viimeisin lisäämäsi vene oli " . $_COOKIE["alus"] .
	" " . $_COOKIE["aika"] . ".");
	}
	?>
	-->
	</div>
	
	<div id="tokaOtsikko">
		<h2>Tervetuloa käyttämään venekokoelmaa</h2>
		
		<?php
		if (isset($_COOKIE["nimi"]) && isset($_COOKIE["aika"])){
		print("Lisättiin uusi vene " . $_COOKIE["nimi"] . 
		" " . $_COOKIE["aika"] . "."); 
		
		}
		?>
		
		
		<?php
		if (isset($_GET["lisatty"]) && isset($_GET["nimi"])){
		print("<p>Lisättiin uusi vene " . $_GET["nimi"] . "</p>");
		}
		
		?>
		
		</div>
		

</body>
</html>

