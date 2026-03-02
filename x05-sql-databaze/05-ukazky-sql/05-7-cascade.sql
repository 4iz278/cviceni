-- kaskada - update/delete skrze cizi klice
-- je to vlastnost ciziho klice
-- http://dev.mysql.com/doc/refman/5.5/en/create-table.html
-- http://dev.mysql.com/doc/refman/5.6/en/innodb-foreign-key-constraints.html
-- doporucili byste pouzivani? Jake jsou vyhody/nevyhody? Je lepsi to resit v aplikacni nebo db vrstve?
-- default je RESTRICT

-- nadrizena tabulka zadnou kaskadu nedefinuje
CREATE TABLE drivers
(
	id SERIAL PRIMARY KEY
)
CHARACTER SET utf8
;

--vytvoreni podrizene tabulky s kaskadou na update, ale ne na delete
CREATE TABLE cars
(
	id SERIAL PRIMARY KEY,
	driver_id BIGINT(20) UNSIGNED,
	
	INDEX (driver_id),
	
	FOREIGN KEY (driver_id) REFERENCES drivers(id) ON UPDATE CASCADE ON DELETE RESTRICT
)
CHARACTER SET utf8
;


--ulozeni nadrizeneho zaznamu
INSERT INTO drivers VALUES (1);

--ulozeni podrizeneho zaznamu
INSERT INTO cars VALUES (0, 1);

--kaskada na update, projde
UPDATE drivers SET id = 2 WHERE id = 1;

--kaskada na delete, neprojde
DELETE FROM drivers;

-- otazka: Jak je tedy nutne smazat zaznamy, aby nebyla porusena referencni integrita?
