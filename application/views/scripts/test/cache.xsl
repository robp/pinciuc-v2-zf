<?xml version="1.0" encoding="utf-8" ?>
<xsl:stylesheet version="2.0" xmlns="http://www.w3.org/1999/xhtml" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:exslt="http://exslt.org/common">

<xsl:template match="/">
<h1>Hello world.</h1>

<p>The number is: <xsl:value-of select="$number"/></p>
</xsl:template>

</xsl:stylesheet>



