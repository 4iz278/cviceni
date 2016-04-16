<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    xmlns:xs="http://www.w3.org/2001/XMLSchema"
    exclude-result-prefixes="xs objednavka"
    xmlns:objednavka="https://github.com/4iz278/cviceni/objednavka"
    version="1.0">
    
    <xsl:output encoding="UTF-8" method="xml" />
    <xsl:template match="/">
        <xsl:text disable-output-escaping='yes'>&lt;!DOCTYPE html&gt;</xsl:text>
        <html>
            <head>
                <title>Ukázková objedávka</title>
                <meta charset="utf-8"/>
            </head>
            <body>
                <xsl:apply-templates/>
            </body>
        </html>
    </xsl:template>
    
    <xsl:template match="objednavka:objednavka">
        <h1>Objednávka</h1>
        <xsl:apply-templates select="objednavka:adresa"/>
        <xsl:apply-templates select="objednavka:polozky"/>
    </xsl:template>
    
    <xsl:template match="objednavka:adresa">
        <xsl:choose>
            <xsl:when test="@typ='fakturacni'"><h2><xsl:text>Fakturační adresa</xsl:text></h2></xsl:when>
            <xsl:when test="@typ='dorucovaci'"><h2><xsl:text>Doručovací adresa</xsl:text></h2></xsl:when>
        </xsl:choose>
        <p>
            <xsl:if test="objednavka:nazev">
                <strong><xsl:value-of select="objednavka:nazev"/></strong><br />
            </xsl:if>
            <xsl:if test="objednavka:jmeno | objednavka:prijmeni">
                <strong><xsl:value-of select="objednavka:jmeno"/><xsl:text> </xsl:text><xsl:value-of select="objednavka:prijmeni"/></strong><br />
            </xsl:if>
            <xsl:if test="objednavka:ulice">
                <xsl:value-of select="objednavka:ulice"/><br />
            </xsl:if>
            <xsl:value-of select="objednavka:mesto"/><br />
            <xsl:value-of select="objednavka:psc"/>
        </p>
    </xsl:template>
    
    <xsl:template match="objednavka:polozky">
        <h2>Položky objednávky</h2>
        <xsl:if test="count(objednavka:polozka)&gt;0">
            <table>
                <xsl:apply-templates select="objednavka:polozka" mode="row"/>
            </table>
        </xsl:if>
    </xsl:template>
    
    <xsl:template match="objednavka:polozka" mode="row">
        <tr>
            <td><xsl:value-of select="objednavka:nazev"/></td>
            <td><xsl:value-of select="objednavka:cena"/><xsl:text> </xsl:text><xsl:value-of select="objednavka:cena/@mena"/></td>
        </tr>
    </xsl:template>
    
</xsl:stylesheet>