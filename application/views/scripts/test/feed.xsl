<?xml version="1.0" encoding="utf-8" ?>
<xsl:stylesheet version="2.0" xmlns="http://www.w3.org/1999/xhtml" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:exslt="http://exslt.org/common">
<xsl:import href="/home/robp/zfdev.pinciuc.com/htdocs/xsl/layout.xsl"/>

<xsl:template match="/">
  <xsl:call-template name="standard-layout">
    <xsl:with-param name="section" select="'home'"/>
    <xsl:with-param name="title" select="'Test'"/>
    <xsl:with-param name="css" select="'home'"/>

    <xsl:with-param name="content">
      <h2>Test</h2>

      <h3>My Gamespot Blog</h3>

      <xsl:apply-templates select="/root/myGamespotBlogFeed"/>
    </xsl:with-param>
  </xsl:call-template>
</xsl:template>

<xsl:template match="myGamespotBlogFeed">
  <p><em>Delayed up to <xsl:value-of select="channel/ttl"/> minutes.</em></p>

  <dl>
  <xsl:for-each select="channel/item">
    <dt><a href="{link}"><xsl:value-of select="title"/></a></dt>
      <dd><xsl:value-of select="description"/><br/><br/></dd>
  </xsl:for-each>
  </dl>

  <xsl:for-each select="channel/image">
    <p><a href="{link}" class="a-img"><img src="{url}" title="{title}" width="{width}" height="{height}"/></a></p>
  </xsl:for-each>
</xsl:template>

</xsl:stylesheet>
