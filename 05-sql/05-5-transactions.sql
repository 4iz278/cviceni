--http://dev.mysql.com/doc/refman/5.5/en/commit.html
--http://dev.mysql.com/doc/refman/5.5/en/glossary.html#glos_acid

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


--funguje na vsechny zmeny, vcetne update, delete, atd., ZKUSIT.


