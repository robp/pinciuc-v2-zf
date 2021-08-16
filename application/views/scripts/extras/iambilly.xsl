<?xml version="1.0" encoding="utf-8" ?>
<xsl:stylesheet version="2.0" xmlns="http://www.w3.org/1999/xhtml" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:exslt="http://exslt.org/common">
<xsl:import href="/home/robp/zfdev.pinciuc.com/htdocs/xsl/layout.xsl"/>

<xsl:template match="/">
<xsl:call-template name="standard-layout">
  <xsl:with-param name="section" select="'extras'"/>
  <xsl:with-param name="title" select="'I Am Billy Etch-a-Sketch Game'"/>
  <xsl:with-param name="css" select="'home'"/>

  <xsl:with-param name="content">
    <h2>I Am Billy "Etch-a-Sketch" Game</h2>

    <p><a href="http://www.sonymusic.ca/IAmBilly/">I Am Billy</a> was a promotional website for <a href="http://www.sonybmg.ca/">Sony BMG</a>, showcasing an animated three-dimensional character named Billy in his animated world. He listened to and watched music from Sony BMG, and had his own blog, computer, and toys and games.</p>

    <p>Based on the classic toy, this Flash version allowed users to draw on the virtual Etch-a-Sketch using the arrow keys on their keyboards. They could save their drawings to be rated by Billy for possible inclusion in his gallery; send drawings to a friend, who could then continue the drawing and send it again; and view the gallery of images that Billy has selected.</p>

    <p class="center">
      <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" ID="billy" WIDTH="700" HEIGHT="535" ALIGN="">
        <param name="movie" value="billysroom.swf?card_id=&amp;drawing_id="/>
        <param name="quality" value="high"/> 
        <param name="bgcolor" value="#000000"/>
        <embed src="billysroom.swf?card_id=foo&amp;drawing_id=foo" quality="high" bgcolor="#000000" swliveconnect="false" width="700" height="535" name="billy" align="" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer">
        </embed>
      </object>
    </p>
  </xsl:with-param>
</xsl:call-template>
</xsl:template>

</xsl:stylesheet>



