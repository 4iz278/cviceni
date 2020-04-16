# 9. Uživatelé a DB, JSON, XML

:no_entry: **TYTO PODKLADY BUDOU TEPRVE AKTUALIZOVÁNY** :no_entry: 

## Opakování z předchozího cvičení
:point_right:

TODO

---

:point_right:

**Na tomto cvičení nás čeká:**
- příklad na obnovu zapomenutého hesla
- práce s datem a časem
- víceuživatelský přístup k databázi
- strukturované datové formáty
    - [JSON](#json)
    - [XML](#xml)
---


## JSON a XML
TODO

### JSON
:point_right:
- = jednoduchý formát odvozený od zápisu objektů v jazyce JavaScript (*JavaScript Object Notation*)
- výhody:
    - podporují ho v podstatě všechny moderní jazyky
    - jde o datově úsporný formát
    - jednoduchý i při ručním vytváření
- nevýhody:
    - není standartní mechanismus kontroly dat - je nutné kontrolovat v rámci zpracovávající aplikace
    - existuje [json schema](http://json-schema.org), ale není moc podporované a využívané
    - nepodporuje jmenné prostory a vícenásobné definice prvků se stejným jménem

:point_right:
   
Příklad JSONu:    
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

:point_right:

#### Práce s JSONem z PHP
- **json_encode($data, $options)**
    - funkce pro zakódování pole, objektu atd.
    - pomocí ```$options``` jdou ovlivnit vlastnosti konverze - viz [json_encode v PHP manuálu](http://php.net/manual/en/function.json-encode.php)
- **json_decode($json, $assoc=false)**
    - funkce pro dekódování JSONu
    - vrací asociační pole nebo objekt (dle nastavení 2. parametru)
- Interface **JsonSerializable**
    - pro převod objektů do JSONu jsou ve výchozím stavu serializovány všechny properties
    - serializaci je možné ovlivnit implementováním rozhraní JsonSerializable (funkce **jsonSerialize()**)

```php
$data = ['jmeno'=>'Josef','prijmeni'=>'Novák'];
$json = json_encode($data); //funkce pro vytvoření JSONu z pole

$data2=json_decode($json, true); //funkce pro dekódování JSONu (vrací asociační pole)
```

:blue_book:
- [příklad použití json_encode(), json_decode()](./09-json/json_encode_decode.php)
- [příklad použití JsonSerializable](./09-json/jsonserializable.php)

### XML
:point_right:

TODO

:point_right:

#### Práce s XML z PHP

TODO