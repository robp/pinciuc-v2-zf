<?xml version="1.0" encoding="utf-8" ?>
<xsl:stylesheet version="2.0" xmlns="http://www.w3.org/1999/xhtml" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:import href="/home/robp/dev.pinciuc.com/htdocs/xsl/head.xsl"/>
<xsl:import href="/home/robp/dev.pinciuc.com/htdocs/xsl/messages.xsl"/>
<xsl:import href="/home/robp/dev.pinciuc.com/htdocs/xsl/comments.xsl"/>
<xsl:import href="/home/robp/dev.pinciuc.com/htdocs/xsl/footer.xsl"/>

<xsl:output method="xhtml" indent="yes" encoding="utf-8"
  doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"
  doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"
  cdata-section-elements="script style comment"
/>

<xsl:template name="standard-layout">
<xsl:param name="section"/>
<xsl:param name="title"/>
<xsl:param name="css"/>
<xsl:param name="content"/>
<html>
  <xsl:call-template name="standard-head">
    <xsl:with-param name="title" select="$title"/>
    <xsl:with-param name="css" select="$css"/>
  </xsl:call-template>
  <body>
  <div id="container">
    <div id="main-container">
      <div id="top-logo">
        <div id="top-logo-title">pinciuc.com / v2.2</div>
        <ul id="top-logo-login">
          <li><a href="/contact/">contact</a></li>
          <li><a href="/login/">login</a></li>
        </ul>
      </div>
  
      <div id="header-image"><xsl:text> </xsl:text></div>
  
      <div id="main-nav">
        <ul>
        <li><xsl:if test="$section = 'home'"><xsl:attribute name="class">current</xsl:attribute></xsl:if><a href="/">Home</a></li>
        <li><xsl:if test="$section = 'photos'"><xsl:attribute name="class">current</xsl:attribute></xsl:if><a href="/photos/">Photos</a></li>
        <li><xsl:if test="$section = 'music'"><xsl:attribute name="class">current</xsl:attribute></xsl:if><a href="/music/">Music</a></li>
        <li><xsl:if test="$section = 'extras'"><xsl:attribute name="class">current</xsl:attribute></xsl:if><a href="/extras/">Extras</a></li>
        </ul>
        <div id="nav-search">
          <form action="/search" method="get">
          <input type="text" name="query" id="searchbox" size="30" value="Search..." onfocus="javascript:if(this.value=='Search...')this.value='';" onblur="javascript:if(this.value=='')this.value='Search...';"/>
          <button type="submit" id="searchbutton" value="search">Go</button>
          </form>
        </div>
      </div>
  
      <div id="content">
        <xsl:call-template name="messages" />
        <xsl:copy-of select="$content"/>
      </div> <!-- content -->
  
      <xsl:call-template name="standard-footer" />
  
    </div> <!-- main-container -->
  </div>  <!-- container -->
  </body>
</html>
</xsl:template>

</xsl:stylesheet>


