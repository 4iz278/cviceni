

--http://dev.mysql.com/doc/refman/5.5/en/commit.html
--http://dev.mysql.com/doc/refman/5.5/en/glossary.html#glos_acid

--co je transakce? K cemu se pouziva?
--je jedno, jestli pouzijeme START TRANSACTION nebo BEGIN, oboje udela to same. BEGIN je kratsi z pouziva se treba v PostgreSQL.

--START TRANSACTION;

--BEGIN;

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
	client_id,
	phone
)
VALUES
(
	1,
	'333-333-333'
)
;

--ROLLBACK
--COMMIT

--POZOR: nektere jine databaze (napr. PostgreSQL) neumozni udelat commit, pokud uvnitr transakce doslo k nejake chybe (treba pokus o insert s neexistujicim cizim klicem). MySQL je s tim (bohuzel) v pohode a commit provede.

--transakce funguje na vsechny zmeny, vcetne update, delete, atd., ZKUSIT.

--otazka: Navrhnete strukturu tabulky/tabulek pro prevod penez z jednoho bankovniho uctu na druhy BEZ NUTNOSTI POUZITI TRANSAKCI. Jde to vubec?


