# 12. CRUD aplikace, REST API


## Zdroje pro cvi�en�

### U�ite�n� zdroje :)

* curl pro Windows: http://curl.haxx.se/dlwiz/?type=bin
* **[10. cvi�en� z kurzu 4IZ268 - Formul��e](https://github.com/4iz268/cviceni/tree/master/10-formulare)**
* **[11. cvi�en� z kurzu 4IZ268 - Ajax](https://github.com/4iz268/cviceni/tree/master/11-ajax)**
* **[12. cvi�en� z kurzu 4IZ268 - API](https://github.com/4iz268/cviceni/tree/master/12-api)**
* http://api.jquery.com/jquery.ajax/

## CRUD

**CRUD** = **C**reate, **R**ead, **U**pdate, **D**elete = programov� p��stup/idiom pro pr�ce s daty. �asto ve vztahu k n�jak�mu objektu, kter� jde Vytvo�it, ��st, Aktualizovat a Mazat.

## REST

**REST** = **RE**presentational **S**tate **T**ransfer = architektonick� p��stup, kter� umo��uje pracovat se str�nkami a m�nit jejich stav. URI str�nky je typicky namapov�no na n�jak� objekt a pomoc� HTTP metod (GET, POST, PUT, DELETE) m�n�me stav tohoto objektu.
** REST nen� protokol, jen zp�sob komunikace. REST se �asto pou��v� pod HTTP protokolem.

Pro p�enos dat se obvykle pou��v� XML nebo JSON.

P��klad: 

* **GET https://hradil.vse.cz/api/clients/1.json** - zobraz� detail pro klienta s ID 1.
* **GET https://hradil.vse.cz/api/clients.json** - zobraz� v�pis v�ech klient�
* **POST https://hradil.vse.cz/api/clients.json** - zalo�� nov�ho klienta, v t�le HTTP metody jsou data (jm�no: Adam, p��jmen�: Shelby)
* **PUT https://hradil.vse.cz/api/clients/1.json** - aktualizuje klienta s ID 1, v t�le HTTP metody jsou nov� data (jm�no: Adam, p��jmen�: Shelby)
* **DELETE https://hradil.vse.cz/api/clients/1.json** - sma�e klienta Adama

Typick� a p��mo�ar� propojen� s CRUD:

* **POST** = **C**reate
* **GET** = **R**ead
* **PUT** = **U**pdate
* **DELETE** = **D**elete

### Ot�zky

* Jak� HTTP metody m��eme pou��vat v HTML?
* Jak byste vy�e�ili odesl�n� n�jak�ch dat p�es HTTP metodu, kterou HTML nepodporuje (nap�. jak poslat HTTP PUT pro update z�znamu pomoc� HTML formul��e)? Zaj�m� m� **�e�en� na serveru** (jako auto�i API) a **�e�en� na klientovi** (HTML).

## API

* **API** = Application Program Interface = aplika�n� programov� rozhran� = popis, jak pracovat s ciz�m programem tak, jak to jeho autor dovolil. Umo��uje napojit se na n�jakou aplikaci typicky *zven��* a propojit ji s na�� aplikac� nebo ji na d�lku ovl�dat. V p��pad� webu je API typicky t�eba, abychom dok�zali vyu��vat n�jak� slu�by, kter� jsme sami nenapsali, ale chceme je m�t v na�� aplikaci, nap�. pou��t mapy od Google pro pl�novan� trasy v na�� aplikaci, pos�lat automaticky p��sp�vky na Twitter, koment��e u�ivatel� v na�� aplikaci ukl�dat rovnou na ze� ve Facebooku, ov��it u�ivatele pomoc� jin� slu�by, apod.
* API p�e autor p�vodn�ho programu.
* API jako jedno z m�la pot�ebuje dobrou a podrobnou (program�torskou) dokumentaci.
* API nen� pro koncov� u�ivatele, ale pro program�tory.
* API je d�lkov� ovlada� k ciz�mu programu.
* API "vol�me" pomoc� n�jak� slu�by, dnes typicky p�es REST skrze HTTP request.


## Uk�zka REST API pro existuj�c� aplikaci

**Pozn�mka: opakov�n� z kurzu 4IZ268: https://github.com/4iz268/cviceni/tree/master/12-api**

### URL aplikace

https://hradil.vse.cz/api/clients

Aplikace m� i HTML rozhran�, ve kter�m lze prov�d�t v�echny popsan� akce.

### Zabezpe�en�

**Aplikace nem� autentizaci ani autorizaci. V�ichni maj� p��stup ke v�emu a data lze sd�let mezi sebou.**

**Pro filtrov�n� dat lze pou��t parametr xname.**

### P��klady

```bash
curl -H "Content-Type: application/json" -X GET https://hradil.vse.cz/api/clients.json?xname=xhraj18

curl -H "Content-Type: application/json" -X GET https://hradil.vse.cz/api/clients/1.json

curl -H "Content-Type: application/json" -X POST -d '{"first_name":"Jimmy","last_name":"Hendrix", "street":"Heaven Gate 1","town":"LA","xname":"xhraj18","zip":"10000"}' https://hradil.vse.cz/api/clients.json

curl -H "Content-Type: application/json" -X PUT -d '{"first_name":"Jimmy","last_name":"Page", "street":"3651 Lindell Rd. Suite D1024","town":"Las Vegas","xname":"xhraj18","zip":"89103"}' https://hradil.vse.cz/api/clients/1.json

curl -H "Content-Type: application/json" -X DELETE https://hradil.vse.cz/api/clients/1.json
```

### Form�t JSON dat

* id - String, generuje se automaticky p�i ulo�en�
* xname - String, nepovinn�, identifikace studenta
* first_name - String, nepovinn�, jm�no klienta
* last_name - String, nepovinn�, p��jmen� klienta
* street - String, nepovinn�, ulice klienta
* zip - String, nepovinn�, PS� klienta
* town - String, nepovinn�, m�sto klienta


### GET index, v�pis v�ech klient�

Pro filtrov�n� z�znam� pro konkr�tn�ho u�ivatele (studenta) lze pou��t parametr xname.

V p��kladu jsme jako xname pou�ili xhraj18, student pou�ije svoje vlastn�.

```bash
curl -H "Content-Type: application/json" -X GET https://hradil.vse.cz/api/clients.json?xname=xhraj18
```

Vrac� pole:

```json
[{"first_name":"Jimmy","id":1,"last_name":"Hendrix","street":"Heaven Gate 1","town":"LA","xname":"xhraj18","zip":"10000"}]
````

### GET show, detail klienta

Vy�aduje id klienta.


```bash
curl -H "Content-Type: application/json" -X GET https://hradil.vse.cz/api/clients/1.json
```

Vrac� 1 z�znam:

```json
{"first_name":"Jimmy","id":1,"last_name":"Hendrix","street":"Heaven Gate 1","town":"LA","xname":"xhraj18","zip":"10000"}
```

### POST create, ulo�en� nov�ho klienta

Id klienta se generuje automaticky p�i ulo�en�, nepos�l�me.

Jako xname pou�ije student svoje xname, v p��kladu pou��v�me xhraj18.

```bash
curl -H "Content-Type: application/json" -X POST -d '{"first_name":"Jimmy","last_name":"Hendrix", "street":"Heaven Gate 1","town":"LA","xname":"xhraj18","zip":"10000"}' https://hradil.vse.cz/api/clients.json
```

Vrac� 1 z�znam v�etn� pr�v� vygenerovan�ho id:

```json
{"first_name":"Jimmy","id":1,"last_name":"Hendrix","street":"Heaven Gate 1","town":"LA","xname":"xhraj18","zip":"10000"}
```

### PUT update, aktualizace klienta

Vy�aduje id klienta.

```
curl -H "Content-Type: application/json" -X PUT -d '{"first_name":"Jimmy","last_name":"Page", "street":"3651 Lindell Rd. Suite D1024","town":"Las Vegas","xname":"xhraj18","zip":"89103"}' https://hradil.vse.cz/api/clients/1.json
```

Nevrac� nic.


### DELETE, smaz�n� klienta

Vy�aduje id klienta.

```
curl -H "Content-Type: application/json" -X DELETE https://hradil.vse.cz/api/clients/1.json
```

Nevrac� nic.


### Pozn�mky pro v�voj��e API (serverov� ��st)

Server mus� do response p�id�vat hlavi�ku:

```
Access-Control-Allow-Origin: *
```

Jinak browser vyhod� bezpe�nostn� chybu:

```
Cross-Origin Request Blocked: The Same Origin Policy disallows reading the remote resource at https://hradil.vse.cz/api/clients.json?xname=xhraj18. (Reason: CORS header 'Access-Control-Allow-Origin' missing).
```

V Apache se hlavi�ka p�id� do souboru **.htaccess**, v Nginx pod location v souboru **nginx.conf**, nap�.

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


Uk�zka spr�vn� a kompletn� hlavi�ky:

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


## Dom�c� �kol

* Napi�te klienta pro jak�koli voln� dostupn� API (Google Maps, Seznam Mapy, Twitter, Facebook, Pinterest, Instagram... nebo i jak�koli jin�).
