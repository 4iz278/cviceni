# 5. SQL

## Připojení k Maria DB na serveru eso.vse.cz

```sh
ssh xname@eso.vse.cz # pripojit se pres konzoli na server eso (heslo je stejne jako heslo do InSISu)
```

```sh
cat ~/mysql-heslo.txt # vypsat vase heslo k mariadb databazi na esu
```

```sh
mysql -pHESLO xhraj18 # pripojit se na vasi databazi (nazev databaze je stejny jako vase xname). POZOR, mezi -p a heslem neni zadna mezera!
```

```sql
show tables; # vypise tabulky v db, asi zadne nebudete mit
```

[CREATE TABLE](./05-1-create-table.sql)

[INSERT](./05-2-insert.sql)

[SELECT](./05-3-select.sql)

[UPDATE](./05-4-update.sql)

[DELETE](./05-5-delete.sql)

* phpMyAdmin