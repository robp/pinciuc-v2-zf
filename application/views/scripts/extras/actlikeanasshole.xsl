<?xml version="1.0" encoding="utf-8" ?>
<xsl:stylesheet version="2.0" xmlns="http://www.w3.org/1999/xhtml" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:exslt="http://exslt.org/common">
<xsl:import href="/home/robp/zfdev.pinciuc.com/htdocs/xsl/layout.xsl"/>

<xsl:template match="/">
<xsl:call-template name="standard-layout">
  <xsl:with-param name="section" select="'extras'"/>
  <xsl:with-param name="title" select="'Tom Green Voice Message e-card / Extras'"/>
  <xsl:with-param name="css" select="'home'"/>

  <xsl:with-param name="content">
    <h2>Tom Green Voice Message e-card</h2>

    <p>Created as part of the online marketing campaign for Tom's album "<a href="http://www.actlikeanasshole.com/">Prepare For Impact</a>". This piece allows users to create a custom voice message using real sound clips from the infamous <a href="http://www.tomgreen.com/">Tom Green</a>. Once the message is complete, users can send the message to their friends in the form of an e-card. They can also choose a preset random message.</p>

    <p class="center">
      <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="700" height="360" id="workecard" align="middle">
        <param name="allowScriptAccess" value="sameDomain" />
        <param name="movie" value="http://www.actlikeanasshole.com/ecard/workecard.swf" />
        <param name="quality" value="high" />
        <param name="bgcolor" value="#000000" />
        <embed src="http://www.actlikeanasshole.com/ecard/workecard.swf" quality="high" bgcolor="#000000" width="700" height="360" name="workecard" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
      </object>
    </p>
  </xsl:with-param>
</xsl:call-template>
</xsl:template>

</xsl:stylesheet>



