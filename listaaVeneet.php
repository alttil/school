
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
		Veneet &nbsp;&nbsp;&nbsp; 
		<a href="veneAsetukset.php">Asetukset</a>&nbsp;&nbsp;&nbsp;
		<a href="haeVeneJSON.php">Hae vene JSON</a>&nbsp;&nbsp;&nbsp;
		
	</nav>
	<form action="" method="post"> <!-- action="listaaVeneet.php" -->
<div id="listaus">
	<h2>Kaikki veneet</h2>
	
<?php
	try {
	
		require_once "venePDO.php";
		
		// Onko painettu nayta-nimistä painiketta
if (isset ( $_POST ["nayta"] )) {
	
	
	$vene = new Vene ( $_POST ["nimi"], $_POST ["malli"], $_POST ["merkki"], $_POST ["pituus"], $_POST ["leveys"], $_POST ["paino"], $_POST ["vuosimalli"], $_POST ["omistaja"], $_POST ["sahkoposti"], $_POST ["kotisatama"], $_POST ["lisatiedot"] );
	
	//laitetaan istuntoon olio
	$_SESSION["alus"] = $vene;
	
	//istunto suljetaan, koska sitä ei tarvita tällä sivulla
		session_write_close ();
		header("location: naytaTiedot.php");
		exit();
}
	
		//tehdään tietokantaluokan olio
		$kantakasittely = new venePDO ();
	
		//kutsutaan tietokantaluokan metodia, mikä hakee kaikki veneet
		//metodi palauttaa oliotaulukon
		$rivit = $kantakasittely->kaikkiVeneet ();
	
		//käydään oliotaulukko läpi
										// '.$Array[0].'
		foreach ( $rivit as $vene) {
			
					
			
			//$vene on oliotaulukosta otettu yksittäinen Vene-luokan olio
			print("<br><tr>");
			print("<td>" . $vene->getId() . "</td>");
			print("&nbsp;<td>Nimi: " . $vene->getNimi() . "</td>");
			print("&nbsp;<td>Omistaja: " . $vene->getOmistaja() . "</td>");
			print '<form action="naytaTiedot.php" method="post">
					<input type="hidden" name="id" value="1">
					<input type="submit" value="Näytä" name="nayta">
					<input type="submit" value="Poista" name="poista">
					</form>';
			print("<br>");
			
		}
	
} catch (Exception $error ) {

		header ( "location: virhe.php?sivu=Listaus$virhe=" . $error->getMessage () );
		exit ();
}	
?>

</div>
	</form>
</body>
</html>