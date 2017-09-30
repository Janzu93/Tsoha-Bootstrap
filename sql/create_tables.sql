CREATE TABLE Kayttaja(
 id serial primary key,
 etunimi VARCHAR(20) not null,
 sukunimi VARCHAR(20) not null,
 kayttajatunnus VARCHAR(10) UNIQUE not null,
 salasana VARCHAR(32) not null,
 syntymapaiva DATE not null,
 osoite VARCHAR(100) not null,
 oikeudet NUMERIC(1,0) DEFAULT 0 not null
);

CREATE TABLE Ilmoitus(
 id serial primary key,
 nimi VARCHAR(200) not null,
 alkamispaiva DATE DEFAULT current_date,
 paattymispaiva DATE not null,
 lahtohinta NUMERIC(8,2) not null,
 hintaNyt NUMERIC(8,2) not null,
 kuvaus VARCHAR(1000) not null,
 kayttaja_id INT REFERENCES Kayttaja(id)
);

CREATE TABLE Huuto(
 id SERIAL primary key,
 ilmoitus_id INT REFERENCES Ilmoitus(id),
 kayttaja_id INT REFERENCES Kayttaja(id),
 hinta NUMERIC(8,2) not null,
 paiva DATE not null
);