--CREATE TABLE: http://dev.mysql.com/doc/refman/5.5/en/create-table.html
--DATOVE TYPY: http://dev.mysql.com/doc/refman/5.5/en/data-types.html
--Server version: 10.0.21-MariaDB-log MariaDB Server
--varchar 65,535 od 5.0.3
--datovy typ serial: SERIAL is an alias for BIGINT UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE.

-- !!! pozor na charset, default je latin1 !!!

--vytvor tabulku
CREATE TABLE clients
(
	id SERIAL PRIMARY KEY,
	name VARCHAR(255),
	surname VARCHAR(255) NOT NULL,
	salary NUMERIC(10,2) NOT NULL DEFAULT 0,
	note TEXT
)
CHARACTER SET utf8
;

--zobraz detail tabulky
DESC clients;

--vypis vsechny zaznamy z tabulky
--zatim zadne nejsou
SELECT * FROM clients;

--ukaz indexy na tabulce
--co je to index? Reknete priklad a analogii s telefonnim seznamem.
--vsimnete si, ze byl automaticky vytvoren index na sloupec id. Proc?
SHOW INDEX from clients;

--numeric je implementovan jako decimal
--default NUMERIC je (10,0)

--vytvoreni podrizene tabulky
CREATE TABLE addresses
(
	id SERIAL PRIMARY KEY,
	client_id BIGINT(20) UNSIGNED NOT NULL,
	street VARCHAR(255),
	city VARCHAR(255),
	zip VARCHAR(255),
	
	INDEX (client_id),
	
	FOREIGN KEY (client_id) REFERENCES clients(id)
)
CHARACTER SET utf8
;


--vytvoreni podrizene tabulky
CREATE TABLE phones
(
	id SERIAL PRIMARY KEY,
	client_id BIGINT(20) UNSIGNED,
	phone VARCHAR(255) NOT NULL,
	
	INDEX (client_id),
	
	FOREIGN KEY (client_id) REFERENCES clients(id)
)
CHARACTER SET utf8
;



--pozor, cizi klic MUSI byt stejny datovy typ jako odkazovana tabulka
-- SIGNED vs UNSIGNED http://stackoverflow.com/questions/3155099/the-difference-between-signed-and-unsigned-in-mysql
-- UNSIGNED nemaji znamenka (zaporna cisla)

/*
http://dev.mysql.com/doc/refman/5.1/en/show-columns.html

DESCRIBE <table>; 
This is acutally a shortcut for:

SHOW COLUMNS FROM <table>;
In any case, there are three possible values for the "Key" attribute:

PRI
UNI
MUL
The meaning of PRI and UNI are quite clear:

PRI=> primary key
UNI=> unique key
The third possibility, MUL, (which you asked about) is basically an index that is neither a primary key nor a unique key. The name comes from "multiple" because multiple occurences of the same value are allowed. Straight from the MySQL documentation:
*/


