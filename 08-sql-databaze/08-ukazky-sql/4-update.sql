-- otazka: musi se tady nutne pouzivat transakce? vysvetlete proc ano/ne.
-- transakce jsou dulezite hlavne pri vice operacich, ktere musi probehnout vsechny nebo zadna
-- u jednoducheho UPDATE nejsou nutne, ale jsou vhodne pri testovani (moznost ROLLBACK)

-- aktualizace platu VSECH klientu najednou, pozor, NEBEZPECNE

START TRANSACTION;

UPDATE clients SET salary = 20000;

ROLLBACK;

-- bez WHERE se upravi vsechny zaznamy!
-- rollback vrati databazi do puvodniho stavu


-- aktualizace 1 konkretniho klienta (OK, takhle to pouzivejte)

START TRANSACTION;

UPDATE clients SET salary = 20000 WHERE id = 1;

COMMIT;


-- pouziti soucasne hodnoty jako zakladu pro novou hodnotu

START TRANSACTION;

UPDATE clients SET salary = salary * 1.2 WHERE id = 1;

COMMIT;