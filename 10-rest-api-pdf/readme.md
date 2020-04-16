# 10. REST API, PDF

:no_entry: **TYTO PODKLADY BUDOU TEPRVE AKTUALIZOVÁNY** :no_entry:

TODO opakování

---

:point_right:

**Na tomto cvičení nás čeká:**
- ukázka tvorby API
- použití PHP kódu pomocí AJAXu
- [generování PDF](#generov%C3%A1n%C3%AD-pdf)

---

TODO tvorba API

TODO AJAX

## Generování PDF
:point_right:

**K čemu by mohlo být dobré generovat PDF z PHP?**
    - generování faktur, dodávkových listů, objednávek atp.
    - exporty dat pro archivaci (u PDF máte uživatel jistotu, že bude všude vypadat stejně)
    
:point_right:

PHP neumí PDF generovat samo o sobě, ale existuje celá řada knihoven a nástrojů, které nám s tím pomohou.
- Z nepřímého generování bychom mohli uvažovat např. o generování PDF z XML pomocí XSL transformace (viz např. XSL-FO v kurzu 4iz238).

Běžněji se ale využívají metody, jak generovat PDF přímo prostřednictvím PHP knihoven - pojďme si tedy představit nejznámnější z nich.
- [TCPDF](http://www.tcpdf.org/)
    - = asi nejkomplexnější knihovna pro generování PDF
    - zvládá i dokumenty podepsané certifikátem atp.
    - lze generovat části popsané pomocí HTML (ale s minimální podporou stylů) a části popsané pomocí speciálních konstrukcí
    - [ukázkové příklady na webu TCPDF](https://tcpdf.org/examples/)  
- [mPDF](http://mpdf.github.io/)
    - knihovna pro jednoduché generování PDF výstupu z HTML a zjednodušeného CSS
    - pro jednodušší dokumenty ji rozhodně doporučuji :)
    - [ukázkové příklady na githubu mPDF](https://github.com/mpdf/mpdf-examples/tree/master)
- [FPDF](http://www.fpdf.org/)
    - jedna ze základních free knihoven pro generování PDF (je na ní postavená třeba i zmíněná knihovna *mPDF*)     

Všechny uvedené knihovny jdou jednoduše instalovat pomocí composeru, nebo jdou do jednodušších aplikací také přímo stáhnout a načíst ručně.

:blue_book:
- TODO
- [web mPDF](http://mpdf.github.io/)
- [web TCPDF](http://www.tcpdf.org/) 