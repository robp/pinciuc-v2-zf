<?xml version="1.0" encoding="utf-8" ?>
<xsl:stylesheet version="2.0" xmlns="http://www.w3.org/1999/xhtml" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:exslt="http://exslt.org/common">
<xsl:import href="/home/robp/zfdev.pinciuc.com/htdocs/xsl/layout.xsl"/>

<xsl:template match="/">
<xsl:call-template name="standard-layout">
  <xsl:with-param name="section" select="'extras'"/>
  <xsl:with-param name="title" select="'WWF Forceable Thumbs Game / Extras'"/>
  <xsl:with-param name="css" select="'home'"/>

  <xsl:with-param name="content">
    <h2>WWF Forceable Thumbs Game</h2>

    <p>Thumb-wrestling game to promote the latest <a href="http://www.wwe.com/">WWF</a> (now WWE) theme song album "<a href="http://www.amazon.com/gp/product/B000063206/002-4855251-7488815?v=glance&amp;n=5174">Forceable Entry</a>". Players use the arrow keys to "grab onto" the opponent, then repeatedly tap Left and Right to pin them for three seconds. Faster pins and higher energy score more points. The game features artwork and music from the album.</p>

    <p class="center">
      <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=3,0,0,0" id="WWFgame-v1" width="600" height="285">
        <param name="movie" value="game.swf"/>
        <param name="menu" value="false"/>
        <param name="quality" value="high"/>
        <param name="bgcolor" value="#FFFFFF"/>
        <embed src="game.swf" quality="high" bgcolor="#FFFFFF" swLiveConnect="FALSE" width="600" height="285" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash">
        </embed>
      </object>
    </p>
  </xsl:with-param>
</xsl:call-template>
</xsl:template>

</xsl:stylesheet>



