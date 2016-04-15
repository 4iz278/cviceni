# 10. JSON, XML

* **K čemu jsou dobré strukturované formáty?**
* Jak je použít v aplikaci?

## Strukturované formáty
### CSV
* základní tabulkový formát, buňky oddělené středníky, čárkami či jiným oddělovačem
* známe ho již ze [2. cvičení](../02-retezce-soubory)
```csv
jmeno;prijmeni;email;email2
Josef;Novák;josef.novak@nekde.cz;josef.novak@nikde.com
Eva;Adamová;;
```

### XML
* značkovací jazyk využívaný pro záznam dokumentů o volitelné struktuře
* jde o obecný jazyk, z něhož jsou odvozeny konkrétní formáty používané pro konkrétní účely
    * dnes se s ním setkáme téměř všude
    * xHTML, docx, xlsx, isdoc, rss...
* každé XML by mělo být vytvářeno dle konkrétního schématu (definuje autor služby)
* výhody:
    * jasně definovaná struktura, snadno kontrolovatelná standartními mechanismy (dle schématu)
    * podpora ve všech rozumných programovacích jazycích (ale ne vždy jednoduché)
    * možnost XSL transformací
    * možnost kombinovat větší množství jmenných prostorů
* nevýhody:
    * pro jednoduchou výměnu dat zbytečně "ukecané" - i v následujícím příkladu značky zabírají větší množství znaků, než samotný obsah
    * v případě velkých dokumentů náročné na paměť (při zpracování DOM parserem - th. procházení v podobě stromu)

```xml
<?xml version='1.0' encoding='UTF-8'?>
<osoby>
    <osoba id="10">
        <jmeno>Josef</jmeno>
        <prijmeni>Novák</prijmeni>
        <email>josef.novak@nekde.cz</email>
        <email>josef.novak@nikde.com</email>
    </osoba>
    <osoba id="12">
        <jmeno>Eva</jmeno>
        <prijmeni>Adamová</prijmeni>
    </osoba>
</osoby>
```

### JSON
* jednoduchý formát odvozený od zápisu objektů v jazyce JavaScript (*JavaScript Object Notation*)
* výhody
    * podpora ve velkém množství jazyků
    * datově úsporný
    * jednoduchý i při ručním vytváření
* nevýhody:
    * není standartní mechanismus kontroly dat - je nutné kontrolovat v rámci zpracovávající aplikace
    * existuje [json schema](http://json-schema.org), ale není moc podporované a využívané
    * nepodporuje jmenné prostory

```json
{
    "10":{
        "jmeno":"Josef",
        "prijmeni":"Novák",
        "email":["josef.novak@nekde.cz","josef.novak@nikde.com"]
    },
    "12":{
        "jmeno":"Eva",
        "prijmeni":"Adamová"
    }
}
```

### Neon
* v rámci aplikací se setkáváme i s jinými strukturovanými formáty, zejména v oblasti konfigurace
* příkladem je jazyk **Neon**
    * viz [https://ne-on.org/](https://ne-on.org/)
    * používá ho např. framework *Nette*

## Práce se strukturovanými formáty v rámci PHP
### JSON
* **json_encode($data, $options)**
    * funkce pro zakódování pole, objektu atd.
    * pomocí $options jdou ovlivnist vlastnosti konverze - viz [json_encode v PHP manuálu](http://php.net/manual/en/function.json-encode.php)
* **json_decode($json, $assoc=false)**
    * funkce pro dekódování JSONu
    * vrací asociační pole nebo objekt (dle nastavení 2. parametru)
* Interface **JsonSerializable**
    * pro převod objektů do JSONu jsou ve výchozím stavu serializovány všechny properties
    * serializaci je možné ovlivnit implementováním rozhraní JsonSerializable (funkce **jsonSerialize()**)

```php
$data = ['jmeno'=>'Josef','prijmeni'=>'Novák'];
$json = json_encode($data); //funcke pro vytvoření JSONu z pole

$data2=json_decode($json, true); //funkce pro dekódování JSONu
```

* [příklad json_encode,json_decode](./json/encode_decode.php)
* [příklad JsonSerializable](./json/jsonserializable.php)

### XML
* v PHP máme k dispozici několik parserů, které umí pracovat s XML dokumenty
    * DOM přístup (procházení dle uzlů stromu)
        * [SimpleXML](http://php.net/manual/en/book.simplexml.php) (SimpleXMLElement)
        * [DOM Parser](http://php.net/manual/en/class.domdocument.php) (DOMDocument)
    * SAX přístup ("proudové" zpracování - vhodné pro hodně velké dokumenty)
        * [XMLReader](http://php.net/manual/en/xmlreader.open.php)
        * [Expat parser](http://www.w3schools.com/php/php_xml_parser_expat.asp)
* **pro většinu případů doporučuji použít SimpleXML**
    * jednoduchý objektový přístup ke XML dokumentu
    * lze jej využít pro čtení i zápis XML dokumentu
    * objekty jsou vzájemně převoditelné s DOM Parserem

* [příklad SimpleXML](./xml/simplexml.php)
* [příklad DOMDocument](./xml/domdocument.php)
* [příklad validace](./xml/validace.php)
* [příklad XSL transformace](./xml/transformace.php)
* [příklad RSS čtečka](./xml/rss-reader.php)

## AJAX aplikace
* *Asynchronous JavaScript and XML*
* přístup k tvorbě interaktivních aplikací, v rámci kterých je využíváno skriptování na straně klienta (v JavaScriptu) i na straně serveru
* pro přenos dat se používá XML, JSON nebo plaintext
* pokud chcete s daty jednoduše pracovat v javascriptu, je výhodné posílat JSON

TODO