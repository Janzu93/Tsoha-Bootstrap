-- Lisää CREATE TABLE lauseet tähän tiedostoon
CREATE TABLE Kayttaja (
	id serial PRIMARY KEY,
	etunimi VARCHAR(20) NOT NULL,
	sukunimi VARCHAR(20) NOT NULL,
	syntymapaiva TIMESTAMP NOT NULL,
	osoite VARCHAR(100) NOT NULL,
	oikeudet NUMERIC(1,0) DEFAULT '0' NOT NULL
);



CREATE TABLE Huuto (
  id SERIAL PRIMARY KEY,
  ilmoitus_id INT REFERENCES Ilmoitus(id),
  kayttaja_id INT REFERENCES Kayttaja(id),
  hinta NUMERIC(8,2) NOT NULL,
  aika TIMESTAMP NOT NULL
);



CREATE TABLE Ilmoitus (
	id serial PRIMARY KEY,
	nimi VARCHAR(200) NOT NULL,
	paattymispaiva TIMESTAMP NOT NULL,
	lahtohinta NUMERIC(8,2) NOT NULL,
	hintaNyt NUMERIC(8,2) NOT NULL,
	kuvaus VARCHAR(1000) NOT NULL,
	kayttaja_id INT REFERENCES Kayttaja(id)
);