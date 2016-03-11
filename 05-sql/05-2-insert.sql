--tuto cast je mozno zkouset az po scriptu create-table, potrebujeme existujici strukturu tabulek
--INSERT, viz http://dev.mysql.com/doc/refman/5.5/en/insert.html

SHOW VARIABLES LIKE 'character_set%';

INSERT INTO clients
(
	name,
	surname,
	salary,
	note
)
VALUES
(
	'Jiří',
	'Hradil',
	10000,
	'rock&roll, festina lente, surf, us muscle cars'
)
;


INSERT INTO addresses
(
	client_id,
	street,
	city,
	zip
)
VALUES
(
	1,
	'Lindell Street 1024',
	'Las Vegas, NE',
	'89103'
)
;

-- !!! pozor na FK, nasledujici zaznam se neulozi, protoze pouzivame odkaz na neexistujiciho klienta (id=0) !!!

INSERT INTO addresses
(
	id,
	client_id,
	street,
	city,
	zip
)
VALUES
(
	0,
	500,
	'Lindell Street 1024',
	'Las Vegas, NE',
	'89103'
)
;


--dalsi datasety
--jmena jsou prevzata z kultovniho serialu Battlestar Galactica :)

INSERT INTO clients
(
	name,
	surname,
	salary,
	note
)
VALUES
(
	'Gaius',
	'Baltar',
	1000000,
	'scientist and guru'
)
;


INSERT INTO clients
(
	name,
	surname,
	salary,
	note
)
VALUES
(
	'Nicholas',
	'Rush',
	500000,
	NULL
)
;


INSERT INTO phones
(
	client_id,
	phone
)
VALUES
(
	1,
	'111-111-111'
)
;

INSERT INTO phones
(
	client_id,
	phone
)
VALUES
(
	1,
	'222-222-222'
)
;

INSERT INTO phones
(
	phone
)
VALUES
(
	'333-333-333'
)
;



--pozor na dlouhe texty !!!
--mysql natvrdo zkrati dlouhy string, nevyhazuje chybu

INSERT INTO clients
(
	name,
	surname,
	salary,
	note
)
VALUES
(
	'Jiří',
	'Ford Mustang je sportovní automobil vyráběný firmou Ford Motor Company. Zpočátku byl založen na modelu Ford Falcon. Výroba vozu začala 9. března 1964 v Dearbornu, Michigan a veřejnosti byl představen 17. dubna 1964 v New Yorku. Byl to nejúspěšnější ford od Modelu A. Název navrhl John Najjar podle letounu North American P-51 Mustang. V letech 1967–1969 probíhala výroba vrcholné verze Shelby Mustang GT 500.',
	10000,
	'rock&roll, festina lente, surf, us muscle cars'
)
;


--zkracena verze zapisu
--0 misto auto increment, 1 uz neprojde (duplicita)
--pozor na michani sloupecku - ukladani probiha do sloupcu definovanych ve strukture tabulky !!!
--doporucujeme radeji pouzivat delsi (spolehlivejsi zapis) - problem je v tom, ze si musime pamatovat/zobrazit poradi sloupcu
INSERT INTO clients
VALUES
(
	0,
	'Jiří',
	'Hradil',
	10000,
	'rock&roll, festina lente, surf, us muscle cars'
)
;

--string na numeric, cast
INSERT INTO clients
VALUES
(
	0,
	'Jiří',
	'Hradil',
	'10000',
	'rock&roll, festina lente, surf, us muscle cars'
)
;

--zkusit doma, cast: http://dev.mysql.com/doc/refman/5.5/en/cast-functions.html
SELECT '1000' =  1000;

SELECT '1000.00' =  1000;

