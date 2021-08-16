<?xml version="1.0" encoding="utf-8" ?>
<xsl:stylesheet version="2.0" xmlns="http://www.w3.org/1999/xhtml" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:exslt="http://exslt.org/common" xmlns:php="http://php.net/xsl">
<xsl:import href="/home/robp/zfdev.pinciuc.com/htdocs/xsl/common.xsl"/>
<xsl:import href="/home/robp/zfdev.pinciuc.com/htdocs/xsl/layout.xsl"/>
<xsl:param name="allTracksCount" />
<xsl:param name="allAlbumsCount" />
<xsl:param name="allArtistsCount" />
<xsl:param name="allSizesSum" />

<xsl:template match="/">
  <xsl:call-template name="standard-layout">
    <xsl:with-param name="section" select="'music'"/>
    <xsl:with-param name="title" select="'Music'"/>
    <xsl:with-param name="css" select="'music'"/>

    <xsl:with-param name="content">
      <div id="artist-browse">
        <h2>Online Music Collection</h2>

        <p>The collection currently contains 
          <xsl:value-of select="floor($allTracksCount div 1000)"/>,<xsl:value-of select="$allTracksCount mod 1000"/> tracks in 
          <xsl:value-of select="$allAlbumsCount" /> albums by 
          <xsl:value-of select="$allArtistsCount" /> artists for 
          <xsl:value-of select="floor($allSizesSum div (1024 * 1024 * 1024))" />.<xsl:value-of select="round(($allSizesSum mod (1024 * 1024 * 1024)) div 10000000)" />GB.  <a href="stats.php">More stats here</a>.
        </p>

        <div id="music-search">
          <h3>Search</h3>

          <p>Enter an artist name, album title, or song title. Use fewer keywords for more results.</p>

          <form name="search" action="search.php" method="get">
            <label for="keywords"><strong>Keyword(s):</strong></label> <input id="keywords" name="keywords" size="30" maxlength="255" /> <button type="submit" name="submit">Search</button><br/>
          </form>
        </div>

        <h3>Browse</h3>

        <p>Or, you can browse the collection alphabetically.</p>

        <div id="browse-left">
          <ul>
            <xsl:for-each select="/albumArtists/albumArtist">
              <xsl:if test="(position() - 1) &lt;= (count(/albumArtists/albumArtist) div 2)">
                <li><a href="/music/albums/albumArtist/{php:function('urlencode',string(name))}"><xsl:value-of select="name"/></a></li>
              </xsl:if>
            </xsl:for-each>
          </ul>
        </div>

        <div id="browse-right">
          <ul>
            <xsl:for-each select="/albumArtists/albumArtist">
              <xsl:if test="(position() - 1) > (count(/albumArtists/albumArtist) div 2)">
                <li><a href="/music/albums/albumArtist/{php:function('urlencode',string(name))}"><xsl:value-of select="name"/></a></li>
              </xsl:if>
            </xsl:for-each>
          </ul>
        </div>
      </div> <!-- artist-browse -->

      <div id="feature-albums">
        <h3>Recently Added Albums</h3>

        <div class="small-album-list">

          <xsl:for-each select="/recentlyAddedAlbums/album">
            <p>
              <a href="/music/album/albumArtist/{php:function('urlencode',string(albumArtist))}/title/{php:function('urlencode',string(title))}"><img width="30" height="30" class="cover" src="/music/cover/albumArtist/{php:function('urlencode',string(albumArtist))}/title/{php:function('urlencode',string(title))}" alt="{title}"/></a>
              <strong><a href="/music/album/albumArtist/{php:function('urlencode',string(albumArtist))}/title/{php:function('urlencode',string(title))}"><xsl:value-of select="title" /></a></strong><br/>
              <a href="/music/albums/albumArtist/{php:function('urlencode',string(albumArtist))}"><xsl:value-of select="albumArtist" /></a>
            </p>
          </xsl:for-each>

         </div>

        <h3>Recently Played Albums</h3>

        <div class="small-album-list">

          <xsl:for-each select="/recentlyPlayedAlbums/album">
            <p>
              <a href="/music/album/albumArtist/{php:function('urlencode',string(albumArtist))}/title/{php:function('urlencode',string(title))}"><img width="30" height="30" class="cover" src="/music/cover/albumArtist/{php:function('urlencode',string(albumArtist))}/title/{php:function('urlencode',string(title))}" alt="{title}"/></a>
              <strong><a href="/music/album/albumArtist/{php:function('urlencode',string(albumArtist))}/title/{php:function('urlencode',string(title))}"><xsl:value-of select="title" /></a></strong><br/>
              <a href="/music/albums/albumArtist/{php:function('urlencode',string(albumArtist))}"><xsl:value-of select="albumArtist" /></a>
            </p>
          </xsl:for-each>
 
        </div>

      </div> <!-- feature-albums -->

    </xsl:with-param>
  </xsl:call-template>
</xsl:template>

</xsl:stylesheet>
