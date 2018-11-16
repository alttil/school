CREATE database a1700456;
USE a1700456;

CREATE TABLE `vene` (
  `id` int(10) UNSIGNED NOT NULL,
  `nimi` varchar(50) NOT NULL,
  `malli` varchar(50) NOT NULL,
  `merkki` varchar(50) NOT NULL,
  `pituus` varchar(10) NOT NULL,
  `leveys` varchar(10) NOT NULL,
  `paino` int(10) NOT NULL,
  `vuosimalli` year(4) NOT NULL,
  `omistaja` varchar(50) NOT NULL,
  `sahkoposti` varchar(100) NOT NULL,
  `kotisatama` varchar(50) NOT NULL,
  `lisatiedot` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;





INSERT INTO `vene` (`id`, `nimi`, `malli`, `merkki`, `pituus`, `leveys`, `paino`, `vuosimalli`, `omistaja`, `sahkoposti`, `kotisatama`, `lisatiedot`) VALUES
(1, 'Pelikaani', 'Soutuvene', 'Terhi', '02.10', '01.20', '450', '1987', 'Pertti Keinonen', 'pertti@keinonen.fi', 'hss', 'Kala tarttuu haaviin!');
(2, 'Barracuda', 'Moottorivene', 'Targa', '15.10', '03.20', '6450', '2007', 'Matti Nykänen', 'matti@nykanen.fi', 'hss', 'Kelpaa ajella, muut kattoo kateellisena');





ALTER TABLE `vene`
  ADD PRIMARY KEY (`id`);
  
  
  ALTER TABLE `vene`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;