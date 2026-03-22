--vytvor schema pro testovaci tabulku

CREATE TABLE clients
(
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	first_name VARCHAR(255),
	last_name VARCHAR(255) NOT NULL,
	salary DECIMAL(10,2) NOT NULL DEFAULT 0,
	note TEXT
)
CHARACTER SET utf8mb4
;


