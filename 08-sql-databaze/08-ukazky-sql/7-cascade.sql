-- kaskada - update/delete skrze cizi klice
-- je to vlastnost ciziho klice
-- doporucili byste pouzivani? Jake jsou vyhody/nevyhody?
-- je lepsi to resit v aplikacni nebo DB vrstve?
-- default je RESTRICT (neumozni smazani/změnu, pokud existuje vazba)

-- nadrizena tabulka zadnou kaskadu nedefinuje
CREATE TABLE drivers
(
    id SERIAL PRIMARY KEY
)
    CHARACTER SET utf8mb4
;

-- vytvoreni podrizene tabulky s kaskadou na update, ale ne na delete
CREATE TABLE cars
(
    id SERIAL PRIMARY KEY,
    driver_id BIGINT UNSIGNED,

    INDEX (driver_id),

    FOREIGN KEY (driver_id) REFERENCES drivers(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
)
    CHARACTER SET utf8mb4
;

-- ulozeni nadrizeneho zaznamu
INSERT INTO drivers VALUES (1);

-- ulozeni podrizeneho zaznamu
INSERT INTO cars VALUES (0, 1);

-- kaskada na update, projde (zmeni se i cars.driver_id)
UPDATE drivers SET id = 2 WHERE id = 1;

-- kaskada na delete, neprojde (RESTRICT zabrani smazani)
DELETE FROM drivers;

-- otazka:
-- Jak je tedy nutne smazat zaznamy, aby nebyla porusena referencni integrita?
-- (napoveda: nejdriv smazat zaznamy v podrizene tabulce, nebo pouzit ON DELETE CASCADE)