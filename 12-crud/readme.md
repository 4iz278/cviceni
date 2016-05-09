# 12. CRUD aplikace, REST API


## CRUD

**CRUD** = **C**reate, **R**ead, **U**pdate, **D**elete = programov� p��stup/idiom pro pr�ce s daty. �asto ve vztahu k n�jak�mu objektu, kter� jde Vytvo�it, ��st, Aktualizovat a Mazat.

## REST

**REST** = **RE**presentational **S**tate **T**ransfer = architektonick� p��stup, kter� umo��uje pracovat se str�nkami a m�nit jejich stav. URI str�nky je typicky namapov�no na n�jak� objekt a pomoc� HTTP metod (GET, POST, PUT, DELETE) m�n�me stav tohoto objektu.
** REST nen� protokol, jen zp�sob komunikace. REST se �asto pou��v� pod HTTP protokolem.

P��klad: 

* **GET https://nejakaaplikace.com/clients/adam** - zobraz� detail pro klienta Adama.
* **POST https://nejakaaplikace.com/clients** - zalo�� nov�ho klienta, v t�le HTTP metody jsou data (jm�no: Adam, p��jmen�: Shelby)
* **PUT https://nejakaaplikace.com/clients/adam** - aktualizuje klienta, v t�le HTTP metody jsou nov� data (jm�no: Adam, p��jmen�: Shelby)
* **DELETE https://nejakaaplikace.com/clients/adam** - sma�e klienta Adama

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


## 1. Zdroje pro cvi�en�:

* 

## 2. Vytvo�en� db sch�matu


## 3. Napln�n� testovac�mi daty


## 4. P�ipojen� k datab�zi


## 5. Pr�ce s aplikac�


### Pozn�mky a ot�zky k aplikaci


##  6. Dom�c� �kol

* Napi�te klienta pro jak�koli voln� dostupn� API (Google Maps, Seznam Mapy, Twitter, Facebook, Pinterest, Instagram... nebo i jak�koli jin�).
