<?xml version="1.0" encoding="utf-8" ?>
<xsl:stylesheet version="2.0" xmlns="http://www.w3.org/1999/xhtml" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:exslt="http://exslt.org/common">
<xsl:import href="/home/robp/zfdev.pinciuc.com/htdocs/xsl/layout.xsl"/>

<xsl:template match="/">
  <xsl:call-template name="standard-layout">
    <xsl:with-param name="section" select="'photos'"/>
    <xsl:with-param name="title" select="'Photos'"/>
    <xsl:with-param name="css" select="'photos'"/>

    <xsl:with-param name="content">
      <h2>Photo Galleries</h2>

      <p>Welcome to my photo galleries. Please feel free to comment on any galleries or images - feedback is always welcomed and appreciated.</p>

      <div id="gallery-container" class="narrow">
        <div class="gallery">
          <ul>
            <xsl:for-each select="/photosets/photoset">
              <li><a class="thumbnail" href="/photos/gallery/galleryId/{@id}">
                  <img class="a-img">
                  <xsl:attribute name="width"><xsl:value-of select="photo/sizes/size[@label='Thumbnail']/@width"/></xsl:attribute>
                  <xsl:attribute name="height"><xsl:value-of select="photo/sizes/size[@label='Thumbnail']/@height"/></xsl:attribute>
                  <xsl:attribute name="src"><xsl:value-of select="photo/sizes/size[@label='Thumbnail']/@source"/></xsl:attribute>
                  <xsl:attribute name="alt"><xsl:value-of select="photo/title"/></xsl:attribute>
                  <xsl:attribute name="style">margin-top:<xsl:value-of select="(100 - photo/sizes/size[@label='Thumbnail']/@height) div 2"/>px</xsl:attribute>
                  </img></a>
              <strong>&#171;&#160;<a href="/photos/gallery/galleryId/{@id}"><xsl:value-of select="title"/></a>&#160;&#187;</strong></li> 
            </xsl:for-each>
          </ul>
        </div>
      </div> <!-- gallery-container -->

    </xsl:with-param>
  </xsl:call-template>
</xsl:template>

</xsl:stylesheet>
