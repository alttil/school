<?php
require_once "vene.php";
 session_start();
 
// Onko painettu talleta-nimistä painiketta
if (isset ( $_POST ["talleta"] )) {
	
	$vene = new Vene ( $_POST ["nimi"], $_POST ["malli"], $_POST ["merkki"], $_POST ["pituus"], $_POST ["leveys"], $_POST ["paino"], $_POST ["vuosimalli"], $_POST ["omistaja"], $_POST ["sahkoposti"], $_POST ["kotisatama"], $_POST ["lisatiedot"] );
	
	//laitetaan istuntoon olio
	$_SESSION["alus"] = $vene;
	//session_write_close();
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
	
	//jos ei ole virheitä lähdetän näyttämään tiedot toiselta sivulta
	if($nimiVirhe == 0 && $malliVirhe == 0 && $merkkiVirhe == 0 && $pituusVirhe == 0 && $leveysVirhe == 0 && $painoVirhe == 0 && $vuosimalliVirhe == 0 && $omistajaVirhe == 0 && $sahkopostiVirhe == 0 && $kotisatamaVirhe == 0 && $lisatiedotVirhe == 0) {
	
		try {
 			require_once "venePDO.php";
 			$kantakasittely = new venePDO();
 			$id = $kantakasittely->lisaaVene($vene);
 		
 			//muutetaan istunnossa ovevan olion id lisäykseltä saaduksi id:ksi
 			$_SESSION["alus"]->setId ($id);
 			
 		} catch (Exception $error) {
 			session_write_close ();
 			header ("location: virhe.php?sivu=" . urlencode ( "Lisäys" ) . "$virhe=" . $error->getMessage() );
 			exit();
 		}
 		
		//istunto suljetaan, koska sitä ei tarvita tällä sivulla
		session_write_close ();
		header("location: listaaVeneet.php");
		exit();
		}
}
// Onko painettu peruuta-nimistä painiketta
elseif (isset($_POST ["peruuta"] )) {

	unset($_SESSION["alus"]);
	header ( "location: index.php" );
	//exit;
} 
// Sivulle tultiin etusivulta tai joltain toiselta sivulta
else {
	//tutkitaan onko istunnossa alusta
	if (isset($_SESSION["alus"])) {
		//otetaan istunnosta olio
		$vene = $_SESSION["alus"];
		
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
		
	} else {
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

// print_r($vene);
?>
<!DOCTYPE html>

<html>
<head>
<meta charset="UTF-8">
<title>Uusi vene</title>
<link rel="stylesheet" type="text/css" href="vene_tyylit.css">
</head>
<body>
	<header class="otsikko">Veneen tiedot</header>

	<nav class="ylapalkki">
		<a href="index.php">Etusivu</a>&nbsp;&nbsp;&nbsp; 
		Uuden veneen lisääminen&nbsp;&nbsp;&nbsp; 
		<a href="listaaVeneet.php">Veneet</a>&nbsp;&nbsp;&nbsp;
		<a href="veneAsetukset.php">Asetukset</a>&nbsp;&nbsp;&nbsp;
		<a href="haeVeneJSON.php">Hae vene JSON</a>&nbsp;&nbsp;&nbsp;
	</nav>

	<article class="uusiVene">
		<h2>Uusi vene</h2>
		<form action="lisaaVene.php" method="post">
<div id="veneLomake">
			<div id="uusiNimi">
				<label>Nimi:</label> 
				<input type="text" name="nimi" size="30" class="kentta"
					value="<?php print(htmlentities($vene->getNimi(), ENT_QUOTES, "UTF-8"));?>">
<?php
print ("<span class='pun'>" . $vene->getError ( $nimiVirhe ) . "</span>") ;
?> 
</div>

				<div id="uusiMalli">
				<label>Malli:</label> 
				<input type="text" name="malli" size="30" class="kentta"
					value="<?php print(htmlentities($vene->getMalli(), ENT_QUOTES, "UTF-8"));?>">
<?php
print ("<span class='pun'>" . $vene->getError ( $malliVirhe ) . "</span>") ;
?>
</div>
			<div id="uusiMerkki">
				<label>Merkki:</label> 
				<input type="text" name="merkki" size="30" class="kentta"
					value="<?php print(htmlentities($vene->getMerkki(), ENT_QUOTES, "UTF-8"));?>"> 
<?php
print ("<span class='pun'>" . $vene->getError ( $merkkiVirhe ) . "</span>") ;
?> 
</div>
<div id="numeroTiedot">
	<div id="uusiPituus">		
				<label>Pituus:</label> 
				 <input type="text" name="pituus"
				size="10" maxlength="10" class="kentta"
					value="<?php print(htmlentities($vene->getPituus(), ENT_QUOTES, "UTF-8"));?>">

<?php
print ("<span class='pun'>" . $vene->getError ( $pituusVirhe ) . "</span>") ;
?> 
</div>
	<div id="uusiLeveys">

			
				<label>Leveys:</label> 
				<input type="text" name="leveys"
				size="10" maxlength="10" class="kentta"
					value="<?php print(htmlentities($vene->getLeveys(), ENT_QUOTES, "UTF-8"));?>">
<?php
print ("<span class='pun'>" . $vene->getError ( $leveysVirhe ) . "</span>") ;
?> 
	</div>
	<div id="uusiPaino">

			
				<label>Paino:</label> 
				<input type="text" name="paino"
				size="10" maxlength="10" class="kentta"
					value="<?php print(htmlentities($vene->getPaino(), ENT_QUOTES, "UTF-8"));?>">
<?php
print ("<span class='pun'>" . $vene->getError ( $painoVirhe ) . "</span>") ;
?> 
	</div>

</div>
<div id="valVuosi">

					<label>Vuosimalli</label> <input type="text" name="vuosimalli"
					size="4" maxlength="4" class="kentta"
					value="<?php print(htmlentities($vene->getVuosimalli(), ENT_QUOTES, "UTF-8"));?>">
				
<?php
print ("<span class='pun'>" . $vene->getError ( $vuosimalliVirhe ) . "</span>") ;
?>
</div>

			<div id="uusiOmistaja">
				<label>Omistaja:</label> 
				<input type="text" name="omistaja" size="50" class="kentta"
					value="<?php print(htmlentities($vene->getOmistaja(), ENT_QUOTES, "UTF-8"));?>">
<?php
print ("<span class='pun'>" . $vene->getError ( $omistajaVirhe ) . "</span>") ;
?>
</div>

			<div id="uusiSahkoposti">
				<label>Sähköposti:</label> 
				<input type="text" name="sahkoposti" size="50" class="kentta"
					value="<?php print(htmlentities($vene->getSahkoposti(), ENT_QUOTES, "UTF-8"));?>">
<?php
print ("<span class='pun'>" . $vene->getError ( $sahkopostiVirhe ) . "</span>") ;
?>
</div>

			<div id="kotisatama">
				<label>Kotisatama:</label> 
				<input type="text" name="kotisatama" size="50" class="kentta"
					value="<?php print(htmlentities($vene->getKotisatama(), ENT_QUOTES, "UTF-8"));?>">
<?php
print ("<span class='pun'>" . $vene->getError ( $kotisatamaVirhe ) . "</span>") ;
?>
</div>

			<div id="lisatiedot">
				<label>Lisätiedot:</label>
				<textarea rows="5" cols="40" name="lisatiedot"><?php print(htmlentities($vene->getLisatiedot(), ENT_QUOTES, "UTF-8"));?>
				</textarea>
<?php
print ("<span class='pun' style='vertical-align:top'>" . $vene->getError ( $lisatiedotVirhe ) . "</span>") ;
?>
</div>


			<p>
				<label>&nbsp;</label> <input type="submit" name="talleta"
					value="Tallenna" class="nappi"> <input type="submit" name="peruuta"
					value="Peruuta" class="nappi"> 
					
			</p>
</div>
		</form>

	</article>

</body>
</html>