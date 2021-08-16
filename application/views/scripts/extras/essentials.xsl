<?xml version="1.0" encoding="utf-8" ?>
<xsl:stylesheet version="2.0" xmlns="http://www.w3.org/1999/xhtml" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:exslt="http://exslt.org/common">
<xsl:import href="/home/robp/zfdev.pinciuc.com/htdocs/xsl/layout.xsl"/>

<xsl:template match="/">
<xsl:call-template name="standard-layout">
  <xsl:with-param name="section" select="'extras'"/>
  <xsl:with-param name="title" select="'The Essentials Collection Game / Extras'"/>
  <xsl:with-param name="css" select="'home'"/>

  <xsl:with-param name="content">
    <h2>The Essentials Collection Game</h2>

    <p>A crossword puzzle game to promote a new series of CDs called The Essentials Collection. Players had to complete the puzzle to enter a contest. The puzzle itself can be reused and reconfigured to any premade configuration (no auto-generation function was created). Navigation can be done via mouse or keyboard, and words are highlighted as they are clicked on. The game featured music from the albums in the CD series.</p>

    <p class="center">
      <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="715" height="500" id="game" align="">
        <param name="movie" value="game.swf"/>
        <param name="quality" value="high"/>
        <param name="bgcolor" value="#000000"/>
        <embed src="game.swf" quality="high" bgcolor="#000000" width="715" height="500" name="game" align="" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer"></embed>
      </object>
    </p>
  </xsl:with-param>
</xsl:call-template>
</xsl:template>

</xsl:stylesheet>



