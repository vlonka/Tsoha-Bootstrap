CREATE TABLE Opiskelija(
  id integer PRIMARY KEY, 
  nimi varchar(50) NOT NULL,
  syntymaaika date NOT NULL,
  salasana varchar(50) NOT NULL
);

CREATE TABLE Opettaja(
  id integer PRIMARY KEY, 
  nimi varchar(50) NOT NULL,
  syntymaaika DATE,
  kuvaus varchar(10000),
  salasana varchar(50) NOT NULL
);

CREATE TABLE Kurssi(
  id integer PRIMARY KEY,
  opettajaid integer,
  aihe varchar(50) NOT NULL,
  kurssimaksu integer NOT NULL,
  kuvaus varchar(10000) NOT NULL,
  aloituspvm DATE NOT NULL,
  aloitusaika TIME NOT NULL,
  FOREIGN KEY(opettajaid) REFERENCES Opettaja(id)
);

CREATE TABLE Ilmoittautuminen(
  id SERIAL PRIMARY KEY,
  opiskelijaid integer,
  kurssiid integer,
  kurssimaksu boolean DEFAULT FALSE,
  FOREIGN KEY(opiskelijaid) REFERENCES Opiskelija(id),
  FOREIGN KEY(kurssiid) REFERENCES Kurssi(id)
);