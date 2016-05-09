# 12. CRUD aplikace, REST API


## Zdroje pro cvičení

* curl pro Windows: http://curl.haxx.se/dlwiz/?type=bin
* **[10. cvičení z předchozího kurzu 4IZ268 - Formuláře](https://github.com/4iz268/cviceni/tree/master/10-formulare)**
* **[11. cvičení z předchozího kurzu 4IZ268 - Ajax](https://github.com/4iz268/cviceni/tree/master/11-ajax)**
* **[12. cvičení z předchozího kurzu 4IZ268 - API](https://github.com/4iz268/cviceni/tree/master/12-api)**
* **[11. cvičení z tohoto kurzu - XML, JSON](../11-json-xml)**
* http://api.jquery.com/jquery.ajax/

## CRUD

**CRUD** = **C**reate, **R**ead, **U**pdate, **D**elete = programový přístup/idiom pro práce s daty. Často ve vztahu k nějakému objektu, který jde Vytvořit, Číst, Aktualizovat a Mazat.

## REST

**REST** = **RE**presentational **S**tate **T**ransfer = architektonický přístup, který umožňuje pracovat se stránkami a měnit jejich stav. URI stránky je typicky namapováno na nějaký objekt a pomocí HTTP metod (GET, POST, PUT, DELETE) měníme stav tohoto objektu.
** REST není protokol, jen způsob komunikace. REST se často používá pod HTTP protokolem.

Pro přenos dat se obvykle používá XML nebo JSON.

Příklad: 

* **GET https://hradil.vse.cz/api/clients/1.json** - zobrazí detail pro klienta s ID 1.
* **GET https://hradil.vse.cz/api/clients.json** - zobrazí výpis všech klientů
* **POST https://hradil.vse.cz/api/clients.json** - založí nového klienta, v těle HTTP metody jsou data (jméno: Adam, příjmení: Shelby)
* **PUT https://hradil.vse.cz/api/clients/1.json** - aktualizuje klienta s ID 1, v těle HTTP metody jsou nová data (jméno: Adam, příjmení: Shelby)
* **DELETE https://hradil.vse.cz/api/clients/1.json** - smaže klienta Adama

Typické a přímočaré propojení s CRUD:

* **POST** = **C**reate
* **GET** = **R**ead
* **PUT** = **U**pdate
* **DELETE** = **D**elete

### Otázky

* Jaké HTTP metody můžeme používat v HTML?
* Jak byste vyřešili odeslání nějakých dat přes HTTP metodu, kterou HTML nepodporuje (např. jak poslat HTTP PUT pro update záznamu pomocí HTML formuláře)? Zajímá mě **řešení na serveru** (jako autoři API) a **řešení na klientovi** (HTML).

## API

* **API** = Application Program Interface = aplikační programové rozhraní = popis, jak pracovat s cizím programem tak, jak to jeho autor dovolil. Umožňuje napojit se na nějakou aplikaci typicky *zvenčí* a propojit ji s naší aplikací nebo ji na dálku ovládat. V případě webu je API typicky třeba, abychom dokázali využívat nějaké služby, které jsme sami nenapsali, ale chceme je mít v naší aplikaci, např. použít mapy od Google pro plánovaní trasy v naší aplikaci, posílat automaticky příspěvky na Twitter, komentáře uživatelů v naší aplikaci ukládat rovnou na zeď ve Facebooku, ověřit uživatele pomocí jiné služby, apod.
* API píše autor původního programu.
* API jako jedno z mála potřebuje dobrou a podrobnou (programátorskou) dokumentaci.
* API není pro koncové uživatele, ale pro programátory.
* API je dálkový ovladač k cizímu programu.
* API "voláme" pomocí nějaké služby, dnes typicky přes REST skrze HTTP request.


## Ukázka REST API pro existující aplikaci

**Poznámka: opakování z kurzu 4IZ268: https://github.com/4iz268/cviceni/tree/master/12-api**

### URL aplikace

https://hradil.vse.cz/api/clients

Aplikace má i HTML rozhraní, ve kterém lze provádět všechny popsané akce.

### Zabezpečení

**Aplikace nemá autentizaci ani autorizaci. Všichni mají přístup ke všemu a data lze sdílet mezi sebou.**

**Pro filtrování dat lze použít parametr xname.**

### Příklady

```bash
curl -H "Content-Type: application/json" -X GET https://hradil.vse.cz/api/clients.json?xname=xhraj18

curl -H "Content-Type: application/json" -X GET https://hradil.vse.cz/api/clients/1.json

curl -H "Content-Type: application/json" -X POST -d '{"first_name":"Jimmy","last_name":"Hendrix", "street":"Heaven Gate 1","town":"LA","xname":"xhraj18","zip":"10000"}' https://hradil.vse.cz/api/clients.json

curl -H "Content-Type: application/json" -X PUT -d '{"first_name":"Jimmy","last_name":"Page", "street":"3651 Lindell Rd. Suite D1024","town":"Las Vegas","xname":"xhraj18","zip":"89103"}' https://hradil.vse.cz/api/clients/1.json

curl -H "Content-Type: application/json" -X DELETE https://hradil.vse.cz/api/clients/1.json
```

### Formát JSON dat

* id - String, generuje se automaticky při uložení
* xname - String, nepovinné, identifikace studenta
* first_name - String, nepovinné, jméno klienta
* last_name - String, nepovinné, příjmení klienta
* street - String, nepovinné, ulice klienta
* zip - String, nepovinné, PSČ klienta
* town - String, nepovinné, město klienta


### GET index, výpis všech klientů

Pro filtrování záznamů pro konkrétního uživatele (studenta) lze použít parametr xname.

V příkladu jsme jako xname použili xhraj18, student použije svoje vlastní.

```bash
curl -H "Content-Type: application/json" -X GET https://hradil.vse.cz/api/clients.json?xname=xhraj18
```

Vrací pole:

```json
[{"first_name":"Jimmy","id":1,"last_name":"Hendrix","street":"Heaven Gate 1","town":"LA","xname":"xhraj18","zip":"10000"}]
````

### GET show, detail klienta

Vyžaduje id klienta.


```bash
curl -H "Content-Type: application/json" -X GET https://hradil.vse.cz/api/clients/1.json
```

Vrací 1 záznam:

```json
{"first_name":"Jimmy","id":1,"last_name":"Hendrix","street":"Heaven Gate 1","town":"LA","xname":"xhraj18","zip":"10000"}
```

### POST create, uložení nového klienta

Id klienta se generuje automaticky při uložení, neposíláme.

Jako xname použije student svoje xname, v příkladu používáme xhraj18.

```bash
curl -H "Content-Type: application/json" -X POST -d '{"first_name":"Jimmy","last_name":"Hendrix", "street":"Heaven Gate 1","town":"LA","xname":"xhraj18","zip":"10000"}' https://hradil.vse.cz/api/clients.json
```

Vrací 1 záznam včetně právě vygenerovaného id:

```json
{"first_name":"Jimmy","id":1,"last_name":"Hendrix","street":"Heaven Gate 1","town":"LA","xname":"xhraj18","zip":"10000"}
```

### PUT update, aktualizace klienta

Vyžaduje id klienta.

```
curl -H "Content-Type: application/json" -X PUT -d '{"first_name":"Jimmy","last_name":"Page", "street":"3651 Lindell Rd. Suite D1024","town":"Las Vegas","xname":"xhraj18","zip":"89103"}' https://hradil.vse.cz/api/clients/1.json
```

Nevrací nic.


### DELETE, smazání klienta

Vyžaduje id klienta.

```
curl -H "Content-Type: application/json" -X DELETE https://hradil.vse.cz/api/clients/1.json
```

Nevrací nic.


### Poznámky pro vývojáře API (serverová část)

Server musí do response přidávat hlavičku:

```
Access-Control-Allow-Origin: *
```

Jinak browser vyhodí bezpečnostní chybu:

```
Cross-Origin Request Blocked: The Same Origin Policy disallows reading the remote resource at https://hradil.vse.cz/api/clients.json?xname=xhraj18. (Reason: CORS header 'Access-Control-Allow-Origin' missing).
```

V Apache se hlavička přidá do souboru **.htaccess**, v Nginx pod location v souboru **nginx.conf**, např.

```
location ~ ^/api(/.*|$) {
    alias /home/xhraj18/api/current/public$1;  # <-- be sure to point to 'public'!
    passenger_base_uri /api;
    passenger_app_root /home/xhraj18/api/current/;
    passenger_document_root /home/xhraj18/api/current/public;
    passenger_enabled on;
    add_header 'Access-Control-Allow-Origin' '*';
}
```


Ukázka správné a kompletní hlavičky:

```
curl -I -k -H "Content-Type: application/json" -X GET https://hradil.vse.cz/api/clients.json?xname=xhraj18
HTTP/1.1 200 OK
Content-Type: application/json; charset=utf-8
Transfer-Encoding: chunked
Connection: keep-alive
Status: 200 OK
X-UA-Compatible: IE=Edge,chrome=1
ETag: "971100cf91d23a3fa9771f89ccc1a716"
Cache-Control: max-age=0, private, must-revalidate
X-Request-Id: 0131a2bb6730b9b5c472fed270334d19
X-Runtime: 0.157872
Date: Thu, 17 Dec 2015 16:07:05 GMT
X-Rack-Cache: miss
X-Powered-By: Phusion Passenger 4.0.57
Server: nginx/1.6.2 + Phusion Passenger 4.0.57
Access-Control-Allow-Origin: *
```

## Ukázky server/client API

**Vstupní podmínkou k této části jsou znalosti:**

* AJAX funkcí pomocí jQuery, viz [11. cvičení z předchozího kurzu 4IZ268 - Ajax](https://github.com/4iz268/cviceni/tree/master/11-ajax) 
* JSON, viz [11. cvičení - JSON, XML](../11-json-xml)

## AJAX JSON client pro externí API

* [index](./12-client/index.html) - výpis a mazání klientů.
* [new](./12-client/new.html) - přidání nového klienta.
* [edit](./12-client/edit.html) - přidání nového klienta.

*Všimněte si, že pro klienta nepotřebujeme PHP, vše děláme jen v HTML a jQuery.*

##  Vlastní JSON server API

### 1. Napíšeme si vlastní API, které vrací data v JSON formátu:

[Výchozí zdroják k serverové části](./12-server.php)

Request: http://eso.vse.cz/~xhraj18/12-server.php

Hlavička:

```
curl -I http://eso.vse.cz/~xhraj18/12-server.php
```
```
HTTP/1.1 200 OK
Date: Mon, 09 May 2016 20:32:08 GMT
Server: Apache/2.4.16 (Fedora) OpenSSL/1.0.1k-fips mod_nss/2.4.10 NSS/3.17.1 Basic ECC PHP/5.6.15 mod_perl/2.0.9 Perl/v5.18.4
X-Powered-By: PHP/5.6.15
Content-Type: application/json;charset=utf-8
```

Tělo:
```
curl -I http://eso.vse.cz/~xhraj18/12-server.php
```
```json
[{"id":1,"first_name":"Jimmy","last_name":"Hendrix","address":"All Along the Watchtower 1, Los Angeles, CA"},{"id":2,"first_name":"John","last_name":"Frusciante","address":"Californication & Hump de Bumb Street 33, Venice Beach, CA"}]
```

### 2. Upravte  soubor [12-server.php](./12-server.php):

* GET: Data se budou načítat z DB (dle formátu statických dat v příkladu vytvořte vhodnou DB strukturu).
* POST: Bude možno uložit nový záznam - vytvořte formulář, který bude odesílat data přes HTTP POST a na serveru se uloží do DB.

### 3. Napište klientské rozhraní pro CRUD k serverové části

Do toho :).

## Domácí úkol

* Napište pomocí HTML a jQuery klienta pro jakékoli další volně dostupné API (Google Maps, Seznam Mapy, Twitter, Facebook, Pinterest, Instagram... nebo i jakékoli jiné).
