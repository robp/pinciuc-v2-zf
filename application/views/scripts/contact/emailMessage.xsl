<?xml version="1.0" encoding="utf-8" ?>
<xsl:stylesheet version="2.0" xmlns="http://www.w3.org/1999/xhtml" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:exslt="http://exslt.org/common" xmlns:atom="http://www.w3.org/2005/Atom">

<xsl:template match="/">
NAME: <xsl:value-of select="$name"/>
EMAIL: <xsl:value-of select="$email"/>
URL: <xsl:value-of select="$url"/>

Comment:
<xsl:value-of select="$comment"/>

DATE/TIME: <xsl:value-of select="$datetime"/>
REMOTE IP: <xsl:value-of select="$ipAddress"/>
BROWSER: <xsl:value-of select="$browser"/>
</xsl:template>

</xsl:stylesheet>
