# 12. CRUD aplikace, REST API


## Zdroje pro cvièení

### U¾iteèné zdroje :)

* curl pro Windows: http://curl.haxx.se/dlwiz/?type=bin
* **[10. cvièení z kurzu 4IZ268 - Formuláøe](https://github.com/4iz268/cviceni/tree/master/10-formulare)**
* **[11. cvièení z kurzu 4IZ268 - Ajax](https://github.com/4iz268/cviceni/tree/master/11-ajax)**
* **[12. cvièení z kurzu 4IZ268 - API](https://github.com/4iz268/cviceni/tree/master/12-api)**
* http://api.jquery.com/jquery.ajax/

## CRUD

**CRUD** = **C**reate, **R**ead, **U**pdate, **D**elete = programový pøístup/idiom pro práce s daty. Èasto ve vztahu k nìjakému objektu, který jde Vytvoøit, Èíst, Aktualizovat a Mazat.

## REST

**REST** = **RE**presentational **S**tate **T**ransfer = architektonický pøístup, který umo¾òuje pracovat se stránkami a mìnit jejich stav. URI stránky je typicky namapováno na nìjaký objekt a pomocí HTTP metod (GET, POST, PUT, DELETE) mìníme stav tohoto objektu.
** REST není protokol, jen zpùsob komunikace. REST se èasto pou¾ívá pod HTTP protokolem.

Pro pøenos dat se obvykle pou¾ívá XML nebo JSON.

Pøíklad: 

* **GET https://hradil.vse.cz/api/clients/1.json** - zobrazí detail pro klienta s ID 1.
* **GET https://hradil.vse.cz/api/clients.json** - zobrazí výpis v¹ech klientù
* **POST https://hradil.vse.cz/api/clients.json** - zalo¾í nového klienta, v tìle HTTP metody jsou data (jméno: Adam, pøíjmení: Shelby)
* **PUT https://hradil.vse.cz/api/clients/1.json** - aktualizuje klienta s ID 1, v tìle HTTP metody jsou nová data (jméno: Adam, pøíjmení: Shelby)
* **DELETE https://hradil.vse.cz/api/clients/1.json** - sma¾e klienta Adama

Typické a pøímoèaré propojení s CRUD:

* **POST** = **C**reate
* **GET** = **R**ead
* **PUT** = **U**pdate
* **DELETE** = **D**elete

### Otázky

* Jaké HTTP metody mù¾eme pou¾ívat v HTML?
* Jak byste vyøe¹ili odeslání nìjakých dat pøes HTTP metodu, kterou HTML nepodporuje (napø. jak poslat HTTP PUT pro update záznamu pomocí HTML formuláøe)? Zajímá mì **øe¹ení na serveru** (jako autoøi API) a **øe¹ení na klientovi** (HTML).

## API

* **API** = Application Program Interface = aplikaèní programové rozhraní = popis, jak pracovat s cizím programem tak, jak to jeho autor dovolil. Umo¾òuje napojit se na nìjakou aplikaci typicky *zvenèí* a propojit ji s na¹í aplikací nebo ji na dálku ovládat. V pøípadì webu je API typicky tøeba, abychom dokázali vyu¾ívat nìjaké slu¾by, které jsme sami nenapsali, ale chceme je mít v na¹í aplikaci, napø. pou¾ít mapy od Google pro plánovaní trasy v na¹í aplikaci, posílat automaticky pøíspìvky na Twitter, komentáøe u¾ivatelù v na¹í aplikaci ukládat rovnou na zeï ve Facebooku, ovìøit u¾ivatele pomocí jiné slu¾by, apod.
* API pí¹e autor pùvodního programu.
* API jako jedno z mála potøebuje dobrou a podrobnou (programátorskou) dokumentaci.
* API není pro koncové u¾ivatele, ale pro programátory.
* API je dálkový ovladaè k cizímu programu.
* API "voláme" pomocí nìjaké slu¾by, dnes typicky pøes REST skrze HTTP request.


## Ukázka REST API pro existující aplikaci

**Poznámka: opakování z kurzu 4IZ268: https://github.com/4iz268/cviceni/tree/master/12-api**

### URL aplikace

https://hradil.vse.cz/api/clients

Aplikace má i HTML rozhraní, ve kterém lze provádìt v¹echny popsané akce.

### Zabezpeèení

**Aplikace nemá autentizaci ani autorizaci. V¹ichni mají pøístup ke v¹emu a data lze sdílet mezi sebou.**

**Pro filtrování dat lze pou¾ít parametr xname.**

### Pøíklady

```bash
curl -H "Content-Type: application/json" -X GET https://hradil.vse.cz/api/clients.json?xname=xhraj18

curl -H "Content-Type: application/json" -X GET https://hradil.vse.cz/api/clients/1.json

curl -H "Content-Type: application/json" -X POST -d '{"first_name":"Jimmy","last_name":"Hendrix", "street":"Heaven Gate 1","town":"LA","xname":"xhraj18","zip":"10000"}' https://hradil.vse.cz/api/clients.json

curl -H "Content-Type: application/json" -X PUT -d '{"first_name":"Jimmy","last_name":"Page", "street":"3651 Lindell Rd. Suite D1024","town":"Las Vegas","xname":"xhraj18","zip":"89103"}' https://hradil.vse.cz/api/clients/1.json

curl -H "Content-Type: application/json" -X DELETE https://hradil.vse.cz/api/clients/1.json
```

### Formát JSON dat

* id - String, generuje se automaticky pøi ulo¾ení
* xname - String, nepovinné, identifikace studenta
* first_name - String, nepovinné, jméno klienta
* last_name - String, nepovinné, pøíjmení klienta
* street - String, nepovinné, ulice klienta
* zip - String, nepovinné, PSÈ klienta
* town - String, nepovinné, mìsto klienta


### GET index, výpis v¹ech klientù

Pro filtrování záznamù pro konkrétního u¾ivatele (studenta) lze pou¾ít parametr xname.

V pøíkladu jsme jako xname pou¾ili xhraj18, student pou¾ije svoje vlastní.

```bash
curl -H "Content-Type: application/json" -X GET https://hradil.vse.cz/api/clients.json?xname=xhraj18
```

Vrací pole:

```json
[{"first_name":"Jimmy","id":1,"last_name":"Hendrix","street":"Heaven Gate 1","town":"LA","xname":"xhraj18","zip":"10000"}]
````

### GET show, detail klienta

Vy¾aduje id klienta.


```bash
curl -H "Content-Type: application/json" -X GET https://hradil.vse.cz/api/clients/1.json
```

Vrací 1 záznam:

```json
{"first_name":"Jimmy","id":1,"last_name":"Hendrix","street":"Heaven Gate 1","town":"LA","xname":"xhraj18","zip":"10000"}
```

### POST create, ulo¾ení nového klienta

Id klienta se generuje automaticky pøi ulo¾ení, neposíláme.

Jako xname pou¾ije student svoje xname, v pøíkladu pou¾íváme xhraj18.

```bash
curl -H "Content-Type: application/json" -X POST -d '{"first_name":"Jimmy","last_name":"Hendrix", "street":"Heaven Gate 1","town":"LA","xname":"xhraj18","zip":"10000"}' https://hradil.vse.cz/api/clients.json
```

Vrací 1 záznam vèetnì právì vygenerovaného id:

```json
{"first_name":"Jimmy","id":1,"last_name":"Hendrix","street":"Heaven Gate 1","town":"LA","xname":"xhraj18","zip":"10000"}
```

### PUT update, aktualizace klienta

Vy¾aduje id klienta.

```
curl -H "Content-Type: application/json" -X PUT -d '{"first_name":"Jimmy","last_name":"Page", "street":"3651 Lindell Rd. Suite D1024","town":"Las Vegas","xname":"xhraj18","zip":"89103"}' https://hradil.vse.cz/api/clients/1.json
```

Nevrací nic.


### DELETE, smazání klienta

Vy¾aduje id klienta.

```
curl -H "Content-Type: application/json" -X DELETE https://hradil.vse.cz/api/clients/1.json
```

Nevrací nic.


### Poznámky pro vývojáøe API (serverová èást)

Server musí do response pøidávat hlavièku:

```
Access-Control-Allow-Origin: *
```

Jinak browser vyhodí bezpeènostní chybu:

```
Cross-Origin Request Blocked: The Same Origin Policy disallows reading the remote resource at https://hradil.vse.cz/api/clients.json?xname=xhraj18. (Reason: CORS header 'Access-Control-Allow-Origin' missing).
```

V Apache se hlavièka pøidá do souboru **.htaccess**, v Nginx pod location v souboru **nginx.conf**, napø.

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


Ukázka správné a kompletní hlavièky:

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


## Domácí úkol

* Napi¹te klienta pro jakékoli volnì dostupné API (Google Maps, Seznam Mapy, Twitter, Facebook, Pinterest, Instagram... nebo i jakékoli jiné).
