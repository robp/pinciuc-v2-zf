<?xml version="1.0" encoding="utf-8" ?>
<xsl:stylesheet version="2.0" xmlns="http://www.w3.org/1999/xhtml" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:exslt="http://exslt.org/common" xmlns:php="http://php.net/xsl">
<xsl:import href="/home/robp/zfdev.pinciuc.com/htdocs/xsl/common.xsl"/>
<xsl:import href="/home/robp/zfdev.pinciuc.com/htdocs/xsl/layout.xsl"/>
<xsl:param name="albumArtist" />

<xsl:template match="/">
  <xsl:call-template name="standard-layout">
    <xsl:with-param name="section" select="'music'"/>
    <xsl:with-param name="title" select="concat($albumArtist, ' / ', 'Music')"/>
    <xsl:with-param name="css" select="'music'"/>

    <xsl:with-param name="content">
      <div id="artist-browse">
        <h2>Online Music Collection</h2>

        <h3>Browse - <xsl:value-of select="$albumArtist" /></h3>

        <p><a href="/music/">Back</a></p>

        <div id="artist-albums">
          <p><xsl:value-of select="count(/albums/album)" /> album<xsl:if test="count(/albums/album) != 1">s</xsl:if>.</p>

          <ul>
            <xsl:for-each select="/albums/album">
              <li>
                <a class="a-img" href="/music/album/albumArtist/{php:function('urlencode',string($albumArtist))}/title/{php:function('urlencode',string(title))}"><img class="a-img" width="80" height="80" src="/music/cover/albumArtist/{php:function('urlencode',string($albumArtist))}/title/{php:function('urlencode',string(title))}" alt="{title}" /></a>
                <p><a href="/music/album/albumArtist/{php:function('urlencode',string($albumArtist))}/title/{php:function('urlencode',string(title))}"><xsl:value-of select="title"/></a>
                <xsl:if test="string-length(normalize-space(year)) > 0"><span class="year">(<xsl:value-of select="year" />)</span></xsl:if></p>
              </li>
            </xsl:for-each>
          </ul>
        </div> <!-- artist-albums -->

        <xsl:if test="count(/creditedAlbums/album) > 0">
          <div id="credited-albums">
            <p>Contributed to <xsl:value-of select="count(/creditedAlbums/album)" /> album<xsl:if test="count(/creditedAlbums/album) != 1">s</xsl:if>.</p>

            <ul>
              <xsl:for-each select="/creditedAlbums/album">
                <li>
                  <a class="a-img" href="/music/album/albumArtist/{php:function('urlencode',string(albumArtist))}/title/{php:function('urlencode',string(title))}"><img class="a-img" width="80" height="80" src="/music/cover/albumArtist/{php:function('urlencode',string(albumArtist))}/title/{php:function('urlencode',string(title))}" alt="{title}" /></a>
                  <p><a href="/music/album/albumArtist/{php:function('urlencode',string(albumArtist))}/title/{php:function('urlencode',string(title))}"><xsl:value-of select="title"/></a></p>
                </li>
              </xsl:for-each>
            </ul>
          </div> <!-- other-albums -->
        </xsl:if>

        <xsl:call-template name="comments">
          <xsl:with-param name="title" select="$albumArtist"/>
          <xsl:with-param name="post_id">albumArtist|<xsl:value-of select="php:function('urlencode',string($albumArtist))"/></xsl:with-param>
        </xsl:call-template>

      </div> <!-- artist-browse -->

      <div id="feature-albums">

        <h3>All Music Guide Minibio</h3>

        <p>
          Lorem ipsum et doler... <a href="http://www.allmusic.com/cg/amg.dll?p=amg&amp;sql=11:3dmsa93gw238~T1">Read More...</a>
        </p>

        <div id="allmusic-link">
          <form action="http://www.allmusic.com/cg/amg.dll" method="post">
            <input class="hidden" type="hidden" name="P" value="amg"/>
            <input class="hidden" type="hidden" name="sql" value="The Arcade Fire"/>
            <input class="hidden" type="hidden" name="opt1" value="1"/>
            <input type="image" src="/images/amg_sm.gif"/><br/>
          </form>
        </div>
      </div> <!-- feature-albums -->
    </xsl:with-param>
  </xsl:call-template>
</xsl:template>

</xsl:stylesheet>
