-- tuto cast je mozno zkusit az po scriptech create-table a insert, potrebujeme nejaka data

SELECT * FROM clients;

SELECT * FROM addresses;

-- JOIN vs LEFT JOIN vs RIGHT JOIN

-- vysvetlete rozdil mezi:
-- JOIN (INNER JOIN) = vraci jen zaznamy, kde existuje shoda v obou tabulkach
-- LEFT JOIN = vraci vsechny zaznamy z leve tabulky + odpovidajici zaznamy z prave (neexistujici jsou NULL)
-- RIGHT JOIN = vraci vsechny zaznamy z prave tabulky + odpovidajici zaznamy z leve

-- jde nahradit RIGHT JOIN LEFT JOINem? Jak?
-- ano, prohodenim poradi tabulek

-- u kazdeho z nasledujicich selectu byste meli bez problemu poznat, kolik se vrati zaznamu

SELECT * FROM clients JOIN addresses ON clients.id = addresses.client_id;

SELECT * FROM clients LEFT JOIN addresses ON clients.id = addresses.client_id;

SELECT * FROM clients JOIN phones ON clients.id = phones.client_id;

SELECT * FROM clients LEFT JOIN phones ON clients.id = phones.client_id;

-- jaky je rozdil mezi temito 2 dotazy?
SELECT * FROM clients RIGHT JOIN phones ON clients.id = phones.client_id;

SELECT * FROM phones LEFT JOIN clients ON clients.id = phones.client_id;

-- poznamka: vysledky jsou ekvivalentni (jen se muze lisit poradi sloupcu)

-- zkuste si SELECT spolecne s WHERE (napr. filtrovani jen na konkretni klienty)