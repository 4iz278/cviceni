--DELETE, viz http://dev.mysql.com/doc/refman/5.5/en/delete.html


--musi se tady pouzivat transakce? Proc ano/ne?
BEGIN;

DELETE FROM clients;

ROLLBACK;



BEGIN;

DELETE FROM clients WHERE id=1;

COMMIT;


-- !!! pozor na cascade (mazani podrizenych zaznamu) !!!
-- http://dev.mysql.com/doc/refman/5.6/en/innodb-foreign-key-constraints.html

