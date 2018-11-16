<?php
require_once "vene.php";
session_start();

if (isset ( $_POST ["muokkaa"] )) {
$vene = new Vene ( $_POST ["nimi"], $_POST ["malli"], $_POST ["merkki"], $_POST ["pituus"], $_POST ["leveys"], $_POST ["paino"], $_POST ["vuosimalli"], $_POST ["omistaja"], $_POST ["sahkoposti"], $_POST ["kotisatama"], $_POST ["lisatiedot"] );
	$_SESSION["alus"] = $vene;
	session_write_close();
	// Tarkastetaan kentät
	
	$nimiVirhe = $vene->checkNimi();
	$malliVirhe = $vene->checkMalli();
	$merkkiVirhe = $vene->checkMerkki();
	$pituusVirhe = $vene->checkPituus();
	$leveysVirhe = $vene->checkLeveys();
	$painoVirhe = $vene->checkPaino();
	$vuosimalliVirhe = $vene->checkVuosimalli();
	$omistajaVirhe = $vene->checkOmistaja();
	$sahkopostiVirhe = $vene->checkSahkoposti();
	$kotisatamaVirhe = $vene->checkKotisatama();
	// Kuvausta ei ole pakko antaa, siksi parametrina false
	$lisatiedotVirhe = $vene->checkLisatiedot ( false );
	header("location: index.php");
	exit;

} // Sivulle tultiin etusivulta tai joltain toiselta sivulta
else {
	if (isset($_SESSION["alus"])){
		$vene = $_SESSION["alus"];
	}else{
	// Tehdään vene oletusarvoilla (tyhjä vene)
	$vene = new Vene ();
	
	// Alustetaan virhemuuttujat
	$nimiVirhe = 0;
	$malliVirhe = 0;
	$merkkiVirhe = 0;
	$pituusVirhe = 0;
	$leveysVirhe = 0;
	$painoVirhe = 0;
	$vuosimalliVirhe = 0;
	$omistajaVirhe = 0;
	$sahkopostiVirhe = 0;
	$kotisatamaVirhe = 0;
	$lisatiedotVirhe = 0;
}
}
unset($_SESSION["alus"]);
?>
<!DOCTYPE html>

<html>
<head>
<meta charset="UTF-8">
<title>Asetukset</title>
<link rel="stylesheet" type="text/css" href="vene_tyylit.css">
</head>
<body>

	<header class="otsikko">Veneasetukset</header>
	<nav class="ylapalkki">
		<a href="index.php">Etusivu</a>&nbsp;&nbsp;&nbsp; 
		<a href="lisaaVene.php">Uuden veneen lisääminen</a>&nbsp;&nbsp;&nbsp; 
		<a href="listaaVeneet.php">Veneet</a>&nbsp;&nbsp;&nbsp;
		Asetukset&nbsp;&nbsp;&nbsp;
		<a href="haeVeneJSON.php">Hae vene JSON</a>&nbsp;&nbsp;&nbsp;
	</nav>
	<form action="veneAsetukset.php" method="post">


			<div id="uusiOmistaja">
				<label>Omistaja:</label> 
				<input type="text" name="omistaja" size="50" class="kentta"
					value="<?php print(htmlentities($vene->getOmistaja(),
					ENT_QUOTES, "UTF-8"));?>">
					<input type="submit" name="muokkaa" value="Muokkaa" class="nappi">

</div>
	
	</form>
	<!--<p id="siirtyminen">Siirrytään etusivulle 5 sekunnin kuluttua.</p>-->
	
<?php
setcookie("alus", $vene->getOmistaja(), time()+60*60*24*7, "/");
$aika = date("d.m.Y", time());
setcookie("aika", $aika, time()+60*60*24*7);
?>

<!--
<?php	
	header("location; url=index.php?lisatty=kylla&omistaja=" .
	urlencode($vene->getOmistaja()));
	//header("location; url=index.php?lisatty=kylla&omistaja=" .
	//urlencode($vene->getOmistaja()));
	//refresh:5
	exit;
	?>
	-->
</body>
</html>