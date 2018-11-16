<?php
require_once "vene.php";

class venePDO {
	
	private $db;
	private $lkm;
	
	function __construct($dsn= "mysql:host=localhost;dbname=a1700456", $user = "root", $password = "salainen") {
				
				//yhteys kantaan
				$this->db = new PDO('mysql:host=localhost;dbname=a1700456', 'root', 'salainen');
				//virheiden jäljitys kehitysaikana
				$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
				//MySQL injection estoon (parametrit sidotaan php:ssa ennen sql-palvelimelle lähettämistä)
				$this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
				//tulosrivien määrä
				$this->lkm = 0;		
				}
	//metodi palauttaa tulosrivien määrän
	function getLkm(){
		return $this->lkm;
	}
	
	function lisaaVene($vene) {
	
		$sql = "insert into vene (nimi, malli, merkki, pituus, leveys, paino, vuosimalli, omistaja, sahkoposti, kotisatama, lisatiedot)
				values (:nimi, :malli, :merkki, :pituus, :leveys, :paino, :vuosimalli, :omistaja, :sahkoposti, :kotisatama, :lisatiedot)";
		
		//valmistellaan sql-lause
		if (! $stmt = $this->db->prepare ($sql)) {
				$virhe = $this->db->errorInfo ();
				throw new PDOException($virhe[2], $virhe[1]);
		}
	
	//parametrien sidontaa
	$stmt->bindValue(":nimi", utf8_decode($vene->getNimi()), PDO::PARAM_STR);
	$stmt->bindValue(":malli", utf8_decode($vene->getMalli()), PDO::PARAM_STR);
	$stmt->bindValue(":merkki", utf8_decode($vene->getMerkki()), PDO::PARAM_STR);
	$stmt->bindValue(":pituus", utf8_decode($vene->getPituus()), PDO::PARAM_STR);
	$stmt->bindValue(":leveys", utf8_decode($vene->getLeveys()), PDO::PARAM_STR);
	$stmt->bindValue(":paino", utf8_decode($vene->getPaino()), PDO::PARAM_INT);
	$stmt->bindValue(":vuosimalli", utf8_decode($vene->getVuosimalli()), PDO::PARAM_INT);
	$stmt->bindValue(":omistaja", utf8_decode($vene->getOmistaja()), PDO::PARAM_STR);
	$stmt->bindValue(":sahkoposti", utf8_decode($vene->getSahkoposti()), PDO::PARAM_STR);
	$stmt->bindValue(":kotisatama", utf8_decode($vene->getKotisatama()), PDO::PARAM_STR);
	$stmt->bindValue(":lisatiedot", utf8_decode($vene->getLisatiedot()), PDO::PARAM_STR);
	
	//Jotta id:n saa lisäyksestä, täytyy laittaa tapahtumakäsittely päälle
	$this->db->beginTransaction();
	
	//suoritetaan sql-lause..insert
	if (! $stmt->execute()) {
		$virhe = $stmt->errorInfo();
			
			if ($virhe[0] == "HY093") {
				$virhe[2] = "Invalid parameter";
			}
			
			//perutaan tapahtuma
			$this->db->rollBack();
	
			throw new PDOException($virhe[2], $virhe[1]);
	}
	
	//id täytyy ottaa talteen ennen tapahtuman päättämistä
	$id = $this->db->lastInsertId ();
	
	$this->db->commit();
	
	//palautetaan lisätyn ilmoituksen id
	return $id;
	
	} //lisaaVene
	
	// }class venePDO
	
	public function haeVeneet($nimi) {
		$sql = "SELECT id, nimi, malli, merkki, pituus, leveys, paino, vuosimalli, omistaja, sahkoposti, kotisatama, lisatiedot FROM vene
			WHERE nimi like :nimi";
	
		//valmistellaan lause, prepare on PDO-metodeja
		if (! $stmt = $this->db->prepare ( $sql )) {
			$virhe = $this->db->errorInfo ();
			throw new PDOException ( $virhe[2], $virhe[1] );
		}
		//sidotaan parametrit
		$ni = "%" . utf8_decode ( $nimi ) . "%";
		$stmt->bindValue ( ":$nimi", PDO::PARAM_STR );
	
		//ajetaan lauseke
		if (! $stmt->execute ()) {
			$virhe = $stmt->errorInfo ();
		
			if ($virhe [0] == "HY093") {
					$virhe [2] = "Invalid parameter";
			}
			throw new PDOException ( $virhe [2], $virhe [1] );
		}
	
		//käsitellään hakulausekkeen tulos
		$tulos = array ();
	
		//pyydetään haun tuloksista kukin rivi kerrallaan
		while ($row = $stmt->fetchObject()){
			//tehdään tietokannasta haetuista rivistä vene-luokan olio
			$vene = new Vene();
		
			$vene->setId($row->id);
			$vene->setNimi(utf8_encode($row->nimi));
			$vene->setMalli(utf8_encode($row->malli));
			$vene->setMerkki(utf8_encode($row->merkki));
			$vene->setPituus($row->pituus);
			$vene->setLeveys($row->leveys);
			$vene->setPaino($row->paino);
			$vene->setVuosimalli($row->vuosimalli);
			$vene->setOmistaja(utf8_encode($row->omistaja));
			$vene->setSahkoposti(utf8_encode($row->sahkoposti));
			$vene->setKotisatama(utf8_encode($row->kotisatama));
			$vene->setLisatiedot(utf8_encode($row->lisatiedot));
		
			//laitetaan olio tulos taulukkoon (olio-taulukkoon)
			$tulos[] = $vene;
		}
		$this->lkm = $stmt->rowcount ();
	
		return $tulos;
	}
	

	public function kaikkiVeneet() {
	
		$sql = "SELECT id, nimi, malli, merkki, pituus, leveys, paino, vuosimalli, omistaja, sahkoposti, kotisatama, lisatiedot FROM vene";
	
		//valmistellaan sql-lause
		if (! $stmt = $this->db->prepare($sql)) {
				$virhe = $this->errorInfo();
		
				throw new PDOException($virhe[2], $virhe[1]);
		}
		//ajetaan sql-lause
		if (! $stmt->execute()){
				$virhe = $stmt->errorInfo();
			
				throw new PDOException($virhe[2], $virhe[1]);
		}
	
		//käsitellään hakulausekkeen tulos
		$tulos = array();
	
		//pyydetään kaun tuloksista kukin rivi kerrallaan
		while ($row = $stmt->fetchObject()){
			//tehdään tietokannasta haetuista rivistä vene-luokan olio
			$vene = new Vene();
		
			$vene->setId($row->id);
			$vene->setNimi(utf8_encode($row->nimi));
			$vene->setMalli(utf8_encode($row->malli));
			$vene->setMerkki(utf8_encode($row->merkki));
			$vene->setPituus($row->pituus);
			$vene->setLeveys($row->leveys);
			$vene->setPaino($row->paino);
			$vene->setVuosimalli($row->vuosimalli);
			$vene->setOmistaja(utf8_encode($row->omistaja));
			$vene->setSahkoposti(utf8_encode($row->sahkoposti));
			$vene->setKotisatama(utf8_encode($row->kotisatama));
			$vene->setLisatiedot(utf8_encode($row->lisatiedot));
		
			//laitetaan olio tulos taulukkoon (olio-taulukkoon)
			$tulos[] = $vene;
		}
		$this->lkm = $stmt->rowCount();
	
		return $tulos;
	
		} //kaikkiVeneet

}//class venePDO
?>