<!DOCTYPE html>

<html>
<head> 
<meta charset="UTF-8">
<title>Hae vene JSON:lla</title>

<link rel="stylesheet" type="text/css" href="vene_tyylit.css">

<!-- Käytä uusinta, näet sen osoitteesta http://code.jquery.com -->
<script src="http://code.jquery.com/jquery-3.3.1.js"
		integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
		crossorigin="anonymous"></script>
</head>

<body>
	<header>VENEKOKOELMA JSON:lla</header>
	<nav class="ylapalkki">
		<a href="index.php">Etusivu</a>&nbsp;&nbsp;&nbsp; 
		<a href="lisaaVene.php">Uuden veneen lisääminen</a>&nbsp;&nbsp;&nbsp;
		<a href="listaaVeneet.php">Veneet</a>&nbsp;&nbsp;&nbsp; 
		<a href="veneAsetukset.php">Asetukset</a>&nbsp;&nbsp;&nbsp;
		Hae vene JSON &nbsp;&nbsp;&nbsp;
	</nav>

	<nav></nav>

	<article>
		<h2>Hae vene</h2>
		<form action="haeVeneJSON.php" method="post">
			<input type="text" id="nimi" name="nimi">
			<!-- onclick kertoo, että painikkeen painalluksen käsittelee haeNimella-funktio -->
			<input type="button" id="hae" name="hae" value="Hae">
		</form>
		<br>
		<div style="margin-bottom:0.5cm" id="lista"></div>
		
		<p>
			<a href="index.php">Etusivulle</a>
		</p>
	</article>
	
	<script>

		$(document).ready(function() {
			
			// Kun painiketta id="hae" painetaan
			$("#hae").click(function() {
				$.ajax({
					url: "veneetJSON.php",  // PHP-sivu, jota haetaan AJAX:lla
					method: "get",
					data: {nimi: $("#nimi").val()},  // Hakukriteeri on nimi, jonka arvona on lomakekentän id="nimi" arvo
					dataType: "json",
					timeout: 5000
				})
				// AJAX haku onnistui
				.done(function(data) {
					// Tyhjennetään elementti, johon vastaus laitetaan
					$("#lista").html("");
					
															

					// Käsitellään vastauksena tullut taulukko
					//$.each(result, function(i, data) {
					for(var i = 0; i < data.length; i++) {
						// Lisätään attribuutilla id="lista" elementtiin sisältöä
						$("#lista").append(
						"<p>Nimi: " + data.nimi +
						"<br>Malli: " + data[i].malli +
						"<br>Merkki: " + data[i].merkki +
						"<br>Pituus: " + data[i].pituus +
						"<br>Leveys: " + data[i].leveys +
						"<br>Paino: " + data[i].paino +
						"<br>Vuosimalli: " + data[i].vuosimalli +
						"<br>Omistaja: " + data[i].omistaja +
						"<br>Sahkoposti: " + data[i].sahkoposti +
						"<br>Kotisatama: " + data[i].kotisatama +
						"<br>Lisätiedot: " + data[i].lisatiedot + "</p>");
					}
					// Jos vastauksena ei tullut yhtään riviä eli vastaus oli tyhjä taulukko
					if (data[i].length == 0) {
						$("#lista").append("<p>Haku ei tuottanut yhtään venettä</p>")
					}
				})
				// AJAX haku ei onnistunut
				.fail(function() {
					$("#lista").html("<p>Listausta ei voida tehdä</p>");
				});
				
			});
		});
	</script>

</body>
</html>
