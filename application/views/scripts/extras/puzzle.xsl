<?xml version="1.0" encoding="utf-8" ?>
<xsl:stylesheet version="2.0" xmlns="http://www.w3.org/1999/xhtml" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:exslt="http://exslt.org/common">
<xsl:import href="/home/robp/zfdev.pinciuc.com/htdocs/xsl/layout.xsl"/>

<xsl:template match="/">
<xsl:call-template name="standard-layout">
  <xsl:with-param name="section" select="'extras'"/>
  <xsl:with-param name="title" select="'Puzzle Game / Extras'"/>
  <xsl:with-param name="css" select="'home'"/>

  <xsl:with-param name="content">
    <h2>Puzzle Game</h2>

    <p>A puzzle game to help promote Franz Ferdinand's new album (<a href="http://www.sonybmg.ca/franzfrenzy/">see original game</a>). Each puzzle solved revealed a more challenging puzzle, until you solved all four, at which point you could enter a contest to win a limited edition poster. The puzzle images were the posters themselves.</p>

    <p>Here I've created a modified version for my own use.</p>

    <p class="center">
      <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="420" height="480" id="puzzle" align="middle">
        <param name="allowScriptAccess" value="sameDomain" />
        <param name="movie" value="puzzle.swf" />
        <param name="quality" value="high" />
        <param name="bgcolor" value="#ffffff" />
        <embed src="puzzle.swf" quality="high" bgcolor="#ffffff" width="420" height="480" name="puzzle" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
      </object>
    </p>
  </xsl:with-param>
</xsl:call-template>
</xsl:template>

</xsl:stylesheet>



