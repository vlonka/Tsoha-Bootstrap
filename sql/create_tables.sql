CREATE TABLE Opiskelija(
  id SERIAL PRIMARY KEY,
  opiskelijanro integer NOT NULL,
  nimi varchar(50) NOT NULL,
  syntymaaika date NOT NULL,
  salasana varchar(50) NOT NULL
);

CREATE TABLE Opettaja(
  id SERIAL PRIMARY KEY,
  openro integer NOT NULL, 
  nimi varchar(50) NOT NULL,
  syntymaaika DATE,
  kuvaus varchar(10000),
  salasana varchar(50) NOT NULL
);

CREATE TABLE Kurssi(
  id SERIAL PRIMARY KEY,
  opeid integer REFERENCES Opettaja(id),
  aihe varchar(50) NOT NULL,
  kurssimaksu integer NOT NULL,
  kuvaus varchar(10000) NOT NULL,
  aloituspvm DATE NOT NULL,
  aloitusaika TIME NOT NULL
);

CREATE TABLE Ilmoittautuminen(
  id SERIAL PRIMARY KEY,
  opiskelijaid integer REFERENCES Opiskelija(id),
  kurssi_id integer REFERENCES Kurssi(id),
  kurssimaksu boolean DEFAULT FALSE
);