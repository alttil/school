<?php
	try {
		require_once "venePDO.php";
		
		//luodaan tietokantaluokan olio
		$kantakasittely = new venePDO ();
		
		//jos  sivua pyytäneeltä tulo hae
		//eli kyseessä on nimellä veneiden hakeminen
		//web-sivulla on ajax-komennossa {nimi: $("#nimi").val()}, josta saadaan haettava vene
		
		if (isset ( $_GET ["nimi"] )) {
		
			//tehdään kantahaku
			$tulos = $kantakasittely->haeVeneet ( $_GET ["nimi"] );
			
			//palautetaan vastaus JSON-tekstinä
			print (json_encode ( $tulos )) ;
		}
		// kyseessä on kaikkien veneiden haku kannasta
		else{
			$tulos = $kantakasittely->kaikkiVeneet ();
			
			//palautetaan vastaus JSON-tekstinä
			print (json_encode ( $tulos ));
		}
	}catch ( Exception $error) {
		
	}

?>