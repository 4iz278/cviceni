--vytvor schema pro testovaci tabulku

CREATE TABLE clients
(
	id SERIAL PRIMARY KEY,
	first_name VARCHAR(255),
	last_name VARCHAR(255) NOT NULL,
	salary NUMERIC(10,2) NOT NULL DEFAULT 0,
	note TEXT
)
CHARACTER SET utf8
;


