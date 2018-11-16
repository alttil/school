<?php
require_once "vene.php";
 
session_start ();

// Onko painettu takaisin-nimistä painiketta
//if (isset($_POST ["takaisin"] )) {

	//unset($_SESSION["alus"]);
	//header ( "location: listaaVeneet.php" );

// Tutkitaan, onko istunnossa alusta
if (isset ( $_SESSION ["alus"] )) {
	// Otetaan istunnosta olio
	$vene = $_SESSION ["alus"];
} else {
	// Tehdään tyhjä vene
	$vene = new Vene ();
	
}




// Laitetaan evästeisiin lisätyn elokuvan nimi ja lisäysaika
setcookie ( "alus", $vene->getNimi (), time () + 60 * 60 * 24 * 30 );
$aika = date ( "d.m.Y", time () );
setcookie ( "aika", $aika, time () + 60 * 60 * 24 * 30 );
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
		<a href="haeVeneJSON.php">Hae vene JSON</a>&nbsp;&nbsp;&nbsp;
		
	</nav>
	<form action="naytaTiedot.php" method="post"> <!-- action="listaaVeneet.php" -->
<div id="listaus">
	<h2>Tarkemmat tiedot veneestä</h2>
	
	<?php
	
			print("<p>Id: " . $vene->getId ()) ;
			print("<br>Nimi: " . $vene->getNimi());
			print("<br>Malli: " . $vene->getMalli());
			print("<br>Merkki: " . $vene->getMerkki());
			print("<br>Pituus: " . $vene->getPituus());
			print("<br>Leveys: " . $vene->getLeveys());
			print("<br>Paino: " . $vene->getPaino());
			print("<br>Vuosimalli: " . $vene->getVuosimalli());
			print("<br>Omistaja: " . $vene->getOmistaja());
			print("<br>Sähköposti: " . $vene->getSahkoposti());
			print("<br>Kotisatama: " . $vene->getKotisatama());
			print("<br>Lisätiedot: " . $vene->getLisatiedot() . "</p>");
			
?>
	

	<p>
				<label>&nbsp;</label> 
				<input type="submit" name="takaisin" value="Takaisin" class="nappi"> 
				<!--<input type="submit" name="muokkaa" value="Muokkaa" class="nappi">
				<input type="submit" name="peruuta" value="Peruuta" class="nappi"> --> 
					
	</p>


</div>
	</form>
</body>
</html>