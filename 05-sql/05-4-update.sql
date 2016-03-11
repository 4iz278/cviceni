--UPDATE, viz http://dev.mysql.com/doc/refman/5.5/en/update.html

--otazka: musi se tady nutne pouzivat transakce? vysvetlete proc ano/ne.

--aktualizace platu VSECH klientu najednou, pozor, NEBEZPECNE

BEGIN;

UPDATE clients SET salary = 20000;

ROLLBACK;


--aktualizace 1 konkretniho klienta (OK, takhle to pouzivejte)

BEGIN;

UPDATE clients SET salary = 20000 WHERE id=1;

COMMIT;



--pouziti predchozi hodnoty

BEGIN;

UPDATE clients SET salary = salary*1.2 WHERE id=1;

COMMIT;






