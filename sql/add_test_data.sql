INSERT INTO Opiskelija (opiskelijanro, nimi, syntymaaika, salasana)
 VALUES ('1243', 'Matti Meikäläinen', '1990-01-01', 'qwerty');
INSERT INTO Opiskelija (opiskelijanro, nimi, syntymaaika, salasana)
 VALUES ('3421', 'Maija Doe', '1991-02-11', 'dvorak');

INSERT INTO Opettaja (openro, nimi, syntymaaika, kuvaus, salasana)
 VALUES ('0987', 'Olli Ope', '1980-12-12', 'Järkyttävä työnarkomaani.', 'cobolrules');
INSERT INTO Opettaja (openro, nimi, syntymaaika, kuvaus, salasana)
 VALUES ('6543', 'Aili Ammattiohjaaja', '1979-03-12', 'Väitetysti peruspätevä', 'reikakortitkunniaan');

INSERT INTO Kurssi (opeid, aihe, kurssimaksu, kuvaus, aloituspvm, aloitusaika)
 VALUES ('2', 'Kokkauksen perusteet', '25', 'Sämpylät, munakas, jauhelihakeitto jne...',
 '2017-01-15', '17:00:00');
INSERT INTO Kurssi (opeid, aihe, kurssimaksu, kuvaus, aloituspvm, aloitusaika)
 VALUES ('1', 'Purkamisen jatkokurssi', '150', 'Lisää mieletöntä hävitystä.',
 '2017-04-02', '04:00:00');