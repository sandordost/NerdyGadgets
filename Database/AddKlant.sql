USE NerdyGadgets;

CREATE TABLE IF NOT EXISTS klant(
	klantId INT,
    email VARCHAR(50),
    password VARCHAR(1000),
    voornaam VARCHAR(20),
    tussenvoegsel VARCHAR(15),
    achternaam VARCHAR(25),
    adres VARCHAR(50),
    land VARCHAR(50),
    postcode VARCHAR (10),
    telefoon VARCHAR (20)
);