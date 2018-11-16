<?php
class Vene implements JsonSerializable  {
	 
	// Taulukko, missä on virhekoodeja vastaavat virhetekstit
	private static $virhelista = array (
			- 1 => "Virheellinen tieto",
			0 => "",
			11 => "Nimi on pakollinen",
			12 => "Nimi on liian lyhyt",
			13 => "Nimi on liian pitkä",
			21 => "Malli on pakollinen",
			61 => "Merkki on pakollinen",
			62 => "Merkkiä ei ole olemassa",
			63 => "Veneen merkki on liian pitkä",
			64 => "Veneen merkissä saa olla vain kirjaimia ja -",
			71 => "Veneellä on oltava pituus",
			72 => "Pituuden pitää olla muodossa (00.00)",
			81 => "Veneellä on oltava leveys",
			82 => "Leveyden pitää olla muodossa (00.00)",
			91 => "Vene ei voi olla painoton",
			31 => "Vuosi on pakollinen",
			32 => "Vuodessa oltava neljä (4) numeroa",
			33 => "Vuosi on liian pieni",
			34 => "Tämä ei ole scifi-leffa, joten kirjoita vuosimalli uudestaan",
			41 => "Veneellä on oltava omistaja",
			42 => "Omistajalla on sekä etu- että sukunimi",
			43 => "Omistajalla on liian pitkä nimi. Vaihda lyhyempään!",
			44 => "Omistajalla saa olla vain kirjaimia ja -",
			121 => "Haluat varmasti, että otamme teihin yhteyttä",
			122 => "Ei tuo ole sähköposti, yritä uudestaan!",
			124 => "@-merkki ja/tai .(piste) puuttuu!",
			110 => "Veneellä on oltava kotisatama",
			111 => "Ei tämä ole satama, keksi parempi",
			112 => "Millään satamalla ei varmasti ole näin pitkää nimeä!",
			113 => "Kotisatamassa saa olla vain kirjaimia ja -",
			51 => "Lisätietoja on hyvä kertoa",
			52 => "Eikö sinulla ole enempää lisätietoja",
			53 => "Eiköhän tässä ole jo liikaa",
			54 => "Lisätiedoissa saa olla vain kirjaimia, numeroita ja - ,.!?"
	);
	
	// Attribuutit
	private $nimi;
	private $malli;
	private $merkki;
	private $pituus;
	private $leveys;
	private $paino;
	private $vuosimalli;
	private $omistaja;
	private $sahkoposti;
	private $kotisatama;
	private $lisatiedot;
	private $id; // Tehty kannan takia, on kannassa avainkenttänä
	
	//metodi, mikä muuttaa olion JSON-muotoon
	public function jsonSerialize(){
		return array(
			"nimi" =>  $this->nimi,
			"malli" =>  $this->malli,
			"merkki" =>  $this->merkki,
			"pituus" =>  $this->pituus,
			"leveys" =>  $this->leveys,
			"paino" =>  $this->paino,
			"vuosimalli" =>  $this->vuosimalli,
			"omistaja" =>  $this->omistaja,
			"sahkoposti" =>  $this->sahkoposti,
			"kotisatama" =>  $this->kotisatama,
			"lisatiedot" =>  $this->lisatiedot,
			"id" =>  $this->id
			);
	}
	
	// Konstruktori
	function __construct($nimi = "", $malli = "", $merkki = "", $pituus = "", $leveys = "", $paino = "", $vuosimalli = "", $omistaja = "", $sahkoposti = "", $kotisatama = "", $lisatiedot = "", $id = 0) {
		$this->nimi = trim ( $nimi );
		$this->setMalli ( $malli );
		$this->setMerkki ( $merkki );
		$this->setPituus ( $pituus );
		$this->setLeveys ( $leveys );
		$this->setPaino ( $paino );
		$this->vuosimalli = trim ( $vuosimalli );
		$this->omistaja = trim ( $omistaja );
		$this->sahkoposti = ( $sahkoposti );
		$this->kotisatama = trim ( $kotisatama );
		$this->lisatiedot = trim ( $lisatiedot );
		$this->id = $id;
	}
	
	// Metodit
	public function setNimi($nimi) {
		$this->nimi = trim ( $nimi );
	}
	public function getNimi() {
		return $this->nimi;
	}
	
	public function checkNimi($required = true, $min = 1, $max = 30) {
		// Jos saa olla tyhjä ja on tyhjä
		if ($required == false && strlen ( $this->nimi ) == 0) {
			return 0;
		}
			
		// Jos ei saa olla tyhjä ja on tyhjä
		if ($required == true && strlen ( $this->nimi ) == 0) {
			return 11;
		}
			
		// Jos nimi on liian lyhyt tai pitkä
		if (strlen ( $this->nimi ) < $min) {
			return 12;
		}
			
		// Jos nimi on liian pitkä
		if (strlen ( $this->nimi ) > $max) {
			return 13;
		}
			

		
		return 0;
	}
	public function setMalli($malli) {
		// etukirjaimet suurilla kirjaimilla
		$Onimi = trim ( $malli );
		$Onimi = mb_convert_case ( $Onimi, MB_CASE_LOWER, "UTF-8" );
		$Onimi = mb_convert_case ( $Onimi, MB_CASE_TITLE, "UTF-8" );
		
		$this->malli = $Onimi;
	}
	public function getMalli() {
		return $this->malli;
	}
	
	public function checkMalli($required = true, $min = 1, $max = 30) {
		
		// Jos saa olla tyhjä ja on tyhjä
		if ($required == false && strlen ( $this->malli ) == 0) {
			return 0;
		}
		
		
		// Jos ei saa olla tyhjä ja on tyhjä
		if ($required == true && strlen ( $this->malli ) == 0) {
			return 21;
		}
	
		//Jos veneen malli on liian lyhyt
		if (strlen ( $this->malli ) < $min) {
			return 22;
		}
			
		//Jos veneen malli on liian pitkä
		if (strlen ( $this->malli ) > $max) {
			return 23;
		}
			
		//Veneen mallissa saa olla vain pieniä ja isoja kirjaimia, välilyönti ja - merkki
		//Tutkitaan, onko veneen mallissa noihin kuulumattomia merkkejä
		if (preg_match ( "/[^a-zöåä \-]/i", $this->malli )) {
			return 24;
		}
		
		return 0;
	}
	public function setMerkki($merkki) {
		// etukirjaimet suurilla kirjaimilla
		$Onimi = trim ( $merkki );
		$Onimi = mb_convert_case ( $Onimi, MB_CASE_LOWER, "UTF-8" );
		$Onimi = mb_convert_case ( $Onimi, MB_CASE_TITLE, "UTF-8" );
		
		$this->merkki = $Onimi;
	}
	public function getMerkki() {
		return $this->merkki;
	}
	
	public function checkMerkki($required = true, $min = 1, $max = 30) {
		// Jos saa olla tyhjä ja on tyhjä
		if ($required == false && strlen ( $this->merkki ) == 0) {
			return 0;
		}
			
		// Jos ei saa olla tyhjä ja on tyhjä
		if ($required == true && strlen ( $this->merkki ) == 0) {
			return 61;
		}
			
		// Jos veneen merkki on liian lyhyt
		if (strlen ( $this->merkki ) < $min) {
			return 62;
		}
			
		// Jos veneen merkki on liian pitkä
		if (strlen ( $this->merkki ) > $max) {
			return 63;
		}
			
		// Veneen merkissä saa olla vain pieniä ja isoja kirjaimia, välilyönti ja -
		// Tutkitaan, onko veneen merkissä noihin kuulumattomia merkkejä
		if (preg_match ( "/[^a-zöåä \-]/i", $this->merkki )) {
			return 64;
		}
		
		return 0;
	}
	
	// Metodit
	public function setPituus($pituus) {
		$this->pituus = trim ( $pituus );
	}
	public function getPituus() {
		return $this->pituus;
	}
	
	public function checkPituus($required = true, $min = 2, $max = 20) {
		// Jos saa olla tyhjä ja on tyhjä
		if ($required == false && strlen ( $this->pituus ) == 0) {
			return 0;
		}
			
		// Jos ei saa olla tyhjä ja on tyhjä
		if ($required == true && strlen ( $this->pituus ) == 0) {
			return 71;
		}
		// Ei ole desimaaliluku?
		if (! preg_match ("/^\d{2}.\d{2}$/", $this->pituus )) {
			return 72;
		}
		return 0;
	}
		
	// Metodit
	public function setLeveys($leveys) {
		$this->leveys = trim ( $leveys );
	}
	public function getLeveys() {
		return $this->leveys;
	}
	
	public function checkLeveys($required = true, $min = 1.0, $max = 6.0) {
		// Jos saa olla tyhjä ja on tyhjä
		if ($required == false && strlen ( $this->leveys ) == 0) {
			return 0;
		}
			
		// Jos ei saa olla tyhjä ja on tyhjä
		if ($required == true && strlen ( $this->leveys ) == 0) {
			return 81;
		}
		// Ei ole desimaaliluku?
		if (! preg_match ("/^\d{2}.\d{2}$/", $this->leveys )) {
			return 82;
		}
		return 0;
	}	

	// Metodit
	public function setPaino($paino) {
		$this->paino = trim ( $paino );
	}
	public function getPaino() {
		return $this->paino;
	}
	
	public function checkPaino($required = true, $min = 100, $max = 30000) {
		// Jos saa olla tyhjä ja on tyhjä
		if ($required == false && strlen ( $this->paino ) == 0) {
			return 0;
		}
			
		// Jos ei saa olla tyhjä ja on tyhjä
		if ($required == true && strlen ( $this->paino ) == 0) {
			return 91;
		}
		return 0;
	}	
	
	public function setVuosimalli($vuosimalli) {
		$this->vuosimalli = $vuosimalli;
	}
	
	public function getVuosimalli() {
		return $this->vuosimalli;
	}
	
	public function checkVuosimalli($required = true, $min = 1930) {
		
		// Jos saa olla tyhjä ja on tyhjä
		if ($required == false && strlen ( $this->vuosimalli ) == 0) {
			return 0;
		}
			
		// Jos ei saa olla tyhjä ja on tyhjä
		if ($required == true && strlen ( $this->vuosimalli ) == 0 ) {
			return 31;
		}
			
		// Onko neljällä numerolla
		if (! preg_match ( "/^\d{4}$/", $this->vuosimalli )) {
			return 32;
		}
			
		//Jos vuosi on liian pieni
		if ($this->vuosimalli < $min) {
			return 33;
		}
			
		// Jos vuosi on liian suuri
		// ei strlen, koska ei tutkita merkkijonon pituutta vaan muuttujan arvoa
		$max = date ( "Y", time () );
		if ($this->vuosimalli > $max) {
			return 34;
		}
		
		return 0;
	}
	
		public function setOmistaja($omistaja) {
		// etukirjaimet suurilla kirjaimilla
		$Onimi = trim ( $omistaja );
		$Onimi = mb_convert_case ( $Onimi, MB_CASE_LOWER, "UTF-8" );
		$Onimi = mb_convert_case ( $Onimi, MB_CASE_TITLE, "UTF-8" );
		
		$this->omistaja = $Onimi;
	}
	public function getOmistaja() {
		return $this->omistaja;
	}
	
	public function checkOmistaja($required = true, $min = 1, $max = 30) {
		// Jos saa olla tyhjä ja on tyhjä
		if ($required == false && strlen ( $this->omistaja ) == 0) {
			return 0;
		}
			
		// Jos ei saa olla tyhjä ja on tyhjä
		if ($required == true && strlen ( $this->omistaja ) == 0) {
			return 41;
		}
			
		// Jos veneen omistajan nimi on liian lyhyt
		if (strlen ( $this->omistaja ) < $min) {
			return 42;
		}
			
		// Jos veneen omistajan nimi on liian pitkä
		if (strlen ( $this->omistaja ) > $max) {
			return 43;
		}
			
		// Veneen omistajalla saa olla vain pieniä ja isoja kirjaimia, välilyönti ja -
		// Tutkitaan, onko veneen omistajalla noihin kuulumattomia merkkejä
		if (preg_match ( "/[^a-zöåä \-]/i", $this->omistaja )) {
			return 44;
		}
		
		return 0;
	}
	
	public function setSahkoposti($Sahkoposti = "") {
		$this->sahkoposti = $Sahkoposti;
	}
	public function getSahkoposti() {
		return $this->sahkoposti;
	}
	
	public function checkSahkoposti($required = true, $min = 5) {
		
		$this->sahkoposti = trim($this->sahkoposti);
		
		// Jos saa olla tyhjä ja on tyhjä
		if ($required == false && strlen ( $this->sahkoposti ) == 0) {
			return 0;
		}
			
		// Jos ei saa olla tyhjä ja on tyhjä
		if ($required == true && strlen ( $this->sahkoposti ) == 0) {
			return 121;
		}
			
		// Jos omistajan sahkoposti on liian lyhyt
		if (strlen ( $this->sahkoposti ) < $min) {
			return 122;
		}
		/*	
		// Jos omistajan sahkoposti on liian pitkä
		if (strlen ( $this->sahkoposti ) > $max) {
			return 123;
		}
		*/
		
		// Tutkitaan sisältääkö sähköposti vaaditut merkit
		if (preg_match ("[^a-zA-Z\.@0-9]", $this->sahkoposti) || ! strstr($this->sahkoposti, "@")) {
			return 124;

		}
		return 0;
	}
	
	public function setKotisatama($kotisatama) {
		// etukirjaimet suurilla kirjaimilla
		$Onimi = trim ( $kotisatama );
		$Onimi = mb_convert_case ( $Onimi, MB_CASE_LOWER, "UTF-8" );
		$Onimi = mb_convert_case ( $Onimi, MB_CASE_TITLE, "UTF-8" );
		
		$this->kotisatama = $Onimi;
	}
	public function getKotisatama() {
		return $this->kotisatama;
	}
	

	public function checkKotisatama($required = true, $min = 3, $max = 50) {
		// Jos saa olla tyhjä ja on tyhjä
		if ($required == false && strlen ( $this->kotisatama ) == 0) {
			return 0;
		}
			
		// Jos ei saa olla tyhjä ja on tyhjä
		if ($required == true && strlen ( $this->kotisatama ) == 0) {
			return 110;
		}
			
		// Jos veneen kotisatama on liian lyhyt
		if (strlen ( $this->kotisatama ) < $min) {
			return 111;
		}
			
		// Jos veneen kotisatama on liian pitkä
		if (strlen ( $this->kotisatama ) > $max) {
			return 112;
		}
			
		// Veneen kotisatamassa saa olla vain pieniä ja isoja kirjaimia, välilyönti ja -
		// Tutkitaan, onko veneen kotisatamassa noihin kuulumattomia merkkejä
		if (preg_match ( "/[^a-zöåä \-]/i", $this->kotisatama )) {
			return 113;
		}
		
		return 0;
	}
	
	public function setLisatiedot($lisatiedot) {
		$this->lisatiedot = trim ( $lisatiedot );
	}
	
	public function getLisatiedot() {
		return $this->lisatiedot;
	}
	
	public function checkLisatiedot($required = true, $min = 10, $max = 300) {
		// Jos saa olla tyhjä ja on tyhjä
		if ($required == false && strlen ( $this->lisatiedot ) == 0) {
			return 0;
		}
			
		// Jos ei saa olla tyhjä ja on tyhjä
		if ($required == true && strlen ( $this->lisatiedot ) == 0) {
			return 51;
		}
			
		// Jos kommentti on liian lyhyt
		if (strlen ( $this->lisatiedot ) < $min) {
			return 52;
		}
			
		// Jos kommentti on liian pitkä
		if (strlen ( $this->lisatiedot ) > $max) {
			return 53;
		}
			
		// Kommentissa saa olla vain kirjaimia, numeroita ja - ,.!?
		if (preg_match ( "/^[a-zöåä0-9\-.,!?]$/i", $this->lisatiedot )) {
			return 54;
		}
		
		return 0;
	}
		
	public function setId($id) {
		$this->id = $id;
	}
	
	public function getId() {
		return $this->id;
	}
	
	// Metodilla näytetään virhekoodia vastaava teksti
	public static function getError($virhekoodi) {
		if (isset ( self::$virhelista [$virhekoodi] ))
			return self::$virhelista [$virhekoodi];
		
		return self::$virhelista [- 1];
	}
}
?>