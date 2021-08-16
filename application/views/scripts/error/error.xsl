<?xml version="1.0" encoding="utf-8" ?>
<xsl:stylesheet version="2.0" xmlns="http://www.w3.org/1999/xhtml" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:import href="/home/robp/zfdev.pinciuc.com/htdocs/xsl/layout.xsl"/>
<xsl:param name="errorCode" />
<xsl:param name="errorTitle" />
<xsl:param name="errorMessage" />
<xsl:param name="errorTrace" />

<xsl:template match="/">
<xsl:call-template name="standard-layout">
  <xsl:with-param name="section" select="''"/>
  <xsl:with-param name="title" select="concat($errorTitle, ' / Error')"/>
  <xsl:with-param name="css" select="'error'"/>

  <xsl:with-param name="content">
    <h1>An error occurred</h1>

    <h4><xsl:value-of select="$errorTitle" /></h4>
    <p class="errorMessage"><xsl:value-of select="$errorMessage" disable-output-escaping="yes" /></p>
    
    <h4>Trace:</h4>
    <p class="errorTrace"><xsl:value-of select="$errorTrace" disable-output-escaping="yes" /></p>
  </xsl:with-param>
</xsl:call-template>
</xsl:template>

</xsl:stylesheet>
