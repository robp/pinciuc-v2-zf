<?xml version="1.0" encoding="utf-8" ?>
<xsl:stylesheet version="2.0" xmlns="http://www.w3.org/1999/xhtml" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:exslt="http://exslt.org/common" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:date="http://exslt.org/dates-and-times" xmlns:str="http://exslt.org/strings">
<xsl:import href="/home/robp/zfdev.pinciuc.com/htdocs/xsl/layout.xsl"/>

<xsl:template match="/">
<xsl:call-template name="standard-layout">
  <xsl:with-param name="section" select="'contact'"/>
  <xsl:with-param name="title" select="'Contact'"/>
  <xsl:with-param name="css" select="'contact'"/>

  <xsl:with-param name="content">
    <div id="c-left">
      <h2>Thank you</h2>

      <p>Your message has been sent.</p>
    </div> <!-- c-left -->

    <div id="c-right">

      <h3>recent entries</h3>

      <ul class="arrowed">
      <li><a href="/entry/222">google maps "street view"</a> [<a href="/entry/222#comments" title="0 comments">0</a>]</li>
<li><a href="/entry/219">on copy protection</a> [<a href="/entry/219#comments" title="1 comment">1</a>]</li>

<li><a href="/entry/211">last batch of photos from newfoundland</a> [<a href="/entry/211#comments" title="1 comment">1</a>]</li>
<li><a href="/entry/210">lightroom beta 4</a> [<a href="/entry/210#comments" title="2 comments">2</a>]</li>
<li><a href="/entry/209">gros morne photos, gear</a> [<a href="/entry/209#comments" title="0 comments">0</a>]</li>

<li><a href="/entry/208">round three of nfld</a> [<a href="/entry/208#comments" title="1 comment">1</a>]</li>
<li><a href="/entry/207">round two of nfld</a> [<a href="/entry/207#comments" title="0 comments">0</a>]</li>
<li><a href="/entry/206">first round of photos from nfld</a> [<a href="/entry/206#comments" title="0 comments">0</a>]</li>

<li><a href="/entry/205">newfoundland</a> [<a href="/entry/205#comments" title="0 comments">0</a>]</li>
<li><a href="/entry/204">vacation</a> [<a href="/entry/204#comments" title="2 comments">2</a>]</li>
      </ul>

      <br/>
      <h3>categories</h3>


      <ul class="arrowed">
      <li><a href="/archive/1">all</a> (10)</li>
<li><a href="/archive/category/1">technology</a> (14)</li>
<li><a href="/archive/category/2">culture</a> (4)</li>
<li><a href="/archive/category/3">personal</a> (38)</li>

<li><a href="/archive/category/4">misc</a> (13)</li>
<li><a href="/archive/category/17">photography</a> (32)</li>
<li><a href="/archive/category/18">entertainment</a> (14)</li>
<li><a href="/archive/category/20">business</a> (2)</li>
      </ul>

    </div> <!-- c-right -->
  </xsl:with-param>
</xsl:call-template>

</xsl:template>

</xsl:stylesheet>
