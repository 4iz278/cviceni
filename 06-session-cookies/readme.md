# 6. SQL a databáze

:grey_exclamation: **Tato složka obsahuje podklady k domácímu studiu ke cvičením 2. a 3.4.2020.**
Oproti běžným podkladům ke cvičením zde naleznete podrobnější vysvětlení dané problematiky a další příklady.

## Opakování z minulého cvičení

:point_right:

V rámci [minulého cvičení](../05-sql-databaze) jsme se zabývali vlastnostmi databáze MariaDB. Následně jsme si:
- [ukázali práci s nástrojem phpMyAdmin](../05-sql-databaze/05-prezentace-phpmyadmin.pptx),
- probrali používání databáze pomocí PDO  
- a [ukázali tvorbu databázové aplikace v rámci komentované prezentace].

Místo podrobného opakování se rovnou vrhneme na obsah dnešního cvičení, protože se na práci s databází podíváme ještě v dalším komentovaném ukázkovém příkladu. 

    
:house:

Ještě připomínám, že součástí byl také [domácí úkol](../05-sql-databaze#dom%C3%A1c%C3%AD-%C3%BAkol). Pokud jej máte (byť i jen z části) hotový, nezapomeňte na jeho odevzdání.
    
---

:point_right:

**Na tomto cvičení nás čeká:**
- [opakování práce s databází](#opakov%C3%A1n%C3%AD-pr%C3%A1ce-s-datab%C3%A1z%C3%AD) prostřednictvím další ukázkové aplikace  
- [cookies](#cookies)
- [session](#session)
- [vyzkoušení si práce se session] <!--TODO--> 
- [ukázková aplikace](#uk%C3%A1zkov%C3%A1-aplikace)
---      

# Opakování práce s databází
:point_right:

S ohledem na to, že s databází budeme pracovat až do konce semestru, ještě bychom si měli práci s ní procvičit.
**Projděte si prosím následující okomentované zdrojové kódy.**

:blue_book:
- postup zprovoznění ukázkové aplikace:
    1. stáhněte si celou složku aplikace ([06-db-app-clients](./06-db-app-clients)) a nahrajte ji na server
    2. nahrajte do MariaDB [strukturu databáze](./06-db-app-clients/06-schema.sql)
    3. nahrajte do MariaDB [ukázková data](./06-db-app-clients/06-data.sql)
    4. nastavte vlastní xname a heslo k databázi v souboru [db.php](./06-db-app-clients/db.php)
- ukázkové skripty v aplikaci:
    - [jednoduchý výpis klientů](./06-db-app-clients/index.php)
    - [výpis klientů se stránkováním](./06-db-app-clients/index_with_pagination.php)
    - [vytvoření nového klienta](./06-db-app-clients/new_prepare.php)
    - [vytvoření nového klienta - bez ošetření SQL injection](./06-db-app-clients/new_open.php)
    - [úprava klienta](./06-db-app-clients/update.php)
    - [smazání klienta](./06-db-app-clients/delete.php)    

# Cookies

TODO

# Session

TODO

TODO vyzkoušení si práce se session

# Ukázková aplikace 

TODO    