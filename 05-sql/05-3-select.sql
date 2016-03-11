--tuto cast je mozno zkusit az po scriptech create-table a insert, potrebujeme nejaka data
--SELECT, viz http://dev.mysql.com/doc/refman/5.5/en/select.html

SELECT * FROM clients;

SELECT * FROM addresses;

--JOIN VS LEFT VS RIGHT JOIN
--vysvetlete rozdil mezi JOIN, LEFT JOIN a RIGHT JOIN

SELECT * FROM clients JOIN addresses ON clients.id=addresses.client_id;

SELECT * FROM clients LEFT JOIN addresses ON clients.id=addresses.client_id;


SELECT * FROM clients JOIN phones ON clients.id=phones.client_id;

SELECT * FROM clients LEFT JOIN phones ON clients.id=phones.client_id;

SELECT * FROM clients RIGHT JOIN phones ON clients.id=phones.client_id;

--zkuste si SELECT spolecne s WHERE

