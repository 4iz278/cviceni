-- tuto cast je mozno zkouset az po scriptu create-table, potrebujeme existujici strukturu tabulek
-- INSERT

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
        'Josef',
        'Nový',
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

-- !!! pozor na FK, nasledujici zaznam se neulozi, protoze pouzivame odkaz na neexistujiciho klienta (id=500) !!!

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

-- dalsi datasety
-- jmena jsou prevzata z kultovniho serialu Battlestar Galactica :)

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

-- ulozeni telefonu bez klienta (client_id = NULL)
-- Myslite, ze ma tohle smysl? Uvedte vyhody/nevyhody.
INSERT INTO phones
(
    phone
)
VALUES
    (
        '333-333-333'
    )
;

-- pozor na dlouhe texty !!!
-- MariaDB muze dlouhy string zkratit (zalezi na nastaveni SQL_MODE)
-- text o Mustangu je prevzat z Wikipedia :)

INSERT INTO clients
(
    name,
    surname,
    salary,
    note
)
VALUES
    (
        'Josef',
        'Ford Mustang je sportovní automobil vyráběný firmou Ford Motor Company. Zpočátku byl založen na modelu Ford Falcon. Výroba vozu začala 9. března 1964 v Dearbornu, Michigan a veřejnosti byl představen 17. dubna 1964 v New Yorku. Byl to nejúspěšnější ford od Modelu A. Název navrhl John Najjar podle letounu North American P-51 Mustang. V letech 1967–1969 probíhala výroba vrcholné verze Shelby Mustang GT 500.',
        10000,
        'rock&roll, festina lente, surf, us muscle cars'
    )
;

-- zkracena verze zapisu, bez uvedeni sloupcu
-- data se ukladaji podle poradi sloupcu v tabulce !!!
-- 0 je misto auto increment (doporučeno nepoužívat, lepší je sloupec vynechat)
-- pozor na zmenu struktury tabulky -> tento zapis se pak muze rozbit

INSERT INTO clients
VALUES
    (
        0,
        'Josef',
        'Nový',
        10000,
        'rock&roll, festina lente, surf, us muscle cars'
    )
;

-- string na numeric (MariaDB provede implicitni pretypovani)
INSERT INTO clients
VALUES
    (
        0,
        'Josef',
        'Nový',
        '10000',
        'rock&roll, festina lente, surf, us muscle cars'
    )
;

-- porovnani stringu a cisla (implicitni konverze typu)
-- projde tohle? Proc?
SELECT '1000' = 1000;

-- a projde tohle? Proc?
SELECT '1000.00' = 1000;