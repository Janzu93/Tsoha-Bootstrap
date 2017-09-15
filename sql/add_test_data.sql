INSERT INTO Kayttaja(etunimi, sukunimi, kayttajatunnus, syntymapaiva, osoite)
 VALUES ('Peikko', 'Petterinen', 'Peikko Petterinen', '1999-01-01', 'Karhunkuja 7, 02100 Espoo');

INSERT INTO Kayttaja(etunimi, sukunimi, kayttajatunnus, syntymapaiva, osoite)
 VALUES ('Matti', 'Maksaja', 'Matti Maksaja', '1998-10-10', 'Testitie 5D, 02110 Helsinki');

INSERT INTO Ilmoitus(nimi, alkamispaiva, paattymispaiva, lahtohinta, hintaNyt, kuvaus, kayttaja_id)
 VALUES('Ladidas kenkä (pariton)', '2017-09-09', '2017-09-20', 20.00, 50.00,'Myydään tarpeettomana Ladidaksen pariton kenkä. Vain tosissaan huutavia kiitos!',
 1);

INSERT INTO Ilmoitus(nimi, alkamispaiva, paattymispaiva, lahtohinta, hintaNyt, kuvaus, kayttaja_id)
 VALUES ('Saapas', '2016-11-11', '2017-01-11', 0.00, 2.00, 'Hyvä saapas, kannattaa ostaa!', 2);

INSERT INTO Huuto(ilmoitus_id, kayttaja_id, hinta, paiva)
 VALUES (1, 2, 50.00, '2017-09-09');

INSERT INTO Huuto(ilmoitus_id, kayttaja_id, hinta, paiva)
 VALUES (2, 1, 2.00, '2016-12-24');