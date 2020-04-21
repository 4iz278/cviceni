CREATE TABLE users
(
	id SERIAL PRIMARY KEY,
	email VARCHAR(255) NOT NULL,
	password VARCHAR(255) NOT NULL
)
CHARACTER SET utf8
;

CREATE UNIQUE INDEX in_users_email ON users(email);


--mysql auto update timestamp: http://dev.mysql.com/doc/refman/5.5/en/timestamp-initialization.html
--pokud je v tabulce pole timestamp, automaticky se aktualizuje na aktualni cast, pokud se zmeni jakakoli jina hodnota v radku
--default hodnota je "on update CURRENT_TIMESTAMP"


CREATE TABLE goods
(
	id SERIAL PRIMARY KEY,
	name VARCHAR(255),
	description TEXT,
	price NUMERIC(10,2) NOT NULL DEFAULT 0,
	
	last_updated_at TIMESTAMP,
	
	last_edit_starts_at TIMESTAMP,
	last_edit_starts_by_id BIGINT(20) UNSIGNED,
	
	FOREIGN KEY (last_edit_starts_by_id) REFERENCES users(id)
	
)
CHARACTER SET utf8
;
